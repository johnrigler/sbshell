sbhelp () 
{ 
    grep 'function' ~/bin/sbshell | grep -v grep | cut -c 10- | sed 's/{ #//g';
    ls --color=tty $SBCMDS/*.bash | while read DOCSHLET; do
        CMD=`grep "^function" $DOCSHLET | sed 's/{.*$//' | cut -c 10-`;
        DESC=`grep "^function" $DOCSHLET | sed 's/^.*#//'`;
        echo "$SBPREFIX$CMD $DESC";
    done;
    rm $$.help 2> /dev/null
}
