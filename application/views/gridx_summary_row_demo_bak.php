<style type="text/css">
    .claro .summaryRow .gridxRowTable {
        background-color: #FFFF99;
    }
</style>
<script type="text/javascript">
    require(["dojo/ready","dojo/request","dijit/registry","gridx/Grid",
        "gridx/core/model/cache/Sync"/*,'gridx/allModules'*/,"dojo/data/ItemFileReadStore",
        "dojo/data/ItemFileWriteStore",
        "gridx/modules/VirtualVScroller",
        "gridx/modules/RowHeader",
        "gridx/modules/extendedSelect/Cell",
        "gridx/modules/extendedSelect/Column",
        "gridx/modules/extendedSelect/Row",
        "gridx/modules/ColumnResizer",
        "gridx/modules/Pagination",
        "gridx/modules/pagination/PaginationBar"
    ],
        function(ready,request,registry,Grid,SyncCache/*,modules*/,ItemFileReadStore,ItemFileWriteStore,
                 VirtualVScroller,
                 RowHeader,
                 ExtendedSelectCell,
                 ExtendedSelectColumn,
                 ExtendedSelectRow,
                 ColumnResizer,
                 Pagination,
                 PaginationBar){
            ready(function(){

                request.get("<?= base_url('gridx/test_data')?>",{handleAs : "json"}).then(function(data){
                    var store = new ItemFileReadStore({
                        data : data
                    });

                    var grid = new Grid({
                        id : "summaryRowDemoGrid",
                        cacheClass : SyncCache,
                        store: store ,
                        structure: [
                            {name : "用户名",field : "username",width : "100px"},
                            {name : "密码",field : "password",width : "100px"},
                            {name : "性别",field : "sex",width : "80px"},
                            {name : "职位",field : "pos",width : "100px"},
                            {name : "用户名",field : "username",width : "100px"},
                            {name : "密码",field : "password",width : "100px"},
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
                            {moduleClass : ColumnResizer,
                                //列宽度调整时，同步调整summaryRow列宽
                                onResize : function(colId, newWidth, oldWidth){
                                    if("summaryRow" in this.grid){
                                        this.grid.summaryRow.columnResizer.setWidth(colId,newWidth)
                                    }
                                }
                            }
                        ],
                        //解决有横向左右移动滚动轴时，跟随滚动
                        onHScroll : function(left){
                            if("summaryRow" in this){
                                this.summaryRow.hScroller.scroll(left);
                                this.summaryRow.hScroller.refresh();
                            }
                        },
                        autoWidth : true,
                        style:"height : 200px"
//                        autoHeight : true
                    },"summaryRowDemoGrid");
                    grid.startup();

                    console.info(grid);

                    var sModules = [];
                    if("rowHeader" in grid){
                        sModules.push(RowHeader);
                    }
                    if("columnResizer" in grid){
                        sModules.push(ColumnResizer);
                    }

                    //用时戳做ID保证唯一性
                    var timestamp =  (new Date()).valueOf().toString();

                    var summaryRow = new Grid({
                        cacheClass : grid.cacheClass,
                        class : "summaryRow",
                        store: new ItemFileWriteStore({
                            data : {id : 'id',items:[{id : timestamp}]}
                        }) ,
                        structure: grid.structure,
                        modules : sModules,
                        //bugFix：columnResize如果grid为autoWidth，hScroller就会有问题，如果同时为autoWidth则无问题
                        autoWidth : grid.autoWidth,
                        style: "width:" + grid.domNode.clientWidth + "px;border : 0;",
                        autoHeight : true,
                        timestamp : timestamp
                    });

                    //bugFix:如果改为display:none，ColumnResizer模块会失效
                    summaryRow.headerNode.style.height = 0;
                    summaryRow.hScrollerNode.style.height = 0;
                    summaryRow.body.refresh();

                    //位于gridxFooter，第一位，实现效果：位于行的最后防止其他bar占位
                    summaryRow.placeAt(grid.footerNode,'first');
//                    summaryRow.placeAt(grid.bodyNode);
//                                        grid.bodyNode.appendChild(summaryRow.domNode);

                    //bugFix:当竖滚动条存在，并hScroller同时存在，没有缩减18px
                    if("vScroller" in grid && grid.vScrollerNode.style.display == "block"){
                        summaryRow.vScrollerNode.style.display = "block";
                        summaryRow.vScrollerNode.style.right = grid.vScrollerNode.style.right;
                        summaryRow.hLayout.reLayout();
                        summaryRow.hScroller.refresh();
                    }

                    summaryRow.startup();

                    //赋予grid
                    grid.summaryRow = summaryRow;

                    //bug:当grid高度超出行的显示高度时，summaryRow显示在最后面，中间有空白间隔

                },function(error){
                    dojoConfirm(error,null,null,"E");
                });


            });
        });
</script>

<div id="container">
    <div id="body">
        <div class="info">
            <ul>
                <li><strong>实现方式</strong>
                    ：通过行底部附加一个高亮的grid形式实现，隐去header和hScroller
                </li>
            </ul>
        </div>
        <div id="summaryRowDemoGrid" ></div>
    </div>
</div>