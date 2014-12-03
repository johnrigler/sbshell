sbcoffee () 
{ 
    echo '<?' > loaddata.php;
    echo '$title = "Change to Title";' >> loaddata.php;
    echo '$name = "unique-name";' >> loaddata.php;
    echo '$body = ' >> loaddata.php;
    echo "'" >> loaddata.php;
    sbcat >> loaddata.php;
    echo "';" >> loaddata.php;
    echo '?>' >> loaddata.php;
    vim loaddata.php;
    scp loaddata.php coffee@rigler.org:autoload;
    ssh coffee@rigler.org "cd autoload; php sqltest.php"
}
