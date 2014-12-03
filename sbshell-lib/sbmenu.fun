sbmenu () 
{ 
    LASTDOCPATH="$DOCDIR";
    sbread $DOCBIN/menuchoices;
    echo $DOCREADCHOICE;
    DOCDIR=$DOCREADCHOICE;
    URI="$DOCSRV:$DOCPATH/$DOCDIR";
    ssh $DOCSRV mkdir $DOCPATH/$DOCDIR 2> /dev/null;
    ssh $DOCSRV chmod 770 $DOCPATH/$DOCDIR;
    ssh $DOCSRV cp -f $DOCBIN/index.php $DOCPATH/$DOCDIR;
    sbcs 1;
    sbls
}
