__sb.nitro.pbx () 
{ 
    - pbx service query;
    -1 "thyilbdal0501a.softlayer.local" $1;
    -pass;
    curl -k "https://$_SBUSER:$__SBPWD@$ARG1/nitro/v1/config/service" | jq
}

_sb.init nitro.pbx
