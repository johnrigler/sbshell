sbsel () 
{ 
    echo "A 'vi' session will open in a bit, place an asterisk (*) next to your choice and
then simply save";
    DOCBASE=`basename $DOCDIR`;
    ssh $DOCSRV "cd $DOCPATH ; find -type d -print 2>/dev/null" | sed 's/^\.\///g' > /tmp/$$.pick;
    vim /tmp/$$.pick;
    TEMPDOCDIR=`grep "*" /tmp/$$.pick | awk '{ print $1}'`;
    if [[ -n $TEMPDOCDIR ]]; then
        DOCDIR=$TEMPDOCDIR;
    else
        echo "Failed to set path, make sure and put an '*' behind your choice";
    fi;
    rm /tmp/$$.pick;
    URI="$DOCSRV:$DOCPATH/$DOCDIR";
    ssh $DOCSRV mkdir $DOCPATH/$DOCDIR 2> /dev/null;
    ssh $DOCSRV chmod 770 $DOCPATH/$DOCDIR;
    sbls
}
