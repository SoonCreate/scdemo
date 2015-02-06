<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ldap extends CI_Controller {

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

    function ou_tree(){
        $rs = $this->search('(objectClass=organizationalUnit)',array('dn'));
        $data = array();
        foreach($rs as $d){
            array_push($data,$d['dn']) ;
        }
        $root['ou'] = '集团';
        $root['dn'] = 'DC=chint,DC=com';
        set_sess('ldap_data',$data);
        $tree = $this->_add_children($root);
//        for($i=0;$i<count($tree);$i++){
//            $tree[$i] = $this->_add_children($data,$tree[$i]);
//        }
            echo '11';

//        echo json_encode($data);
    }

    function _add_children($node){
        $rt = $node;
        log_message('info',$rt['dn']);
        $children = $this->_children($rt['dn']);
        if(count($children) > 0){
            $rt['children'] = $children;
            for($i=0;$i<count($rt['children']);$i++){
                $rt['children'][$i] = $this->_add_children($rt['children'][$i]);
            }
        }
        return $rt;
    }

    function _children($substr){
        $data = _sess('ldap_data');
//        echo 'data:'.print_r($data);
        echo 'substr:'.$substr;
        echo '<hr/>';
        $rt = array();
        if(count($data) > 0){
            for($i=0;$i<count($data);$i++){
                $len = strlen($data[$i]);
                $pos = strripos($data[$i],$substr);
                if($pos >=0){

                    $s = substr($data[$i],0,$pos - 1);

                    if(substr_count($s,'OU=') === 1){
                        echo '11:'.$s.'$i : '.$i.'<br/>';
                        echo $data[$i];

//                        echo $data[$i];
//                        echo '<hr/>';
                        $row['dn'] = $data[$i];
                        $row['ou'] = substr($s,3);
                        array_push($rt,$row);
                        //删除满足情况的ou
                        array_splice($data,$i,1);
                    }
                }
            }
        }
        unset_sess('ldap_data');
        set_sess('ldap_data',$data);
        echo '$rt :' ;
        print_r($rt);
        return $rt;
    }

    //AD域验证
    function search($filter,$attributes = null){
        $name = 'ybchenyy';
        $ldap['pwd']  = '325604';
        $conn = @ldap_connect('chint.com');
        $ldap['base_dn']="ou=浙江正泰仪器仪表有限责任公司,dc=chint,dc=com";
//        $ldap['filter'] = '(&(objectClass=user)(samaccountname='.$name.'))';
        $ldap['username']=$name."@chint.com";
        if($conn){
//            echo $conn.'连接服务器成功';
            //设置链接属性
            ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION,3);
            ldap_set_option($conn, LDAP_OPT_REFERRALS,0);

            $bind = @ldap_bind($conn,$ldap['username'], $ldap['pwd']);
            if ($bind){
//                echo "yes";
//                $attributes = array("mail", "sn", "cn");
//                $sr=ldap_search($conn,$ldap['base_dn'],'(objectClass=organizationalUnit)',$attributes);
                if(is_array($attributes)){
                    $sr=ldap_search($conn,$ldap['base_dn'],$filter,$attributes);
                }else{
                    $sr=ldap_search($conn,$ldap['base_dn'],$filter);
                }
                $array = ldap_get_entries($conn,$sr);
//                var_dump($array);
//                 print_r($array);
                ldap_unbind($conn) or die("Can't unbind from LDAP server.");
                return $array;
            } else {
                return null;
            }
        }else{
            return null;
        }
    }

    //通过NTLM方式获取当前客户端登陆名,IE有bug
    function get_local_user_ntlm(){
        /***********************************************************************
         ************************************************************************
         *
         * PHP NTLM GET LOGIN
         * Version 0.2.1
         * http://www.secusquad.com/ntlm/
         * Copyright (c) 2004 Nicolas GOLLET ( Nicolas (dot) gollet (at) secusquad (dot) com )
         * Copyright (c) 2004 Flextronics Saint-Etienne
         *
         * This program is free software. You can redistribute it and/or modify
         * it under the terms of the GNU General Public License as published by
         * the Free Software Foundation; either version 2 of the License.
         *
         ***********************************************************************/
        session_start();
        $headers = apache_request_headers();  // 获取用户头

        if (@$_SERVER['HTTP_VIA'] != NULL){ // 确认是否使用了代理(proxy),因为ntlm验证不能穿过代理.
            echo "Proxy bypass!";
        }
        elseif($headers['Authorization'] == NULL){    //si l'entete autorisation est inexistante如果许可头不存在
            header( "HTTP/1.0 401 Unauthorized" );   //envoi au client le mode d'identification
            header( "WWW-Authenticate: NTLM" );   //dans notre cas le NTLM
            exit;       //on quitte
        }
        if(isset($headers['Authorization']))     //dans le cas d'une authorisation (identification)
        {
            if(substr($headers['Authorization'],0,5) == 'NTLM '){  // 确认client是否在ntlm下

                $chaine=$headers['Authorization'];
                $chaine=substr($chaine, 5);    // 获取 base64-encoded type1 信息
                $chained64=base64_decode($chaine);  // 解码 base64 到 $chained64

                if(ord($chained64{8}) == 1){
                    //     |_ byte signifiant l'etape du processus d'identification (etape 3)

                    // verification du drapeau NTLM "0xb2" ?l'offset 13 dans le message type-1-message (comp ie 5.5+) :
                    if (ord($chained64[13]) != 178){
                        echo "NTLM Flag error!";
                        exit;
                    }

                    $retAuth = "NTLMSSP".chr(000).chr(002).chr(000).chr(000).chr(000).chr(000).chr(000).chr(000);
                    $retAuth .= chr(000).chr(040).chr(000).chr(000).chr(000).chr(001).chr(130).chr(000).chr(000);
                    $retAuth .= chr(000).chr(002).chr(002).chr(002).chr(000).chr(000).chr(000).chr(000).chr(000);
                    $retAuth .= chr(000).chr(000).chr(000).chr(000).chr(000).chr(000).chr(000);

                    $retAuth64 =base64_encode($retAuth);  // encode en base64
                    $retAuth64 = trim($retAuth64);    // enleve les espaces de debut et de fin

                    header( "HTTP/1.0 401 Unauthorized" );   // envoi le nouveau header
                    header( "WWW-Authenticate: NTLM $retAuth64" ); // avec l'identification suppl閙entaire
                    exit;

                }

                else if(ord($chained64{8}) == 3){
                    //          |_ byte signifiant l'etape du processus d'identification (etape 5)

                    // on recupere le domaine
                    $lenght_domain = (ord($chained64[31])*256 + ord($chained64[30])); // longueur du domain
                    $offset_domain = (ord($chained64[33])*256 + ord($chained64[32])); // position du domain.
                    $domain = str_replace("\0","",substr($chained64, $offset_domain, $lenght_domain)); // decoupage du du domain

                    //le login
                    $lenght_login = (ord($chained64[39])*256 + ord($chained64[38])); // longueur du login.
                    $offset_login = (ord($chained64[41])*256 + ord($chained64[40])); // position du login.
                    $login = str_replace("\0","",substr($chained64, $offset_login, $lenght_login)); // decoupage du login

                    if ( $login != NULL){
                        // stockage des donn閑s dans des variable de session
                        $_SESSION['Login']=$login;
//                        header("Location: newpage.php");
                        exit;
                    }
                    else{
                        echo "NT Login empty!";
                    }


                }
            }
        }

    }

    function phpinfo(){
        echo phpinfo();
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */