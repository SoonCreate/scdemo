define([ "dijit/Menu", "dijit/MenuItem", "dijit/MenuSeparator","dijit/PopupMenuItem",
    "dojo/aspect","dojo/dom","dijit/registry"],
    function(Menu, MenuItem, MenuSeparator, PopupMenuItem,aspect,dom,registry){
    /*
     *   摘要:
     *       系统右键菜单管理，全局，根据不同的对象，菜单展示可自定义
     */
    return {

        startup : function(){
            /*
                右键菜单的创建顺序是通过先全局后局部的方式：局部可覆盖全局
             */
            //整个窗体菜单
            var mainMenu = new Menu({
                contextMenuForWindow : true
            });
            mainMenu.addChild(new MenuItem({
                iconClass : "dijitEditorIcon dijitEditorIconCut",
                accelKey : "Ctrl+X",
                label : "剪切"
            }));
            mainMenu.addChild(new MenuItem({
                iconClass : "dijitEditorIcon dijitEditorIconCopy",
                accelKey : "Ctrl+C",
                label : "复制"
            }));
            mainMenu.addChild(new MenuItem({
                iconClass : "dijitEditorIcon dijitEditorIconPaste",
                accelKey : "Ctrl+V",
                label : "粘贴"
            }));
            mainMenu.startup();

            var partMenu = new Menu({
                targetNodeIds: [dom.byId("partMenu")]
            });
            partMenu.addChild(new MenuItem({
                label: "局部菜单项二"
            }));
            partMenu.addChild(new MenuItem({
                label: "局部菜单项二"
            }));
            partMenu.startup();

            var partMenu2 = new Menu({
                targetNodeIds: [dom.byId("partMenu")],
                selector: "a"
            });

            //在单击右键之前获取当前的点击对象
            aspect.before(partMenu2, "_openMyself", dojo.hitch(this, function(e){
                var timestamp =  (new Date()).valueOf().toString();
                //重新设置菜单项
                dojo.forEach(partMenu2.getChildren(),function(entry){
                    entry.destroyRecursive();
                });
                partMenu2.addChild(new MenuItem({
                    label: "动态菜单项"+timestamp
                }));
                partMenu2.addChild(new MenuItem({
                    label: "动态菜单项"+timestamp
                }));
            }));
            partMenu2.startup();

            var grid =   registry.byId("menuDemoGrid");
            var gridMenu = new Menu({});
            gridMenu.addChild(new MenuItem({
                label: "gridMenu"
            }));
            gridMenu.startup();
            grid.menu.bind(gridMenu,{
                hookPoint: 'grid'
            });

            var gridBodyMenu = new Menu({});
            gridBodyMenu.addChild(new MenuItem({
                label: "gridBodyMenu"
            }));
            gridBodyMenu.startup();
            grid.menu.bind(gridBodyMenu,{
                hookPoint: 'body'
            });

            //has bug
            var gridHeaderMenu = new Menu({});
            gridHeaderMenu.addChild(new MenuItem({
                label: "gridHeaderMenu"
            }));
            gridHeaderMenu.startup();
            grid.menu.bind(gridHeaderMenu,{
                hookPoint: 'header'
            });

            //has bug
            var gridHeaderCellMenu = new Menu({});
            gridHeaderCellMenu.addChild(new MenuItem({
                label: "gridHeaderCellMenu"
            }));
            gridHeaderCellMenu.startup();
            grid.menu.bind(gridHeaderCellMenu,{
                hookPoint: 'headercell'
            });

            var gridHeaderCellSelectedMenu = new Menu({});
            gridHeaderCellSelectedMenu.addChild(new MenuItem({
                label: "gridHeaderCellSelectedMenu"
            }));
            gridHeaderCellSelectedMenu.startup();
            grid.menu.bind(gridHeaderCellSelectedMenu,{
                hookPoint: 'headercell',
                selected : true
            });

            var gridRowMenu = new Menu({});
            gridRowMenu.addChild(new MenuItem({
                label: "gridRowMenu"
            }));
            gridRowMenu.startup();
            grid.menu.bind(gridRowMenu,{
                hookPoint: 'row'
            });

            var gridRowSelectedMenu = new Menu({});
            gridRowSelectedMenu.addChild(new MenuItem({
                label: "gridRowSelectedMenu"
            }));
            gridRowSelectedMenu.startup();
            grid.menu.bind(gridRowSelectedMenu,{
                hookPoint: 'row',
                selected : true
            });

            var gridCellMenu = new Menu({});
            gridCellMenu.addChild(new MenuItem({
                label: "gridCellMenu"
            }));
            gridCellMenu.startup();
            grid.menu.bind(gridCellMenu,{
                hookPoint: 'cell'
            });

            var gridCellSelectedMenu = new Menu({});
            gridCellSelectedMenu.addChild(new MenuItem({
                label: "gridCellSelectedMenu"
            }));
            gridCellSelectedMenu.startup();
            grid.menu.bind(gridCellSelectedMenu,{
                hookPoint: 'cell',
                selected : true
            });
        }
    }


});
