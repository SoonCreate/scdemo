<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Remote_message extends CI_Controller {

	public function index()
	{
        render_with_source_code('remote_message_demo');
	}

    function error(){
        message('E',"数据验证失败！");
    }

    function warning(){
        message('W',"数据重复，但仍重新保存！");
    }

    function info(){
        message('I',"数据保存成功！");
    }
}
