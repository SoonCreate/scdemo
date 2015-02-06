<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>速创内部培训demo演示</title>
    <link rel="stylesheet" href="../dojo/dojo/resources/dojo.css" />
    <link rel="stylesheet" href="../dojo/dijit/themes/claro/document.css" />
    <link rel="stylesheet" href="../dojo/dijit/themes/claro/claro.css" />
    <!--    <link rel="stylesheet" type="text/css" href="//115.29.6.162/cdn/dojo/dojox/grid/enhanced/resources/claro/EnhancedGrid.css" />-->
    <link rel="stylesheet" href="../dojo/gridx/resources/claro/Gridx.css" />
    <link rel="stylesheet" href="resources/css/demo.css" />
    <!-- 设置dojo参数 -->
    <script type="text/javascript">
        var dojoConfig = {
//            parseOnLoad: true,
            async : true,
            packages: [
                { name: "local", location: "/scdemo/resources/js/"}
            ]
        }
        function url(s){
            var ciBaseUrl = "<?= base_url()?>";
            return ciBaseUrl + s;
        }

    </script>
    <script src="../dojo/dojo/dojo.js"></script>

    <script type="text/javascript" src="resources/js/src.js" charset="utf-8"></script>
    <script type="text/javascript" src="resources/js/message.js" charset="utf-8"></script>
</head>
<body class="claro">
<div id="preloader">Loading Application...</div>
<script type="dojo/require">
    "demo.dom": "dojo/dom",
    "demo.registry": "dijit/registry"
</script>
<div data-dojo-type="dijit/layout/BorderContainer" id="mainContainer"
     data-dojo-props="gutters:true">
    <div data-dojo-type="dijit/layout/ContentPane" id="headerPane"
         data-dojo-props="splitter:false, region:'top'">速创内部培训demo演示</div>
    <div data-dojo-type="dijit/layout/BorderContainer" id="mainSplitter"
         data-dojo-props="liveSplitters: false, design: 'sidebar', region: 'center'">
        <div data-dojo-type="dijit/layout/AccordionContainer"
             id="leftAccordion" data-dojo-props="minSize: 20, region: 'leading',splitter:true">
            <div data-dojo-type="dijit/layout/ContentPane" id="ap1"
                 data-dojo-props="title: '控件', href:'<?= base_url('welcome/dijit_title_list')?>'"
                 class="paneAccordion"></div>
            <div data-dojo-type="dijit/layout/ContentPane" id="ap2"
                 data-dojo-props="title: '图表', href:'<?= base_url('chart/chart_title_list')?>'"
                 class="paneAccordion"></div>
            <div data-dojo-type="dijit/layout/ContentPane" id="ap3"
                 data-dojo-props="title: '其他', content:'待添加'"
                 class="paneAccordion"></div>
        </div>
        <div data-dojo-type="dijit/layout/TabContainer" id="mainTabContainer"
             data-dojo-props="region: 'center'">
            <div data-dojo-type="dijit/layout/ContentPane" id="tabWelcome"
                 data-dojo-props="title: 'Welcome', href:'<?= base_url('welcome/welcome_message')?>'"></div>
        </div>
    </div>
</div>
</body>

</body>
</html>