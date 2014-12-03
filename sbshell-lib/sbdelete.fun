sbdelete () 
{ 
    sbfont red;
    echo;
    echo "The following will be deleted:";
    sbfont aqua;
    echo;
    ssh $SBSRV "cat $SBPATH/$SBDIR/$SBPAGE-$SBSECTION.php" 2> /dev/null;
    ssh $SBSRV "ls $SBPATH/$SBDIR/$SBPAGE-$SBSECTION.png";
    sbfont red;
    echo;
    echo "OK to delete? (y/n)";
    sbfont white;
    read OK;
    if [[ $OK = "y" ]]; then
        ssh $SBSRV "rm $SBPATH/$SBDIR/$SBPAGE-$SBSECTION.php";
        ssh $SBSRV "rm $SBPATH/$SBDIR/$SBPAGE-$SBSECTION.png";
    fi
}
