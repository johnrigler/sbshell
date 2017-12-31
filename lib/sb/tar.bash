__sb.sb.tar() {

WD=`pwd`
cd ~
tar -cf sbshell.tar sbshell
scp sbshell.tar nahc-pgsql1:.
cd $WD

} 

_sb.init 'sb.tar'
