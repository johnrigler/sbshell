<?php
require_once __DIR__ . "/../cruff/clipboard.php";
function check($condition, $message){ if(!$condition) throw new RuntimeException($message); }
$temporary = sys_get_temp_dir() . "/sbshell-clipboard-" . bin2hex(random_bytes(6));
$sb_root = $temporary . "/archive-one";
$archive = $sb_root;
$previous_database = getenv("SB_DATABASE");
mkdir($temporary . "/home", 0777, true);
putenv("SB_DATABASE=" . $temporary . "/home/catalog.sqlite3");
mkdir($sb_root . "/42/sub", 0777, true);
mkdir($sb_root . "/43");
file_put_contents($sb_root . "/42/alpha one.md", "alpha");
file_put_contents($sb_root . "/42/zeta.txt", "zeta");
file_put_contents($sb_root . "/43/other.txt", "other");
try{
	check(sb_clipboard_paths() === [], "A missing home database has an empty clipboard.");
	check(!is_file(getenv("SB_DATABASE")), "Reading an empty clipboard must not create a database.");
	sb_catalog_scan($sb_root);
	sb_save_document("42/zeta.txt", "Named file", hash_file("sha256", $sb_root . "/42/zeta.txt", true));
	$db = sb_catalog(true); $db->exec("INSERT INTO metadata VALUES ('generatedAt','original')"); $db->close();
	$stamp = sb_directory_stamp($sb_root);
	check(sb_save_clipboard("42/", ["zeta.txt", "alpha one.md", "sub/"]) === 3, "Save both files and directory references.");
	check(sb_clipboard_paths() === [$archive . "/42/zeta.txt", $archive . "/42/alpha one.md", $archive . "/42/sub/"], "Preserve order and spaces as absolute paths.");
	check(sb_directory_stamp($sb_root) === $stamp, "Clipboard writes must not cause auto-refresh loops.");
	sb_catalog_scan($sb_root . "/42");
	check(count(sb_clipboard_paths()) === 3, "Catalog scans must preserve the clipboard.");
	check(sb_document_path("Named file") === $sb_root . "/42/zeta.txt", "Preserve named documents.");
	$db = sb_catalog();
	check($db->querySingle("SELECT value FROM metadata WHERE key='generatedAt'") === "original", "Preserve FileProxy metadata.");
	check($db->querySingle("SELECT count(*) FROM files") === 3, "Clipboard writes must preserve the file index.");
	check($db->querySingle("SELECT count(*) FROM sqlite_master WHERE name='sb_clipboard'") === 0, "New archive catalogs must not create separate clipboard tables.");
	$db->close();
	sb_save_clipboard("43/", ["other.txt"]);
	check(sb_clipboard_paths() === [$archive . "/43/other.txt"], "A later copy replaces the previous clipboard.");
	foreach([["../other.txt"], ["/etc/passwd"], ["missing.txt"], ["zeta.txt", "missing.txt"], ["catalog.sqlite3"], "not a list"] as $invalid){
		try { sb_save_clipboard("42/", $invalid); throw new LogicException("Invalid selection accepted."); }
		catch(RuntimeException $error){ check(in_array($error->getCode(), [400,409]), "Reject invalid selections before replacing anything."); }
		check(sb_clipboard_paths() === [$archive . "/43/other.txt"], "Validation failure must keep the old clipboard.");
	}
	$db = sb_clipboard_database(true);
	$db->exec("CREATE TABLE book_records (note TEXT); INSERT INTO book_records VALUES ('keep this record')");
	$db->exec("CREATE TRIGGER test_failure BEFORE INSERT ON sb_clipboard BEGIN SELECT RAISE(ABORT,'test write failure'); END");
	$db->close();
	try { sb_save_clipboard("42/", ["zeta.txt"]); throw new LogicException("Write failure expected."); }
	catch(Exception $error){ check($error->getMessage() !== "Write failure expected.", "The trigger must reject the insert."); }
	check(sb_clipboard_paths() === [$archive . "/43/other.txt"], "A database write failure must roll back the complete replacement.");
	$db = sb_clipboard_database(true); $db->exec("DROP TRIGGER test_failure"); $db->close();
	sb_save_clipboard("42/", ["zeta.txt", "zeta.txt"]);
	check(sb_clipboard_paths() === [$archive . "/42/zeta.txt"], "Repeated paths occur only once.");
	$sb_root = $temporary . "/archive-two";
	mkdir($sb_root . "/43", 0777, true);
	file_put_contents($sb_root . "/43/second.txt", "second archive");
	check(sb_clipboard_paths() === [$archive . "/42/zeta.txt"], "Another archive must read the same global clipboard.");
	sb_save_clipboard("43/", ["second.txt"]);
	$second = $sb_root . "/43/second.txt";
	$sb_root = $archive;
	check(sb_clipboard_paths() === [$second], "A copy from a different archive must replace the global list.");
	$db = sb_clipboard_database();
	check($db->querySingle("SELECT note FROM book_records") === "keep this record", "Clipboard updates must preserve other book-of-record tables.");
	check($db->querySingle("PRAGMA integrity_check") === "ok", "The global database must pass SQLite integrity checks.");
	$db->close();
	sb_save_clipboard("", []);
	check(sb_clipboard_paths() === [], "An empty saved clipboard reads as an empty list.");
	$db = sb_clipboard_database(true); $db->exec("DROP TABLE sb_clipboard"); $db->close();
	$hash = hash_file("sha256", getenv("SB_DATABASE"));
	check(sb_clipboard_paths() === [], "A home database with other records can have an empty clipboard.");
	check(hash_file("sha256", getenv("SB_DATABASE")) === $hash, "Reading must not alter the home database.");
	echo "Global clipboard: absolute paths, cross-archive reads/replacement, persistence, rollback, catalog/name and book-of-record preservation passed.\n";
}finally{
	putenv($previous_database === false ? "SB_DATABASE" : "SB_DATABASE=" . $previous_database);
	foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($temporary, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST) as $entry){
		if($entry->isDir() && !$entry->isLink()) rmdir($entry->getPathname()); else unlink($entry->getPathname());
	}
	rmdir($temporary);
}
