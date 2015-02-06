<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart extends CI_Controller {

    function chart_title_list(){
        $this->load->view('_chart_title_list');
    }

    function chart2d(){
        render_with_source_code('chart2d_demo');
    }

    function geo_charting(){
        render_with_source_code('geo_charting_demo');
    }
}
