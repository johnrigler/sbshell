sbssh () 
{ 
    echo ". sbsh" > e;
    echo "sbset $DOCDIR" >> e;
    echo "THISSECTION=$THISSECTION" >> e;
    echo "THISPAGE=$THISPAGE" >> e;
    echo "Type '. ./e' when you get to the prompt. Don't forget to exit back here";
    scp ./e $1:.;
    ssh $1 chmod 700 e;
    ssh $1;
    ssh $1 rm ./e
}
