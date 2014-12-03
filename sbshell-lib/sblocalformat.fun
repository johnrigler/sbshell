sblocalformat () 
{ 
    while read LINE; do
        echo $LINE | sed 's/\.brinksinc\.com://g';
    done > $$.temp;
    localformat[$1] $$.temp 2> /dev/null;
    RC=$?;
    if [[ $RC -eq 127 ]]; then
        awk '{print $1 " " $2 }' $$.temp;
    fi;
    rm $$.temp
}
