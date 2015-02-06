require(["dojo/ready","dojo/request","dijit/registry","gridx/Grid","local/dijit/SummaryRow",
    "gridx/core/model/cache/Sync"/*,'gridx/allModules'*/,
    "dojo/data/ItemFileReadStore",
    "dijit/form/Button",
    "dijit/form/ComboButton",
    "dijit/Menu",
    "dijit/MenuItem",

    "gridx/modules/VirtualVScroller",
    "gridx/modules/RowHeader",
    "gridx/modules/extendedSelect/Cell",
    "gridx/modules/extendedSelect/Column",
    "gridx/modules/extendedSelect/Row",
    "gridx/modules/ColumnResizer",
    "gridx/modules/Pagination",
    "gridx/modules/pagination/PaginationBar",
    "gridx/modules/SingleSort",
    "gridx/modules/Filter",
    "gridx/modules/filter/FilterBar"
],
    function(ready,request,registry,Grid,SummaryRow,SyncCache/*,modules*/,ItemFileReadStore,Button,ComboButton,Menu,MenuItem,
             VirtualVScroller,
             RowHeader,
             ExtendedSelectCell,
             ExtendedSelectColumn,
             ExtendedSelectRow,
             ColumnResizer,
             Pagination,
             PaginationBar,
             SingleSort,
             Filter,
             FilterBar){
        ready(function(){

            request.get(url('gridx/test_data'),{handleAs : "json"}).then(function(data){
                var store = new ItemFileReadStore({
                    data : data
                });

                var grid = new Grid({
                    cacheClass : SyncCache,
                    store: store ,
                    structure: [
                        {name : "用户名",field : "username",width : "100px"},
                        {name : "密码",field : "password",width : "100px",dataType:"number"},
                        {name : "性别",field : "sex",width : "80px",dataType:"number"},
                        {name : "职位",field : "pos",width : "100px"},
                        {name : "用户名",field : "username",width : "100px"},
                        {name : "密码",field : "password",width : "100px",dataType:"number"},
                        {name : "性别",field : "sex",width : "80px"}
                    ],
//                        barBottom : [
//                            { content: "<div id='summaryRow'></div>",className : "summaryRow", style: "border : 0" }
//                        ],
                    modules : [
                        VirtualVScroller,
                        RowHeader,
                        ExtendedSelectCell,
                        ExtendedSelectColumn,
                        ExtendedSelectRow,
                        Pagination,
                        PaginationBar,
                        ColumnResizer,
//                            SingleSort,
                        Filter,
                        FilterBar
                    ],
                    autoWidth : true,
                    style:"height : 200px"
//                        autoHeight : true
                },"summaryRowDemoGrid");
                grid.startup();

                //汇总列添加
                var bt1 = new Button({
                    label : "添加汇总列",
                    onClick : function(){
                        if(grid.summaryRow == undefined){
                            var sRow = new SummaryRow({
                                grid : grid
                            });
                            sRow.startup();
                        }
                    }
                },"addSummaryRow");

                //删除汇总列
                var bt2 = new Button({
                    label : "删除汇总列",
                    onClick : function(){
                        if(grid.summaryRow != undefined){
                            grid.summaryRow.destroy();
                        }
                    }
                },"destroySummaryRow");

                //配置计算用ComboButton
                var menu = new Menu({ style: "display: none;"});

                menu.addChild(
                    new MenuItem({
                        label: "汇总",
                        onClick: function(){
                            alert('SUM');
                        }
                    })
                );

                menu.addChild(
                    new MenuItem({
                        label: "平均值",
                        onClick: function(){
                            alert('AVG');
                        }
                    })
                );

                menu.addChild(
                    new MenuItem({
                        label: "最小值",
                        onClick: function(){
                            alert('MIN');
                        }
                    })
                );

                menu.addChild(
                    new MenuItem({
                        label: "最大值",
                        onClick: function(){
                            alert('MAX');
                        }
                    })
                );

                menu.addChild(
                    new MenuItem({
                        label: "计数",
                        onClick: function(){
                            alert('COUNT');
                        }
                    })
                );

                menu.startup();

                var bt3 = new ComboButton({
                    label : "汇总当前选择列",
                    dropDown: menu,
                    onClick : function(){
                        //获取选择的列
                        var colIds = grid.select.column.getSelected();
                        var passValid = true;

                        //验证选择列数量
                        if(colIds.length == 0){

                            passValid = false;
                            dojoConfirm("请至少选择一列！",null,null,"W");

                        }else{
                            //验证数据类型
                            for(var i=0;i<colIds.length;i++){
//                                    var selectedColumn = grid.column(colIds[i]);
//                                    var dataType = getDataTypeByColumn(colIds[i],grid);
                                var dataType = grid._columnsById[colIds[i]].dataType;

                                if(dataType == "number"){
                                    continue;
                                }else{
                                    passValid = false;
                                    dojoConfirm("请选择有效的数字类型列！",null,null,"W");
                                    break;
                                }
                            }

                            //处理汇总
                            if(passValid){
                                //验证成功后展示汇总行并填充运算结果
                                var sRow;
                                if(grid.summaryRow != undefined){
                                    sRow = grid.summaryRow;
                                }else{
                                    sRow = new SummaryRow({
                                        grid : grid
                                    });
                                    sRow.startup();
                                }

                                grid.summaryRow.sum(colIds);
                            }
                        }
                    }
                },"sumColumnData");

            },function(error){
                dojoConfirm(error,null,null,"E");
            });

        });
    });