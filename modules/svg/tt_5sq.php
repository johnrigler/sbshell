<?php 

$xoff=20;
$yoff=20;

include 'svg_lib.php';

lasersaurheader();
//cross(472,240);
//line(10,140,506,140); // horizontal marker
//line(255,20,255,258); // vertical marker
//line(20,20,255,258);
//line(20,255,255,20);
// square 
square(120,120,140,10);
fingerhole( 40,120 );
fingerhole( 468,120 );
//fingerhole( 255,238 ); // bottom hole
airhole( 470,32 );
surface(472,220,10);
svgclose();

?>