require(["dojo/ready","dijit/form/Button","dojo/request","dijit/Dialog"],function(ready,Button,request,Dialog){
    ready(function(){
        var bt1 = new Button({
            onClick : function(){
                showResponse(url("remote_message/error"),1)
            }
        },"ajax_error");
        bt1.startup();

        var bt2 = new Button({
            onClick : function(){
                showResponse(url("remote_message/warning"),2)
            }
        },"ajax_warning");
        bt2.startup();

        var bt3 = new Button({
            onClick : function(){
                showResponse(url("remote_message/info"),3)
            }
        },"ajax_info");
        bt3.startup();
    });

    function showResponse(url,data){
        request.post(url,
            {
                data : {mtype : data},
                handleAs : "json",
                timeout : 2000
            }).then(function(response){
                handleResponse(response);
            },function(){
                alertRemoteFail();
            });
    }
});