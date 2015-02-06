<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

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

	public function index()
	{
		$this->load->view('welcome');
	}

    function welcome_message(){
        $this->load->view('welcome_message');
    }

    function dijit_title_list(){
        $this->load->view('_dijit_title_list');
    }

    function dojo_menu_demo(){
        $d['filename'] = 'local/MenuBar';
        $d['path'] = 'resources/js/MenuBar.js';
        $d2['filename'] = 'local/RightMenu';
        $d2['path'] = 'resources/js/RightMenu.js';
        render_with_source_code('dojo_menu_demo',array($d,$d2));
    }

    function dojo_menu_demo_menubar_data(){
        echo '{
            "items" : [
             {"name":"program","label":"程序","sort" : 1,"children":
            [
            { "id": "1","type": "program","do": "direct_to","url": "gogo" ,"label":"信息记录"},
            { "id": "2","type": "program","do": "direct_to","url": "","label":"货源清单" },
            { "id": "2","type": "MenuSeparator","do": "direct_to","url": "","label":"" },
            { "id": "3","type": "program","do": "direct_to","url": "","label":"更多","children" :
                [
                    {"id": "4","type": "program","do": "direct_to","url": "","label":"很多","children" :
                        [
                            {"id": "4","type": "program","do": "direct_to","url": "","label":"喜多多"}
                        ]
                    },
                    { "id": "2","type": "MenuSeparator","do": "direct_to","url": "","label":"" },
                    {"id": "4","type": "program","do": "direct_to","url": "","label":"多西多"}
                ]
            },
            { "id": "2","type": "program","do": "direct_to","url": "","label":"货源清单2" }
            ]
            },
            {"name":"edit","label":"编辑","sort" : 2,"children":
            [
            { "id": "1","type": "program","do": "direct_to","url": "gogo" ,"label":"粘贴"},
            { "id": "2","type": "program","do": "direct_to","url": "","label":"复制" },
            { "id": "3","type": "program","do": "direct_to","url": "","label":"保存","children" :
                [
                    {"id": "4","type": "program","do": "direct_to","url": "","label":"另存为CSV"},
                    {"id": "4","type": "program","do": "direct_to","url": "","label":"另存为TXT"},
                    {"id": "4","type": "program","do": "direct_to","url": "","label":"另存为PDF"}
                ]
            }
            ]
            }
            ]
            }';
    }

    function phpinfo(){
        echo phpinfo();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */