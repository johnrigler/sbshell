sbaddkey () 
{ 
    echo "$SBSRV" | sed 's/@/ /g';
    HOST=`hostname`;
    WHO=`whoami`;
    if [[ -n $2 ]]; then
        TARGET=$2;
    else
        TARGET=$SBSRV;
    fi;
    ssh $TARGET "mkdir .ssh";
    cat $1 | ssh $TARGET "dd >> ~/.ssh/authorized_keys";
    ssh $TARGET exit;
    if [[ $? -eq 0 ]]; then
        echo "Add worked";
    else
        echo "Add failed";
    fi
}
