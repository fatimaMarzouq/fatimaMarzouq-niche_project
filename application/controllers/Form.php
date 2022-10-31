<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Form extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('session'); 

    }
    function get_pagination_config() {
        $config = array();
        $config['full_tag_open'] = '   <div class="pagination float-right my-5"><nav aria-label="Page navigation example"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav></div>';
        $config['first_tag_open'] = ' <li class="page-item"> <span class="page-link"  ><span aria-hidden="true">';
        $config['first_tag_close'] = '</span></span></li>';
        $config['first_link'] = '<img src="' . base_url() . 'assets/svgs/page-arrow-first.svg" alt="" class="mt-n1">';

        $config['num_tag_open'] = '<li class="page-item"><span class="page-link" href="">';
        $config['num_tag_close'] = '</span></li>';

        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '<span class="sr-only">(current)</span></span></li>';


        $config['next_tag_open'] = '<li class="page-item"><span class="page-link" ><span aria-hidden="true">';
        $config['next_tag_close'] = '</span></span></li>';
        $config['next_link'] = '<img src="' . base_url() . 'images/page-arrow-next.svg" alt="" class="mt-n1">';

        $config['prev_tag_open'] = '<li class="page-item"><span class="page-link" ><span aria-hidden="true">';
        $config['prev_tag_close'] = '</span></span></li>';
        $config['prev_link'] = '<img src="' . base_url() . 'images/page-arrow-prev.svg" alt="" class="mt-n1">';

        $config['last_tag_open'] = ' <li class="page-item"> <span class="page-link"  ><span aria-hidden="true">';
        $config['last_tag_close'] = '</span></a></li>';
        $config['last_link'] = '<img src="' . base_url() . 'images/page-arrow-last.svg" alt="" class="mt-n1">';
        return $config;
    }
   public function form_logout(){
        session_destroy();
        $this->session->set_flashdata('msg','Logout Successfully');
        redirect('form/form_login');
    }
    public function form_login(){
        $this->load->view('form/form_login');  
    }
    public function form_login_check(){
        $table='tbl_admin';
        $usermail=$this->input->post('email');
        $passwords=$this->input->post('password');
        $password=md5($passwords);
        $result=$this->Common_model->login_check($usermail,$password,$table);
        
        if($result > 0)
        {
           
           $this->session->set_flashdata('msg','Login Successfully');   
           redirect(base_url('form/newspapper_index'));
            
        }
        else
        {
             if($result == '-1')
                 $this->session->set_flashdata('error_msg',"You don't have permission to login"); 
                 else
                 $this->session->set_flashdata('error_msg','Invalid Email ID or Password'); 
            
            
            redirect(base_url('form/form_login'));
        }
    }
    public function newspapper_index(){
        $user_id=$this->session->userdata('id');
        if($user_id){
            $msgs = $this->Common_model->get_run("SELECT * FROM tbl_msg where DATE(`created_date`) = CURDATE()  ORDER BY created_date DESC");
            // print_r($msgs);
            $current_user_msgs=[];
            if(!empty($msgs)){
                foreach($msgs as $msg){
                    if(in_array($user_id, explode(',', $msg["sending_msg_user"]))){
                        array_push($current_user_msgs,$msg);
                    }
                }
            }
            // print_r($current_user_msgs);
            $data['main']='form/newspapper';
            $data['user_msgs']=$current_user_msgs;
            $this->load->view('form/template',$data);
        }
    }
    public function sellout_list($page = 0) {
        
        $export = isset($_POST['export']) ? $_POST['export']:"0";
        $record_count = isset($_POST['record_count'])? $_POST['record_count'] : "0";
        $export_header = isset($_POST['export_header']) ? $_POST['export_header'] : "";
        
        
        
        $limit = 10;
        
        $start = (!empty($page) ? $page : 1);
        if ($start != 0) {
                $page = $start;
        } else {
                $page = 1;
        }
        $start = ($page - 1) * $limit;
        $filter_data['page'] = $page;
        $filter_data['limit'] = $limit;
        
        $by = isset($_GET['by']) ? $_GET['by'] : "DESC";
        $data['sort_item'] = $sort1 = isset($_GET['sort']) ? $_GET['sort'] : "id";
        $data['sort_type'] = ($by == "DESC") ? "ASC" : "DESC";
       // $data['duration'] = $duration = isset($_GET['duration']) ? $_GET['duration'] : "";
         $search_term = isset($_GET['search_term']) ? $_GET['search_term'] : "";
         $from_date = isset($_GET['from_date']) ? $_GET['from_date'] : "";
         $to_date = isset($_GET['to_date']) ? $_GET['to_date'] : "";

        //$workshop_id =isset($_GET['workshop_id']) ? $_GET['workshop_id'] : "";



        if (($sort1 != '')) {
            $sort = array(
                "field_name" => $sort1,
                "field_value" => $by
            );
        }

        if (($from_date != '')) {
            $filter[] = array(
                "field_name" => "from_date",
                "field_value" => $from_date
            );
        }
         if (($to_date != '')) {
            $filter[] = array(
                "field_name" => "to_date",
                "field_value" => $to_date
            );
        }
        $create_date_range_filter = array();
        
        if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5)
            $con = "1=1 ";
        else
          $con = "1=1 and `user_id` in (".$this->all_user_data.") ";
          
         if(!empty($search_term)){
                    //$serach_parameter = explode(" ",$search_term);
                    $serach_parameter = $search_term;
                    //echo  $serach_parameter;
                    //exit;
                    if(!empty($serach_parameter))
                    {
                        $con .= " and ";
                        //foreach($serach_parameter as $k => $serach_param){
                          
                            $con .= "( region like '%".$serach_parameter."%' or outlet_name like '%".$serach_parameter."%') ";
                           
                       //}
                        //exit;
                       
                    }
                }
       if(!empty($filter)){
            foreach($filter as $k => $filt){
                //echo $filt['field_value'];
                
                if(isset($filt['field_name']) && ($filt['field_name'] == 'from_date' || $filt['field_name'] == 'to_date')){
                    $create_date_range_filter[$filt['field_name']] = $filt['field_value'];
                   
                }else{
                
                    $con .= " and ".$filt['field_name']." = '".$filt['field_value']."'";
                }
                
            }
            if(!empty($create_date_range_filter)){
                $con .= " and (DATE(created_date) >= '".$create_date_range_filter['from_date']."' AND DATE(created_date) <= '".$create_date_range_filter['to_date']."') ";
            }
        }
        
        $select = "*";
        
        if(!empty($sort)){
            if($sort['field_name'] == 'created_date'){
                $orderBy = " ".$sort['field_name'].' '. $sort['field_value'];
            }
            else{
                $orderBy = $sort['field_name'].' '. $sort['field_value'];
            }
        }else{
            $orderBy = "id  " . $by;

        }
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `sellout`");
        if(!empty($max_count))
        $data['max_count'] = $max_count['max_count'];
        else
        $data['max_count'] = 0;
        
        if($export == 1){
             $export_response = [];
           $limit = $record_count;
           
            $from_date = isset($_POST['from_date']) ? $_POST['from_date'] : "";
            $to_date = isset($_POST['to_date']) ? $_POST['to_date'] : "";
            $search_term = isset($_POST['search_term']) ? $_POST['search_term'] : "";
    
            $by = isset($_POST['by']) ? $_POST['by'] : "DESC";
            $data['sort_item'] = $sort1 = isset($_POST['sort']) ? $_POST['sort'] : "";
            $data['sort_type'] = ($by == "DESC") ? "ASC" : "DESC";
            
            
             if (($sort1 != '')) {
                $sort = array(
                        "field_name" => $sort1,
                        "field_value" => $by
                    );
              }
        
               if (($from_date != '')) {
                    $filter[] = array(
                        "field_name" => "from_date",
                        "field_value" => $from_date
                    );
                }
                 if (($to_date != '')) {
                    $filter[] = array(
                        "field_name" => "to_date",
                        "field_value" => $to_date
                    );
                }
            
            $create_date_range_filter = array();
            if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5)
            $con = "1=1 ";
        else
          $con = "1=1 and `user_id` in (".$this->all_user_data.") ";
              if(!empty($search_term)){
                    //$serach_parameter = explode(" ",$search_term);
                    $serach_parameter = $search_term;
                    //echo  $serach_parameter;
                    //exit;
                    if(!empty($serach_parameter))
                    {
                        $con .= " and ";
                        //foreach($serach_parameter as $k => $serach_param){
                          
                            $con .= "( region like '%".$serach_parameter."%' or outlet_name like '%".$serach_parameter."%') ";
                           
                       //}
                        //exit;
                       
                    }
                }
           if(!empty($filter)){
                foreach($filter as $k => $filt){
                    //echo $filt['field_value'];
                    
                    if(isset($filt['field_name']) && ($filt['field_name'] == 'from_date' || $filt['field_name'] == 'to_date')){
                        $create_date_range_filter[$filt['field_name']] = $filt['field_value'];
                       
                    }else{
                    
                        $con .= " and ".$filt['field_name']." = '".$filt['field_value']."'";
                    }
                    
                }
                if(!empty($create_date_range_filter)){
                    $con .= " and (DATE(created_date) >= '".$create_date_range_filter['from_date']."' AND DATE(created_date) <= '".$create_date_range_filter['to_date']."') ";
                }
            }
        
             if(!empty($sort)){
                if($sort['field_name'] == 'created_date'){
                    $orderBy = " ".$sort['field_name'].' '. $sort['field_value'];
                }
                else{
                    $orderBy = $sort['field_name'].' '. $sort['field_value'];
                }
            }else{
                $orderBy = "id  " . $by;
        
            }
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,name as Name,number as Contact Number,email as Email,customer_feed as Customer Feedback,target as User Target,user_sale as User Sales,analysis_per as  Sales Analysis %,username as Username,add_more_array_count,add_more_array";
            $table = 'sellout';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            // echo '<pre>';print_r($invoice_data_val);
            
           
            // exit;
            $myNewOrder = [];
            //$myNewOrder1 = ['Outlet Name','Region','Date','Name','Contact Number','Email','Customer Feedback','User Target','User Sales','Sales Analysis %','Username'];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'image_array'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                                //for ($x = 0; $x <$data['max_count']; $x++) {
                                  //  $y = $x + 1;
                                    // $myNewOrder[] = 'Category'.$y;
                                    // $myNewOrder[] = 'Brand'.$y;
                                    // $myNewOrder[] = 'Model Number'.$y;
                                    // $myNewOrder[] = 'Quantity'.$y;
                                    // $myNewOrder[] = 'Selling'.$y;
                                    // $myNewOrder[] = 'Offer Price'.$y;
                                    if($data['max_count'] > 0){
                                     $myNewOrder[] = 'Category';
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Model Number';
                                    $myNewOrder[] = 'Quantity';
                                    $myNewOrder[] = 'Selling';
                                    $myNewOrder[] = 'Offer Price';
                                    }
                                 
                                //} 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<sizeof($invoice_data_val);$i++){
                
                //echo $i;
                $total_count = 0;
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                       //  $total_count =2;
                       // echo  $total_count;
                        //echo '</br>';
                         $max_data_count = 0;
                        //  if($total_count > 2){
                        //      $total_count = 2;
                        //  }
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      // $max_data_count = 5;
                     // $index_array = ['1','2','3','4','5'];
                        
                        for ($j = 0; $j < $total_count; $j++) {
                            $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                            
                              $result['Category'] =  $result1['category'];
                             
                            
                             $result['Brand'] = $result1['brand'];
                            
                            
                             $result['Model Number'] = $result1['model'];
                              
                             
                            $result['Quantity'] =  $result1['quantity'];
                            
                             
                             $result['Selling'] = $result1['selling_price'];
                            
                             
                             $result['Offer Price'] = $result1['offer'];
                             
                               // echo 'new loop======='.$i+$j.'</br>';
                                
                            $export_response[] = $result;
                            
                        }
                      
                        //$result[$key] = $invoice_data_val[$i][$key];
                        //unset($myNewOrder[$key]);
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
               // echo $total_count.'</br>';
                if($total_count == 0){
                    $export_response[] = $result;
                }
            }
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
         
        //         exit;
            $sheetname = 'Sellout';
           // $header = explode('$$$$', $export_header);
    //  echo '<pre>';print_r($export_response);
    //  exit;
            // unset($header[sizeof($header)]);
            // unset($header[3]);
            // echo '<pre>';print_r($myNewOrder);
            // echo '<pre>';print_r($myNewOrder1);
            // exit;
            
           $header = $myNewOrder;
         //  echo '<pre>';print_r($header);
         // echo '<pre>';print_r($header);
        //  echo '<pre>';print_r($export_response);
             //  exit;
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'sellout';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
          
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/sellout_list';
      
        if(isset($_GET)){
              
                $config['reuse_query_string'] = TRUE;
                
               
        }else{

                $config['suffix'] = (!empty($_GET) ? "?" : ""). http_build_query($_GET, '', "&");
            
                
        }
        $config['total_rows'] = $allcount;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = TRUE;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $invoice_data_val;
        $data['row'] = $page;
        
        $data['record_count'] = $allcount;

       // echo '<pre>';print_r($data['result']);
        //exit;
        
       
        

        $data['main']='form/sellout_list';
        $this->load->view('form/template',$data); 	
    }
    function sellout_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "sellout";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='form/sellout_detail';
        $this->load->view('form/template',$data); 	
    }
}