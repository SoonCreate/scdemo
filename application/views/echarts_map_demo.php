<div class="info">
    <ul>
        <li><strong>eCharts</strong>：是百度的一个针对大数据分析用的图表工具，是一个开源项目，官网
            <a href="http://echarts.baidu.com" target="_blank">echarts.baidu.com</a></li>
        <li><strong>中国地图</strong>：dojo的geo charting默认是美国地图，中国地图的解决方案可以用echarts替代</li>
        <li><strong>事件</strong>：echarts/config中的EVENT定义了很多事件，当然也可以用dojo获取node并加载事件</li>
        <li><strong>BUG</strong>：Error: multipleDefine {src: "dojoLoader", info: Object, stack: (...), message: "multipleDefine"}
        。问题应该是echarts使用的自己的AMD机制和dojo类似，可是dojo调用echarts的过程中会同时加载很多模块，会有重复！</li>
    </ul>
</div>
<div id="main" style="height:400px"></div>
<p></p>
<script type="text/javascript" src="resources/js/libs/echarts_map_demo.js" charset="utf-8"></script>