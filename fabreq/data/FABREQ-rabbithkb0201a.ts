Script started on Thu 25 Jan 2018 10:39:29 PM CST
[32mwelcome to the shell..
jrigler  28248 28039  0 20:34 pts/3    00:00:00 script --flush --force --append -c bash -rcfile ~/softball/fabreq/_script.rc # 28039 /home/jrigler/softball/data/FABREQ-330.ts
jrigler  28250 28248  0 20:34 pts/3    00:00:00 script --flush --force --append -c bash -rcfile ~/softball/fabreq/_script.rc # 28039 /home/jrigler/softball/data/FABREQ-330.ts
jrigler  30660 30448  0 22:39 pts/0    00:00:00 script --flush --force --append -c bash -rcfile ~/softball/fabreq/_script.rc # 30448 /home/jrigler/softball/data/FABREQ-rabbithkb0201a.ts
jrigler  30662 30660  0 22:39 pts/0    00:00:00 script --flush --force --append -c bash -rcfile ~/softball/fabreq/_script.rc # 30448 /home/jrigler/softball/data/FABREQ-rabbithkb0201a.ts
jrigler  30665 30663  0 22:39 pts/1    00:00:00 grep FABREQ
[36m[?1034hbash-4.2$ ssh rabbithkb[Kg0201a
Authorized uses only. All activity may be monitored and reported.

Last login: Thu Jan 25 22:37:58 2018 from 172.21.138.176
Authorized uses only. All activity may be monitored and reported.

]0;jrigler@rabbithkg0201a:~[?1034h[jrigler@rabbithkg0201a ~]$ sudo su -

We trust you have received the usual lecture from the local System
Administrator. It usually boils down to these three things:

    #1) Respect the privacy of others.
    #2) Think before you type.
    #3) With great power comes great responsibility.

[sudo] password for jrigler: 
p11-kit: duplicate 'USGOV SubCA01' certificate found in: usgov-subca.20340507.crt
]0;root@rabbithkg0201a:~[?1034h[root@rabbithkg0201a ~]# ps -ef | grep rabbit
root     21329 20714  0 22:42 pts/0    00:00:00 grep rabbit
rabbitmq 23580     1  0  2017 ?        00:03:48 /usr/lib64/erlang/erts-5.9/bin/epmd -daemon
root     23856     1  0  2017 ?        00:00:00 runuser rabbitmq --session-command /usr/sbin/rabbitmq-server
rabbitmq 23859 23856  0  2017 ?        00:00:00 /bin/sh /usr/sbin/rabbitmq-server
rabbitmq 23868 23859 64  2017 ?        135-16:00:01 /usr/lib64/erlang/erts-5.9/bin/beam.smp -W w -K true -A30 -P 1048576 -- -root /usr/lib64/erlang -progname erl -- -home /home/rabbitmq -- -noshell -noinput -sname rabbit@rabbithkg0201a -boot /var/lib/rabbitmq/mnesia/rabbit@rabbithkg0201a-plugins-expand/rabbit -config /etc/rabbitmq/rabbitmq -kernel inet_default_connect_options [{nodelay,true}] -sasl errlog_type error -sasl sasl_error_logger false -rabbit error_logger {file,"/var/log/rabbitmq/rabbit@rabbithkg0201a.log"} -rabbit sasl_error_logger {file,"/var/log/rabbitmq/rabbit@rabbithkg0201a-sasl.log"} -os_mon start_cpu_sup false -os_mon start_disksup false -os_mon start_memsup false -mnesia dir "/var/lib/rabbitmq/mnesia/rabbit@rabbithkg0201a"
rabbitmq 24555 23868  0  2017 ?        00:00:01 inet_gethost 4
rabbitmq 24718 24555  0  2017 ?        00:00:00 inet_gethost 4
rabbitmq 24719 24555  0  2017 ?        00:00:00 inet_gethost 4
]0;root@rabbithkg0201a:~[root@rabbithkg0201a ~]# cd /etc/log
-bash: cd: /etc/log: No such file or directory
]0;root@rabbithkg0201a:~[root@rabbithkg0201a ~]# cd /etc/ogs
-bash: cd: /etc/ogs: No such file or directory
]0;root@rabbithkg0201a:~[root@rabbithkg0201a ~]# lcd /[K[K[K[K[Kcd /et[K[Kvar
]0;root@rabbithkg0201a:/var[root@rabbithkg0201a var]# cd logs
-bash: cd: logs: No such file or directory
]0;root@rabbithkg0201a:/var[root@rabbithkg0201a var]# cd spol[Kol
]0;root@rabbithkg0201a:/var/spool[root@rabbithkg0201a spool]# pwd
/var/spool
]0;root@rabbithkg0201a:/var/spool[root@rabbithkg0201a spool]# ls
[0m[01;34manacron[0m  [01;34mcron[0m  [01;34mlpd[0m  [01;34mmail[0m  [01;34mplymouth[0m  [01;34mpostfix[0m  [01;34mup2date[0m
[m]0;root@rabbithkg0201a:/var/spool[root@rabbithkg0201a spool]# cd ..
]0;root@rabbithkg0201a:/var[root@rabbithkg0201a var]# cd rab[K[K[K[K[K[Kcd /etc
]0;root@rabbithkg0201a:/etc[root@rabbithkg0201a etc]# cd rabbitmq/
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# ls
enabled_plugins  rabbitmq.config
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# catt [K[K rabbitmq.config
[{rabbit, [{cluster_nodes, ['rabbit@rabbithkg0201a','rabbit@rabbithkg0201b','rabbit@rabbithkg0201c']}]}].  
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# jw
-bash: jw: command not found
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# jq
-bash: jq: command not found
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# ls -l
total 8
-rw-r--r-- 1 root wheel  23 Jul 27  2016 enabled_plugins
-rw-r--r-- 1 root root  108 Jul 27  2016 rabbitmq.config
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# pwd
/etc/rabbitmq
]0;root@rabbithkg0201a:/etc/rabbitmq[root@rabbithkg0201a rabbitmq]# exit
logout
]0;jrigler@rabbithkg0201a:~[jrigler@rabbithkg0201a ~]$ cat /etc/rabbitmq/rabbitmq.config
[{rabbit, [{cluster_nodes, ['rabbit@rabbithkg0201a','rabbit@rabbithkg0201b','rabbit@rabbithkg0201c']}]}].  
]0;jrigler@rabbithkg0201a:~[jrigler@rabbithkg0201a ~]$ exit
logout
Connection to rabbithkg0201a closed.
bash-4.2$ exit
exit

Script done on Thu 25 Jan 2018 10:44:57 PM CST
