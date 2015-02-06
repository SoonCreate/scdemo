<div class="info">
    <ul>
        <li><strong>显示效果</strong>
            ：通过行底部附加一个高亮的grid形式实现(隐去header和hScroller)
        </li>
        <li><strong>列宽调整联动</strong>
            ：获取当前grid结构的实际列宽设置structure；并调整width属性：autoWidth + style
        </li>
        <li><strong>过滤结果RowIds采集</strong>
            ：用于更新运算范围，运算结果随过滤器的过滤结果重新计算
        </li>
        <li><strong>监听</strong>
            ：grid.columnResizer.onResize ； grid.filter.onFilter ； grid.onHScroll
        </li>
        <li><strong>运算类型</strong>
            ：汇总，平均值，最小值，最大值，计数 ["SUM","AVG","MIN","MAX","COUNT"]
        </li>
    </ul>
</div>
<button id="addSummaryRow"></button>
<button id="destroySummaryRow"></button>
<button id="sumColumnData"></button>
<hr/>
<div id="summaryRowDemoGrid" ></div>
<script type="text/javascript" src="resources/js/libs/gridx_summary_row_demo.js" charset="utf-8"></script>
