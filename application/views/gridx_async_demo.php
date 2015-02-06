<div class="info">
    <ul>
        <li><strong>dojo/store/JsonRest</strong>
            ：异步数据交互常用Store:<a href="http://livedocs.dojotoolkit.org/dojo/store/JsonRest" target="_blank">文档</a>
        </li>
        <li><strong>Client-pageSize</strong>：发送到服务端的条目HTTP header : items=0-19</li>
        <li><strong>Server-Header</strong>：服务端反馈HTTP header : Content-Range</li>
        <li><strong>Sort</strong>：发送到服务端URL后自动加参数 : [restStore:sortParam]key为store参数，默认为sort；值：[+/-]代表顺/逆序；[colName]排序列</li>
        <li><strong>Filter</strong>：?username=*0*&sortBy=+username ，在输入值时过滤器会根据规则模糊查询大部分数据，加载到本地再进行过滤；ps.自带的过滤器性能和易用性都比较差，建议重写过滤器</li>
    </ul>
</div>
<div id="asyncTestGrid" ></div>
<script type="text/javascript" src="resources/js/libs/gridx_async_demo.js" charset="utf-8"></script>
