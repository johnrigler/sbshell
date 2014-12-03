sbdiv () 
{ 
    vim /tmp/$$.temp;
    scp /tmp/$$.temp $URI/.;
    sbenv | ssh $SBSRV $SBRCMDS/sbdiv.remote $$;
    rm /tmp/$$.*
}
