/**
 * New node file
 */
/**
 * New node file
 */

//引入http模块
var socketio = require('socket.io'),
	mysql    = require('mysql'),
	http     = require('http'),
	domain   = require('domain'),
	colors = require('colors'); 
var d = domain.create();
d.on("error", function(err) {
	console.log(err);
}); 
//是否开启bug调试模式 
var ISDEBUG = true;
var server = http.createServer(function(req, res) {

	res.writeHead(200, {
		'Content-type': 'text/html'
	});

	res.end();
}).listen(7130, function() {
	console.log('Ok'.red);
});


//禁言用户
var shutuparr = new Array();
//被踢用户
var kickarr = new Array();
//房间用户列表
var clients = {};
var io=socketio.listen(server);
io.on('connection', function(socket) {

	debuglog('连接成功');

	//进入房间
	socket.on('cnn', function(data) {
		
			socket.roomnum = data.roomnum;
			socket.equipment = data.equipment;
			var username = typeof data.username == "undefined"?"游客":data.username;
			var nickanme = data.nickname;
			var ucuid = typeof data.ucuid == "undefined"?'':data.ucuid;
			var uid   = typeof data.uid == "undefined"?data.userid:data.uid;
			socket.uid = uid;
			clients[uid + "@"] = {
				nickanme     :username,
				username     :username,
				ucuid        :ucuid,
				uid          :uid,
				equipment    :data.equipment,
				userBadge    :'',
				goodnum      :data.goodnum,
				h            :data.h,
				level        :data.level,
				richlevel    :data.richlevel,
				spendcoin    :data.spendcoin,
				sellm        :data.sellm,
				sortnum      :data.sortnum,
				username     :data.username,
				vip          :data.vip,
				familyname   :data.familyname,
				userType     :data.userType,
				nowroomnum   :data.roomnum
			};
			console.log(data.sortnum)
			socket.join(data.roomnum + data.equipment);
			socket.join(data.roomnum);
			if(data.equipment=='app'){
				socket.broadcast.to(data.roomnum).emit("join","{\"msg\":[{\"_method_\":\"SendMsg\",\"action\":\"0\",\"ct\":{\"actBadge\":\""+clients[uid + "@"].userBadge+"\",\"familyname\":\""+clients[uid + "@"].familyname+"\",\"goodnum\":\""+clients[uid + "@"].goodnum+"\",\"h\":\""+clients[uid + "@"].h+"\",\"level\":\""+clients[uid + "@"].level+"\",\"richlevel\":\""+clients[uid + "@"].richlevel+"\",\"sellm\":\""+clients[uid + "@"].sellm+"\",\"sortnum\":\""+clients[uid + "@"].sortnum+"\",\"userType\":\""+clients[uid + "@"].userType+"\",\"userid\":\""+clients[uid + "@"].uid+"\",\"username\":\""+clients[uid + "@"].username+"\",\"vip\":\""+clients[uid + "@"].vip+"\",\"equipment\":\""+clients[uid + "@"].equipment+"\"},\"msgtype\":\"0\",\"timestamp\":\""+new Date().getHours()+":"+new Date().getMinutes()+"\",\"tougood\":\"\",\"touid\":\"\",\"touname\":\"\",\"ugood\":\""+clients[uid + "@"].goodnum+"\",\"uid\":\"\",\"trueuserid\":\"\",\"uname\":\"\"}],\"retcode\":\"000000\",\"retmsg\":\"OK\",\"equipment\":\""+clients[uid + "@"].equipment+"\"}");	
			}else{
				socket.broadcast.to(data.roomnum + 'app').emit("join","{\"msg\":[{\"_method_\":\"SendMsg\",\"action\":\"0\",\"ct\":{\"actBadge\":\""+clients[uid + "@"].userBadge+"\",\"familyname\":\""+clients[uid + "@"].familyname+"\",\"goodnum\":\""+clients[uid + "@"].goodnum+"\",\"h\":\""+clients[uid + "@"].h+"\",\"level\":\""+clients[uid + "@"].level+"\",\"richlevel\":\""+clients[uid + "@"].richlevel+"\",\"sellm\":\""+clients[uid + "@"].sellm+"\",\"sortnum\":\""+clients[uid + "@"].sortnum+"\",\"userType\":\""+clients[uid + "@"].userType+"\",\"userid\":\""+clients[uid + "@"].uid+"\",\"username\":\""+clients[uid + "@"].username+"\",\"vip\":\""+clients[uid + "@"].vip+"\",\"equipment\":\""+clients[uid + "@"].equipment+"\"},\"msgtype\":\"0\",\"timestamp\":\""+new Date().getHours()+":"+new Date().getMinutes()+"\",\"tougood\":\"\",\"touid\":\"\",\"touname\":\"\",\"ugood\":\""+clients[uid + "@"].goodnum+"\",\"uid\":\"\",\"trueuserid\":\"\",\"uname\":\"\"}],\"retcode\":\"000000\",\"retmsg\":\"OK\",\"equipment\":\""+clients[uid + "@"].equipment+"\"}");	
			}
			socket.emit("Conn",updateuserlist(socket));	
			

	});
	socket.on('sendmsg',function(data){
		    console.log("聊天".red);
		    var data = typeof data == 'object'?JSON.stringify(data):data;
		    if(socket.equipment == 'app'){
		    	io.to(socket.roomnum).emit("showmsg",data);
		    }else{
		    	io.to(socket.roomnum + 'app').emit("showmsg",data);  
		    }
	})

	socket.on('disconnect', function() {
		d.run(function() { 
			
			if(socket.uid==undefined){
				return;
			}
			var userClient = clients[socket.uid + "@"];
			console.log("离开广播"+userClient.goodnum);
			socket.broadcast.to(socket.roomnum + 'pc').emit("showmsg","{\"msg\":[{\"_method_\":\"SendMsg\",\"action\":\"1\",\"ct\":{\"actBadge\":\"\",\"familyname\":\"\",\"goodnum\":\""+userClient.goodnum+"\",\"h\":\""+userClient.h+"\",\"level\":\""+userClient.level+"\",\"richlevel\":\""+userClient.richlevel+"\",\"sellm\":\""+userClient.sellm+"\",\"sortnum\":\""+userClient.sortnum+"\",\"userType\":\""+userClient.userType+"\",\"userid\":\""+userClient.uid+"\",\"username\":\""+userClient.username+"\",\"vip\":\""+userClient.vip+"\",\"equipment\":\""+userClient.equipment+"\"},\"msgtype\":\"0\",\"timestamp\":\""+new Date().getHours()+":"+new Date().getMinutes()+"\",\"tougood\":\"\",\"touid\":\"\",\"touname\":\"\",\"ugood\":\""+userClient.goodnum+"\",\"uid\":\""+socket.uid+"\",\"trueuserid\":\"\",\"uname\":\""+userClient.username+"\"}],\"retcode\":\"000000\",\"retmsg\":\"OK\",\"equipment\":\""+clients[socket.uid + "@"].equipment+"\"}");	
		    socket.broadcast.to(socket.roomnum + 'app').emit("onUserdisconnect","{\"msg\":[{\"_method_\":\"SendMsg\",\"action\":\"1\",\"ct\":{\"actBadge\":\"\",\"familyname\":\"\",\"goodnum\":\""+userClient.goodnum+"\",\"h\":\""+userClient.h+"\",\"level\":\""+userClient.level+"\",\"richlevel\":\""+userClient.richlevel+"\",\"sellm\":\""+userClient.sellm+"\",\"sortnum\":\""+userClient.sortnum+"\",\"userType\":\""+userClient.userType+"\",\"userid\":\""+userClient.uid+"\",\"username\":\""+userClient.username+"\",\"vip\":\""+userClient.vip+"\",\"equipment\":\""+userClient.equipment+"\"},\"msgtype\":\"0\",\"timestamp\":\""+new Date().getHours()+":"+new Date().getMinutes()+"\",\"tougood\":\"\",\"touid\":\"\",\"touname\":\"\",\"ugood\":\""+userClient.goodnum+"\",\"uid\":\""+socket.uid+"\",\"trueuserid\":\"\",\"uname\":\""+userClient.username+"\"}],\"retcode\":\"000000\",\"retmsg\":\"OK\",\"equipment\":\""+userClient.equipment+"\"}");
		    socket.leave(socket.roomnum);
			socket.leave(socket.roomnum + userClient.equipment);
		    delete clients[socket.uid + "@"];
		    debuglog(countclient());
		});
	});


});
/* =================================================================TOOLS FUNCTION===================================================================================================== */
function contains(arr, id) {
	for (var i = 0; i < arr.length; i++) {
		if (arr[i] === id) {
			return true;
		}
	}

	return false;
}
Array.prototype.remove=function(val){
	var index=this.indexOf(val);
	if(index>-1){
		this.splice(index,1);
	}
}
//更新格式化用户列表
function updateuserlist(socket){
	var userliststr = "{\"msg\":[{\"_method_\":\"SendMsg\",\"action\":\"0\",\"ct\":[{\"tucount\":1,\"ucount\":10},{\"ulist\":[";
	var a = 0;
	if(clients[socket.uid+"@"].equipment == 'pc'){
		for(var i in clients){
			a = 1;
			if(socket.roomnum==clients[i].nowroomnum&&clients[i].equipment=='app'){
				userliststr += "{\"actBadge\":\""+clients[i].userBadge+"\",\"familyname\":\""+clients[i].familyname+"\",\"goodnum\":\""+clients[i].goodnum+"\",\"h\":\""+clients[i].h+"\",\"level\":\""+clients[i].level+"\",\"richlevel\":\""+clients[i].richlevel+"\",\"sellm\":\""+clients[i].sellm+"\",\"sortnum\":\""+clients[i].sortnum+"\",\"userType\":\""+clients[i].userType+"\",\"userid\":\""+clients[i].uid+"\",\"username\":\""+clients[i].username+"\",\"vip\":\""+clients[i].vip+"\",\"equipment\":\""+clients[i].equipment+"\"},";
			}	
		}
	}else{
		for(var i in clients){
			a = 1;
			if(socket.roomnum==clients[i].nowroomnum){
				userliststr += "{\"actBadge\":\""+clients[i].userBadge+"\",\"familyname\":\""+clients[i].familyname+"\",\"goodnum\":\""+clients[i].goodnum+"\",\"h\":\""+clients[i].h+"\",\"level\":\""+clients[i].level+"\",\"richlevel\":\""+clients[i].richlevel+"\",\"sellm\":\""+clients[i].sellm+"\",\"sortnum\":\""+clients[i].sortnum+"\",\"userType\":\""+clients[i].userType+"\",\"userid\":\""+clients[i].uid+"\",\"username\":\""+clients[i].username+"\",\"vip\":\""+clients[i].vip+"\",\"equipment\":\""+clients[i].equipment+"\"},";
			}	
		}
	}
	if(i==1){
		userliststr = userliststr.substr(0,userliststr.length-1)+"]}";
	}else{
		userliststr = userliststr+"]}";
	}
	
	userliststr += "],\"msgtype\":\"6\",\"timestamp\":\"\",\"tougood\":\"\",\"touid\":\"\",\"touname\":\"\",\"ugood\":\"\",\"uid\":\"\",\"uname\":\"\"}],\"retcode\":\"000000\",\"retmsg\":\"OK\",\"equipment\":\"app\"}";
    console.log(userliststr)
	return userliststr;
}
function countclient(){
	var i=0;
	for(var s in clients){
		i++;
	}
	return i;
}
//自定义log输出
function debuglog(msg){
	ISDEBUG?console.log(msg):false;
}
//时间格式化
function FormatNowDate(){
		var mDate = new Date();
		var H = mDate.getHours();
		var i = mDate.getMinutes();
		var s = mDate.getSeconds();
		return H + ':' + i + ':' + s;
}
