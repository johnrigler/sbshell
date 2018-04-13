var net = require('net');

var client = new net.Socket();
client.connect(443,'mattermost.inside.softlayer.com/hooks/1s6b8xtny3bozyuchyne3myfze', function() {
        console.log('Connected');
        client.write('Hello, server! Love, Client.');
});
