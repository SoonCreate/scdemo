<h1>MenuBar</h1>
<div class="info">
    <ul>
        <li><strong>contextMenuForWindow</strong>：控制当前窗口的全局菜单开关</li>
        <li><strong>targetNodeIds</strong>：控制到单个dom对象</li>
        <li><strong>iconClass</strong>：菜单图标控制</li>
        <li><strong>accelKey</strong>：与Windows系统快捷键交互</li>
    </ul>
</div>
<div id="MenuBar"></div>


<h1>RightMenu</h1>
<div class="info">
    <ul>
        <li><strong>selector</strong>：局部选择器</li>
        <li><strong>dojo/aspect</strong>：钩子函数</li>
    </ul>
</div>
<div id="partMenu" style="width: 100px;height: 100px;background-color: greenyellow">
    局部菜单展示区
    <br/><br/><br/>
    <a href="#">右键我动态生成菜单<a>
</div>


<h1>Gridx RightMenu</h1>
<div class="info">
    <ul>
        <li><strong>触发器目标hookPoint：</strong>：grid/body/header/row/cell</li>
        <li><strong>被选择的目标selected</strong>：开/关</li>
    </ul>
</div>
<div id="menuDemoGrid"></div>
<code>注意：header cell上的右键菜单需要激活点击后才能显示，这块还需要再研究</code>
<script type="text/javascript" src="resources/js/libs/dojo_menu_demo.js" charset="utf-8"></script>