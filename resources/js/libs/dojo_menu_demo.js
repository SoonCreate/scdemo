require(["dojo/ready","local/MenuBar","local/RightMenu","dojo/request","gridx/Grid",
    "gridx/core/model/cache/Sync"/*,'gridx/allModules'*/,"dojo/data/ItemFileReadStore",
    "gridx/modules/VirtualVScroller",
    "gridx/modules/RowHeader",
    "gridx/modules/extendedSelect/Cell",
    "gridx/modules/extendedSelect/Column",
    "gridx/modules/extendedSelect/Row",
    "gridx/modules/Menu",
    'gridx/modules/HeaderMenu'
],
    function(ready,MenuBar,RightMenu,request,Grid,SyncCache/*,modules*/,ItemFileReadStore,
             VirtualVScroller,
             RowHeader,
             ExtendedSelectCell,
             ExtendedSelectColumn,
             ExtendedSelectRow,
             Menu,
             HeaderMenu){
        ready(function(){
            var menuBar = new MenuBar({
                style : "width : 200px"
            },"MenuBar").build();
            menuBar.startup();

            request.get(url("gridx/test_data"),{handleAs : "json"}).then(function(data){
                var store = new ItemFileReadStore({
                    data : data
                });

                var grid = new Grid({
                    id : "menuDemoGrid",
                    cacheClass : SyncCache,
                    store: store ,
                    structure: [
                        {name : "用户名",field : "username",width : "100px"},
                        {name : "密码",field : "password",width : "100px"},
                        {name : "性别",field : "sex",width : "80px"},
                        {name : "职位",field : "pos",width : "100px"}
                    ],
                    modules : [
                        VirtualVScroller,
                        RowHeader,
                        ExtendedSelectCell,
                        ExtendedSelectColumn,
                        ExtendedSelectRow,
                        Menu,
                        HeaderMenu
                    ],
                    autoWidth : true,
                    autoHeight : true
//                ,
//                onHeaderContextMenu : function(){
//                    console.info("onHeaderContextMenu");
//                },
//                onHeaderCellContextMenu : function(evt){
//                    console.info("onHeaderCellContextMenu");
//                    console.info(evt);
//                    console.info(grid.menu._menus["headercell"].menu);
//                    grid.menu._menus["headercell"].menu._openMyself(evt);
//
//                }
//                style : "width: 800px;height: 500px;"
                },"menuDemoGrid");
                grid.startup();

                RightMenu.startup();

            },function(error){
                dojoConfirm(error,null,null,"E");
            });


        });
    });