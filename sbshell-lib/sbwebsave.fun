sbwebsave () 
{ 
    DATE=`date +%Y%m%d`;
    NAME=sbweb.$DATE.tar;
    WD=`pwd`;
    cd $DOCPATH;
    tar -cf /tmp/$NAME .;
    scp /tmp/$NAME rigler@rigler.org:.;
    rm /tmp/$NAME;
    cd $WD
}
