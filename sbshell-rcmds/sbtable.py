#!/usr/bin/python

import sys
import re

def chunks(l, n):
    """ Yield successive n-sized chunks from l.
    """
    for i in xrange(0, len(l), n):
        yield l[i:i+n]

def parsehostname( name ):
		  split = name.split(".")
		  if type(split) == type(str()):
        		return split.rstrip(":")

		  if type(split) == type(list()):
				return split[0].rstrip(":")

def complistsforheader(x,y):
	newlist = []

	for item in y:
		if item in leftlist(x):
			newlist.append(listtodict(x)[item])
		else:
			newlist.append('<img src=/images/singlepixel.png>')
	return newlist 

def leftlist(list):
	newlist = []
	for item in list:
		newlist.append(item[0])
	return newlist

def rightlist(list):
	newlist = []
	for item in list:
		newlist.append(item[1])
	return newlist

def listtodict(list):
	newdict = dict()
	for item in list:
		newdict[item[0]] = item[1]
	return newdict

def setwarning(element):
	element = re.sub('FAIL','<img src=/images/fail_s.png>',element)
	element = re.sub('PASS','<img src=/images/pass_s.png>',element)
	element = re.sub('WARNING','<img src=/images/warning_s.png>',element)
	element = re.sub('EXCEPTION','<img src=/images/exception_s.png>',element)
	element = re.sub('PERCENT','%',element)
	return element


def htmltable(list,dict,ykey):
	print "<table border=1><tr><td>"
        for item in ykey:
                print "<td><img src=/images/vlabel.php?label=" + item + "></td>"
        print "</tr>"

	for item in list:
		print "<tr><td>" + item + "</td>"
		for element in dict[item]:
			print "<td>" + setwarning(element) + "</td>"
		print "</tr>"
	print "</table>"

xkeys = []
ykeys = []
xset = dict()

if (len(sys.argv) > 1):
       	width = int(sys.argv[1])
else:
	width = 6


for line in sys.stdin:
	chompline = line.rstrip()
	values = chompline.split()	
	xkey=parsehostname(values[0])

        if xkey not in xkeys:
                xkeys.append(xkey)
                xset[xkey] = [] 

	if values[1] not in ykeys:
		ykeys.append(values[1])

	if (len(values) == 3):
		newlist = [ values[1],values[2] ] 
	else:
		newlist = [ values[1],'<img src=/images/pass_s.png>']
	
	xset[xkey].append(newlist)

for ykey in chunks(ykeys,width):
	xfinal = dict()
	print
	for xkey in xkeys:
		xfinal[xkey] = complistsforheader(xset[xkey],ykey)
	htmltable(xkeys,xfinal,ykey)


