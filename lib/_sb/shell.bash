_sb.shell() {
: creates base functionality for _sb
	echo version 5.0;


if [ -n $1 ]
  then
   echo xxx
  fi

. $_SBDIR/lib/_sb/declare_F.bash
. $_SBDIR/lib/_sb/source.bash
. $_SBDIR/lib/_sb/process.bash
. $_SBDIR/lib/_sb/init.bash

#. $_SBDIR/lib/sb/home.bash
#. $_SBDIR/lib/sb/checkip.bash

_sb.init sb.home
_sb.init sb.color
_sb.init sb.checkip
_sb.init sb.env

#. $_SBDIR/lib/sb/color.bash
. $_SBDIR/lib/sb/color/no.bash
: sb/color/alp.bash
: sb/modules.bash
: sb/pass.bash
: sb/mail.test.bash
: sb/runfor.bash
: sb/create.bash
: sb/status.bash
: sb/dsh.bash
: sb/tar.bash
: sb/env.bash
: sb/color.bash

-() { :; }
--() { :; }
---() { :; }

-1() {

if [[ -n $2 ]]
then
ARG1=$2
else
ARG1=$1;
fi
    }

}
