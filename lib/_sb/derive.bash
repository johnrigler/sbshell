function _sb.derive() {

. $_SBDIR/lib/_sb/process.bash

BASE=`echo $1 | cut -c 6-`
EVAL="$BASE() { _sb.process $1 ARGS; }"
EVAL=`echo $EVAL | sed 's/ARGS/$*/'`
#_sb.init $BASE
echo eval $EVAL
}
