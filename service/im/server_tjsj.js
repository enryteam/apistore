var io = require('socket.io').listen(11212),
fs = require('fs'),
cookie=require('cookie');
request=require('request');
global.userlist={};


//io.set('log level', 1);//将socket.io中的debug信息关闭

var content;
var socketUser = {};
var settings={};
var id;
var toid;
var type;
settings.host='http://tjsj.51daniu.cn/rest/';
io.sockets.on('connection', function (socket) {

          //监听接收信息
          socket.on('enryIMsend', function (data) {
              console.log(data);
              if(data.touserid&&data.fromuserid){
                  id = data.fromuserid;
                  toid = data.touserid;
                  msgtype = data.msgtype;
                  data.content = data.content;
                  content = data.content;
              }
              //console.log(settings.host+'index.php?c=im&a=tjsj&type=getinfo&sid='+id+'&touid='+toid+'&msg='+content);
              request(settings.host+'index.php?c=im&a=tjsj&type=getinfo&sid='+id+'&touid='+toid+'&msgtype='+msgtype+'&msg='+content,function(err,res,body){
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
                          // socket.emit('enryIMinit',{
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
                              request(settings.host+'index.php?c=im&a=tjsj&type=unline&sid='+id,function(err,res,body){})
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
              if(data.touserid&&userlist[data.touserid]!=undefined){

                  var user=userlist[data.touserid];

                  //data.fromuserid=socketUser[data.fromuserid].userid;
                  //console.log(socketUser[data.fromuserid]);
                  //data.fromuserid = data.touserid;
                  //将用户信息发送给指定用户
                  user.emit('enryIMreceive',data);
                  console.log(data.touserid+"=============>"+data.fromuserid);

              }
          });
});
