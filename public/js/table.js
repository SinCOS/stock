$(function() {
    var stock_url = "";
    var node_info = {
        stock_url: "",
        columns: [{
            "data": null,
            'orderable': false
        }, {
            "data": "cpy_id"
        }, {
            "data": "name"
        }, {
            "data": "zlbfb"
        }, {
            "data": "jlr"
        }, {
            "data": "calc"
        }, {
            "data": "one"
        }, {
            "data": "two"
        }, {
            "data": "three"
        }, {
            "data": "zf"
        }, {
            "data": "zs"
        }, {
            "data": null,
            'orderable': false
        }],
        current: null
    };

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
    node_info.current = $("#table_one").DataTable({
        "aaSorting": [
            [8, "desc"]
        ],
        "oLanguage": Language,

        "processing": true, //载入数据的时候是否显示“载入中”
        "serverSide": true, //生成get数据
        "columns": node_info.columns,
        "fnServerData": function(sSource, aoData, fnCallback) {

            $.ajax({
                    url: '/api/stock/jlr',
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
            var page = node_info.current.page();
            var page_len = node_info.current.page.len();
            $('td:eq(0)', nRow).text(page * page_len + iDisplayIndex + 1);
            $('td:eq(11)', nRow).addClass('cpy_id').attr('data', aData['cpy_id']).on('click', function() {
                var self = this;
                var cpy_id = parseInt($(this).attr('data'));
                var cpy_name = $(this).attr("cpy_name");
        
                var layer_index =  layer.open({
                        type: 1,
                        title: '自选股收藏夹',
                        content: $("#favor"),
                        area: ['345px','435px'],
                        btn: ['新建','确认','返回'],
                        yes: function(index,layero){
                            layer.prompt({
                                title: '新建收藏夹'
                            },function(value,iindex,elem){
                                if(!value || value == ''  ){


                                    return false;
                                }
                                Vue.http.post('/user/category', {name: value}).then(resp=>{
                                    if(resp.body.status == 400){
                                        layer.msg(resp.body.message);
                                        setTimeout(function(){
                                            login();
                                        },3000);
                                        
                                    }else if (resp.body.status == 200) {
                                         app.reflushFavor();
                                      
                                         
                                    }
                                    
                                },resp=>{
                                    layer.msg('网络连接失败!!!');
                                });
                               
                                layer.close(iindex);
                            });

                        },
                        btn0: function(){

                            return false;
                        }
                });
                return false;
                layer.msg("是否把 ' " + cpy_name + " ' 添加到自选股", {
                    btn: ['是', '否'],
                    yes: function(layero) {
                        Vue.http.post('/user/favor/' + cpy_id).then(function(resp){
                            layer.msg(resp.body.message);
                        },resp=>{
                            layer.msg(resp.body.message);
                        });;
                        layer.close(layero);
                    }
                });

            }).attr('cpy_name', aData['name']).text('关注');
            if (parseFloat(aData['zf']) > 0) {
                $('td:eq(9)', nRow).addClass('error');
            }
            return nRow;
        }
    });
});
