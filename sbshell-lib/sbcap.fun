sbcap () 
{ 
    WD=`pwd`;
    cd $DOCBIN;
    cp empty.png webimage.png;
    mspaint webimage.png;
    scp webimage.png $URI/$THISPAGE-$THISSECTION.png
}
