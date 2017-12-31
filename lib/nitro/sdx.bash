__sb.nitro.sdx () 
{ 
    - show sdx configuration;
    -1 issdxdal0901b $1;
    -pass;
    curl -s -S --max-time 10 -k "https://$_SBUSER:$__SBPWD@$ARG1/nitro/v1/config/$2";
    curl -s -S --max-time 10 -k "https://$_SBUSER:$__SBPWD@$ARG1/nitro/v2/config/$2"
}

_sb.init nitro.sdx
