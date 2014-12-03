sbver () 
{ 
    echo $SBVER;
    ssh $SBSRV $SBRCMDS/sbver.remote
}
