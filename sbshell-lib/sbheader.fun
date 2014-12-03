sbheader () 
{ 
    scp $URI/$THISPAGE-00.php /tmp/$$.header;
    if [[ $? -eq 1 ]]; then
        echo "<div>" > /tmp/$$.header;
        echo "[][]" >> /tmp/$$.header;
        echo "</div>" >> /tmp/$$.header;
    fi;
    vim /tmp/$$.header;
    scp /tmp/$$.header $URI/$THISPAGE-00.php;
    rm /tmp/$$.header
}
