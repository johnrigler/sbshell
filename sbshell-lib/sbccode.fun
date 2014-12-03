sbccode () 
{ 
    DATE=`date "+%Y%m%d"`;
    YEAR=`date "+%Y"`;
    sbset development/c/$1;
    sbset development/c/$1/$YEAR;
    sbset development/c/$1/$YEAR/$DATE;
    doccp 1;
    ( echo "<table border=1>";
    ls --color=tty | while read FILE; do
        LS=`ls -l $FILE | cut -c 23-44`;
        CKSUM=`cksum $FILE | awk '{ print $1,$2 }'`;
        echo "<tr><td><a href=$FILE>$FILE</a><td>$LS<td>$CKSUM</tr>";
    done;
    echo "</table>" ) | docprep;
    sbcs;
    ( make clean;
    make;
    echo $? ) | docprep;
    ls --color=tty | while read FILE; do
        scp $FILE $URI/.;
    done
}
