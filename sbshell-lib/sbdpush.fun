sbdpush () 
{ 
    cat $SBDSH | while read SBHOST; do
        scp $1 $SBHOST:$2 &
    done
}
