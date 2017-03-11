
$(function(){
	

	login = function(){
		layer.open({
			type: 1,
			content: $('#login_frm').html(),
			area: [
				'400px','400px'
			]
		});
	}
	getUserId = function(){
		if (localStorage.userID) {return localStorage.userID;}
		return false;
	}
	register = function (){
		layer.open({
			type: 1,
			content: $("#register_frm").html(),
			area: [
				'400px','400px'
			]
		});
	}
	shutdown = function(){
		if(localStorage.userID){
			localStorage.userID = null;
		}
		window.location = "/user/logoff";
	}
	layui.use(['element','form'], function(){
		 var element = layui.element();
		  var form = layui.form();
          form.on('submit(formDemo)', function(data) {
          	if(data.field.username.length < 5){
          		layer.msg('用户名长度不能少于5个字符');
          		return false;
          	}
          	if(data.field.password.length <6){
          		layer.msg('密码长度太短');
          		return false;
          	}
        	$.post('/user/login', data.field, function(data, textStatus, xhr) {
        		if (data.status == 1) {
                    localStorage['userID']=1;
                    window.location = "/";
                    return;
                }else{
                    layer.msg(data.message);
                }
        	},'json');
            return false;
        });
          form.on('submit(register_frm)',function(data){
          		
          });
        	
	});
	var app = new Vue({
		el: "#app",
		data: {
			loginIn:false,
			userInfo:[]
		},
		updated: function(){
			layui.element().init();
		},
		created: function(){
			var userID = getUserId();
			console.log(userID);
			let self = this;

			if(!userID){
				return false;
			}
			this.$http.get('/user/info/'+userID).then(resp=>{
				self.userInfo = resp.body.result;
				
				self.loginIn = true;
			}, resp=>{
				self.loginIn = false;
			});
		},
		watch:{
			loginIn: function(newV,oldV){
				layui.element().init();
				
			}
		},
		methods:{

		}
		});
});
