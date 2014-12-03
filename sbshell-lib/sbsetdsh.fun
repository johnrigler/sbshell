sbsetdsh () 
{ 
    ls --color=tty $SBDSHDIR/$1 | tee $SBDSH
}
