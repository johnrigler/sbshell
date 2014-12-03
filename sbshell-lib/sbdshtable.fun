sbdshtable () 
{ 
    function header () 
    { 
        echo > /dev/null
    };
    function footer () 
    { 
        echo > /dev/null
    };
    unset AUDITNAME;
    unset AUDITDESC;
    unset AUDITTEST;
    . $1;
    RMCD=`function remote { echo >/dev/null; } ; cat $1`;
    echo "<h2>$AUDITNAME: $AUDITDESC  </h2>";
    echo "<h3>Test: $AUDITTEST </h3>";
    cat "$1".header 2> /dev/null;
    header;
    dsh "$RMCD ; remote" | sbtable.pyc $LINE;
    cat "$1".footer 2> /dev/null;
    footer
}
