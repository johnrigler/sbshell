sql.Insert.Datacenter () 
{ 
    ( echo $1;
    cat $1 | xargs -n2 | egrep --color=auto --color=auto --color=auto 'x|kick' | xargs -n1 | grep --color=auto --color=auto --color=auto -v ":" | sed 's/,//g' | xargs ) | xargs -n3
}
