sbfont () 
{ 
    case $1 in 
        white)
            FG='0m'
        ;;
        bold)
            FG='1m'
        ;;
        underline)
            FG='4m'
        ;;
        error)
            FG='31m'
        ;;
        red)
            FG='31m'
        ;;
        green)
            FG='32m'
        ;;
        yellow)
            FG='33m'
        ;;
        blue)
            FG='34m'
        ;;
        purple)
            FG='35m'
        ;;
        aqua)
            FG='36m'
        ;;
    esac;
#    echo -n -e 
     printf "\033[$FG"
}
