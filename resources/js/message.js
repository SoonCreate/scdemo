function flashMessage(m){
    require(["dojo/_base/fx", "dojo/dom","dojo/has","dojo/domReady!"],
        function(fx,dom,has){
            //ie处理:错误弹框，成功不显示
            dojoConfirm(m["content"],null,null,m["type"]);
        }); //end of require(["dojo/ready"
}

//失败后运行ffunc,成功后允许sfunc
function handleResponse(response,ffunc,sfunc,nobackfunc){
    var error = false;
    if(response && "messages" in response){
        var messages = response["messages"];
        //显示服务端返回信息
        if(messages.length > 0){
            for(var i=0;i<messages.length;i++){
                var m = messages[i];
                //显示服务端返回信息
                flashMessage(m);
                //存在错误刷新数据
                if(m['type'] == 'E' || m['type'] == 'W'){
                    error = true;
                }
            }
        }
        if(error){
            if(ffunc){
                ffunc();
            }
        }else{
            if(sfunc){
                sfunc();
            }
        }
    }else{
        if(nobackfunc){
            nobackfunc();
        }
    }
}

//效果同js原先的confirm
//content ：弹出框内容 ； callback ： 确认后要执行的内容
function dojoConfirm(content,callback,noback,type){
    require(["dijit/Dialog","dijit/form/Button"],
        function(Dialog,Button){
            //检查如果存在则销毁
            var di = dijit.byId("confirmDialog");
            if(di){
                di.hide();
                di.destroyRecursive();
            }
            switch(type){
                case "E" :
                    //此处可以再渲染
                    content =  "<div class='messageContainer'><img src='resources/images/error.gif' width='60px' height='60px'/>" +
                        "<div class='messageContent'>" + content + "</div></div>";
                    break;
                case "W" :
                    content = "<div class='messageContainer'><img src='resources/images/warning.png' width='60px' height='60px'/>" +
                        "<div class='messageContent'>" +content + "</div></div>";
                    break;
                default :
                    content = "<div class='messageContainer'><img src='resources/images/info.png' width='60px' height='60px'/>" +
                        "<div class='messageContent'>" +content + "</div></div>";
                    break;
            }
            var confirmDialog = new Dialog({
                content : content,
                id : "confirmDialog",
                title : "消息",
                onClick : function(){
                    if(type == "I"){
                        this.hide();
                    }
                }
            });
            //IE优化
//            var node = domConstruct.create("div",{class : "confirmButtonGroup"});
            var node = document.createElement('div');
//            node.setAttribute('class', 'confirmButtonGroup');
            node.className = "dijitDialogPaneActionBar";

            //确认按钮
            var okbutton = new Button({
                label : "确认",
                onClick : function(){
                    if(callback){
                        callback();
                    }
                    confirmDialog.hide();
                }
            });
            okbutton.placeAt(node,"last");

        //取消按钮
            var cancelbutton = new Button({
                label : "取消",
                onClick : function(){
                    if(noback){
                        noback();
                    }
                    confirmDialog.hide();
                }
            });
            cancelbutton.placeAt(node,"last");

            confirmDialog.containerNode.appendChild(node);
            confirmDialog.show();
    });

}

function alertRemoteFail(){
    dojoConfirm("服务器响应错误，请联系维护人员！",null,null,"E");
}

function closeDialog(id){
    var posDialog = dijit.byId(id);
    if(posDialog){
        posDialog.hide();
    }
}
