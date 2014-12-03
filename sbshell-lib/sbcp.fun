sbcp () 
{ 
    if [[ ! -n $1 ]]; then
        let NEXT=THISPAGE+1;
    else
        let NEXT=$1;
    fi;
    THISSECTION="01";
    THISPAGE="$NEXT";
    SBSECTION="01";
    SBPAGE="$NEXT";
    sbls
}
