s/<html>/\&#60html\&gt/g
s/<HTML>/\&#60HTML\&gt/g
s/<?/\&#60?/g
s/?>/?\&gt/g
s/<!/\&#60!/g
s/<pre>/\&#60pre>/g
s/<PRE>/\&#60PRE>/g
s/<\/pre>/\&#60\/pre>/g
s/<\/PRE>/\&#60\/PRE>/g
s/<div/\&#60div/g
s/<DIV/\&#60DIV/g
s/<\/div>/\&#60\/div>/g
s/<\/DIV>/\&#60\/DIV>/g
s/<span/\&#60span/g
s/<SPAN/\&#60SPAN/g
s/<\/span>/\&#60\/span>/g
s/<\/SPAN>/\&#60\/SPAN>/g
s/PERCENT/%/g
s/<\./<span class=oldcmd>/g
s/\.>/<\/span>/g
/#-/{
s//<span class=comment>#/
s/$/<\/span>/
}
/^# /{
s//<span class=comment># /
s/$/<\/span>/
}
/^##/{
s//<span style='color: green'>##/
s/$/<\/span>/
}
s/~RED~/<span style='color: red'>/
s/~~/<\/span>/
s/PerCent/\%/
