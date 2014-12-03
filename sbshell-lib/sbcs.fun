sbcs () 
{ 
    SBSECTION=`echo $SBSECTION | sed 's/^0*//'`;
    if [[ ! -n $1 ]]; then
        let TEMPSECTION=${SBSECTION}+1;
        echo $TEMPSECTION;
        SBSECTION=`printf "%02d\n" $TEMPSECTION`;
    else
        TEMPSECTION=${1};
        SBSECTION=`printf "%02d\n" $TEMPSECTION`;
    fi;
    sbfont green;
    echo "Host: $HOST | Page: $SBPAGE | Section: $SBSECTION";
    sbfont white
}
