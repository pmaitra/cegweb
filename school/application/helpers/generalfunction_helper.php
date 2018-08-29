<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('set_pagination_config'))
{
    function set_pagination_config($setdata)
    {
            $config['base_url'] = $setdata['base_url'];
            $config['total_rows'] = $setdata['total_rows'];
            $config['per_page'] = PER_PAGE;
            $config['num_links'] = 5;
            $config['cur_page'] = $setdata['cur_page'];//CURRENT PAGE NUMBER
            $config['first_link'] = "First";
            $config['last_link'] = "Last";
            $config['full_tag_open'] = "<div class='pagination'>";
            $config['full_tag_close'] = "</div>";
            $config['anchor_class'] = "";

            return $config;
    }
}

if (!function_exists('total_count'))
{
    function total_count($table_name,$count_param,$condition='',$db_name='')
    {
       $ci =& get_instance();
       
            $ci->db->select('*');
            $ci->db->from($table_name);
            if(!empty($condition))
            {
                 $condition = make_conditional_array($condition);
                foreach ($condition as $single_condition) {
                    $ci->db->where($single_condition['field'], $single_condition['value']);
                }

            }
       
            $query = $ci->db->get();
            $total_count_value = $query->num_rows();
       
       //echo $ci->db->last_query();

       if ($total_count_value > 0)
       {
            return $total_count_value;
       }
       return 0;

    }
}

if (!function_exists('userloginvalidate'))
{
    function userloginvalidate()
    {
       $ci =& get_instance();
       $ci->load->library('session');

        if($ci->session->userdata('loginuserid'))
        {
            return true;
        }
       else
       {
           redirect(BASEURL);
       }
    }
}

if (!function_exists('loginredirection'))
{
    function loginredirection()
    {
       $ci =& get_instance();
       $ci->load->library('session');
       if($ci->session->userdata('loggedinuserid'))
       {
           redirect(BASEURL.'dashboard');
       }

       return TRUE;
    }
}
if (!function_exists('logintempcheck'))
{
    function logintempcheck()
    {
       $ci =& get_instance();
       $ci->load->library('session');
       if($ci->session->userdata('logintemp'))
       {
           return TRUE;
       }
       redirect(BASEURL.'logintemp');
       
    }
}


if (!function_exists('uservalidate'))
{
    function uservalidate()
    {
       $ci =& get_instance();
       $ci->load->library('session');
       $user_id = $ci->session->userdata('loggedinuserid');
       $passwordResetFlag = $ci->session->userdata('passwordResetFlag');
       
       if(!empty($user_id))
       {
           //$admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_ADMIN));
           $user_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_SSP_STUDENT));
           $user_map = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$user_group_id,'user_id'=>$user_id));

        }
       
       if(!empty($user_map))
       {
           if(empty($passwordResetFlag))
           {
               redirect(BASEURL.'home/passwordreset');
           }
            return GROUP_SSP_STUDENT;
       }
       else
       {
           redirect(BASEURL.'logout');
       }
    }
}

if (!function_exists('adminvalidate'))
{
    function adminvalidate()
    {
       $ci =& get_instance();
       $ci->load->library('session');
       $user_id = $ci->session->userdata('loggedinuserid');
       
       if(!empty($user_id))
       {
           $admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_ADMIN));
           $user_map = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$admin_group_id,'user_id'=>$user_id));
       }
       
       if(!empty($user_map))
       {     
            return GROUP_NISM_ADMIN;
       }
       else
       {
           redirect(BASEURL.'logout');
       }
    }
}

if (!function_exists('teachervalidate'))
{
    function teachervalidate()
    {
       $ci =& get_instance();
       $ci->load->library('session');
       $user_id = $ci->session->userdata('loggedinuserid');
       
       if(!empty($user_id))
       {
           $teacher_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_ICAM_TEACHER));
           $user_map = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$teacher_group_id,'user_id'=>$user_id));
       }
       
       if(!empty($user_map))
       {     
           //pr($user_map);
            return GROUP_ICAM_TEACHER;
       }
       else
       {
           redirect(BASEURL.'logout');
       }
    }
}

if (!function_exists('alumnivalidate'))
{
    function alumnivalidate()
    {
       $ci =& get_instance();
       $ci->load->library('session');
       $user_id = $ci->session->userdata('loggedinuserid');
       
       if(!empty($user_id))
       {
           //$admin_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_ADMIN));
           $user_group_id = fetch_single_value('groups', 'id', array('group_name'=>GROUP_NISM_APPLICANT));
           $user_map = fetch_single_value('user_groups_map', 'group_id', array('group_id'=>$user_group_id,'user_id'=>$user_id));
           $user_alumni_flag = fetch_single_value('users', 'icam_portal_alumni_flag',array('icam_portal_alumni_flag'=>1,'icam_alumni_flag'=>1,
                    'id'=>$user_id));

        }
       
       if(!empty($user_map) && $user_alumni_flag == 1)
       {     
            return TRUE;
       }
       else
       {
           redirect(BASEURL.'alumni/logout');
       }
    }
}

if (!function_exists('fetch_single_value'))
{
    function fetch_single_value($table_name,$field_name,$condition='',$db_name='')
    {
       $ci =& get_instance();
       $ci_instance = $ci->db;
       if(!empty($db_name))
       {
            $ci_instance = $ci->load->database($db_name, TRUE);
       }
           $ci_instance->select($field_name.' as value');
           $ci_instance->from($table_name);
            if(!empty($condition))
            {
                $condition = make_conditional_array($condition);
                foreach ($condition as $single_condition) {
                    $ci_instance->where($single_condition['field'], $single_condition['value']);
                }
            }
            $query = $ci_instance->get();
            $total_count_value = $query->num_rows;

       if(!empty($query->row()->value))
       {
            return $query->row()->value;
       }
       return FALSE;
    }
}

if (!function_exists('value_already_exist'))
{
    function value_already_exist($table_name,$field_name,$condition='')
    {
       $ci =& get_instance();
       $ci_instance = $ci->db;
       if(!empty($db_name))
       {
           $ci_instance = $ci->load->database($db_name, TRUE);
       }
           $ci_instance->select($field_name.' as value');
           $ci_instance->from($table_name);
            if(!empty($condition))
            {
                $condition = make_conditional_array($condition);
                foreach ($condition as $single_condition) {
                    $ci_instance->where($single_condition['field'], $single_condition['value']);
                }
            }
            $query = $ci_instance->get();
            $total_count_value = $query->num_rows;

       if(!empty($query->row()->value))
       {
            return $query->row()->value;
       }
       return FALSE;
    }
}

    /*example
     * fetch_all_data('cm_category', 
     * array('cat_id,category_name'),
     * array('0'=>array('field'=>'group_id','value'=> $group_id),
     * '1'=>array('field'=>'parent_id','value'=> 0)));
     * */

    if (!function_exists('fetch_all_data'))
    {
        function fetch_all_data($table_name,$field_name_arr ='',$condition='',$in_condition='',$order_by='',$db_name='')
        {
            try 
            {
                if(!empty($field_name_arr))
                    $field_name_all = implode(",", $field_name_arr);
                if(empty($field_name_all))
                   $field_name_all='*';

                $ci =& get_instance();
                $ci_instance = $ci;

                $ci_instance->db->select($field_name_all);
                $ci_instance->db->from($table_name);
                //  var_dump($condition);
                if(!empty($condition))
                {
                    $condition = make_conditional_array($condition);
                    foreach ($condition as $single_condition) {
                        $ci_instance->db->where($single_condition['field'], $single_condition['value']);
                    }

                }
                if(!empty($in_condition))
                {
                    $in_condition = make_conditional_array($in_condition);
                    foreach ($in_condition as $single_in_condition) {
                        $ci_instance->db->where_in($single_in_condition['field'], $single_in_condition['value']);
                    }

                }
                if(!empty($order_by))
                {
                    $ci_instance->db->order_by($order_by); 
                }
                $query = $ci_instance->db->get();
            
                //echo $ci->db->last_query();
                $result_arr = $query->result_array();

                if(!empty($result_arr))
                {
                     return $result_arr;
                }
                return FALSE;
            } 
            catch (Exception $ex) 
            {
                
            }
                
        }  
    }
        
        /*example
     * fetch_all_data('cm_category', 
     * array('cat_id,category_name'),
     * array('0'=>array('field'=>'group_id','value'=> $group_id),
     * '1'=>array('field'=>'parent_id','value'=> 0)));
     * */

    if (!function_exists('fetch_single_row'))
        {
            function fetch_single_row($table_name,$field_name_arr ='',$condition='',$db_name='')
            {

                if(!empty($field_name_arr))
                    $field_name_all = implode(",", $field_name_arr);
               if(empty($field_name_all))
                   $field_name_all='*';

               $ci =& get_instance();
                $ci_instance = $ci;
               
                   $ci_instance->db->select($field_name_all);
                   $ci_instance->db->from($table_name);
                    if(!empty($condition))
                    {
                        $condition = make_conditional_array($condition);
                        foreach ($condition as $single_condition) {
                            $ci_instance->db->where($single_condition['field'], $single_condition['value']);
                        }
                    }
                $query = $ci_instance->db->get();

               $result_arr = $query->result_array();
               //var_dump($result_arr);die;
               if(!empty($result_arr[0]))
               {
                    return $result_arr[0];
               }
               return FALSE;
            }
        }
        
        if (!function_exists('fetch_single_column'))
        {
            function fetch_single_column($table_name,$field_name_str ='',$condition='',$in_condition='',$order_by='',$unique_array='',$db_name='')
            {
                if(is_array($field_name_str))
                    $field_name_all = implode(",", $field_name_str);
                else {
                    $field_name_all = $field_name_str;
                }
               if(empty($field_name_all))
                   $field_name_all='*';

                $ci =& get_instance();
                $ci_instance = $ci;
                $ci_instance->db->select($field_name_all);
                $ci_instance->db->from($table_name);

                if(!empty($condition))
                {
                    $condition = make_conditional_array($condition);
                    foreach ($condition as $single_condition) {
                        $ci_instance->db->where($single_condition['field'], $single_condition['value']);
                    }

                }
                if(!empty($in_condition))
                {
                    $in_condition = make_conditional_array($in_condition);
                    foreach ($in_condition as $single_in_condition) {
                        $ci_instance->db->where_in($single_in_condition['field'], $single_in_condition['value']);
                    }

                }
                if(!empty($order_by))
                {
                    $ci_instance->db->order_by($order_by); 
                }
                $query = $ci_instance->db->get();
               
               $result_arr = $query->result_array();

               if(!empty($result_arr))
               {
                    foreach ($result_arr as $result_arr_single)
                    {
                        $result_arr_rebuild[] = $result_arr_single[$field_name_all];

                    }
                    if(!empty($result_arr_rebuild))
                    {
                        if(!empty($unique_array))
                        {
                            $result_arr_rebuild = array_values(array_unique($result_arr_rebuild));
                        }
                        return $result_arr_rebuild;
                    }
               }
               return FALSE;

            }
        }

        //For creating captcha for contact us in right panel
          if (!function_exists('create_custom_captcha'))
        {
            function create_custom_captcha()
            {
                //echo 'hi'; die;
                $ci =& get_instance();
                $ci->load->helper('captcha');
                $ci->session->set_userdata('captcha_word','');
                $vals = array(
                        'word'         =>'',
                        'img_path'     => $_SERVER['DOCUMENT_ROOT']."\public\captcha\\",
                        'img_url'      => PUBLICURL . 'captcha/',
                        'font_path'    => '',
                        'img_width'    => '200',
                        'img_height'   => 30,
                        'expiration'   => 300
                     );

                $cap = create_captcha($vals);
                
                $result_data = array(
                    'CAP_IP_ADDRESS' => $_SERVER['REMOTE_ADDR'],
                    );

                    //var_dump($cap);die;
                if(value_already_exist('CAPTCHA', 'CAP_ID',  make_conditional_array($result_data)))
                {
                   $result_data = array(
                    'CAP_TIME' =>$cap['time'],
                    'CAP_WORD' => strtolower($cap['word']),
                    ); 
                   
                    $ci->db->where('CAP_IP_ADDRESS' , $_SERVER['REMOTE_ADDR']);
                    $ci->db->update('CAPTCHA', $result_data); 
                }
                else
                {
                    $result_data = array(
                    'CAP_TIME' =>$cap['time'],
                    'CAP_IP_ADDRESS' => $_SERVER['REMOTE_ADDR'],
                    'CAP_WORD' => strtolower($cap['word']),
                    );
                    $query = $ci->db->insert('CAPTCHA', $result_data);
                }


               $expiration = time()-300; // 5 Mins limit
               $ci->db->query('DELETE FROM "CAPTCHA" WHERE "CAP_TIME" < '.$expiration);

                if(!empty($cap['image']))
                        return $cap['image'];
                       else
                         return FALSE;
                }
        }
    
    if (!function_exists('fckeditor_custom_create'))
    {
        function fckeditor_custom_create($instance_name,$instant_value='',$file_upload_path)
        {
            $ci =& get_instance();

           $ci->load->library('fckeditor');
           $ci->fckeditor->InstanceName = $instance_name;
           $ci->fckeditor->Value = $instant_value;
           //$ci->fckeditor->Config = array('UserFilesAbsolutePath'=>$file_upload_path,'UserFilesPath'=>$file_upload_path,'Enabled'=>"true");
           
           $fck_html = $ci->fckeditor->create($instance_name);
           
            if(!empty($fck_html))
               return $fck_html;
           else
               return FALSE ;

        }
    }
    
        if (!function_exists('last_insert_id'))
        {
            function last_insert_id($table_name)
           {
               $ci =& get_instance();
               $query = $ci->db->query("SELECT IDENT_CURRENT('$table_name') as last_id");
               $res = $query->result();
               if(!empty($res[0]->last_id))
                    return $res[0]->last_id;
               else
                   return FALSE;
           }
        }
        
        // Function used for making condition array properly
        if (!function_exists('make_condition_array'))
        {
            function make_conditional_array($data_arr='')
           {
                    $i=0;
                     foreach ($data_arr as $key => $value) {
                         $data_arr_reset[$i]['field']= $key;
                         $data_arr_reset[$i]['value']= $value;
                         $i++;
                     }
                     //var_dump($data_arr_reset);die;
               if(!empty($data_arr_reset) && is_array($data_arr))
                    return $data_arr_reset;
               else
                   return FALSE;
           }
        }
        
        //errorlog writing
        if (!function_exists('error_log_entry'))
        {
            function error_log_entry($data_str)
           {
                if(!empty($data_str))
                {
                    $ci =& get_instance();
                    $ci->load->helper('file');
                    /*
                     if(ENVIRONMENT == 'production')
                     {

                       $config['protocol'] = 'smtp';
                       $config['smtp_timeout']    = 50;                // SMTP Timeout (in seconds). ( None )
                       $config['smtp_host'] = 'ssl://smtprelaypool.ispgateway.de';
                       $config['smtp_port'] = '465';
                       $config['smtp_user'] = 'info@comelio.com';
                       $config['smtp_pass'] = 'B13086CH';
                       $config['charset'] = 'UTF-8';
                       $config['mailtype'] = 'html';
                       $config['wordwrap'] = TRUE;  
                       $ci->load->library('email',$config);

                       $ci->email->from('info@comelio.com', 'Comelio');
                       $ci->email->to('sayak.mukherjee@comelio.com');
                       $ci->email->cc('kalyan.samanta@comelio.com');
                       //$ci->email->bcc('them@their-example.com');

                       $ci->email->subject('Comelio | Error in WEBSITE ');
                       $data_mail = $data_str;
                       $data_mail.= $data_mail.PHP_EOL .'Domain:'.$_SERVER['SERVER_NAME'].PHP_EOL .date('H i s');
                       $ci->email->message($data_mail);
                       $ci->email->send();
					   
                       echo $ci->email->print_debugger();
                    }
					*/
					
                    //if(ENVIRONMENT =='production') 
                    //{                  
                       $present_data = read_file(ROOTURL.'\log\error\july.txt');
                       $data = $present_data.PHP_EOL .$data_str;
                       $data.= $data.PHP_EOL .'Domain'.$_SERVER['SERVER_NAME'].PHP_EOL .  date('H i s');
                       write_file(ROOTURL.'\log\error\july.txt', $data);
                   // } 
                   return TRUE;
                }
               
           }
        }

        
	// function used for getting all images of the folder 
        if (!function_exists('get_all_images'))
        {
            function get_all_images($location) { // added optional argument

                $handle = opendir(ROOTURL.$location);
                while($file = readdir($handle)){
                if($file !== '.' && $file !== '..'){
                    $images[]='/public/front/socialicon/'.$file;
                    }
                }
                //var_dump($images);die;
                return $images;
            } 
        }
        
        // Function used for making id array properly
        // Input array( 0 => array ('bscat_id' => '1' ,'bscat_name' =>  'Oracle'))
        // 1 => array ('bscat_id' => '2' ,'bscat_name' =>  'Datenbanken'))
        //Output array('1'=>oracle,'2'=>'Datenbanken')
        if (!function_exists('make_id_val_array'))
        {
            function make_id_val_array($data_arr='',$key='')
           {
                if(!empty($key) && !empty($data_arr))
                {
                     for($i=0;$i<count($data_arr);$i++) {
                         $data_arr_reset[$data_arr[$i]['id']] = $data_arr[$i];  
                     }
                }    
                else if(!empty($data_arr))
                {
                     for($i=0;$i<count($data_arr);$i++) {
                         $key_id = array_shift(array_slice($data_arr[$i], 0, 1));
                         $key_value = array_shift(array_slice($data_arr[$i], 1, 2));
                         $data_arr_reset[$key_id]=$key_value;
                         unset($key_id);
                         unset($key_value);
                     }
                }
               if(!empty($data_arr_reset) && is_array($data_arr))
                    return $data_arr_reset;
               else
                   return FALSE;
           }    
        }
        
        // remove redundency
        if (!function_exists('remove_duplicateKeys'))
        {
            function remove_duplicateKeys($key,$data)
            {

                $_data = array();

                foreach ($data as $v) {
                  if (isset($_data[$v[$key]])) {
                    // found duplicate
                    continue;
                  }
                  // remember unique item
                  $_data[$v[$key]] = $v;
                }
                // if you need a zero-based array, otheriwse work with $_data
                $data = array_values($_data);
                return $data;
            }
        }
        
        //Multidimention array key search with value
        if (!function_exists('array_searcher'))
        {
            function array_searcher($needle,$needle_value, $array) 
            { 
                    foreach ($array as $array_single) 
                    { 
                        if($array_single[$needle]==$needle_value)
                        {
                            $result_arr[] = array('title'=>$array_single['title']);
                        }
                    }
                    if(!empty($result_arr))
                        return $result_arr;
                    return FALSE;
            }
        }
        
        //location Generator
        if (!function_exists('freegeoip_locate'))
        {
            function freegeoip_locate($ip) 
            {
                $url = "http://freegeoip.net/json/".$ip;
                $geo = json_decode(file_get_contents($url), true);
                return $geo;
            }
        }

         //umlaut  conversion
        if (!function_exists('umlaut_conversion'))
        {
            function umlaut_conversion($string='')
            {
                $patterns=array('/ä/','/ü/','/ö/','/Ä/','/Ö/','/Ü/','/ß/','/#/');
                $replacements=array('ae','ue','oe','ae','oe','ue','ss','sharp');        
                $string= preg_replace($patterns, $replacements, $string);
                $string=preg_replace('/[^A-Za-z0-9\-\']/', '_', $string); 
            
                if(!empty($string))
                    return $string;
                else
                    return FALSE;
            }
        }
        
       //umlaut reverse conversion
       if (!function_exists('umlaut_reverse_conversion'))
        {
            function umlaut_reverse_conversion($string='')
            {
                $patterns =array('/ae/','/ue/','/oe/','/ae/','/oe/','/ue/','/ss/','/sharp/');
                $replacements=array('ä','ü','ö','Ä','Ö','Ü','ß','#');       
                $string= preg_replace($patterns, $replacements, $string);
                $string=preg_replace('/_/', ' ', $string); 
            
               if(!empty($string))
                    return $string;
                else
                    return FALSE;
            }
        }
              
        //rendering views
        if (!function_exists('renderViews'))
        {
            function renderViews($array)
            {
               $ci =& get_instance();
               //$ci->load->library('session');
               if(is_array($array))
               {
                   foreach ($array as $key => $value) {
                       $ci->load->view($key,$value);
                   }                  
               }
               else 
               {
                   $ci->load->view($value);
               }
            }
        }
        
        //arrayToKeyArray converter
        if (!function_exists('arrayToKeyArray'))
        {
            function arrayToKeyArray($array,$key_element)
            {
               if(is_array($array))
               {
                   foreach ($array as $key => $value) 
                   {
                       $rebuildArr[$value[$key_element]]=$value;
                   }
                   return $rebuildArr;
               }
               else 
               {
                   return;
               }
            }
        }
        
        if (!function_exists('delete_single_row'))
        {
            function delete_single_row($table_name,$condition='',$db_name='')
            {
               $ci =& get_instance();
               $ci_instance = $ci;

                    if(!empty($condition))
                    {
                        $condition = make_conditional_array($condition);
                        foreach ($condition as $single_condition) {
                            $ci_instance->db->where($single_condition['field'], $single_condition['value']);
                        }
                    }
                    $ci_instance->db->delete($table_name);
               return TRUE;
            }
        }
        if (!function_exists('single_column_update'))
        {
            function single_column_update($tbl_name,$param,$condition) {
                $ci =& get_instance();
                $ci_instance = $ci;
                    if(!empty($condition))
                    {
                        $condition = make_conditional_array($condition);
                        foreach ($condition as $single_condition) {
                            $ci_instance->db->where($single_condition['field'], $single_condition['value']);
                        }
                    }
                    $ci_instance->db->update($tbl_name, $param);
                    $last_affected_id = $ci_instance->db->affected_rows();
                if(!empty($last_affected_id))
                {
                    return $last_affected_id;
                }
                return FALSE;
        }
        
        if (!function_exists('custom_file_check'))
        {
            function custom_file_check($file_path,$thumb_path='',$noimage='') 
            {
                if(!empty($thumb_path) && !empty($file_path) && file_exists(FILEROOTURL.'uploads/images/'.$thumb_path.$file_path) )
                {
                    return ASSETURL.'uploads/images/'.$thumb_path.$file_path;
                }
                else if(!empty($file_path) && file_exists(FILEROOTURL.'uploads/images/'.$file_path) )
                {
                    return ASSETURL.'uploads/images/'.$file_path;
                }
                else if(!empty($file_path) && file_exists(FILEROOTURL.'images/'.$file_path) )
                {

                    return ASSETURL.'images/'.$file_path;
                }
                if($noimage == 'icon')
                {
                    return ASSETURL.'images/no-icon.png';
                }
                return ASSETURL.'images/no-image-box.png';
            }
        }
        
        if (!function_exists('seo_friendly_url'))
        {
            function seo_friendly_url($string){
            $string = str_replace(array('[\', \']'), '', $string);
            $string = preg_replace('/\[.*\]/U', '', $string);
            $string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
            $string = htmlentities($string, ENT_COMPAT, 'utf-8');
            $string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
            $string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/') , '-', $string);
            return strtolower(trim($string, '-'));
            }
        }
        
        if (!function_exists('rebuild_errors'))
        {
            function rebuild_file_errors($string='')
            {
                if(!empty($string))
                {
                    switch ($string)
                    {
                        case '<p>The filetype you are attempting to upload is not allowed.</p>':
                            $string = 'The filetype you are attempting to upload is not allowed.';
                            break;
                        case '<p>The uploaded file exceeds the maximum allowed size in your PHP configuration file.</p>':
                            $string = 'The uploaded file exceeds the maximum allowed size.';
                            break;
                        default;
                            break;
                    }
                    
                }
                return $string;
            }
        }

        if (!function_exists('message_display_date'))
        {
            function message_display_date($string,$type='')
            {
                $theDiff="";
                $datetime1 = date_create($string);
                $datetime2 = date_create(date("Y-m-d H:i:s"));
                $interval = date_diff($datetime1, $datetime2);
                $min=$interval->format('%i');
                $sec=$interval->format('%s');
                $hour=$interval->format('%h');
                $mon=$interval->format('%m');
                $day=$interval->format('%d');
                $year=$interval->format('%y');
                if($interval->format('%i%h%d%m%y')=="00000")
                {
                  //echo $interval->format('%i%h%d%m%y')."<br>";
                  return $sec." Seconds ago";

                }
                else if($interval->format('%h%d%m%y')=="0000"){
                      return $min." Minutes ago";
                 }
                 else if($interval->format('%d%m%y')=="000"){
                      return $hour." Hours ago";
                 }
                 else if($interval->format('%m%y')=="00"){
                 return $day." Days ago";
                 }
                 else if($interval->format('%y')=="0"){
                 return $mon." Months ago";
                 }
                 else{
                 return $year." Years ago";
                 }
                return $string;
            }
        }
        
        
        /* developers help function only for dumping data and die*/
        if (!function_exists('pr'))
        {
            function pr($arr,$dieFlag=1)
            {
                echo "<pre>";
                print_r($arr);
                if($dieFlag ==1)
                {
                    die;
                }
            }
        }
        
        if (!function_exists('fullCountryList'))
        {
            function fullCountryList($country_id='')
            {
                try
                {
                   $country_data = fetch_all_data('countries', array('id','name','sortname'), '', array('id'=>array(101,44)));
                    
                   return $country_data;
                } 
                catch (Exception $e) 
                {
                    var_dump($e->getMessage());
                }
            }
        }
        
        if (!function_exists('getCountryById'))
        {
            function getCountryById($country_id)
            {
                try
                {
                   if(!empty($country_id))
                   {
                       $country_data = fetch_single_value('countries','name',array('id'=>$country_id));
                    
                       return $country_data;
                   }
                   return FALSE;
                } 
                catch (Exception $e) 
                {
                    return FALSE;
                    //var_dump($e->getMessage());
                }
            }
        }
        
        if (!function_exists('getVenueById'))
        {
            function getVenueById($venue_id)
            {
                try
                {
                   if(!empty($venue_id))
                   {
                       $venue_data = fetch_single_value('candidate_venue_list','city',array('id'=>$venue_id));
                    
                       return $venue_data;
                   }
                   return FALSE;
                } 
                catch (Exception $e) 
                {
                    return FALSE;
                    //var_dump($e->getMessage());
                }
            }
        }

        if (!function_exists('send_custom_sendmail'))
        {
            function send_custom_sendmail($from_email,$send_email,$subject,$message,$cc_to='',$bcc_to='')
            { 
             $from_email = $from_email; 
             $to_email = $send_email; 

             $ci =& get_instance();
             //Load email library 
             $ci->load->library('email'); 
             
             $config['protocol'] = 'sendmail';
             $config['mailpath'] = '/usr/sbin/sendmail';
             $config['charset'] = 'iso-8859-1';
             $config['wordwrap'] = TRUE;
             $config['mailtype'] = 'html';

                $ci->email->initialize($config);
                //$this->email->set_mailtype("html");
             $ci->email->from($from_email, 'ICAM Admin'); 
             $ci->email->to($to_email);
             //$this->email->cc('another@another-example.com');
             if(!empty($bcc_to))
             {
                 $ci->email->bcc($bcc_to);
             }
             $ci->email->subject($subject); 
             $ci->email->message(general_email_template($message)); 
            // pr($ci->email->send());
             //Send mail 
             if($ci->email->send()) 
             {
                 return true;
             }
             return false;
            } 
        }
        
        if (!function_exists('send_customer_mail'))
        {
            function send_customer_mail($from_email,$to_email,$subject,$message,$html_message='',$cc_to='',$bcc_to='')
            {               // pr('hi');
                try {
                   // echo $from_email;
                    //echo $to_email;
                    //echo $subject;
                   // echo $message;
                    //pr($from_email);
                //error_reporting(-1);
                //ini_set('display_errors', '1');
                //echo ENVIRONMENT;die;
                if(ENVIRONMENT == 'awsdemo')
                {
                    //pr('hi');
                    $config = Array(
                    'protocol'  => 'sendmail',
                    'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
                    'smtp_port' => '465',
                    'smtp_user' => 'AKIAJWIZ3AKPBW6RNZ7Q',
                    'smtp_pass' => 'AjYuLerZxFpfQk+eGqYhf/xv5G2mKrWVkx4jbbCZk7rZ',
                    'mailtype'  => 'html',
                    'starttls'  => true,
                    'newline'   => "\r\n",
                    //'charset'=>"iso-8859-1",
                     'charset'=>"utf-8",        
                    'wordwrap'=>TRUE
                    );
                }
                else 
                {
                    $config = Array(
                
                    'protocol'  => 'sendmail',
                    'smtp_host' => 'mail.qtsin.net',
                    'smtp_port' => '25',
                    'smtp_user' => 'no_reply@qtsin.net',
                    'smtp_pass' => 'noreply@2017',
                    'mailtype'  => 'html',
                    'starttls'  => true,
                    'newline'   => "\r\n",
                    //'charset'=>"iso-8859-1",
                     'charset'=>"utf-8",        
                    'wordwrap'=>TRUE
                    );
                }
                
        if(empty($html_message))
        {
            $html_message = $message;
        }
        $ci =& get_instance();
        $ci->load->library('email', $config);

        $ci->email->from('no_reply@qtsin.net', $from_email);
        $ci->email->bcc('no_reply@qtsin.net', $from_email);
        $ci->email->to($to_email);
        $ci->email->subject($subject);
        $ci->email->message($html_message);
        
        if(ENVIRONMENT != 'development')
        {
           // pr('h');
            $ci->email->send();
        }
        email_log_entry($from_email,$to_email,$subject,$message);
        //pr($ci->email->print_debugger());
                } catch (Exception $e) {
                    //pr($e);
                }
            }
        }
            
            
        if (!function_exists('send_custom_mail_smtp'))
        {
            function send_custom_mail_smtp($from_email,$send_email,$subject,$message,$cc_to='',$bcc_to='')
            { 
                 error_reporting(-1);
		ini_set('display_errors', 1);
             $from_email = $from_email; 
             $to_email = $send_email; 

             $ci =& get_instance();
             //Load email library 
             $ci->load->library('email'); 
             
            $config = Array(
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_port' => '465',
            'smtp_user' => 'sayak.qtsin@gmail.com',
            'smtp_pass' => 'qtsqts@10',
            'mailtype'  => 'html',
            'starttls'  => true,
            'newline'   => "\r\n"
            );

            $ci->email->initialize($config);
                //$this->email->set_mailtype("html");
             $ci->email->from($from_email, 'ICAM Admin'); 
             $ci->email->to($to_email);
             //$this->email->cc('another@another-example.com');
             if(!empty($bcc_to))
             {
                 $ci->email->bcc($bcc_to);
             }
             $ci->email->subject($subject); 
             $ci->email->message(general_email_template($message)); 
             
               pr($ci->email->print_debugger());
             pr($ci->email->send());
             //Send mail 
             if($ci->email->send()) 
             {
                 return true;
             }
             return false;
            } 
        }
        
        if (!function_exists('general_email_template'))
        {
            function general_email_template($username,$message,$title,$footer='')
            {
               $final_message=' <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns="http://www.w3.org/1999/xhtml"
                 xmlns:v="urn:schemas-microsoft-com:vml"
                 xmlns:o="urn:schemas-microsoft-com:office:office">
                <head>
                        <!--[if gte mso 9]><xml>
                        <o:OfficeDocumentSettings>
                        <o:AllowPNG/>
                        <o:PixelsPerInch>96</o:PixelsPerInch>
                        </o:OfficeDocumentSettings>
                        </xml><![endif]-->
                        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
                    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
                        <meta name="format-detection" content="date=no" />
                        <meta name="format-detection" content="address=no" />
                        <meta name="format-detection" content="telephone=no" />
                        <title>Email Template</title>


                </head>
                    <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; background:#eee; -webkit-text-size-adjust:none">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eee">
                                    <tr>
                                            <td align="center" valign="top">

                                                    <table width="700" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                                                            <tr>
                                                                    <td class="td" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; width:600px; min-width:600px; Margin:0" width="600">
                                                                            <!-- Header -->
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 35px 0px;">
                                                                                    <tr>
                                                                                            <td>

                                                                                                    <div class="img-center" style="font-size:0pt; line-height:0pt; text-align:center">
                                                                                                    <a href="#" target="_blank"><img src="'.BASEURL.'assets/images/'.LOGOLINK.'" height="50" alt="ICAM_logo" ></a></div>
                                                                                            </td>
                                                                                    </tr>
                                                                            </table>
                                                                            <!-- END Header -->

                                                                            <!-- Main -->
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                            <td>
                                                                                                    <!-- Head -->
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#0088cc" style="padding: 15px 0px;">
                                                                                                            <tr>
                                                                                                                    <td>

                                                                                                                            <div class="h3-2-center" style="color:#1e1e1e; font-family:Arial, sans-serif; min-width:auto !important; font-size:20px; line-height:26px; text-align:center; letter-spacing:1px">'.$title.' </div>

                                                                                                                            <div class="h2" style="color:#ffffff; font-family:Georgia, serif; min-width:auto !important; font-size:40px; line-height:54px; text-align:center">
                                                                                                                                    <em>'.$username.'</em>
                                                                                                                            </div>

                                                                                                                    </td>
                                                                                                            </tr>
                                                                                                    </table>
                                                                                                    <!-- END Head -->										

                                                                                                    <!-- Body -->
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding: 15px 15px;">
                                                                                                            <tr>
                                                                                                                    <td align="left" style="color:#1e1e1e; font-family:Arial, sans-serif; min-width:auto !important; font-size:14px; line-height:24px;">

                                                                                                                            <p>
                                                                                                                            '.$message.'
                                                                                                                            
                                                                                                                                </p>


                                                                                                                            <p>
                                                                                                                                    
                                                                                                                            </p>															

                                                                                                                    </td>
                                                                                                            </tr>
                                                                                                    </table>
                                                                                                    <!-- END Body -->

                                                                                                    <!-- Foot -->
                                                                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#0088cc" style="padding:20px 0px;">
                                                                                                            <tr>
                                                                                                                    <td>																

                                                                                                                            <div class="h3-1-center" style="color:#1e1e1e; font-family:Georgia, serif; min-width:auto !important; font-size:20px; line-height:26px; text-align:center">
                                                                                                                                    <em>Follow Us</em>
                                                                                                                            </div>

                                                                                                                            <!-- Socials -->
                                                                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                                                                    <tr>
                                                                                                                                            <td align="center">
                                                                                                                                                    <table border="0" cellspacing="0" cellpadding="0">
                                                                                                                                                            <tr>
                                                                                                                                                                    <td class="img-center" style="font-size:0pt; line-height:0pt; text-align:center" width="38"><a href="http://www.facebook.com/" target="_blank"><img src="'.BASEURL.'assets/images/facebook.png" border="0" width="28" height="28" alt="" /></a></td>
                                                                                                                                                                    <td class="img-center" style="font-size:0pt; line-height:0pt; text-align:center" width="38"><a href="http://www.twitter.com/" target="_blank"><img src="'.BASEURL.'assets/images/twitter.png" border="0" width="28" height="28" alt="" /></a></td>
                                                                                                                                                                    <td class="img-center" style="font-size:0pt; line-height:0pt; text-align:center" width="38"><a href="https://www.linkedin.com/" target="_blank"><img src="'.BASEURL.'assets/images/linkedin.png" border="0" width="28" height="28" alt="" /></a></td>

                                                                                                                                                            </tr>
                                                                                                                                                    </table>
                                                                                                                                            </td>
                                                                                                                                    </tr>
                                                                                                                            </table>
                                                                                                                            <!-- END Socials -->


                                                                                                                    </td>
                                                                                                            </tr>
                                                                                                    </table>
                                                                                                    <!-- END Foot -->
                                                                                            </td>
                                                                                    </tr>
                                                                            </table>
                                                                            <!-- END Main -->

                                                                            <!-- Footer -->
                                                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                                                    <tr>
                                                                                            <td>

                                                                                                    <div class="text-footer" style="color:#666666; font-family:Arial, sans-serif; min-width:auto !important; font-size:12px; line-height:18px; text-align:center; margin: 15px 0;">
                                                                                                            '.$footer.'
                                                                                                    </div>

                                                                                            </td>
                                                                                    </tr>
                                                                            </table>
                                                                            <!-- END Footer -->
                                                                    </td>
                                                            </tr>
                                                    </table>

                                            </td>
                                    </tr>
                            </table>
                    </body>
                    </html>
                    ';
               //pr($final_message);
               return $final_message;
            }
        }
        
        if (!function_exists('getCityInfo'))
        {
        function getCityInfo($countryId='')
        {
            try 
            {
                $ci =& get_instance();
                //SELECT C.name,S.name FROM cities C  join states S on S.id=C.state_id WHERE S.`country_id` IN  (101) order by c.name
                $ci->db->select(array('cities.id as cityId','cities.name as cityName','states.name as stateName','states.id as stateId'));
                $ci->db->from("cities");
                $ci->db->join("states","states.id=cities.state_id",'left');
                if(!empty($countryId))
                {
                    $ci->db->where_in('states.country_id',$countryId);
                }
                $ci->db->order_by('cities.name asc');
                $query = $ci->db->get();
               // print_r($this->db->last_query());
                if($query->num_rows() > 0)
                {

                    foreach ($query->result_array() as $row)
                    {    
                     $resultset[]=$row;
                    }
                }
                
                if(!empty ($resultset))
                    return $resultset;
                else
                    return false;
            } 
            catch (Exception $e) 
            {
                var_dump($e->getMessage());
            }
        }
    }
    
   if (!function_exists('input_date_convertion'))
   {
        function input_date_convertion($input_date='')
        {
            try 
            {
                //pr($input_date);
               $input_date_rebuild = strtr($input_date, '-', '/');
               $input_date_rebuild = date('Y-m-d', strtotime($input_date_rebuild)); 
               //$input_date_rebuild = date('Y-m-d', strtotime(str_replace('-', '/', $input_date)));
               //pr($input_date_rebuild);
               return $input_date_rebuild;
            } 
            catch (Exception $e) 
            {
                return FALSE;
            }
        }
    }
    
    if (!function_exists('input_date_convertion_old'))
   {
        function input_date_convertion_old($input_date='')
        {
            try 
            {
                //pr($input_date);
               //$input_date_rebuild = strtr($input_date, '/', '-');
               $input_date_rebuild = date('Y-m-d', strtotime($input_date)); 

               return $input_date_rebuild;
            } 
            catch (Exception $e) 
            {
                return FALSE;
            }
        }
    }
    
   if (!function_exists('user_display_status'))
   {
        function user_display_status($candidate_details)
        {
            if(isset($candidate_details['selected_flag']))
            {
                switch ($candidate_details['selected_flag']) 
                {
                    case '0':
                    //Scrutiny Check start
                    switch ($candidate_details['scrutiny_flag']) 
                    {
                        case '0':
                            $display_data['message'] = 'Your application scrutiny is in progress';
                            $display_data['cls_details'] ='alert-info';
                        break;
                        case '1':
                            //interview schedule Check start
                            switch ($candidate_details['interview_schedule_flag']) 
                            {
                                case '0':
                                    $display_data['message'] = 'Your application scrutiny has done.Interview schedule is in progress.';
                                    $display_data['cls_details'] ='alert-info'; 
                                    break;
                                case '1':
                                    $display_data['interview_flag'] = 1;
                                    $display_data['interview_details'] = fetch_single_row('candidate_venue_map', '',array('candidate_id'=>$candidate_details['candidate_id']));
                                    $display_data['interview_times_slot'] = fetch_all_data('interview_time_slot', array('id','slot'));
                                    if(!empty($display_data['interview_times_slot']))
                                    {
                                        foreach ($display_data['interview_times_slot'] as $single_slot) {
                                            $interview_slot_rebuild[$single_slot['id']] = $single_slot['slot'];
                                        }
                                        $display_data['interview_times_slot_details'] = $interview_slot_rebuild;
                                    }
                                    $display_data['message'] = 'Your Application has been approved for interview.';
                                    $display_data['cls_details'] ='alert-success';                            
                                    break;

                                break;
                                    default:
                                            $display_data['message'] = 'Your Application has Rejected.';
                                            $display_data['cls_details'] ='alert-danger'; 
                                            break;
                                }
                                //interview schedule Check end
                            break;
                            default:
                            $display_data['message'] = 'Your Application has Rejected.';
                            $display_data['cls_details'] ='alert-danger'; 
                            break;
                        } 
                        break;
                        case '1':
                             $display_data['course_capacity'] = $candidate_details['total_seat'];
                             $display_data['booking_count'] = 0;checkCourseBookingData($candidate_details['course_id'],1);
                             $display_data['admission_count'] = checkCourseBookingData($candidate_details['course_id']);
                            // TODO Bring up system inteligency later 
                            //$display_data['admission_avaliable_count'] = ($display_data['course_capacity'] - $display_data['booking_count'] + $display_data['admission_count']);
                            $display_data['admission_avaliable_count'] =1;
                            $display_data['message'] = 'You have been selected for the course. Please complete the payment for admission .';
                            $display_data['cls_details'] ='alert-success';   
                            $display_data['admission_flag'] = 1;
                            $display_data['admission_details'] = fetch_all_data('courses_fee_structure', '',array('course_id'=>$candidate_details['course_id']));
                            $display_data['admission_payment_details'] = fetch_all_data('candidate_payment', array('term_id','invoice_id'),array('application_id'=>$candidate_details['application_id']
                                        ,'term_id > '=>0));
                            
                            //$display_data['admission_details'] =   userPaymentDetails($candidate_details) ;   
                            break;
                        default:
                            $display_data['message'] = 'Your Application has Rejected.';
                            $display_data['cls_details'] ='alert-danger'; 
                            break;
                    //Selected Check end 
                    }
                }
                else
                {
                    $display_data['message'] = 'Your Application has Rejected.';
                    $display_data['cls_details'] ='alert-danger'; 
                }
                    return $display_data;        
        }
    }
    if (!function_exists('userPaymentDetails'))
    {
        function userPaymentDetails($candidateDetails)
        {
            try 
            {
                //pr($candidateDetails);
                $ci =& get_instance();
                //SELECT C.name,S.name FROM cities C  join states S on S.id=C.state_id WHERE S.`country_id` IN  (101) order by c.name
                $ci->db->select(array('courses_fee_structure.course_id','courses_fee_structure.program_id','courses_fee_structure.term_id',
                    'courses_fee_structure.fee_type','courses_fee_structure.general_fee','courses_fee_structure.st_fee',
                    'courses_fee_structure.sc_fee','courses_fee_structure.term_name','courses_fee_structure.obc_fee'));
                $ci->db->from("courses_fee_structure");
                $ci->db->join("candidate_payment","courses_fee_structure.term_id = candidate_payment.term_id");
                $ci->db->where("courses_fee_structure.course_id",$candidateDetails['course_id']);
                $ci->db->where("candidate_payment.application_id",$candidateDetails['application_id']);
                $ci->db->where("candidate_payment.term_id > ",0);
                
                $ci->db->order_by('courses_fee_structure.term_id asc');
                $query = $ci->db->get();
                pr($ci->db->last_query());
                if($query->num_rows() > 0)
                {

                    foreach ($query->result_array() as $row)
                    {    
                     $resultset[]=$row;
                    }
                }
                
                if(!empty ($resultset))
                    return $resultset;
                else
                    return false;
            } 
            catch (Exception $e) 
            {
                var_dump($e->getMessage());
            }
        }
    }
   if (!function_exists('convert_date_ist_to_gmt'))
   {
        function convert_date_ist_to_gmt($select_date)
        {
            if(!empty($select_date))
            {
                $date = new DateTime($select_date, new DateTimeZone('IST'));
                $date->setTimezone(new DateTimeZone('GMT'));

                return $date->format('d-m-Y');
            }
            return FALSE;
            
            
        }
   }
   
    if (!function_exists('email_log_entry'))
    {
        function email_log_entry($send_from,$send_to,$subject,$message)
        {
                
                $ci =& get_instance();
                $param['send_from'] = $send_from;
                $param['send_to'] = $send_to;
                $param['subject'] = $subject;
                $param['message'] = $message;
                $param['created_date'] = date ('c');

                $ci->db->insert('email_log', $param);
                $email_log_id = $ci->db->insert_id();

                if($email_log_id)
                {
                    return $email_log_id;
                }
                return FALSE;      

         }
    }
    
    if (!function_exists('birthday_email_template'))
    {
    function birthday_email_template($name,$message)
    {
    $final_message='
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml"
       xmlns:v="urn:schemas-microsoft-com:vml"
       xmlns:o="urn:schemas-microsoft-com:office:office">
       <head>
          <!--[if gte mso 9]>
          <xml>
             <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
             </o:OfficeDocumentSettings>
          </xml>
          <![endif]-->
          <meta http-equiv="Content-type" content="text/html; />
             <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
          <meta http-equiv="X-UA-Compatible" content="IE=edge" />
          <meta name="format-detection" content="date=no" />
          <meta name="format-detection" content="address=no" />
          <meta name="format-detection" content="telephone=no" />
          <title>Email Template</title>
       </head>
       <body class="body" style="padding:0 !important; margin:0 !important; display:block !important; background:#eee; -webkit-text-size-adjust:none">
          <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#eee">
             <tr>
                <td align="center" valign="top">
                   <table width="700" border="0" cellspacing="0" cellpadding="0" class="mobile-shell">
                      <tr>
                         <td class="td" style="font-size:0pt; line-height:0pt; padding:0; margin:0; font-weight:normal; width:600px; min-width:600px; Margin:0" width="600">
                            <!-- Header -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="padding: 35px 0px;">
                               <tr>
                                  <td>
                                     <div class="img-center" style="font-size:0pt; line-height:0pt; text-align:center"><a href="#" target="_blank"><img src="'.BASEURL.'assets/images/logo.png" border="0" alt="" height="60" /></a></div>
                                  </td>
                               </tr>
                            </table>
                            <!-- END Header -->
                            <!-- Main -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                               <tr>
                                  <td>
                                     <!-- Head -->
                                     <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#0088cc" style="padding: 15px 0px;">
                                        <tr>
                                           <td>
                                              <div class="h3-2-center" style="color:#fff; font-family:Arial, sans-serif; min-width:auto !important; font-size:24px; line-height:28px; text-align:center; letter-spacing:1px">Happy Birthday to  </div>
                                              <div class="h2" style="color:#ffffff; font-family:Georgia, serif; min-width:auto !important; font-size:40px; line-height:54px; text-align:center">
                                                 <em>'.$name.'</em>
                                              </div>
                                           </td>
                                        </tr>
                                     </table>
                                     <!-- END Head -->                                       
                                     <!-- Body -->
                                     <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#ffffff" style="padding: 15px 15px;">
                                        <tr>
                                           <td align="left" style="color:#1e1e1e; font-family:Arial, sans-serif; min-width:auto !important; font-size:14px; line-height:24px;">
                                              <p align="center">
                                                 <img src="'.BASEURL.'assets/images/bday/birthday.jpg" style="width: 80%">
                                              </p>
                                              <p><b>'.$message.'</b></p>
                                              <p><b>Thank You.</b> 
                                                 <br>
                                                 Demo University
                                              </p>
                                           </td>
                                        </tr>
                                     </table>
                                     <!-- END Body -->
                                     <!-- Foot -->
                                     <table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#0088cc" style="padding:20px 0px;">
                                        <tr>
                                           <td>
                                              <div class="h3-1-center" style="color:#1e1e1e; font-family:Georgia, serif; min-width:auto !important; font-size:20px; line-height:26px; text-align:center">
                                                 <em>Follow Us</em>
                                              </div>
                                              <!-- Socials -->
                                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                 <tr>
                                                    <td align="center">
                                                       <table border="0" cellspacing="0" cellpadding="0">
                                                          <tr>
                                                             <td class="img-center" style="font-size:0pt; line-height:0pt; text-align:center" width="38"><a href="http://www.facebook.com/nismindia" target="_blank"><img src="'.BASEURL.'assets/images/facebook.png" border="0" width="28" height="28" alt="" /></a></td>
                                                             <td class="img-center" style="font-size:0pt; line-height:0pt; text-align:center" width="38"><a href="http://www.twitter.com/NISMindia" target="_blank"><img src="'.BASEURL.'assets/images/twitter.png" border="0" width="28" height="28" alt="" /></a></td>
                                                             <td class="img-center" style="font-size:0pt; line-height:0pt; text-align:center" width="38"><a href="https://www.linkedin.com/profile/edit?locale=en_US&trk=profile-preview" target="_blank"><img src="'.BASEURL.'assets/images/linkedin.png" border="0" width="28" height="28" alt="" /></a></td>
                                                          </tr>
                                                       </table>
                                                    </td>
                                                 </tr>
                                              </table>
                                              <!-- END Socials -->
                                           </td>
                                        </tr>
                                     </table>
                                     <!-- END Foot -->
                                  </td>
                               </tr>
                            </table>
                            <!-- END Main -->
                            <!-- Footer -->
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                               <tr>
                                  <td>
                                     <div class="text-footer" style="color:#666666; font-family:Arial, sans-serif; min-width:auto !important; font-size:12px; line-height:18px; text-align:center; margin: 15px 0;">
                                        Demo University, Plot No. 82, Sector - 17, Vashi, Navi Mumbai, Maharashtra, 400703, India
                                        <br />
                                        <a href="http://www.nism.ac.in" target="_blank" class="link-1" style="color:#666666; text-decoration:none"><span class="link-1" style="color:#666666; text-decoration:none">www.nism.ac.in</span></a>
                                        <span class="mobile-block"><span class="hide-for-mobile">|</span></span>
                                        Phone: <a href="tel:+1655606605" target="_blank" class="link-1" style="color:#666666; text-decoration:none"><span class="link-1" style="color:#666666; text-decoration:none">022 66735100 - 05</span></a>
                                     </div>
                                  </td>
                               </tr>
                            </table>
                            <!-- END Footer -->
                         </td>
                      </tr>
                   </table>
                </td>
             </tr>
          </table>
       </body>
    </html>
    ';
    //pr($final_message);
    return $final_message;
    }
}
   
 }
 
   if (!function_exists('get_email_template_details'))
   {
      function get_email_template_details($template_type)
      {
         $ci =& get_instance();
           $select_arr = array('email_trigger_events.event_name ','email_templates.body ','email_templates.email_header','email_templates.subject','email_templates.email_footer',);
         $ci->db->select($select_arr);
         $ci->db->from('email_template_event_map');
         $ci->db->join('email_trigger_events', 'email_template_event_map.event_id = email_trigger_events.id'); 
         $ci->db->join('email_templates', 'email_template_event_map.email_template_id   = email_templates.id');
          $ci->db->where('email_trigger_events.event_name', $template_type);

         $query = $ci->db->get();
         $result_arr = $query->result_array();
             //pr($result_arr);
         if(!empty($result_arr[0]))
         {
                    return $result_arr[0];
          }
         return FALSE;
        
      }
   }
   
   if (!function_exists('checkCourseBookingData'))
   {
        function checkCourseBookingData($course_id,$onlyBooking='')
        {
               $ci =& get_instance();
               $select_arr = array('count(candidate_details.id) as booking_count');
               $ci->db->select($select_arr);
               $ci->db->from('candidate_details');
               $ci->db->join('courses', 'candidate_details.course_id = courses.id');
               
               if(!empty($onlyBooking))
               {
                   $ci->db->where('candidate_details.admission_first_fee_flag', 1);
                   $ci->db->where('candidate_details.admission_payment_flag', 0);
               }
               else
               {
                   $ci->db->where('candidate_details.admission_first_fee_flag', 1);
                   $ci->db->where('candidate_details.admission_payment_flag', 1);
               }
               
               $ci->db->where('candidate_details.course_id', $course_id);
               
               $query = $ci->db->get();
              
               $result_arr = $query->result_array();
               //pr($result_arr[0]['booking_count']);
               if(!empty($result_arr[0]['booking_count']))
               {
                   return $result_arr[0]['booking_count'];
               }
               return FALSE;
            }
   }
   
   //Course List display on menu navigation
   if (!function_exists('getCourseList'))
   {
        function getCourseList()
        {
            $ci =& get_instance();
            $select_arr = array('id','drive_name','program_name','course_link','status');
            $ci->db->select($select_arr);
            $ci->db->from('courses');
            $ci->db->order_by('created_date desc');

            //$ci->db->where('courses.course_id');
               
            $query = $ci->db->get();
              
            $course_list = $query->result_array();
             
            //$course_list = fetch_all_data('courses', array('id','drive_name','program_name','course_link','status'),'','created_date desc') ;
            
            if(!empty($course_list))
            {
                return $course_list;
            }
            else
            {
                return FALSE;
            }
        }
   }
   
   //Course List display on menu navigation
   if (!function_exists('getCourseListForTeacher'))
   {
        function getCourseListForTeacher($teacher_id)
        {
            $ci =& get_instance();
            $select_arr = array('courses.id','courses.drive_name','courses.program_name',
                'courses.course_link','courses.status','courses.form_submission_last_date');
            $ci->db->select($select_arr);
            $ci->db->from('courses');
            $ci->db->join('teacher_candidate_map','courses.id = teacher_candidate_map.course_id','left');
            $ci->db->where('teacher_candidate_map.teacher_id',$teacher_id);
            $ci->db->order_by('courses.created_date desc');

            $ci->db->group_by('teacher_candidate_map.course_id');
               
            $query = $ci->db->get();
              //echo $ci->db->last_query();              die();
            $course_list = $query->result_array();
             //pr($course_list);
            //$course_list = fetch_all_data('courses', array('id','drive_name','program_name','course_link','status'),'','created_date desc') ;
            
            if(!empty($course_list))
            {
                return $course_list;
            }
            else
            {
                return FALSE;
            }
        }
   }
   
   //Course List display on menu navigation
   if (!function_exists('displayCheck'))
   {
        function displayCheck($value,$optionalParam='')
        {
            if(!empty($value))
            {
                if($optionalParam == 'date')
                {
                    $value = date('d/m/Y', strtotime($value));
                }
                else if($optionalParam == 'datetime')
                {
                    $value = date('d/m/Y h:i:s A', strtotime($value));
                }
                return $value;
            }
            else 
            {
                return 'N/A';
            }
        }
   }
   
   if (!function_exists('genarateImageFromByteArr')) {

    function genarateImageFromByteArr($fieldName, $optionalParam = '') {
        $imageCreation = '';
        if (!empty($fieldName)) {
            $imgData = json_decode($fieldName, TRUE);
            if (!empty($imgData['imageBytes'])) {
                $imageCreation = "data:png/jpeg/jpg/gif;base64, " . $imgData['imageBytes'];
            }
        }
        return $imageCreation;
    }

}

if (!function_exists('getAccademicSessionId')) {

    function getAccademicSessionId($slug, $optionalParam = '') {
        $ayId = fetch_single_value('student_session','id',array('slug'=>$slug));
        if(!empty($ayId))
        {
            return $ayId;
        }
        return FALSE;
    }

}

?>
