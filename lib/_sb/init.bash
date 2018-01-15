_sb.init () 
{ 
    echo "--- $1 ----";
    EVAL="$1() { _sb.process __sb.$1 ARGS; }";
    EVAL=`echo $EVAL | sed 's/ARGS/$*/'`;
    eval $EVAL
}
