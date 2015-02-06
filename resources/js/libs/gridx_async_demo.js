require(["dojo/ready",
    "gridx/Grid",
    "gridx/core/model/cache/Async",
    "dojo/store/JsonRest",
    "dojox/grid/DataGrid",
    "dojo/data/ObjectStore",
    "gridx/modules/Pagination",
    "gridx/modules/pagination/PaginationBar",
    "gridx/modules/ColumnResizer",
    "gridx/modules/SingleSort",
    "gridx/modules/Filter",
    "gridx/modules/filter/FilterBar",
    "gridx/modules/VirtualVScroller"
],
    function(ready,Grid,AsyncCache/*,modules*/,JsonRest,DataGrid,ObjectStore,
             Pagination,
             PaginationBar,
             ColumnResizer,
             SingleSort,
             Filter,
             FilterBar,
             VirtualVScroller){
        ready(function(){

            var restStore = new JsonRest({idProperty: 'id', target:url('gridx/test_data/'),sortParam: "sortBy"});
            var store = new ObjectStore({objectStore: restStore});
//            console.info(store);
//            var dg = DataGrid({
//                store: store ,
//                structure: [
//                    {name : "用户名",field : "username",width : "100px"},
//                    {name : "密码",field : "password",width : "100px"},
//                    {name : "性别",field : "sex",width : "80px"},
//                    {name : "职位",field : "pos",width : "100px"}
//                ],
//                autoHeight : true,
//                autoWidth: true
//            },"myGrid");
//            dg.startup();
            var pageSize = 20;
            var grid = new Grid({
                cacheClass : AsyncCache,
                store: store ,
                structure: [
                    {name : "用户名",field : "username",width : "160px",dataType :"string"},
                    {name : "密码",field : "password",width : "160px",dataType :"number"},
                    {name : "性别",field : "sex",width : "120px",dataType :"string"},
                    {name : "职位",field : "pos",width : "160px",dataType :"string"}
                ],
                pageSize: pageSize,//发送到服务端的条目HTTP header : items=0-19
                modules : [
                    {
                        moduleClass: Pagination,
                        initialPage: 0//20 //初始化显示在第几页
                    },
                    {
                        moduleClass: PaginationBar,
                        sizes: [20,50, 100],  //显示分页size
                        sizeSeparator: "|"  //分页size之间分割符
                    },
                    ColumnResizer,
                    {
                        moduleClass: SingleSort
//                        ,
//                        initialOrder: { colId: '4', descending: true } //初始化排序
                    },
//                    VirtualVScroller,
                    Filter,
                    FilterBar
                ],
                //同步时可用已下方式进行服务端过滤 https://github.com/oria/gridx/wiki/How-to-filter-Gridx-with-any-condition%3F
//                filterServerMode: true,
//                filterSetupQuery: function(expr){
//                    // return the filter query that your server can understand.
//                    console.info(expr);
//                },
                autoWidth : true,
//                autoHeight : true,
                style:"margin-left: 20px;height:400px"

            },"asyncTestGrid");

            grid.startup();
            grid.pagination.setPageSize(pageSize);

        });
    });