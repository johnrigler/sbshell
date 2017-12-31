sql.isinventory.ListImsId () 
{ 
    echo "select ims_json->'$.id' from inventory;" | mysql isinventory
}
