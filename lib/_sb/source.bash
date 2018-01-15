_sb.source() {

touch $$ /tmp/$$

declare -f $1 >> $$
   echo "----------------------------------------------------------"
   cat $$

if [[ $1 == "_"* ]] 
   then
   : function name matches "_*"
   cat $$ | sed "s/^_/_sb./g" > /tmp/$$ 
else
   : function name does not match "_*"
   : append 'sb.' before function or some other behaviour
   cat $$ | s/^[az]/sb./g > /tmp/$$
fi 

   echo "----------------------------------------------------------"
cat /tmp/$$  
source /tmp/$$ 
rm $$ /tmp/$$ 
  
}
