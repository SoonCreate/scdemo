<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

//在你的控制器实例化之后,任何方法调用之前调用.
$hook['post_controller_constructor'][] = array(
    'class'    => 'SMessage',
    'function' => 'initial',
    'filename' => 'SMessage.php',
    'filepath' => 'hooks'
);

//在你的控制器完全运行之后调用.
$hook['post_controller'] = array(
    'class'    => 'SMessage',
    'function' => 'response',
    'filename' => 'SMessage.php',
    'filepath' => 'hooks'
);

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */