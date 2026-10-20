<?php
require_once __DIR__ . "/catalog.php";

// One ordered clipboard per archive; the source files remain in the filesystem.
function sb_save_clipboard($prefix, $files){
	if(!is_array($files) || array_values($files) !== $files){
		throw new RuntimeException("Send a list of selected filenames.", 400);
	}
	$paths = [];
	foreach($files as $file){
		if(!is_string($file)) throw new RuntimeException("Each selection must be a filename.", 400);
		$leaf = rtrim($file, "/");
		if($leaf === "" || $leaf[0] === "." || basename($leaf) !== $leaf || str_contains($leaf, "\0")
			|| $leaf === "catalog.sqlite3" || str_starts_with($leaf, "catalog.sqlite3-")){
			throw new RuntimeException("Select entries from the current directory.", 400);
		}
		$path = $prefix . $leaf;
		if(strpbrk($GLOBALS["sb_root"] . "/" . $path, "\r\n") !== false){
			throw new RuntimeException("Clipboard paths must fit on one line.", 400);
		}
		$full = $GLOBALS["sb_root"] . "/" . $path;
		if(!is_file($full) && !is_dir($full)) throw new RuntimeException("The selected entry is missing: " . $file, 409);
		if(is_dir($full)) $path .= "/";
		$paths[$path] = true;
	}
	$db = sb_catalog(true);
	$db->exec("BEGIN IMMEDIATE");
	try{
		$db->exec("DELETE FROM sb_clipboard");
		$put = $db->prepare("INSERT INTO sb_clipboard(position, path) VALUES (:position, :path)");
		foreach(array_keys($paths) as $position => $path){
			$put->bindValue(":position", $position, SQLITE3_INTEGER);
			$put->bindValue(":path", $path, SQLITE3_TEXT);
			$put->execute();
		}
		$put->close();
		$db->exec("COMMIT");
	}catch(Throwable $error){
		$db->exec("ROLLBACK");
		throw $error;
	}finally { $db->close(); }
	return count($paths);
}

function sb_clipboard_paths(){
	$db = sb_catalog();
	if(!$db) return [];
	$paths = [];
	try{
		if($db->querySingle("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='sb_clipboard'")){
			$rows = $db->query("SELECT path FROM sb_clipboard ORDER BY position");
			while($row = $rows->fetchArray(SQLITE3_ASSOC)){
				$path = $row["path"];
				if($path === "" || str_starts_with($path, "/") || in_array("..", explode("/", $path), true) || str_contains($path, "\0")
					|| strpbrk($GLOBALS["sb_root"] . "/" . $path, "\r\n") !== false){
					throw new RuntimeException("The clipboard contains an invalid path.");
				}
				$paths[] = $path;
			}
		}
	}finally { $db->close(); }
	return $paths;
}

if(PHP_SAPI === "cli" && realpath($_SERVER["SCRIPT_FILENAME"] ?? "") === __FILE__){
	try{
		if($argc > 2) throw new RuntimeException("Usage: php clipboard.php [archive-or-week-directory]");
		$sb_root = realpath($argv[1] ?? getcwd());
		if(!$sb_root || !is_dir($sb_root)) throw new RuntimeException("Pass an archive or week directory.");
		while(!is_file($sb_root . "/catalog.sqlite3")){
			$parent = dirname($sb_root);
			if($parent === $sb_root) throw new RuntimeException("No catalog.sqlite3 found. Pass the archive directory used by SB Shell.");
			$sb_root = $parent;
		}
		foreach(sb_clipboard_paths() as $path) echo rtrim($sb_root, "/") . "/" . $path . "\n";
	}catch(Throwable $error){
		fwrite(STDERR, $error->getMessage() . "\n");
		exit(1);
	}
}
