<?php
require_once __DIR__ . "/catalog.php";

// The user's home database is the shared book of record; open only this table.
function sb_clipboard_database($write = false){
	$path = getenv("SB_DATABASE");
	if(!$path){
		$sb_home = getenv("HOME");
		if(!$sb_home) throw new RuntimeException("Set SB_DATABASE to locate the home clipboard database.");
		$path = rtrim($sb_home, "/") . "/catalog.sqlite3";
	}
	if($path[0] !== "/") throw new RuntimeException("SB_DATABASE must be an absolute database path.");
	if(!$write && !is_file($path)) return null;
	if(!class_exists("SQLite3")) throw new RuntimeException("Enable PHP's SQLite3 extension to use the clipboard.");
	$db = new SQLite3($path, $write ? SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE : SQLITE3_OPEN_READONLY);
	$db->enableExceptions(true);
	$db->busyTimeout(3000);
	if($write) $db->exec("CREATE TABLE IF NOT EXISTS sb_clipboard (position INTEGER PRIMARY KEY, path TEXT NOT NULL UNIQUE)");
	return $db;
}

// Copy replaces one global ordered list of absolute filesystem references.
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
		$path = rtrim($GLOBALS["sb_root"], "/") . "/" . $prefix . $leaf;
		if(strpbrk($path, "\r\n") !== false){
			throw new RuntimeException("Clipboard paths must fit on one line.", 400);
		}
		if(!is_file($path) && !is_dir($path)) throw new RuntimeException("The selected entry is missing: " . $file, 409);
		if(is_dir($path)) $path .= "/";
		$paths[$path] = true;
	}
	$db = sb_clipboard_database(true);
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
	$db = sb_clipboard_database();
	if(!$db) return [];
	$paths = [];
	try{
		if($db->querySingle("SELECT count(*) FROM sqlite_master WHERE type='table' AND name='sb_clipboard'")){
			$rows = $db->query("SELECT path FROM sb_clipboard ORDER BY position");
			while($row = $rows->fetchArray(SQLITE3_ASSOC)){
				$path = $row["path"];
				if($path === "" || !str_starts_with($path, "/") || in_array("..", explode("/", $path), true) || str_contains($path, "\0")
					|| strpbrk($path, "\r\n") !== false){
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
		if($argc !== 1) throw new RuntimeException("Usage: sb.clip");
		foreach(sb_clipboard_paths() as $path) echo $path . "\n";
	}catch(Throwable $error){
		fwrite(STDERR, $error->getMessage() . "\n");
		exit(1);
	}
}
