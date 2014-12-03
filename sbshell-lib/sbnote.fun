sbnote () 
{ 
    SBDATE=`date "+/%Y/%W/%w"`;
    SBME="sbreports/riglerjo";
    sbenv | ssh $SBSRV $SBRCMDS/sbdir.remote "$SBME$SBDATE";
    SBTIME=`date '+%H:%M'`;
    if [[ -n $1 ]]; then
        NOTE="<br>$SBTIME $*";
    else
        NOTE="<br>$SBTIME <a href=/$SBDIR> $SBDIR </a>";
    fi;
    echo $NOTE | ssh $SBSRV $SBRCMDS/sbdesc.remote $SBPATH/$SBME$SBDATE
}
