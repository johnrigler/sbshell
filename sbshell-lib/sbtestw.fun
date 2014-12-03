sbtestw () 
{ 
    DATE=`date "+%Y%d%m"`;
    sbset development/test/$DATE;
    sbmenu;
    sbset development/test/$DATE/two;
    sbdiv;
    sbcs;
    sbpre;
    sbcs;
    ls --color=tty | sbprep;
    sbcs;
    sbcap
}
