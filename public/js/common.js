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
            userFavor: []
        },
        updated: function() {
            layui.element().init();
        },
        created: function() {
            var userID = getUserId();
            console.log(userID);
            let self = this;

            if (!userID) {
                return false;
            }
            this.$http.get('/user/info/' + userID).then(resp => {
                self.userInfo = resp.body.result;
                if (self.userInfo.username && self.userInfo.username !== '') {
                    self.loginIn = true;
                    if (self.loginIn && localStorage['userFavor']) {
                        var _userFavor = JSON.parse(localStorage['userFavor']);
                        console.log(_userFavor);
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

        },
        watch: {
            loginIn: function(newV, oldV) {
                layui.element().init();
            }
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
            }
        }
    });

});
