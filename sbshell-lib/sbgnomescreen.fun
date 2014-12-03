sbgnomescreen () 
{ 
    gnome-screensaver-command -q | grep inactive > /dev/null 2>&1;
    RC=$?;
    if [[ $RC -eq 0 ]]; then
        echo "Inactive";
    else
        echo "Active";
    fi
}
