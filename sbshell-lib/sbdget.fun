sbdget () 
{ 
    cat $SBDSH | while read SBHOST; do
        echo $SBHOST;
        scp $SBHOST:$1 $1.$SBHOST;
    done
}
