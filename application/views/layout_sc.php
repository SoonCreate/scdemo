<div data-dojo-type="dijit/layout/TabContainer"  data-dojo-props="region: 'center',nested : true">
    <div data-dojo-type="dijit/layout/ContentPane" data-dojo-props="title: 'Demo'">
        <div id="container">
            <div id="body">
                <?php echo  $content_for_layout ?>
            </div>
        </div>
    </div>
    <?php if(isset($view_code)) :?>
    <div data-dojo-type="dijit/layout/ContentPane" data-dojo-props="title: '模版代码'">

        <code>
            文件地址：<?= APPPATH.'views/'.$view_code.'.php'?>
        </code>
         <pre>

            <?php
            $a = file(SITE_PATH.APPPATH.'views/'.$view_code.'.php');
            foreach($a as $line => $content){
//                echo $line;
                echo htmlspecialchars($content);
            }
            ?>
         </pre>

    </div>
    <?php endif ?>
    <?php if(isset($js_code)) :?>
        <div data-dojo-type="dijit/layout/ContentPane" data-dojo-props="title: 'Dojo代码'">

            <code>
                文件地址：<?= 'resources/js/libs/'.$js_code.'.js'?>
            </code>
         <pre>
            <?php
             $a = file(SITE_PATH.'resources/js/libs/'.$js_code.'.js');
             foreach($a as $line => $content){
                 echo htmlspecialchars($content);
             }
             ?>
         </pre>

        </div>
    <?php endif ?>

    <?php if(isset($others) && (count($others) > 0))  :
        foreach($others as $o) :
        ?>
        <div data-dojo-type="dijit/layout/ContentPane" title = "<?= $o['filename']?>">

            <code>
                文件地址：<?= $o['path']?>
            </code>
         <pre>
            <?php
             $a = file(SITE_PATH.$o['path']);
             foreach($a as $line => $content){
                 echo htmlspecialchars($content);
             }
             ?>
         </pre>

        </div>
    <?php
    endforeach;
    endif ?>

</div>