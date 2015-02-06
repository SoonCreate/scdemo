<!--<script type="text/javascript" src="resources/js/geoCharting.js" charset="utf-8"></script>-->
<script type="text/javascript">
    require(["dojox/geo/charting/MouseInteractionSupport","dojox/geo/charting/TouchInteractionSupport"]);
</script>
<div class="info">
    <ul>
        <li><strong>申明</strong>:该示例为官方示例，默认为美国地图。如果需要中国地图的支持必须要学习以下几个关于地理地图绘制技术——
        openlayers、shapefile、geoJSON之间的转换，控件参数shapeData其实是shapefile --> geoJSON --> openlayers转换成json的结果。
            如果有这方面的经验或者兴趣可以去尝试研究一下，如果遇到对于中国地图的一些报表可以尝试使用百度的
        <a href="http://echarts.baidu.com/index.html">eCharts</a>
        </li>
    </ul>
</div>
<!-- csv dataStore -->
<div data-dojo-type="dojox/data/CsvStore" data-dojo-id="csvStore" url="resources/data/USPopulation.csv"
     identifier="Id" label="State"></div>
<div style="width: 100%; height:100%; background: rgb(120, 120, 120);">
    <div id="mapWidget" data-dojo-type="dojox/geo/charting/widget/Map"
         shapeData="resources/data/USStates.json"
         dataStore="csvStore" series="resources/data/series.json"  markerData="resources/data/markers.json" showTooltips="true"
         animateOnResize="false" colorAnimationDuration="0"
         adjustMapCenterOnResize="true" adjustMapScaleOnResize="true" dataBindingAttribute="2009"
         enableMouseSupport="true" style="height:400px"
         enableMousePan="true" enableMouseZoom="true" enableFeatureZoom="false" enableTouchSupport="true"
        >
    </div>

</div>
<p></p>