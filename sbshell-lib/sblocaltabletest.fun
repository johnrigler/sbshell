sblocaltabletest () 
{ 
    while read LINE; do
        echo $LINE;
    done | sbtable.pyc > /var/www/sbtable.html;
    firefox http://127.0.0.1/sbtable.html
}
