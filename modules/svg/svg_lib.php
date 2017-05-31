<?php 

$xoff=20;
$yoff=20;


# 24 by 48 lasersaur

function lasersaurheader() {

echo '<?xml version="1.0" encoding="UTF-8" ?>
<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">
<svg width="1220mm" height="610mm" viewBox="0 0 1220 610" 
version="1.1" xmlns="http://www.w3.org/2000/svg">';


}

function refresh() {

echo "<meta http-equiv='refresh' content='10'>";



}

function svgclose() {

echo '</svg>
';

}

function airhole( $x, $y ) {

$size=4;

echo "<circle cx='$x' cy='$y' r='$size' 
              stroke='blue' stroke-width='2' fill='none' />\n";


}

function fingerhole( $x, $y ) {

$size=12;

echo "<circle cx='$x' cy='$y' r='$size' 
              stroke='brown' stroke-width='2' fill='none' />\n";

}

function line( $x1, $y1, $x2, $y2  ) {


echo "<line x1='$x1' y1='$y1' x2='$x2' y2='$y2' 
     style='stroke:rgb(255,0,0);stroke-width:2' />\n";

}

function tooth( $x, $y, $w, $h, $off, $depth=5 ) {

// build a basic box

//$w2 = $w * 2;
//$h2 = $h * 2;

$x1 = $x - $w;
$x2 = $x + $w;
$y1 = $y - $h;
$y2 = $y + $h;

// find vertical middle

// build top
//line ( $x1, $y1, $x2, $y1 );  // top
$midleft = $x1 + $w - $off;
$midright = $x2 - $w + $off;

line ( $x1, $y1, $midleft, $y1 );
line ( $x2, $y1, $midright, $y1 );
$topdepth = $y1 + $depth;
line ( $midleft, $y1, $midleft, $topdepth );
line ( $midright, $y1, $midright, $topdepth );
line ( $midleft, $topdepth, $midright, $topdepth );


}

function tooth_poly( $x, $y ) {

$height = 30;

$left = $x - 30;
$right = $x + 30;
$y2 = $y + $height;

tooth($x,$y,30,10,8,18);
tooth($x,$y2,30,10,10,20);

line($left,$y - 20,$left,$y2);
line($right,$y - 20,$right,$y2);

}

function cross( $x, $y ) {

$xoff = 20;
$yoff = 20;

line($xoff,$yoff,$x + $xoff,$y + $yoff);
line($xoff,$y + $yoff,$x + $xoff,$yoff);

}


function cup( $x , $y, $size ) {

echo "<circle cx='$x' cy='$y' r='$size' stroke='green'
              stroke-width='2' 
              fill='none' />\n";

}

function cup_2   ( $x, $y ) { cup ($x , $y, 27); }
function cup_3   ( $x, $y ) { cup ($x, $y, 36); }
function cup_375 ( $x, $y ) { cup ($x, $y, 48); }
function cup_4   ( $x, $y ) { cup ($x , $y, 53); }
function cup_5   ( $x, $y ) { cup ($x ,$y, 66); }
function cup_6   ( $x, $y ) { cup ($x, $y, 78); }

function cup_4_down ( $x, $y )

{

cup_2 ( $x, $y );
cup_3 ( $x, $y );

}


function text( $x, $y, $message ) {

echo "
<text x='$x' y='$y' fill='red' 
  transform='rotate(0 0,0)'>$message</text>";

}

$unit="mm";
$val=10;
$h=1100;
$hm=$h*-1;
$v=500;
$vm=$v*-1;

$sw=1;

//echo "<svg width=1200$unit height=600$unit viewBox='0 0 1200 600' >\n";

function surface( $h , $v , $val) {

$unit="";
$hm=$h*-1;
$vm=$v*-1;

$sw=1;

$xoff=20;
$yoff=20;


echo "<path fill='none' stroke='black' stroke-width='$sw'  d='";
echo"
M$xoff,$yoff 
h$h a$val,$val 0 0 1 $val,$val 
v$v a$val,$val 0 0 1 -$val,$val 
h$hm a$val,$val 0 0 1 -$val,-$val 
v$vm a$val,$val 0 0 1 $val,-$val
'/>\n\n"; 

}

function square( $x , $y , $size, $val) {

$unit="";
$hm=$x*-1;
$vm=$y*-1;

$sw=1;

$xoff=190;
$yoff=70;


echo "<path fill='none' stroke='purple' stroke-width='$sw'  d='";
echo"
M$xoff,$yoff 
h$x a$val,$val 0 0 1 $val,$val 
v$y a$val,$val 0 0 1 -$val,$val 
h$hm a$val,$val 0 0 1 -$val,-$val 
v$vm a$val,$val 0 0 1 $val,-$val
'/>\n\n";

}


?>
