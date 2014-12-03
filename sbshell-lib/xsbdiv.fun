xsbdiv () 
{ 
    TOP=/tmp/$$.top;
    MIDDLE=/tmp/$$.middle;
    END=/tmp/$$.end;
    DEST=/tmp/$$.dest;
    echo "  <div>" > $TOP;
    echo >> $TOP;
    vim $MIDDLE;
    echo "  </div>" > $END;
    echo >> $END;
    cat $TOP $MIDDLE $END > $DEST;
    scp $DEST $URI/$SBPAGE-$SBSECTION.php;
    rm /tmp/$$.*
}
