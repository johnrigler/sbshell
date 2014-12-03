sbread () 
{ 
    let LINE=1;
    FILELINENO=1;
    MAXLINES=`cat $1 | wc -l`;
    CHAR=' ';
    while [[ $CHAR != 'x' ]]; do
        clear;
        sbfont aqua;
        echo "(Use the keyboard to make a selection)";
        echo "i (up) k (down) x (select)";
        sbfont white;
        echo;
        echo;
        cat $1 | while read FILELINE; do
            if [[ $FILELINENO -eq $LINE ]]; then
                sbfont green;
                echo $FILELINE > $$.choice;
            else
                sbfont white;
            fi;
            echo "$FILELINE";
            let FILELINENO=FILELINENO+1;
        done;
        read -n 1 CHAR;
        case $CHAR in 
            i)
                if [[ $LINE -gt 1 ]]; then
                    let LINE=LINE-1;
                fi
            ;;
            j)
                echo "Left"
            ;;
            k)
                if [[ $LINE -lt $MAXLINES ]]; then
                    let LINE=LINE+1;
                fi
            ;;
            l)
                echo "Right"
            ;;
            ' ')
                echo "Space"
            ;;
        esac;
    done;
    clear;
    sbfont white;
    DOCREADCHOICE=`cat $$.choice`;
    rm $$.choice
}
