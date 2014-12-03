sbset () 
{ 
    SBSECTION=01;
    SBPAGE=1;
    SBDIR=$1;
    URI="$SBSRV:$SBPATH/$SBDIR";
    SBURI="$SBSRV:$SBPATH/$SBDIR";
    if [[ $2 != "nonote" ]]; then
        sbnote;
    fi;
    sbrenv | ssh $SBSRV "$SBRCMDS/sbdir.remote $SBDIR" & sbcs 1
}
