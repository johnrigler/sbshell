sbintwrite () 
{ 
    echo "
PRS1='<span class=prompt>'
PRS2='<span class=cmd>'
PRSC='</span>'
" > $$.script;
    rm $$.err;
    INTERVAL=$1;
    START=`date "+%Y%m%d%H%M%S%Z"`;
    shift;
    echo "
$*" >> $$.script;
    echo 'RC=$?' >> $$.script;
    echo "echo '<hr>'" >> $$.script;
    echo 'echo "$PRS1"RC:"$PRSC$PRS2$RC$PRSC"' >> $$.script;
    echo 'END=`date "+%Y%m%d%H%M%S%Z"`' >> $$.script;
    echo 'echo "$PRS1"END:"$PRSC$PRS2$END$PRSC"' >> $$.script;
    sh $$.script > $$.out 2> $$.err & while [[ $? -eq 0 ]]; do
        cat $$.out | sbprep $START $*;
        sleep $INTERVAL;
        ps $!;
    done;
    echo "<span class=error>" > $$.out2;
    cat $$.err >> $$.out2;
    echo "</span>" >> $$.out2;
    cat $$.out $$.out2 | sbprep $START $*;
    rm $$.*
}
