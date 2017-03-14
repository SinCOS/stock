<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>主力动向观测站</title>
    <link rel="shortcut icon" href="../favicon.ico">
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/material-design-lite/1.1.0/material.min.css" rel="stylesheet">-->
    <!--<link href="https://cdn.datatables.net/1.10.12/css/dataTables.material.min.css" rel="stylesheet">-->
    <!--<script src="https://cdn.bootcss.com/datatables/1.10.12/js/dataTables.material.min.js"></script>-->
    <!--<script src="https://cdn.bootcss.com/datatables/1.10.12/js/jquery.dataTables.min.js"></script>-->
    <!-- Latest compiled and minified CSS & JS -->
    <link rel="stylesheet" href="/public/layui/css/layui.css" media="all">
    <script src="//code.jquery.com/jquery.js"></script>
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/r/bs-3.3.5/jq-2.1.4,dt-1.10.8/datatables.min.css">
    <script type="text/javascript" src="//cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
    <!-- <script src="js/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/tips.css" />
<script src="js/time_js.js"></script>
<link type="text/css" rel="stylesheet" href="css/time_css.css" /> -->
</head>
<!--<script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/echarts-all-3.js"></script>-->
<!--        <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/dataTool.min.js"></script>
       <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/china.js"></script>
       <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/map/js/world.js"></script>
       <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=ZUONbpqGBsYGXNIYHicvbAbM"></script>
       <script type="text/javascript" src="http://echarts.baidu.com/gallery/vendors/echarts/extension/bmap.min.js"></script> -->
<style type="text/css">
.layui-nav {
    margin-left: 0px;
}

.header {
    height: 60px;
    border-bottom: none;
}

.layui-nav-right {
    position: absolute;
    right: 0px;
    top: 0;
}

.tb_body {
    padding: 15px;
}
</style>

<body>
    <div class="layui-layout layui-layout-admin" id='app'>
        <div class="layui-header header" >
            <div class="layui-main" style="margin: 0px;">
                <ul class="layui-nav ">
                    <li class="layui-nav-item"><a href="javascript:void;">主力追踪</a></li>
                    <li class="layui-nav-item layui-this">
                        <a href="javascript:;">产品</a>
                        <dl class="layui-nav-child">
                            <dd><a href="">选项1</a></dd>
                            <dd><a href="">选项2</a></dd>
                            <dd><a href="">选项3</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="">大数据</a></li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">解决方案</a>
                        <dl class="layui-nav-child">
                            <dd><a href="">移动模块</a></dd>
                            <dd><a href="">后台模版</a></dd>
                            <dd><a href="">电商平台</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="">社区</a></li>
                </ul>
                <ul class="layui-nav layui-nav-right">
                    <template v-if="loginIn ==  true ">
                        <li class="layui-nav-item">
                            <a href="javascript:;" v-text="userInfo['username']"></a>
                            <dl class="layui-nav-child">
                                <dd><a href="">移动模块</a></dd>
                                <dd><a href="javascript:shutdown();">退出</a></dd>
                            </dl>
                        </li>
                    </template>
                    <template v-else>
                        <li class="layui-nav-item"><a href="javascript:login();">登录</a></li>
                        <li class="layui-nav-item"><a href="javascript:register();">注册</a></li>
                    </template>
                </ul>
            </div>
        </div>
        <div class="layui-side layui-bg-black">
            <div class="layui-side-scroll">
                <ul class="layui-nav layui-nav-tree" lay-filter="demo">
                    <li class="layui-nav-item layui-nav-itemed">
                        <a href="javascript:;">自选股</a>
                        <dl class="layui-nav-child">
                            <dd><a href="javascript:;">默认</a></dd>
                        <template v-for="item in userFavor">
                            <dd><a href="javascript:;" v-text="item.name" ></a></dd>
                        </template>
                            <dd><a href="">全部</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item">
                        <a href="javascript:;">解决方案</a>
                        <dl class="layui-nav-child">
                            <dd><a href="">移动模块</a></dd>
                            <dd><a href="">后台模版</a></dd>
                            <dd><a href="">电商平台</a></dd>
                        </dl>
                    </li>
                    <li class="layui-nav-item"><a href="">云市场</a></li>
                    <li class="layui-nav-item"><a href="">社区</a></li>
                </ul>
            </div>
        </div>
        <div class="layui-body tb_body" style="overflow-y:scroll;">
            <table id="table_one" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th rowspan="2" colspan="3">说明:委托20万以上，成交的金额算做主力流入流出资金</th>
                        <th colspan="2">实时累计（万元）</th>
                        <th colspan="3">1分钟</th>
                        <th>3分钟</th>
                        <th> </th>
                        <th></th>
                    </tr>
                    <tr>
                        <th colspan="2">15：00-9：30</th>
                        <th>9：32</th>
                        <th>9：31</th>
                        <th>9：30</th>
                        <th>9：32-9：30</th>
                        <th> </th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th style="width: 20px;">排名</th>
                        <th style="width: 100px;">股票代码</th>
                        <th style="width: 100px;">股票名称</th>
                        <th style="width: 130px;" id="tab1">流入占比</th>
                        <th style="width: 130px;" id="tab2">总净流入</th>
                        <th style="width: 130px;" id="tab3">净流入</th>
                        <th style="width: 130px;">净流入</th>
                        <th style="width: 130px;">净流入</th>
                        <th style="width: 130px;" id="tab4">净流入</th>
                        <th style="width: 60px;">涨幅</th>
                        <th style="width: 60px;">涨速</th>
                        <th> 操作</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="layer" id='favor' style="display:none;">
            <ul class="list-group" style="padding:10px;">
                <li class="list-group-item">默认</li>
                <template v-for="item in userFavor" >

                    <li class="list-group-item" v-text='item.name' ></li>
                </template>
            </ul>
        </div>
        <div class="login-from" id='login_frm' style="display: none;">
            <form class="layui-form layui-form-pane" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-inline">
                        <input type="text" name="username" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密 码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux"><img src=""></div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                        <a href="/user/forget" title="忘记密码">忘记密码</a>
                    </div>
                </div>
            </form>
        </div>
        <div class="register_frm" id="register_frm" style="display: none;">
            <form class="layui-form" action="">
                <div class="layui-form-item">
                    <label class="layui-form-label">用户名</label>
                    <div class="layui-input-block">
                        <input type="text" name="username" required lay-verify="required" placeholder="请输入用户名" autocomplete="off" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">密 码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="password" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux"><img src=""></div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">确认密码</label>
                    <div class="layui-input-inline">
                        <input type="password" name="repassword" required lay-verify="required" placeholder="请输入密码" autocomplete="off" class="layui-input">
                    </div>
                    <div class="layui-form-mid layui-word-aux"><img src=""></div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
                        <a href="/user/forget" title="已有帐号">已有帐号</a>
                    </div>
                </div>
            </form>
        </div>
        </div>
        </body>
        <script src="https://unpkg.com/vue/dist/vue.js"></script>
        <script src="https://cdn.jsdelivr.net/vue.resource/1.2.1/vue-resource.min.js"></script>
        <script src="/public/layui/layui.js" charset="utf-8"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/r/bs-3.3.5/jqc-1.11.3,dt-1.10.8/datatables.min.js"></script>
        <script type="text/javascript" src="/public/js/common.js?v2.10"></script>
        <script type="text/javascript" src="/public/js/table.js?v1"></script>
        <script type="text/javascript">
        function jsk(aoData) {
            var u = {}
            u = aoData[0]

            //alert(u.dtaw)
            var arr = {},
                b = {},
                c = {}
            for (i = 0; i < aoData.length; i++) {
                //k=JSON.stringify(aoData[i].name)
                k = aoData[i].name
                if (typeof arr[k] == 'object') {
                    b = JSON.stringify(arr[k])
                    c = JSON.stringify(b.data)
                    alert(b)
                } else {
                    arr[k] = aoData[i].value
                }


            }
            return arr
        }

        $(function() {
            var intval_index = null;
            var tabctr_idx = 0;
            var count = 60;
            var Language = { // 汉化
                "sProcessing": "正在加载数据...",
                "sLengthMenu": "显示_MENU_条 ",
                "sZeroRecords": "没有您要搜索的内容",
                "sInfo": "从_START_ 到 _END_ 条记录——总记录数为 _TOTAL_ 条",
                "sInfoEmpty": "记录数为0",
                "sInfoFiltered": "(全部记录数 _MAX_  条)",
                "sInfoPostFix": "",
                "sSearch": "搜索",
                "sUrl": "",
                "oPaginate": {
                    "sFirst": "第一页",
                    "sPrevious": " 上一页 ",
                    "sNext": " 下一页 ",
                    "sLast": " 最后一页 "
                }
            };

            $("#tabctrl a").click(function(e) {
                e.preventDefault();
                tabctr_idx = $("#tabctrl a").index($(this));
                $(this).tab('show');

            });

            var tbl_four = $('#table_four').DataTable({
                "aaSorting": [
                    [8, "desc"]
                ],
                "oLanguage": Language,

                "processing": true, //载入数据的时候是否显示“载入中”
                "serverSide": true, //生成get数据
                "columns": [{
                    "data": null,
                    'orderable': false
                }, {
                    "data": "cpy_id"
                }, {
                    "data": "name"
                }, {
                    "data": 'nxjlrjh'
                }, {
                    "data": "nxjlrch"
                }, {
                    "data": "nxjlr"
                }, {
                    "data": "jhcs"
                }, {
                    "data": "chcs"
                }, {
                    "data": "jcc"
                }, {
                    "data": "zf"
                }, {
                    "data": "zs"
                }],
                "fnServerData": function(sSource, aoData, fnCallback) {
                    $.ajax({
                            url: '/api/stock/nszl',
                            type: 'POST',
                            dataType: 'json',
                            data: jsk(aoData),
                        })
                        .done(function(resp) {
                            fnCallback(resp);
                        })
                        .fail(function() {

                            console.log("network error");
                        })
                        .always(function() {
                            console.log("complete");
                        });
                },
                "fnRowCallback": function(nRow, aData, iDisplayIndex) {

                    var page = tbl_four.page();
                    var page_len = tbl_four.page.len();
                    $('td:eq(0)', nRow).text(page * page_len + iDisplayIndex + 1);
                    $('td:eq(1)', nRow).addClass('cpy_id');; //.attr('data',aData['cpy_id']);
                    if (parseFloat(aData['zf']) > 0) {
                        $('td:eq(9)', nRow).addClass('error');
                    }
                    $("td:eq(1)", nRow).attr('data', aData['cpy_id']);
                    return nRow;
                }
            });
            var cur_date = new Date();

        });
        </script>
        <style type="text/css">
        td.error {
            background-color: #f04124;
            border-color: #de2d0f;
            color: #fff;
        }
        
        td.success {
            background-color: #43AC6A;
            border-color: #3a945b;
            color: #fff;
        }
        </style>


</html>
