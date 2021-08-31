// JavaScript Document
var socket  = require('socket.io'),
	express = require('express'),
	https   = require('https'),
	http    = require('http'),
	logger  = require('winston');
	
	
logger.remove(logger.transports.Console);
logger.add(logger.transports.Console,{colorize:true,timestamp:true});
logger.info('SocketIO > listening on port');


var app = express();
app.set('port', process.env.PORT || 9000);
app.set('host', process.env.HOST || '0.0.0.0');

var http_server = http.createServer(app).listen(app.get('port'), app.get('host'));

function emitNewOrder(http_server){

  var io = socket.listen(http_server);
  io.sockets.on('connection',function(socket){
	
	socket.on("key",function(data){
		console.log(app.get('host')+' '+app.get('port'));
		io.emit("key",data);
	})  
  })	
  
}



emitNewOrder(http_server);





