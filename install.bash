: version_5.0 pre-merge
export _SBCOLOR=red;
: Set your directory path here or specify with
: ./install.bash /usr/local/shells/examples/sbshell
export _SBDIR=~/sbshell;

cd ~/sbshell
git pull
git checkout version_5.0

                                          #SB
sbshell() {                               #SB
                                          #SB
: Verify that _SBDIR is the correct path  #SB
                                          #SB
                                          #SB
export _SBDIR=~/sbshell                   #SB
. $_SBDIR/lib/_sb/shell.bash              #SB
                                          #SB
echo "$SBDIR from sbshell()"              #SB
                                          #SB
_sb.shell                                 #SB
                                          #SB
}                                         #SB
                                          #SB                               

echo >> ~/.bashrc
grep -v "#SB" ~/.bashrc >> $$
grep "#SB" $0 | grep -v "^grep" >> $$
mv $$ ~/.bashrc

vi ~/.bashrc
