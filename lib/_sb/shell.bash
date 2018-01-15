_sb.shell() {
: creates base functionality for _sb
	echo version 4.1;

. $_SBDIR/lib/_sb/declare_F.bash
. $_SBDIR/lib/_sb/source.bash
. $_SBDIR/lib/_sb/process.bash
. $_SBDIR/lib/_sb/derive.bash
. $_SBDIR/lib/_sb/process.bash
. $_SBDIR/lib/_sb/init.bash
. $_SBDIR/lib/sb/home.bash
. $_SBDIR/lib/sb/checkip.bash
. $_SBDIR/lib/sb/color.bash
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

}
