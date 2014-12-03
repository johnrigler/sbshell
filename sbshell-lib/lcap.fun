lcap () 
{ 
    WD=`pwd`;
    cd $DOCBIN;
    cp empty.png /tmp/webimage_$$.png;
    $PAINT /tmp/webimage_$$.png;
    scp /tmp/webimage_$$.png $URI/$THISPAGE-$THISSECTION.png;
    rm /tmp/webimage_$$.png
}
