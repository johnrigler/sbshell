<?php

//echo $_SERVER["argc"];


if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) {
 //   header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    exit("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\r\n<html><head>\r\n<title>Help File</title>\r\n</head><body>\r\n<h1>Help</h1>\r\n<p> was not found on this server.</p>\r\n</body></html>");
}
else {
if ($_SERVER["argc"] == 1)
echo "This is a notation example";
else
echo "This has been called";


}
?>
