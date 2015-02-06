<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gridx extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

    function __construct(){
        parent::__construct();
        header('Content-Type: text/html; charset=utf-8');
    }

    function async_demo(){
        render_with_source_code('gridx_async_demo');
    }


    function test_data(){
        $data['identifier'] = 'id';
        $data['label'] = 'username';
        $data['items'] = array();

        //url需要解析
        $sort_by = urlencode($this->input->get('sortBy'));
        $sort_order = substr($sort_by,0,1);
        $sort_field = substr($sort_by,1);

        $username = $this->input->get('sortBy');

//        foreach ($_SERVER as $key => $value) {
//            echo $key.':'.$value;
//                echo '<br/>';
//        }
        $start = 0;
        $end = 20000 ;
        $totalCnt = 20000;

        if(isset($_SERVER['HTTP_RANGE'])){
            $idx = stripos($_SERVER['HTTP_RANGE'],'-');
            $start = intval(substr($_SERVER['HTTP_RANGE'],6,$idx-6));
            $end = intval(substr($_SERVER['HTTP_RANGE'],$idx+1));
            if($end == 0){
                $end = $totalCnt;
            }
        }else{
            //gridx rightMenu demo
            $end = 10;
        }

        //判断排序
        switch($sort_order){
            case '-' :
                //逆序
                for($i = $totalCnt - $start - 1;$i >= $totalCnt - $end - 1;$i--){
                    //过滤器测试
//                    if(stripos($username,'*') >= 0){
//                        continue;
//                    }

                    $row['id'] = 'sc'.$i;
                    $row['username'] = 'yacole'.$i;
                    $row['password'] = $i * 10;
                    $row['sex'] = 1;
                    $row['pos'] = '总监'.$i;
                    array_push($data['items'],$row);
                }

                break;
//            case '+':
//                for($i = $start;$i <= $end;$i++){
//                    $row['id'] = $i;
//                    $row['username'] = 'yacole'.$i;
//                    $row['password'] = '1'.$i;
//                    $row['sex'] = '男'.$i;
//                    $row['pos'] = '总监'.$i;
//                    array_push($data['items'],$row);
//                }
//                break;
            default:
                for($i = $start;$i <= $end;$i++){

//                    if(stripos($username,'*') >= 0 && $i/10 == 0){
//                        continue;
//                    }

                    $row['id'] = 'sc'.$i;
                    $row['username'] = 'yacole'.$i;
                    $row['password'] = $i * 10;
                    $row['sex'] = 1;
                    $row['pos'] = '总监'.$i;
                    array_push($data['items'],$row);
                }
                break;
        }


        $output =  $data;
        if(isset($_SERVER['HTTP_RANGE'])){
            //        header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.round($totalCnt/($end+1)));
            header('Content-Range:'.$_SERVER['HTTP_RANGE'].'/'.$totalCnt);
            $output = $data['items'];
        }
        echo json_encode($output);
    }

    //汇总行：实现方式，两个grid联动
    function summary_row_demo(){
        $d['filename'] = 'local/dijit/SummaryRow';
        $d['path'] = 'resources/js/dijit/SummaryRow.js';
        render_with_source_code('gridx_summary_row_demo',array($d));
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */