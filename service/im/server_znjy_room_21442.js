var io = require('socket.io').listen(21442),
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

settings.host='http://znjy.51daniu.cn/rest/';
io.sockets.on('connection', function (socket) {

          //监听接收信息
          socket.on('enryROOMsend', function (data) {
              console.log(data);
              if(data.fromuserid){
                  id = data.fromuserid;
                  type = data.msgtype;
                  content = data.content;
              }
              console.log(settings.host+'index.php?c=imroom&a=znjy&type=getinfo&sid='+id+'&port=21442&msgtype='+type+'&msg='+content);
              request(settings.host+'index.php?c=imroom&a=znjy&type=getinfo&sid='+id+'&port=21442&msgtype='+type+'&msg='+content,function(err,res,body){
                  //console.log(id+res.statusCode+body);
                  if(!err&&res.statusCode==200){

                      if(body){
                          body=eval('('+body+')');
                          //console.log(body);
                          var userid=body.sid;
                          var username=body.sid;
                          var online=body.online;
                          if(id!=undefined&&id!=null)
                          {
                            //将新用户存进socket用户列表中
                            userlist[id]=socket;
                            //console.log(userlist[id]);
                            socketUser[id] = {
                                'userid':userid,
                                'username':username,
                                'userline':online
                            };
                            //console.log(socketUser );
                          }
                           //发送信息给新登录用户
                          //  socket.emit('system',{
                          //      'alluser':socketUser
                          //  });


                          //console.log(socketUser);
                          // //上线欢迎
                          // socket.emit('enryROOMinit',{
                          //     'msg':'welcome!'
                          // })
                          // //广播  推送已登录的用户
                          // socket.broadcast.emit('broadcast',{
                          //     'userid':userid,
                          //     'username':username,
                          //     'type':2
                          // });
                          //下线推送通知  disconnect方法名不能修改
                          socket.on('disconnect',function(){
                              //更改用户不在线
                              if(id!=undefined)
                              {
                              socketUser[id]=null;
                              userlist[id]=null;
                              }
                              request(settings.host+'index.php?c=imroom&a=znjy&type=unline&sid='+id,function(err,res,body){})
                              socket.broadcast.emit('broadcast',{
                                  'msg':'offline',
                                  'offlineid':id,
                                  'offlinename':username,
                                  'type':1
                              });
                          })
                      }else{
                          console.log('falseness connect');
                      }
                  }
              })
              //将用户信息发送给房间内用户
              //console.log(data);
              socket.broadcast.emit('enryROOMreceive',data);
          });
});
