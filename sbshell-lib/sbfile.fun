sbfile () 
{ 
    scp $1 $URI/$1;
    echo "<div>
   <a href=$1> $1 </a>
</div>" > $THISPAGE-$THISSECTION.php;
    scp $THISPAGE-$THISSECTION.php $URI/.;
    rm $THISPAGE-$THISSECTION.php
}
