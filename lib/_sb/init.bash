_sb.init () 
{ 
    echo "--- $1 ----";
    source $_SBDIR/lib/sb/$1.bash
    EVAL="$1() { _sb.process __sb.$1 ARGS; }";
    EVAL=`echo $EVAL | sed 's/ARGS/$*/'`;
    eval $EVAL

}
