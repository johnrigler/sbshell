date.HM ()
{
    date "+%H%M"
}

date.Y ()
{
    date "+%Y"
}

date.W () 
{
    date "+%W"
}

date.w ()
{
    date "+%w"
}

fabreq.define () 
{ 
    : set _FABREQ_DIR to be where you want this to live
    export _FABREQ_DIR="/home/jrigler/softball/fabreq"
    : purge last years data by simply moving or removing the directory
    export _FABREQ_DATA_PATH="$_FABREQ_DIR/$(date.Y)/$(date.W)" 
    mkdir -p $_FABREQ_DATA_PATH 2>/dev/null
    : a fabr file is tagged script command output
    export _FABREQ_DATA="$_FABREQ_DATA_PATH/$1.fabr"
    : customize for this ticket 
    export _FABREQ_INIT="$_FABREQ_DIR/init/FABREQ-$1.init"
    : contains all that is declared in the subshell
    export _FABREQ_SHELL="$_FABREQ_DIR/_script.rc"
    : show me what you set
    fabreq.env
}
