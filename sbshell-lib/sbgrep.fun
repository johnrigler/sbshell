sbgrep () 
{ 
    while read LINE; do
        echo $LINE | egrep "$1" 2>&1 > /dev/null;
        if [ $? -eq 0 ]; then
            echo "$LINE $2";
        else
            echo "$LINE";
        fi;
    done
}
