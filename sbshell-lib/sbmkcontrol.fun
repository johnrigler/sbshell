sbmkcontrol () 
{ 
    echo "#!/bin/bash 

AUDITNAME=$1
AUDITROWS=5
AUDITFORMAT=html
AUDITDESC='Describe Audit Here'
AUDITTEST='Test for pass'

# function header { echo; }  ## Runs before remote execution
# function remote { echo; }  ## Runs remotely and is consolidated 
# function footer { echo; }  ## Runs after remote execution

" > $1;
    chmod 755 $1;
    vim $1
}
