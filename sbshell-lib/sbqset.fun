sbqset () 
{ 
    ME=`whoami`;
    if [[ $ME = "root" ]]; then
        ME=`ps -ef | grep $PPID | grep -v root | awk '{ print $1 }'`;
    fi;
    THISWEEK=`date +%W`;
    sbset "$ME/$THISWEEK" > /dev/null;
    sbcp $1;
    sbcs $2
}
