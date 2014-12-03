sbpush () 
{ 
    sbcs `sbrenv | ssh $SBSRV "$SBRCMDS/sbpush.remote"`
}
