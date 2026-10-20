<?php
// This file also works as the router passed to php -S.
$sb_root = realpath(($_SERVER["DOCUMENT_ROOT"] ?? "") ?: getcwd());
require_once __DIR__ . "/catalog.php";
if(isset($_GET["document"])){
	try{
		if(!is_string($_GET["document"])) throw new RuntimeException("Enter a document name.", 400);
		$file = sb_document_path($_GET["document"]);
		$path = substr($file, strlen($sb_root) + 1);
		$url = "/" . implode("/", array_map("rawurlencode", explode("/", $path)));
		header("Location: " . $url . (isset($_GET["raw"]) ? "?raw=1" : ""));
	}catch(Throwable $error){
		http_response_code(in_array($error->getCode(), [400,404,409]) ? $error->getCode() : 500);
		echo htmlspecialchars($error->getMessage());
	}
	exit();
}
$sb_path = rawurldecode(explode("?", $_SERVER["REQUEST_URI"] ?? "/", 2)[0]);
if(in_array("..", explode("/", $sb_path), true) || str_contains($sb_path, "\0")){
	http_response_code(404);
	exit("Directory not found.");
}
$sb_target = realpath($sb_root . $sb_path);
$sb_index = $sb_target === __FILE__;
if($sb_index){
	// A symlinked index belongs to its URL directory, not this source directory.
	$sb_path = dirname($sb_path);
	$sb_target = realpath($sb_root . $sb_path);
}elseif(PHP_SAPI === "cli-server" && is_file($sb_target ?: "")){
	if(strtolower(pathinfo($sb_path, PATHINFO_EXTENSION)) === "pdf" && !isset($_GET["raw"])){
		include __DIR__ . "/document.php";
		exit();
	}
	return false;
}
if(!$sb_target || !is_dir($sb_target) || !chdir($sb_target)){
	http_response_code(404);
	exit("Directory not found.");
}
$sb_parts = array_values(array_filter(explode("/", $sb_path), fn($part) => $part !== "" && $part !== "."));
$sb_url = "/";
foreach($sb_parts as $part) $sb_url .= rawurlencode($part) . "/";
if(!$sb_index && !str_ends_with($sb_path, "/")){
	$query = $_SERVER["QUERY_STRING"] ?? "";
	header("Location: " . $sb_url . ($query === "" ? "" : "?" . $query));
	exit();
}
if(isset($_GET["sb-refresh"])){
	header("Content-Type: application/json; charset=utf-8");
	header("Cache-Control: no-store");
	try { echo json_encode(["stamp" => sb_directory_stamp($sb_target)]); }
	catch(Throwable $error){ http_response_code(503); echo json_encode(["error" => $error->getMessage()]); }
	exit();
}

$ls = array_values(array_filter(glob("1_*.*") ?: [], "is_file"));
require_once __DIR__ . "/preview.php";
$sb_dirs = $sb_files = [];
$sb_names = [];
$sb_catalog_error = "";
try{
	sb_catalog_scan(rtrim($sb_root . rawurldecode($sb_url), "/") ?: "/");
}catch(Throwable $error){ $sb_catalog_error = $error->getMessage(); }
try { $sb_names = sb_document_names(); } catch(Throwable $error) { $sb_catalog_error = $error->getMessage(); }
$sb_stamp = "";
try { $sb_stamp = sb_directory_stamp($sb_target); } catch(Throwable $error) { /* Retry on the next directory load. */ }
foreach(scandir(".") as $file){
	if($file[0] === "." || realpath($file) === __FILE__) continue;
	if($file === "catalog.sqlite3" || str_starts_with($file, "catalog.sqlite3-")) continue;
	if(is_dir($file)) $sb_dirs[] = $file . "/";
	elseif(is_file($file)) $sb_files[] = $file;
}
?>
<!doctype html>
<html>
<head>
 <meta http-equiv="content-type" content="text/html;charset=UTF-8">
 <meta name="viewport" content="width=device-width,initial-scale=1">
 <title>John Rigler</title>
 		<link rel="stylesheet" type="text/css" href="/style.css">

</head>
<body>
<style>
.sb-navigation, .refresh-control { font:14px/1.5 system-ui,sans-serif; color:#273749; margin:10px 16px; }
.sb-navigation a { color:#135da8; text-decoration:underline; }
.sb-navigation summary { cursor:pointer; }
.sb-navigation ul { padding-left:24px; }
.sb-navigation li { margin:4px 0; overflow-wrap:anywhere; }
.sb-file-controls { margin:10px 0; }
.sb-file-controls button { font:inherit; padding:5px 12px; cursor:pointer; }
.sb-entry { margin:8px 0; }
.sb-entry > summary { padding:6px 0; }
.sb-preview { min-width:0; padding:8px 0 16px; }
.sb-file-actions { margin:4px 0 10px; }
.sb-image, .sb-markdown img { max-width:100%; height:auto; }
.sb-image:not([src]) { display:none; }
.sb-pdf { display:block; width:100%; height:75vh; min-height:320px; border:1px solid #b8c3cf; }
.sb-pdf-fallback { height:auto; min-height:0; padding:0 12px; box-sizing:border-box; }
.sb-markdown { color:#172433; font:16px/1.6 system-ui,sans-serif; max-width:85ch; }
.sb-markdown pre { padding:12px; background:#eef2f6; overflow:auto; white-space:pre; }
.sb-markdown blockquote { margin-left:0; padding-left:16px; border-left:3px solid #b8c3cf; }
.sb-catalog-error { margin:10px 16px; color:#9c2424; font:14px/1.5 system-ui,sans-serif; }
@media print {
  .sb-breadcrumbs, .sb-assembled-files, .sb-directory > summary, .sb-file-controls,
  .sb-file-actions, .sb-entry:not([open]), .refresh-control, .sb-catalog-error { display:none !important; }
  .sb-directory, .sb-directory > ul, .sb-directory > ul > li { margin:0; padding:0; list-style:none; }
  .sb-directory > ul > li:not(:has(> .sb-entry[open])) { display:none; }
  .sb-entry > summary { font-weight:bold; }
  .sb-navigation { color:#000; }
  .sb-markdown pre { white-space:pre-wrap; overflow-wrap:anywhere; }
}
</style>
<nav class="sb-navigation sb-breadcrumbs" aria-label="Breadcrumbs">
<?php
$sb_crumbs = ["/" => basename($sb_root) ?: "Home"];
$sb_link = "/";
foreach($sb_parts as $part){
	$sb_link .= rawurlencode($part) . "/";
	$sb_crumbs[$sb_link] = $part;
}
foreach($sb_crumbs as $link => $label){
	if($link !== "/") echo ' <span aria-hidden="true">/</span> ';
	if($link === $sb_url) echo '<span aria-current="page">' . htmlspecialchars($label) . '</span>';
	else echo '<a href="' . $link . '">' . htmlspecialchars($label) . '</a>';
}
?>
</nav>
<?php if($sb_catalog_error){ ?>
<p class="sb-catalog-error" role="status">Catalog update failed: <?php echo htmlspecialchars($sb_catalog_error); ?></p>
<?php } ?>
<details class="sb-navigation sb-directory<?php if($ls) echo ' sb-assembled-files'; ?>" id="sb-directory"<?php if(!$ls) echo " open"; ?>>
<summary>Files and directories</summary>
<?php if($sb_dirs || $sb_files){ ?>
<div class="sb-file-controls" hidden>
<button type="button" id="sb-expand-all">Expand all</button>
<button type="button" id="sb-collapse-all">Collapse all</button>
</div>
<ul>
<?php
foreach(array_merge($sb_dirs, $sb_files) as $file){
	$link = $sb_url . rawurlencode(rtrim($file, "/")) . (str_ends_with($file, "/") ? "/" : "");
	$relative = ltrim(rawurldecode($sb_url), "/") . $file;
	$label = $sb_names[$relative] ?? $file;
	if(is_file($file) && sb_preview_type($file)){
		echo '<li><details class="sb-entry" data-file="' . htmlspecialchars($file) . '"><summary>' . htmlspecialchars($label);
		if($label !== $file) echo ' <small>(' . htmlspecialchars($file) . ')</small>';
		echo '</summary><div class="sb-preview"><p class="sb-file-actions"><a href="' . $link . '">Open file</a>';
		if(sb_preview_type($file) === "pdf") echo ' · <a href="' . $link . '?raw=1" target="_blank" rel="noopener">Open original PDF / print</a>';
		echo '</p>';
		sb_preview($file, rawurlencode($file), true);
		echo '</div></details>';
	}else{
		echo '<li><a href="' . $link . '">' . htmlspecialchars($label) . '</a>';
		if($label !== $file) echo ' <small>(' . htmlspecialchars($file) . ')</small>';
	}
	echo '</li>' . "\n";
}
?>
</ul>
<?php }else{ ?>
<p>This directory is empty.</p>
<?php } ?>
</details>
<div class="refresh-control">
<label><input type="checkbox" id="auto-refresh" data-stamp="<?php echo $sb_stamp; ?>" checked> Auto-refresh when files change (check every 10 seconds)</label>
</div>
<script>
<?php readfile(__DIR__ . "/directory.js"); ?>
</script>
<?php
foreach($ls as $file){
	if(sb_preview_type($file)){
		sb_preview($file, rawurlencode($file));
	}else{
		include $file;
	}
};
?>
</body>
</html>
<?php
exit();
?>


<?php

function typescript_color( $a ,$b ){  

echo "[$a;$b]";
}

// Clear session information

unset($_SESSION['host']);
unset($_SESSION['W']);
?>

<!-- Begin Menu Choices -->
<div class=contentsframe>

<table>
<tr><td>John Rigler<td><?php include "banner.php"; ?>
</table>
<br>
<br>
<br>

<?php
// map this directory

$dir = opendir(".");

while(false != ($file = readdir($dir))) 
{
if($file == "images")continue;
if($file == "hide")continue;
if($file == "cgi-bin")continue;
if($file == ".")continue;
if($file == "..")continue;

$files [] = $file;
}

sort($files);

foreach($files as $file)
{

if(is_dir($file) == 1)$dirs [] = $file;
if(is_file($file) == 1)
  if(is_numeric($file[0]))
    {
    $files [] = $file;
    $sections[$file[0]] []= $file;
    }

}

// Read the format 

$format=($_GET[format]);

// figure out what page this is. 

$thispage=($_GET[page]);

if (! $thispage)$thispage=1;

if($thispage==1)
   {
   $nextpage = 2;
   }
   else
   {
   $nextpage = $thispage + 1;
   $prevpage = $thispage - 1;
   }

// Draw out the path

$length = strlen($_SERVER[DOCUMENT_ROOT]);
$cwd = getcwd();

if ($cwd[1] == ":") 
	{
	$path = explode('\\',substr($cwd,$length));
	}
	else
	{
	$path = explode('/',substr($cwd,$length));
	}

if($format != "htmldoc")
{
foreach($path as $index => $directory)
  {
  $countup = 0;
  $urlpath [] = "/" . $directory;
  echo "<div class=shortspacing style='float:left'>
   <div class=contentsbox>
      <a href=";
  while($countup <= $index)
	{
	$trimmed = $urlpath[$countup];
	echo $trimmed;
	if($index == 0)
		{ 
		$urlpath[0] = "";
		$directory = "home";
		}
		
	$countup++;
	}

	echo " style=color:white> $directory</a> 
    </div>
  </div>
";

	if ($countup > 3)echo "</div><div class=contentsbox>";
  } 
}

//echo "</div>";




?>
</div>

<!-- End Menu Choices -->

<!-- Begin Table of Contents -->

<?php 

if(count($dirs) > 0)
  {
  echo "<div class=contentsframe>";
  foreach($dirs as $subdir)
   {

?>
  <!-- Begin Table of Contents Entry -->
  <div class=shortspacing>
    <div class=contentsbox><a style='color:white' href=<?php echo "$subdir > $subdir"; ?></a></div>

  </div>
  <div class=spacing>
  <p><?php if( file_exists("$subdir/desc.php"))include "$subdir/desc.php"; ?></p>
  <hr>
  <!-- End Table of Contents Entry -->

  </div>
<?php   } ?>
</div>
<?php } ?>

<!-- End Table of Contents -->

<div style='border:none;background-color: transparent'>

<?php 
if($format != "htmldoc")
{
 if($sections[$prevpage])
	$visibility="visible";
	else
	$visibility="hidden";

	echo "<div class=shortspacing style='float:left;visibility: $visibility '>
      <div class=contentsbox>
    <a href=?page=$prevpage style='color:white'> Prev </a>
      </div>
   </div>";


if($sections[$nextpage])
        $visibility="visible";
        else
        $visibility="hidden";

  echo "<div class=shortspacing style='border:none;float:left;visibility: $visibility '>
      <div class=contentsbox style='border:none'>
      <a href=?page=$nextpage style='color:white'> Next </a>
      </div>
   </div>
</div>";
}

?>

<!-- End Forward/Back Choices -->


  <!-- Begin Body -->


<?php

//   }


if($sections[$thispage])
{
echo "<div class=bodyframe>";


$before = array("[0m","[40;31;01m","[01;32m","[01;34m","[01;36m" );
$after = array("</span>","<span class=color40_31_01>","<span class=color32>","<span class=color34>","<span class=color36>");
$colors = array();
$target = array();

$colors[0] ="";
$colors[31]="[31m";
$colors[32]="[32m";
$colors[33]="[33m";
$colors[99]="[00m";
$target[31]="<span class=color31>";
$target[32]="<span class=color32>";
$target[33]="<span class=color33>";
$target[99]="</span>";

foreach ($sections[$thispage] as $file)
  {
  list($prefix,$postfix) = explode(".",$file);
  list($page,$section) = explode("-",$prefix);
  if($page == $thispage)
  {
    if($postfix == "ts")
      {
      echo "<pre>";
			$lines = file($file);
      foreach ($lines as $line)
        {
				//typescript_color(4,5);
        $line = str_replace($before,$after,$line);
        $line = str_replace($colors,$target,$line);
 				echo "$line<span class=normal>";
        }
      echo "</pre>";
      }

    if($postfix == "php")
        {
        if($format != "htmldoc")echo "<div class=spacing><span class=section>$section</span>";
        include "$file";
        echo "</div>";
        }
    if($postfix == "png")
        if($format != "htmldoc")echo "
<div class=spacing><span class=section>$section</span>
  <div>
   <img src=$file>
  </div>
</div>
";
   }
  }
 }

echo "<pre>";
print_r($_SESSION);
echo "</pre>";

?>
   </div>
 </div>
</body>
</html>
