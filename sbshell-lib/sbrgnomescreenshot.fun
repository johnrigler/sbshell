sbrgnomescreenshot () 
{ 
    ssh -X $SBCONSOLE gnome-screenshot -w -i;
    sbenv | ssh -X $SBCONSOLE $SBCMDS/sbgnomescreenshot.remote
}
