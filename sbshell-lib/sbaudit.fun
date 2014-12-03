sbaudit () 
{ 
    AUDITSET=$1;
    read EXEC_LIST;
    echo "xxxxxxxxxxxxxxxxxxxxxxxxxxxx";
    echo $EXEC_LIST;
    echo "XXXXXXXXXXXXXXXXx";
    sbset hardening/$AUDITSET 2>&1 > /dev/null;
    sbdateset 2>&1 > /dev/null;
    DATE=`date`;
    echo "<title> $1 for $DATE</title>" | sbdivp;
    sbcs;
    echo "<h1>Introduction: $1</h1>$INTRODUCTION" | sbdivp;
    for AUDIT in $EXEC_LIST;
    do
        sbcs;
        . $AUDIT;
        sbdshtable $AUDIT $AUDITROWS | sbdivp;
    done;
    sbcs;
    echo "<h1>Conclusion</h1>$CONCLUSION" | sbdivp
}
