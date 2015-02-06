require(["dojo/ready",
    "dojox/charting/Chart2D",
    "dojox/charting/themes/Claro",
    "dojox/charting/action2d/Highlight",
    "dojox/charting/action2d/Tooltip",
    "dojox/charting/widget/Legend"
],
    function(ready,Chart2D,Claro,Highlight,Tooltip,Legend){
        ready(function(){
            //绘图
            var labels = [
                {value : 1,text : 'A'},
                {value : 2,text : 'B'},
                {value : 3,text : 'C'},
                {value : 4,text : 'D'}
            ];
            var dataA = [10,20,30,40];
            var dataB = [11,22,33,44];

            var chart = new Chart2D("chart_ClusteredColumns"
//                ,
//                {
//                    title:'柱状图 - ClusteredColumns'
//                }
            );
            chart.setTheme(Claro);
            chart.addPlot("default",{
                type: "ClusteredColumns", //用于指定图形的类型
                gap:8, //指定每个柱形图之间的间隔
                markers: true, //是否显示刻度
                animate:{duration: 1000}//定义柱形图的动态效果
            });

            chart.addAxis("x", { labels:labels });
            chart.addAxis("y", { vertical: true,
                fixLower: "major",
                fixUpper: "major" , //补充最大刻度，比如48，会补充到50
                majorTick: {color: "red", length: 10}, //y轴大刻度
                minorTick: {stroke: "black", length: 3}, //y轴小刻度
                includeZero: true //从0开始
            });
//            chart.addAxis("y", { includeZero: true, vertical:true});
            chart.addSeries('目标',dataA,{color:"red"});
            chart.addSeries('实际',dataB,{color:"green"});

            // Highlight!
            new Highlight(chart,"default");
            new Tooltip(chart, "default");

            chart.render();
            new Legend({chart: chart},"legend_ClusteredColumns");

            //曲线图
            // Define the data
            var chartData2 = [10000,9200,11811,12000,7662,13887,14200,12222,12000,10009,11288,12099];

            // Create the chart within it's "holding" node
            var chart2 = new Chart2D("chart_Lines");

            // Set the theme
            chart2.setTheme(Claro);

            // Add the only/default plot
            chart2.addPlot("default", {
                type: "Lines",
                markers: true
            });

            // Add axes
            chart2.addAxis("x");
            chart2.addAxis("y", { min: 5000, max: 15000, vertical: true, fixLower: "major", fixUpper: "major" });

            // Add the series of data
            chart2.addSeries("销售曲线",chartData2);
            new Highlight(chart2,"default");
            new Tooltip(chart2, "default");
            // Render the chart!
            chart2.render();
            new Legend({chart: chart2},"legend_Lines");

        });
    });