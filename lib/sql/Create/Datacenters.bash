sql.Create.Datacenters () 
{ 
    echo "
create table datacenters (
id int(11) not null auto_increment,
datacenter varchar(16),
xcluster varchar(16),
kickstarter varchar(16),
nicename varchar(64),
primary key(id)
); " | mysql isinventory
}
