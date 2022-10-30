<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
class Welcome extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('session'); 

    }
   
    public function logout(){
        session_destroy();
        $this->session->set_flashdata('msg','Logout Successfully');
        redirect('welcome/login');
    }

    public function login(){
        $this->load->view('common/login');  
    }
    public function registration(){
        $this->load->view('common/registration');  
    }
    public function login_check(){
        $table='tbl_admin';
        $usermail=$this->input->post('email');
        $passwords=$this->input->post('password');
        $password=md5($passwords);
        $result=$this->Common_model->login_check($usermail,$password,$table);
        
        if($result > 0)
        {
           
           $this->session->set_flashdata('msg','Login Successfully');   
           redirect(base_url('welcome/index'));
            
        }
        else
        {
             if($result == '-1')
                 $this->session->set_flashdata('error_msg',"You don't have permission to login"); 
                 else
                 $this->session->set_flashdata('error_msg','Invalid Email ID or Password'); 
            
            
            redirect(base_url('welcome/login'));
        }
    }

    
    public function index()
    {
        
        //echo '<pre>'; print_r($data['result']);
        if($this->session->userdata('id')){
             $customer_form = $this->Common_model->get_run("SELECT * FROM tbl_admin where `manager_id` ='".$this->session->userdata('id')."'  ORDER BY id DESC");
             
            $all_user = [];
            $this->all_user_data = 0;
            if(!empty($customer_form)){
                foreach($customer_form as $customer_f){
                    $all_user[] = $customer_f['id'];
                }
               $this->all_user_data =  implode(',',$all_user);
            }
            
            if($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5)
                $con = "1=1 ";
             else
                $con = "`user_id` in (".$this->all_user_data.") ";
                
               
               // echo                 $con;
               // exit;
            $sellout = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `sellout` where  ".$con."");
            $data['sellout'] = $sellout['total_count'];

            
            $display_by_model_count = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `display_by_model_count` where  ".$con."");
            $data['display_by_model_count'] = $display_by_model_count['total_count'];
            
            $display_share = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `display_share` where  ".$con."");
            $data['display_share'] = $display_share['total_count'];
            
            $special_fixture_count_list = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `special_fixture_count` where  ".$con."");
            $data['special_fixture_count_list'] = $special_fixture_count_list['total_count'];
            
            $brand_promoter_count_list = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `brand_promoter_count` where  ".$con."");
            $data['brand_promoter_count_list'] = $brand_promoter_count_list['total_count'];
            
            $price_tracker = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `price_tracker` where  ".$con."");
            $data['price_tracker'] = $price_tracker['total_count'];
            
            $market_sensing = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `market_sensing` where  ".$con."");
            $data['market_sensing'] = $market_sensing['total_count'];
            
            $store_image = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `300_store_image` where  ".$con."");
            $data['store_image'] = $store_image['total_count'];
            
            $display_and_deployment_tracker = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `display_and_deployment_tracker` where  ".$con."");
            $data['display_and_deployment_tracker'] = $display_and_deployment_tracker['total_count'];
            
            $voc = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `voc` where  ".$con."");
            $data['voc'] = $voc['total_count'];
            
            $market_issues = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `market_issues` where  ".$con."");
            $data['market_issues'] = $market_issues['total_count'];
            
            $training_tracker = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `training_tracker` where  ".$con."");
            $data['training_tracker'] = $training_tracker['total_count'];
            
            $stock_out = $this->Common_model->get_run_one("SELECT count('id') as total_count FROM `stock_out` where  ".$con."");
            $data['stock_out'] = $stock_out['total_count'];
            
        }
        $data['main']='common/content';
        $this->load->view('common/template',$data);
    } 
    
     public function msg_list()
    {
        // $data['Customers'] = $this->Common_model->get_data('tbl_customer');
        $user_id = $this->session->userdata('id');
        $msg_list = $this->Common_model->get_run("SELECT * FROM tbl_msg  where `user_id` ='".$user_id."'  ORDER BY id DESC");
        $result = array();
        if(!empty($msg_list)){
            
            foreach($msg_list as $customer_f){
              
                $customer_form = $this->Common_model->get_run_one("SELECT 1 AS a, GROUP_CONCAT(name ORDER BY name ASC SEPARATOR ', ') AS full_name FROM tbl_admin WHERE id IN (".$customer_f['sending_msg_user'].") GROUP BY a");
           
                $customer_f['full_name'] = $customer_form['full_name'];
                $result[]= $customer_f;
            }
          
        }
      // echo '<pre>';print_r($result);
      // exit;
        $data['msg_list'] = $result;
        $data['main']='customer/msg_list';
        $this->load->view('common/template',$data);
    } 
    public function add_msg()
    {
       
       $customer_form = $this->Common_model->get_run("SELECT * FROM tbl_admin where `manager_id` ='".$this->session->userdata('id')."'  ORDER BY id DESC");
             
        $all_user = [];
        $this->all_user_data = 0;
        if(!empty($customer_form)){
            foreach($customer_form as $customer_f){
                $all_user[] = $customer_f;
            }
          
        }
        //echo '<pre>';print_r($all_user);
        //exit;
        $data['user_list']= $all_user;
        $data['main']='customer/add_msg';
        $this->load->view('common/template',$data);
    } 
    public function save_msg(){
       
        $tbl_msg   = 'tbl_msg';
        $user_id     = $this->session->userdata('id');
        $msg      = $this->input->post('msg');
        $sending_msg_user      = $this->input->post('sending_msg_user');
        
         $save_customer      = array(
                'user_id'    => $user_id,
                'msg'         => $msg,
              //  'created_date' =>$this->current_date_time,
                'sending_msg_user' => implode(',',$sending_msg_user),
               
            );
    
    
        
            $result=$this->Common_model->save_data($save_customer,$tbl_msg);
        
        
        if(($result > 0)){
           
                $this->session->set_flashdata('msg','Msg Added Successfully');
            
             redirect(base_url('Welcome/msg_list'));
        }
        else{
            $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
            redirect(base_url('Welcome/msg_list'));
        }
    }
    public function customer()
    {
        // $data['Customers'] = $this->Common_model->get_data('tbl_customer');
        $data['Customers'] = $this->Common_model->get_run("SELECT tbl_admin.*,tbl_role.role as role_name FROM tbl_admin LEFT JOIN tbl_role ON tbl_admin.role = tbl_role.id where tbl_admin.`id` !='2'  ORDER BY id DESC");
       

        $data['main']='customer/customer';
        $this->load->view('common/template',$data);
    } 
    public function add_customer()
    {
        $data['roles'] = $this->Common_model->get_run("SELECT * FROM `tbl_role` where `status` = '1'");
        $data['users_list'] = $this->Common_model->get_run("SELECT * FROM `tbl_admin` where `role` != '2'");
        $data['outlet_list'] = $this->Common_model->get_run("SELECT * FROM `tbl_outlet_master`");
        $data['forms_name'] = array('sell_out_report','display_by_model_count','display_share','special_fixture_count','brand_promoter_count','price_tracker','market_sensing','300_store_image','display_and_deployment_tracker','voc','market_issues','training_tracker','stock_out','attendance');
        $data['main']='customer/add_customer';
        $this->load->view('common/template',$data);
    } 
    

    public function save_customer(){
        $id=$this->uri->segment(3);
        $tbl_customer   = 'tbl_admin';
        $name     = $this->input->post('name');
        $password      = $this->input->post('password');
        $email          = $this->input->post('email');
        $role           = $this->input->post('role');
        $type      = $this->input->post('type');
        $assigned_outlet        = $this->input->post('assigned_outlet');
        $assigned_form        = $this->input->post('assigned_form');
        $manager_id        = $this->input->post('manager_id');
        $target        = $this->input->post('target');
        $this->form_validation->set_rules('email', 'Username', 'required|is_unique[tbl_admin.email]');
        if(!empty($id)){
            $check_valid = true;
        }else{
            $check_valid = $this->form_validation->run();
        }
        if ($check_valid === FALSE) {
            // $this->session->set_flashdata('name',$name);
            //  $this->session->set_flashdata('email',$email);
            //   $this->session->set_flashdata('password',$password);
                $this->session->set_flashdata('error_msg',form_error('email'));
                redirect(base_url('Welcome/add_customer'));
        }else{
             $save_customer      = array(
                    'name'    => $name,
                    //'password'     => $password,
                    'email'         => $email,
                    'role'          => $role,
                    'type'     => $type,
                    'assigned_outlet'       => implode(',',$assigned_outlet),
                    'assigned_form'       => implode(',',$assigned_form),
                    'manager_id'       => $manager_id,
                    'target' => $target
                );
        
        
            if(!empty($id)){
                if(!empty($password)){
                    $save_customer['password'] = md5($password);
                }
                $result=$this->Common_model->update_data($save_customer,$tbl_customer,$id);
                
            }else{
    
               $save_customer['password'] = md5($password);
                $result=$this->Common_model->save_data($save_customer,$tbl_customer);
            }
            
            if(($result > 0) || !empty($id)){
                if(!empty($id)){
                    $this->session->set_flashdata('msg','Customer Update Successfully');
                }else{
                    $this->session->set_flashdata('msg','Customer Add Successfully');
                }
                 redirect(base_url('Welcome/customer'));
            }
            else{
                $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
                redirect(base_url('Welcome/customer'));
            }
        }
    }

    public function edit_customer(){
        $id=$this->uri->segment(3);
         $data['roles'] = $this->Common_model->get_run("SELECT * FROM `tbl_role` where `status` = '1'");
        $data['users_list'] = $this->Common_model->get_run("SELECT * FROM `tbl_admin` where `role` != '2'");
        $data['outlet_list'] = $this->Common_model->get_run("SELECT * FROM `tbl_outlet_master`");
        $data['forms_name'] = array('sell_out_report','display_by_model_count','display_share','special_fixture_count','brand_promoter_count','price_tracker','market_sensing','300_store_image','display_and_deployment_tracker','voc','market_issues','training_tracker','stock_out','attendance');
        
        $data['result'] = $this->Common_model->get_run_one("SELECT tbl_admin.*,tbl_role.role as role_name FROM tbl_admin LEFT JOIN tbl_role ON tbl_admin.role = tbl_role.id  where tbl_admin.`id`='".$id."'");

        $data['main']='customer/edit_customer';
        $this->load->view('common/template',$data);
    }

   
   
   public function roles()
    {
        // $data['Customers'] = $this->Common_model->get_data('tbl_customer');
        $data['Customers'] = $this->Common_model->get_run("SELECT * FROM tbl_role ORDER BY id DESC");
        $data['main']='roles/role';
        $this->load->view('common/template',$data);
    } 
    public function add_role()
    {
        $data['main']='roles/add_role';
        $this->load->view('common/template',$data);
    } 

    public function save_role(){

        $tbl_customer   = 'tbl_role';
        $id=$this->uri->segment(3);
        $role     = $this->input->post('role');
        $status           = $this->input->post('status');
       
        $save_role      = array(
            'role'    => $role,
            'status'          => $status
           
        );
        if(!empty($id)){
                    $result=$this->Common_model->update_data($save_role,$tbl_customer,$id);

            
        }else{
            $result=$this->Common_model->save_data($save_role,$tbl_customer);
        }
        
        if($result > 0 || !empty($id)){
            if(!empty($id)){
             $this->session->set_flashdata('msg','Customer Update Successfully');
            }else{
            $this->session->set_flashdata('msg','Role Added Successfully');
            }
             redirect(base_url('Welcome/roles'));
        }
        else{
            $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
            redirect(base_url('Welcome/roles'));
        }
    }

    public function edit_role(){
        $id=$this->uri->segment(3);
        $tbl_customer='tbl_role';
        $data['result'] = $this->Common_model->getdata_one($tbl_customer,$id);
        $data['main']='roles/edit_role';
        $this->load->view('common/template',$data);
    }
    
      public function delete_role(){
        $id=$this->uri->segment(3);
        $tbl_customer='tbl_role';
        if (!empty($id)) {
            $result=$this->Common_model->do_delete($tbl_customer,$id);
        }
        if($result>0){
         $this->session->set_flashdata('msg','Delete Successfully');
         redirect(base_url('welcome/roles'));
        }
        else{
          $this->session->set_flashdata('error_msg','Delete Failed');
          redirect(base_url('welcome/roles'));
        }
    }

    //  public function update_customer(){
    //     $id=$this->uri->segment(3);
    //     $tbl_customer   = 'tbl_customer';
        
    //      $first_name     = $this->input->post('first_name');
    //     $last_name      = $this->input->post('last_name');
    //     // $last_name      = $this->input->post('last_name');
    //     $email          = $this->input->post('email');
    //     $password          = $this->input->post('password');
    //     $status           = $this->input->post('status');
    //     // $language           = $this->input->post('language');
    //     $mobile_no      = $this->input->post('mobile_no');
    //     $address        = $this->input->post('address');

    //     if(empty($password)){
    //         $update_customer = array(
    //             'first_name'    => $first_name,
    //         'last_name'     => $last_name,
    //             'email'         => $email,
    //             'status'        => $status,
    //             'mobile_no'     => $mobile_no,
    //             'address'       => $address
    //     );
    //     }

    //     elseif (!empty($password)) {
    //         $update_customer = array(
    //             'full_name'      => $full_name,
    //             'email'          => $email,
    //             'password'       => md5($password),
    //             'status'         => $status,
    //             'mobile_no'      => $mobile_no,
    //             'address'        => $address
    //     );
    //     }

    //     $result=$this->Common_model->update_data($update_customer,$tbl_customer,$id);
        
    //     if($result > 0){
    //         $this->session->set_flashdata('msg','Customer Update Successfully');
    //          redirect(base_url('Welcome/customer'));
    //     }
    //     else{
    //         $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
    //         redirect(base_url('Welcome/customer'));
    //     }
    // }
    public function delete_customer(){
        $id=$this->uri->segment(3);
        $tbl_customer='tbl_admin';
        if (!empty($id)) {
            $result=$this->Common_model->do_delete($tbl_customer,$id);
        }
        if($result>0){
         $this->session->set_flashdata('msg','Delete Successfully');
         redirect(base_url('welcome/customer'));
        }
        else{
          $this->session->set_flashdata('error_msg','Delete Failed');
          redirect(base_url('welcome/customer'));
        }
    }

    
    public function profile(){
        $id=$this->session->userdata('id');
        $data['registration']=$this->Common_model->getdata_one('tbl_admin',$id);
        $data['main']='common/profile';
        $this->load->view('common/template',$data);
    } 

     
     public function Forget_Password(){
         $this->load->view('common/forget_password');   
    }


    public function password_change(){
        $table='tbl_admin';
        $email=$this->input->post('email');
        $result=$this->Common_model->Change_Forget_Password($email);

        if(!($result== -1)){
            $id=$result[0]['id'];
            $random_pass=rand();
            $new_pass=md5($random_pass);
            $random=array('password'=>$new_pass );
            $result=$this->Common_model->update_for_all($random,$table,$id,'id');

            $this->email->from('testing.developer999@gmail.com', 'testing'); 
             $this->email->to($email);
             $this->email->subject('Forget Password'); 
             $this->email->message('Your New password is:'.$random_pass); 
             if($this->email->send()) {
                    $this->Common_model->my_success('Email Send Successfully');
            }
             else{ 
                $this->Common_model->my_failed();
            }
        }
        else{
            $this->Common_model->my_failed();
        }
        $this->Common_model->my_return();
    }

    
    public function put_register(){
        $id=$this->uri->segment(3);
        $table='tbl_admin';
       // $gstin=$this->input->post('gstin');
        $name=$this->input->post('name');
       
        $email=$this->input->post('email');
        $password=$this->input->post('password');
       

        $save=array(
                'name'=>$name,
                'email'=>$email
            //    'numberVerified'=>$numberVerified,
              //  'total_business'=>$total_business,
              //  'total_products'=>$total_products
        );

        if($id){
                if($password)
                $save['password'] = md5($password);
        $result=$this->Common_model->update_data($save,$table,$id);
        }else{
            $save['password'] = md5($password);
            $result=$this->Common_model->save_data($save,$table);
        }
        if($result>0){
             if($id){
            $this->session->set_flashdata('msg',' Update Successfully');
             redirect(base_url('Welcome/profile'));
             }else{
                 $this->session->set_flashdata('msg','Customer Add Successfully');
                 redirect(base_url('Welcome/login'));
             }
        }
        else{
            $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
              if($id){
            redirect(base_url('Welcome/profile'));
              }else{
                 redirect(base_url('Welcome/login'));
             }
        }
    }

    
    
}
