sbvi () 
{ 
    if [[ -e $1 ]]; then
        if [[ -e $DOCBIN/$1.bash ]]; then
            vi $DOCBIN/$1.bash;
        fi;
        . $SBCMDS/$1.bash;
    else
        scp $URI/$SBPAGE-$SBSECTION.php /tmp/$$.sbvi;
        vi /tmp/$$.sbvi;
        scp /tmp/$$.sbvi $URI/$SBPAGE-$SBSECTION.php;
        rm /tmp/$$.sbvi;
    fi
}
