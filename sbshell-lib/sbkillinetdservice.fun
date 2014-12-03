sbkillinetdservice () 
{ 
    ssh -n $1 "sed 's/^$2/#$2/g' /etc/inetd.conf >> /tmp/$$ ; mv /tmp/$$ /etc/inetd.conf ; refresh -s inetd"
}
