sbpushold () 
{ 
    sbls | grep php > /dev/null;
    if [[ $? -eq 0 ]]; then
        LAST=`sbls | grep php | tail -1 | sed 's/^.*-//g' | sed 's/\..*//'`;
        sbcs $LAST > /dev/null;
        sbcs;
    else
        sbcs 1;
    fi
}
