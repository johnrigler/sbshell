sbpre ()
{
if [[ `uname` = 'AIX' ]]
        then
        sbfont yellow
        script /tmp/$$.temp
        fi

if [[ `uname` = 'Linux' ]]
        then
        sbfont yellow
        echo 'export PS1="{($PS1)} "' > $$.rc;
        echo 'export PS2="{($PS2)} "' >> $$.rc;
        script -c "bash --rcfile $$.rc" /tmp/$$.temp;
        rm $$.rc;
        fi

        sbfont white
        scp /tmp/$$.temp $SBSRV:$SBPATH/$SBDIR/.
        sbenv | ssh $SBSRV $SBRCMDS/sbpre.`uname`.`basename $SHELL`.remote $$
        rm /tmp/$$.*

}
