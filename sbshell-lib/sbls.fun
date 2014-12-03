sbls () 
{ 
    sbrenv | ssh $SBSRV "$SBRCMDS/sbls.remote"
}
