__sb.sb.modules () 
{ 
    find $_SBDIR/lib -maxdepth 1 -type d | xargs -n1 basename | sort -u
}

_sb.init sb.modules
