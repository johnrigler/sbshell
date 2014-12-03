sbgimp () 
{ 
    WD=`pwd`;
    cd /tmp/screenshot;
    rm *.png;
    scp $SBSRV:$SBPATH/$SBDIR/$SBPAGE-$SBSECTION.png /tmp/screenshot/;
    gimp /tmp/screenshot/$SBPAGE-$SBSECTION.png;
    scp /tmp/screenshot $SBSRV:$SBPATH/$SBDIR/$SBPAGE-$SBSECTION.png;
    cd $WD
}
