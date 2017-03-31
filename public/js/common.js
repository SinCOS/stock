$(function() {


    login = function() {
        destoryStorage();
        layer.open({
            type: 1,
            content: $('#login_frm').html(),
            area: [
                '400px', '400px'
            ]
        });
    }
    getUserId = function() {
        if (localStorage.userID !== null) {
            return localStorage['userID']; }
        return false;
    }
    register = function() {
        layer.open({
            type: 1,
            content: $("#register_frm").html(),
            area: [
                '400px', '400px'
            ]
        });
    }

    function destoryStorage() {
       localStorage.clear();
    }

    function saveUserFavor(result) {
        if (result) {
            localStorage['userFavor'] = JSON.stringify(result);

        }

    }
    shutdown = function() {
        if (localStorage.userID) {
            destoryStorage();
        }
        window.location = "/user/logoff";
    }
    layui.use(['element', 'form'], function() {
        var element = layui.element();
        var form = layui.form();
        form.on('submit(formDemo)', function(data) {
            if (data.field.username.length < 5) {
                layer.msg('用户名长度不能少于5个字符');
                return false;
            }
            if (data.field.password.length < 6) {
                layer.msg('密码长度太短');
                return false;
            }
            $.post('/user/login', data.field, function(data, textStatus, xhr) {
                if (data.status == 200) {
                    localStorage['userID'] = data.result.userID;
                    localStorage['token'] = data.result.token;
                    app.reflushFavor();
                    window.location = "/";
                    return;
                } else {
                    layer.msg(data.message);
                }
            }, 'json');
            return false;
        });
        form.on('submit(register_frm)', function(data) {

        });

    });
    app = new Vue({
        el: "#app",
        data: {
            loginIn: false,
            userInfo: [],
            userFavor: [],
            favorIndex: 0,
            favorClickIndex: false,
            favorselectIndex:0,
            echarts:null
        },
        updated: function() {
            layui.element().init();
        },
        created: function() {
            var userID = getUserId();
            console.log(userID);
            let self = this;

            if (!userID) {
                return ;
            }
            this.$http.get('/user/info/' + userID).then(resp => {
                self.userInfo = resp.body.result;
                if (self.userInfo.username && self.userInfo.username !== '') {
                    self.loginIn = true;
                    if (self.loginIn && localStorage['userFavor']) {
                        var _userFavor = JSON.parse(localStorage['userFavor']);
                        if (_userFavor) {
                            self.userFavor = _userFavor;
                        }else{
                        	app.reflushFavor();
                        }
                    } else {
                        app.reflushFavor();
                    }
                } else {
                    destoryStorage();
                }

            }, resp => {
                self.loginIn = false;
            });
            console.log(self.loginIn);
            if (table_info && table_info.current){
                      setInterval(function(){
                table_info.current.ajax.reload();
                 },60*1000);
            }
          
        },
        watch: {
            loginIn: function(newV, oldV) {
                layui.element().init();
            }
        },mounted: function(){
              //layui.element().init();
              
        },
        methods: {
            reflushFavor: function() {
                var self = this;
                this.$http.get('/user/category').then(resp => {
                    if (resp.body.status == 200) {
                        self.userFavor = resp.body.result;
                        saveUserFavor(resp.body.result);
                    }
                }, fail => {
                    console.log(JSON.stringify(fail));
                });
            },
            favor_select: function(id){
            	this.favorIndex = id;
            },
            favor_click: function(id,public = 0){

                if (id == 0 && public == 0) {
                    table_info.stock_url = stock_url;
                     this.favorClickIndex = false;
                    table_info.current.ajax.reload();
                }else if(public == 0){
                    table_info.stock_url = stock_url + '/' +id +'/0';
                     this.favorClickIndex = false;
                }else{
                    table_info.stock_url = stock_url + '/' + id;
                    this.favorClickIndex = true;
                    table_info.current.ajax.reload();
                }
                this.favorselectIndex = id;
            },
            save_favor: function(cpy_id){
            	var self = this;
            	console.log(self.favorIndex);
            	if(self.favorIndex == 0 ){
            		layer.msg('请选择分类');
            		return false;
            	}
            	this.$http.post('/user/favor/'+cpy_id,{sg_id : self.favorIndex}).then(resp => {
            		layer.msg(resp.body.message);
            	}, fail => {

            	})	
            	return true;
            }
        }
    });

});
