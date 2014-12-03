sbshowdsh () 
{ 
    cat $SBDSH | xargs -n999 | sed 's/\ /,/g'
}
