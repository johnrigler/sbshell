sbdivp () 
{ 
    THIS=$0;
    PRELEN=90;
    PS1="`pwd`> ";
    LINE=/tmp/$$.line;
    EVAL=/tmp/$$.eval;
    ERROR=/tmp/$$.error;
    DEST=/tmp/$$.dest;
    echo "<!---- Begin code snippet ---->" > $DEST;
    if [[ $1 == "newpage" ]]; then
        echo "<!-- NEW PAGE -->" >> $DEST;
    fi;
    echo "  <div>" >> $DEST;
    while read LINE; do
        echo "$LINE";
    done | sed -f $SBCMDS/html.sed >> $DEST;
    echo "  </div>" >> $DEST;
    echo "<!---- End code snippet ---->" >> $DEST;
    cat $DEST;
    if [[ $1 == "append" ]]; then
        scp $URI/$SBPAGE-$SBSECTION.php $$.section;
        cat $DEST >> $$.section;
        mv $$.section $DEST;
    fi;
    scp $DEST $URI/$SBPAGE-$SBSECTION.php;
    rm /tmp/$$.*
}
