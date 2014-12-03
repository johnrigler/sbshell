sbtest () 
{ 
    DATE=`date "+%Y%d%m"`;
    sbset development/test/$DATE;
    sbset development/test/$DATE/three;
    sbdiv;
    sbcs;
    sbpre;
    sbcs;
    ls --color=tty | sbprep
}
