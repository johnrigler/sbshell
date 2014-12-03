sbprep () 
{ 
    echo "<pre>" > sbprep.$$;
    if [[ -n "$*" ]]; then
        DATE=$1;
        shift;
        UNAME=`uname -s -n -r -m -p -i`;
        echo "<span class=prompt>UNAME:</span><span class=cmd>$UNAME</span>" >> sbprep.$$;
        echo "<span class=prompt>PATH:</span><span class=cmd>$PWD</span>" >> sbprep.$$;
        echo "<span class=prompt>START:</span><span class=cmd>$DATE</span>" >> sbprep.$$;
        echo "<span class=prompt>CMD:</span><span class=cmd>$*</span>" >> sbprep.$$;
        echo "<hr>" >> sbprep.$$;
    fi;
    while read LINE; do
        echo "$LINE";
    done >> sbprep.$$;
    echo "</pre>" >> sbprep.$$;
    scp sbprep.$$ $SBSRV:$SBPATH/$SBDIR/$SBPAGE"-"$SBSECTION".php";
    rm sbprep.$$
}
