<?php 

function lasersaurheader() {



echo '<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg width="1251pt" height="446pt" viewBox="0 0 1251 446" version="1.1" xmlns="http://www.w3.org/2000/svg">';

}


function airhole( $x, $y ) {

$size=6;

echo "<circle cx='$x' cy='$y' r='$size' 
              stroke='blue' stroke-width='2' fill='none' />\n";


}

function stickhole( $x, $y ) {

$size=10;

echo "<circle cx='$x' cy='$y' r='$size' 
              stroke='brown' stroke-width='2' fill='none' />\n";

}




function cup( $x , $y ) {

$size=60;

echo "<circle cx='$x' cy='$y' r='$size' stroke='green'
              stroke-width='2' 
              fill='none' />\n";

}

$unit="mm";
$val=10;
$h=1100;
$hm=$h*-1;
$v=500;
$vm=$v*-1;

$sw=1;

//echo "<svg width=1200$unit height=600$unit viewBox='0 0 1200 600' >\n";

lasersaurheader();
cup( 500,250 );
airhole( 1080,480 );
stickhole( 40,40 );

function surface( $h , $v , $val) {

echo "<path fill=none stroke=black stroke-width=$sw  d='";
echo"
M20,20 
h$h a$val,$val 0 0 1 $val,$val 
v$v a$val,$val 0 0 1 -$val,$val 
h$hm a$val,$val 0 0 1 -$val,-$val 
v$vm a$val,$val 0 0 1 $val,-$val
'>\n\n"; 

}

//surface($h, $v, $val);


echo "</svg>";

?>
