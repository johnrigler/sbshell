sql.LoadInventory () 
{ 
    - 1= filename 2= table;
    echo "load data local infile '$1' into table $2;"
}
