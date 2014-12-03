sbdateset () 
{ 
    DATE=`date '+%Y%m%d'`;
    YEAR=`date '+%Y'`;
    sbset $SBDIR/$YEAR nonote;
    sbset $SBDIR/$DATE nonote
}
