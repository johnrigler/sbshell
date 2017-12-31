sql.Insert.All.Datacenters () 
{ 
    ls --color=auto --color=auto --color=auto | while read A; do
        sql.Insert.Datacenter $A | sed 's/\.json//g' | sed 's/\.softlayer\.local//g';
    done | while read DC XCLUSTER KICKSTARTER; do
        echo "insert into datacenters (datacenter,xcluster,kickstarter,nicename) values ('$DC','$XCLUSTER','$KICKSTARTER','');";
    done | mysql isinventory
}
