var http = require('http');

var mattermost = http.createServer(function(req,res) {

        res.writeHeader(200, { 'Content-Type': 'text/plain' });
	res.write('Echo server\r\n');
	res.end();
});

mattermost.listen(1337);
