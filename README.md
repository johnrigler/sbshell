In order to install this tool, you will need a working version of php on a unix or linux server.  Install this into a web directory and then visit the URL for futher instructions.

Fixed simple cosmetic issues.

--------------- add to .bashrc -------------
. /home/jrigler/sbshell.init
. /home/jrigler/somemod/somemod.bash

------------- contents of ~/sbshell.init

__sb.sb.shell () 
{ 
    _SBFILE=sb.bash;
    _SBCOLOR=white;
    _SBDIR=/home/jrigler/sbshell/;
    _SBLIB=$_SBDIR/$_SBFILE;
}

__sb.sb.shell

. $_SBLIB

_sb.load

_sb.init 'sb.shell'
