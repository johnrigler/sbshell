_sb.init () 
{ 
    echo "--- $1 ----";
    original=`echo $1 | sed 's/\./\//'`
    : load original function into shell 
    source "$_SBDIR/lib/$original".bash
#    ORIGINAL=$(declare -f $1)
    : reload with __sb. prefix
    (
    echo -n "__sb."
    declare -f $1
    ) > $$
    source $$ 

    : overload stub over original name
    EVAL="$1() { _sb.process __sb.$1 ARGS; }";
    EVAL=`echo $EVAL | sed 's/ARGS/$*/'`;
    eval $EVAL

}
