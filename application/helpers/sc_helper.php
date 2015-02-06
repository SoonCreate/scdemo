<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

//渲染函数
function render($view = NULL,$data = NULL){
    render_by_layout('sc',$view,$data);
}

//模板
function render_by_layout($layout = NULL,$view = NULL,$data = NULL){
    $CI =  &get_instance();
    if(is_null($view)){
        $view = $CI->router->fetch_directory().'/'.$CI->router->fetch_class().'/'.$CI->router->fetch_method();
    }
    if(is_null($layout)){
        $CI->load->view($view,$data);
    }else{
        $CI->layout->setlayout($layout);
        $CI->layout->view($view,$data);
    }
}

//获取session值
function _sess($key){
    global $CI;
//    $CI->load->library('session');
    return $CI->session->userdata($key);
}
//设置session
function set_sess($key,$value = NULL){
    global $CI;
//    $CI->load->library('session');
    if(is_array($key)){
        $newdata = $key;
    }else{
        $newdata[$key] = $value;
    }
    $CI->session->set_userdata($newdata);
}

function unset_sess($key){
    global $CI;
    $CI->session->unset_userdata($key);
}

function clear_all_sess(){
    global $CI;
    $CI->session->sess_destroy();
}

function _text(){
    global $CI;
    $numargs = func_num_args();
    $arg_list = func_get_args();
    $out_data = $CI->lang->line($arg_list[0]);
    if( $out_data ){
        if ( $numargs > 1 ){
            $app = '$out_data = sprintf( $out_data ';
            for ($i = 1; $i < $numargs; $i++){
                $app = $app.",\$arg_list[$i]";
            }
            $app = $app.");";
            eval($app);
        }
        return $out_data;
    }
    else{
        return $arg_list[0];
    }
}

//返回信息操作
function initial_message(){
    set_sess('message',Array());
}
//返回本次插入后的id
function last_id(){
    global $CI;
    if( !$CI->db ) $CI->load->database();
    return $CI->db->insert_id();
}

//临时使用的输出
function message($type,$content){
    $message['type'] = $type;
    $message['content'] = $content;
    //刷新message会话数据
    $messages = _sess('message');
    array_push($messages,$message);
    set_sess('message',$messages);
}

//配置了源代码解释，文件名调用view名
function render_with_source_code($filename,$others = array()){
    $data = code_file($filename);
    $data['others'] = $others;
    render($filename,$data);
}

function code_file($filename){
    $data['view_code'] = $filename;
    $data['js_code'] = $filename;
    return $data;
}