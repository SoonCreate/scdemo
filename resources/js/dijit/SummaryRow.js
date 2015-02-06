define([
    "dojo/_base/declare",
    "gridx/Grid",
    "gridx/modules/ColumnResizer",
    "gridx/modules/RowHeader",
    "dojo/data/ItemFileWriteStore",
    "dojo/query",
    "dojo/_base/lang"
], function(declare,Gridx,ColumnResizer,RowHeader,ItemFileWriteStore,query,lang){

    return declare(Gridx, {
        //统计类型包括：汇总，平均值，最小值，最大值，计数
        sType : ["SUM","AVG","MIN","MAX","COUNT"],
        summaryColumns : [],
        constructor: function(args){
            if("grid" in args){
                //用时戳做ID保证唯一性
                var timestamp =  (new Date()).valueOf().toString();
                var grid = args.grid;

                //防止当个grid重复注册
                args.id = grid.id + "_summaryRow";
                var sModules = [];
                if("rowHeader" in grid){
                    sModules.push(RowHeader);
                }
                if("columnResizer" in grid){
                    sModules.push(ColumnResizer);
                }

                args.cacheClass = grid.cacheClass;
                args.store =  new ItemFileWriteStore({
                    data : {items:[{id : timestamp}]}
                }) ;

                args.modules  = sModules;
                //bugFix：columnResize如果grid为autoWidth，hScroller就会有问题，如果同时为autoWidth则无问题
                args.autoWidth = grid.autoWidth;

                //获取当前grid的长度
                //bugFix:当调整宽度在前，实例化summaryRow在后时，显示长度有问题
                //解决方案：获取现有结构，替换掉原先的结构
                args.structure = [];
                grid._columns.forEach(function(c){
                    var s = new Object();
                    s.name = c.name;
                    s.field = c.field;
                    s.width = c.declaredWidth;
                    s.decorator =  function(cellData, rowId, rowIndex){
                        if(cellData != undefined){
                            return "<b>" + cellData + "</b>";
                        }
                    };
                    args.structure.push(s);
                });

                args.style = "width:" + grid.domNode.clientWidth + "px;border : 0;";

                args.autoHeight =  true;
                args.timestamp = timestamp;
                args.class = "summaryRow";

            }
        },
        postCreate : function(){
            this.inherited(arguments);
            var summaryRow = this;
            var grid = this.grid;
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

            //赋予grid
            grid.summaryRow = summaryRow;

            //bug:当grid高度超出行的显示高度时，summaryRow显示在最后面，中间有空白间隔

            //解决有横向左右移动滚动轴时，跟随滚动
            dojo.connect(grid,"onHScroll",function(left){
                if(this.summaryRow != undefined){
                    this.summaryRow.hScroller.scroll(left);
                    this.summaryRow.hScroller.refresh();
                }
            });

            //列宽度调整时，同步调整summaryRow列宽
            if("columnResizer" in grid){
                dojo.connect(grid.columnResizer,"onResize",function(colId, newWidth, oldWidth){
                    if(this.grid.summaryRow != undefined){
                        this.grid.summaryRow.columnResizer.setWidth(colId,newWidth)
                    }
                });
            }

            //过滤器过滤数据后summaryRow被重新计算
            if("filter" in grid){
                dojo.connect(grid.filter,"onFilter",function(){
//                    console.info(this.grid.filterBar.model._cache);
                    if(this.grid.summaryRow != undefined){
                        this.grid.summaryRow.redo();
                    }
                });
            }
        },
        destroy : function(){
            this.grid.summaryRow = undefined;
            //清空数组
            this.summaryColumns.length = 0;
            this.inherited(arguments);
        },
        //根据列ID设置值
        setValue : function(colId,value){
            var c = this.column(colId);
            if(c){
                if(!this._hasValue(colId)){
                    this.summaryColumns.push(colId);
                }
                this.store.setValue(this.model.byIndex(0).item,c.field(),value);
            }
        },
        //运算：总计
        sum : function(colIds){
            this._sum(colIds,this._getFilteredRowIds());
        },
        _sum : function(colIds,rowIds){
//            console.info(colIds);
//            console.info(rowIds);
            var grid = this.grid;
            var ids = [];
            if(lang.isArray(colIds)){
                ids = colIds;
            }else{
                ids.push(colIds);
            }

            for(var i=0;i<ids.length;i++){
                var sumResult = 0;
                var columnFiled = grid.column(ids[i]).field();

                //通过fetch循环汇总
                if(rowIds == undefined){
                    grid.store.fetch({
                        onItem : function(item){
                            sumResult = sumResult + Number(item[columnFiled]);
                        }
                    });
                }else{
                    rowIds.forEach(function(id){
                        sumResult = sumResult + Number(grid.store._itemsByIdentity[id][columnFiled]);
                    });
                }

                //设置汇总值
                this.setValue(ids[i],"sum: "+sumResult);
            }
        },
        //根据当前grid状态重新计算
        redo : function(){
            var colIds = this.summaryColumns;
            var rowIds = this._getFilteredRowIds();
            this._sum(colIds,rowIds);
        },
        //是否存在值
        _hasValue : function(colId){
            var c = this.column(colId);
            if(c){
                var v = this.store.getValue(this.model.byIndex(0).item,c.field());
                if(v == undefined){
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        },
        //获取过滤后的行id列表
        _getFilteredRowIds : function(){
            var grid = this.grid;
            if(grid.model.hasFilter()){
                //获取filter后的
                return query(".gridxRow",grid.bodyNode).attr("rowid");
            }else{
                //没有过滤，为全部数据时
                return undefined;
            }

        }
    });
});
