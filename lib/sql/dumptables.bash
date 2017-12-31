sql.dumptables () 
{ 
    - Dump entire database table by table;
    echo "show tables\G" | mysql $1 | grep --color=auto --color=auto --color=auto "^Tables" | cut -c 32- | while read TABLE TRASH; do
        mysqldump $1 $TABLE > "$TABLE".dump;
    done
}
