sbdesc () 
{ 
    scp $URI/desc.php /tmp/$$.desc;
    vim /tmp/$$.desc;
    scp /tmp/$$.desc $URI/desc.php;
    rm /tmp/$$.desc
}
