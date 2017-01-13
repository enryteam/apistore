var io = require('socket.io').listen(18171),
fs = require('fs'),
cookie=require('cookie');
request=require('request');
global.userlist={};


//io.set('log level', 1);//将socket.io中的debug信息关闭

var content;
var socketUser = {};
var settings={};
var id;
var type;
settings.host='http://jjs.51daniu.cn/rest/';
io.sockets.on('connection', function (socket) {

  setInterval(function(){
    request(settings.host+'index.php?c=trade&a=release_detail&g_code=171',function(err,res,body){

        //console.log(res);
        if(!err&&res.statusCode==200){
          socket.broadcast.emit('enryROOMreceive18171',body);
        }

    });
  },5000);


});
