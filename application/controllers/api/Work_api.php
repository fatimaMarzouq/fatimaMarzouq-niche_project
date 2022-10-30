<?php 

error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . 'libraries/REST_Controller.php';

//class Work_api extends CI_Controller{
class Work_api extends REST_Controller{

	public function __construct()
    {
        parent::__construct();
        $this->load->model('Api_model');
        $this->load->library('upload');
		$this->load->library('session');
	 //$this->load->helper(array('form', 'url'));
        $this->current_date_time = date('Y-m-d H:i:s');
	
    }

 
     public function login_post()
    {
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'Username', 'required|trim');
        if ($this->form_validation->run() === FALSE) {
                $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                $this->response($response);
        }else{
            
            $email     = $this->input->post('email');

            $passwords = $this->input->post('password');
    
            $password  = md5($passwords);

            

            $result    = $this->Api_model->LoginCheck($email,$password);

            if($result > 0)
            {               
                    //echo json_encode(array('msg'=>'Login Successfully','status'=>'200')); 
                     $user_area[] = array('id'=>'1','outlet'=>'test','target'=>'10000');
                $user_area[] = array('id'=>'2','outlet'=>'test1','target'=>'10000');
                $user_area[] = array('id'=>'3','outlet'=>'test2','target'=>'10000');
                $result['user_outlet']=$user_area;
                    $response ['message'] = 'Login Successfully';
            $response['statuscode'] = 200;
            $response['data'] = $result;
            $this->response($response, REST_Controller::HTTP_OK);
            }

            else
            {
                 //echo json_encode(array('msg'=>'The user name or password captured is incorrect','status'=>'500'));
                 $response ['message'] = 'The user name or password captured is incorrect';
            $response['statuscode'] = 500;
            $this->response($response, REST_Controller::HTTP_OK);
            }
        }

    }

     public function add_product_post()
    {

        $this->form_validation->set_rules('user_id', 'user_id', 'required|trim');

        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('availableFrom', 'availableFrom', 'required');
        $this->form_validation->set_rules('height', 'Height', 'required');
        $this->form_validation->set_rules('width', 'Width', 'required');
        $this->form_validation->set_rules('productType', 'Product type', 'required');
        $this->form_validation->set_rules('price', 'Price', 'required');
                $this->form_validation->set_rules('gstin', 'GSTIN', 'required|trim|numeric');
        $this->form_validation->set_rules('lat', 'Lat', 'required');
        $this->form_validation->set_rules('lng', 'Long', 'required');
        if ($this->form_validation->run() === FALSE) {
                $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                $this->response($response);
        }else{

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
  $n =6;
    for ($i = 0; $i < $n; $i++) {
        $index = rand(0, strlen($characters) - 1);
        $randomString .= $characters[$index];
    }
            $tbl_product               = 'tbl_product';
    
            $productCode         = 'MOHO'.$randomString;
            $user_id         = $this->input->post('user_id');
    
            $address                 = $this->input->post('address');   
    
            $availableFrom                      = $this->input->post('availableFrom');
    
            $height                     = $this->input->post('height');
    
              $width         = $this->input->post('width');
    
            $productType                 = $this->input->post('productType');   
    
            $availableTo                      = $this->input->post('availableTo');
    
            $price                     = $this->input->post('price');
    
              $gstin         = $this->input->post('gstin');
    
            $discount                 = $this->input->post('discount');   
    
            $includePrinting                      = $this->input->post('includePrinting');
    
            $location                     = $this->input->post('location');
    
              $otherInformation         = $this->input->post('otherInformation');
    
            $status                 = $this->input->post('status');   
    
         
    
              if ($_REQUEST['productImage']) {
    
                                   $image_name      = explode(",",$_REQUEST['productImage']);                  
                                      
                                      $count = count($image_name);
    
                                      for ($i=0; $i<$count; $i++) {
    
                                           $image = $image_name[$i];
    
                                            if ($image) {
                                              $image_parts = explode(";base64,",$image);
                                              $image_type_aux = explode("uploads/", $image_parts[0]);
                                              $image_base64 = base64_decode($image_parts[0]);
                                              $profile= uniqid() . time() . '.png';
                                              $file = './images/product_image/' .$profile;
                                             // $pathdb ="./images/users/api_img/".$profile;
                                              file_put_contents($file, $image_base64);
                                              
                                              $productImage = "images/product_image/".$profile;
                                              
                                            }
    
                                      }
    
    
    
                               }
    
          
    
    
    
            $save_product= array(
    
                'productCode'    => $productCode,       
    
                'address'            => $address,
    
                'availableFrom'                 => $availableFrom,
    
                'height'                => $height,
    
                 'width'    => $width,     
                 'user_id' => $user_id,
    
                'productType'            => $productType,
    
                'availableTo'                 => $availableTo,
    
                'price'                => $price,
    
                 'gstin'    => $gstin,       
    
                'discount'            => $discount,
    
                'includePrinting'                 => $includePrinting,
    
                'location'                => $location,
    
                 'otherInformation'    => $otherInformation,       
    
                'status'            => $status,
    
                'productImage'                 => $productImage,
    
               
            );
    
    
    
            $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
            
    
            if(!empty($InsertResult)){
              // echo json_encode(array('msg'=>'Add Product Successfully','status' =>'200'));
              $response ['message'] = 'Product added Successfully';
            $response['statuscode'] = 200;
                          $response['data'] = array('id' => (int)$InsertResult);

            $this->response($response, REST_Controller::HTTP_OK);
            }else{
                // echo json_encode(array('msg'=>'failed','status'=>'500'));
                 $response ['message'] = 'Failed';
            $response['statuscode'] = 500;
            $this->response($response, REST_Controller::HTTP_OK);
            }
        }
    }
    
      public function capturedata_post()
    {

            $user_id         = $this->input->post('user_id');
            $form_type = $this->input->post('form_type');
            $userdetail = $this->Common_model->get_run_one("SELECT * FROM `tbl_admin` where `id` = '".$user_id."'");
            
             $outlet_data = $this->Common_model->get_run_one("SELECT *  FROM `tbl_outlet_master` where `outlet_name` = '".$this->input->post('outlet_name')."' and `region`='".$this->input->post('region')."'");
                        //echo $this->db->last_query();
            if(!empty($outlet_data))
            $account_name = $outlet_data['account_name'];
                        
                        
            if(!empty($userdetail))
                $username = $userdetail['email'];
            else
                $username = '';
            
            if($form_type == 'sell_out_report'){
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
        
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                $this->form_validation->set_rules('name', 'name', 'required');
                $this->form_validation->set_rules('number', 'number', 'required');
                $this->form_validation->set_rules('email', 'email', 'required');
                        $this->form_validation->set_rules('customer_feed', 'customer_feed', 'required');
                $this->form_validation->set_rules('target', 'target', 'required');
                $this->form_validation->set_rules('user_sale', 'user_sale', 'required');
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
        
               
                    $tbl_product               = 'sellout';
                    $outlet_name         = $this->input->post('outlet_name');
                    
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $name                     = $this->input->post('name');
            
                    $number         = $this->input->post('number');
            
                    $email                 = $this->input->post('email');   
            
                    $customer_feed                  = $this->input->post('customer_feed');
            
                    $target                   = $this->input->post('target');
            
                      $user_sale         = $this->input->post('user_sale');
            
                    $analysis_per               = $this->input->post('analysis_per');   
            
                    $image_array                     = base64_encode(serialize($this->input->post('image_array')));
            
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
            
                     
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,       
            
                        'region'            => $region,
            
                        'date'                 => $this->current_date_time,
            
                        'name'                => $name,
                        'user_id' => $user_id,
                         'username' => $username,
            
                         'number'    => $number,     
                         'email' => $email,
            
                        'customer_feed'            => $customer_feed,
            
                        'target'                 => $target,
            
                        'user_sale'                => $user_sale,
            
                         'analysis_per'    => $analysis_per,       
            
                        'image_array'            => $image_array,
            
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
            
                       'created_date' =>$this->current_date_time,
                       'account_name' => $account_name
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
            }elseif($form_type == 'display_by_model_count'){
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'display_by_model_count';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,       
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'username' => $username,
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                         'add_more_array_count' => count($this->input->post('add_more_array')),
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'display_share'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'display_share';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,       
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'special_fixture_count'){
                
                 $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'special_fixture_count';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,    
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'brand_promoter_count'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'brand_promoter_count';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,  
                        'username' => $username,
                        'region'            => $region,
                        'date'                 =>$this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'price_tracker'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'price_tracker';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,   
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
                
                
            }elseif($form_type == 'market_sensing'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'market_sensing';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,      
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == '300_store_image'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = '300_store_image';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    //$add_more_array1                   = base64_encode(serialize($this->input->post('add_more_array1')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,     
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                       // 'add_more_array1'                 => $add_more_array1,
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'display_and_deployment_tracker'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'display_and_deployment_tracker';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,       
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'voc'){
                
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'voc';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,       
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
            
            }elseif($form_type == 'market_issues'){   
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'market_issues';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,   
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'training_tracker'){   
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'training_tracker';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    // $category                      = $this->input->post('category');
                    // $sub_category                      = $this->input->post('sub_category');
                    // $brand                      = $this->input->post('brand');
                    // $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name, 
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'user_id' => $user_id,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }elseif($form_type == 'stock_out'){   
                $this->form_validation->set_rules('outlet_name', 'outlet_name', 'required|trim');
                $this->form_validation->set_rules('region', 'region', 'required');
                $this->form_validation->set_rules('date', 'date', 'required');
                
                if ($this->form_validation->run() === FALSE) {
                        $response = array('statuscode' => 500, 'message' => lang('field_required'),'error'=>$this->validation_errors());
                        $this->response($response);
                }else{
                     $tbl_product               = 'stock_out';
                    $outlet_name         = $this->input->post('outlet_name');
                    $add_more_array                   = base64_encode(serialize($this->input->post('add_more_array')));
                    $region                 = $this->input->post('region');   
                    $date                      = $this->input->post('date');
                    // $category                      = $this->input->post('category');
                    // $sub_category                      = $this->input->post('sub_category');
                    // $brand                      = $this->input->post('brand');
                    // $date                      = $this->input->post('date');
                    $save_product= array(
            
                        'outlet_name'    => $outlet_name,      
                        'username' => $username,
                        'region'            => $region,
                        'date'                 => $this->current_date_time,
                        'add_more_array'                 => $add_more_array,
                        'add_more_array_count' => count($this->input->post('add_more_array')),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                          'account_name' => $account_name
                       
                    );
            
            
            
                    $InsertResult = $this->Api_model->save_data($save_product,$tbl_product);
                }
                
            }
                    
        
            if(!empty($InsertResult)){
              // echo json_encode(array('msg'=>'Add Product Successfully','status' =>'200'));
            $userdata = $this->Common_model->get_run_one("SELECT * FROM `tbl_admin` where `id` = '".$user_id."'");
            if(!empty($userdata)){
                $outlet_visit = $this->Common_model->get_run_one("SELECT * FROM `tbl_masterdata3` where `outlet_name` = '".$outlet_name."' and `user` = '".$userdata['email']."' and `new_date` like '%".date('n/d/Y')."%' ");
                                   //echo $this->db->last_query();

               if(!empty($outlet_visit)){
                    $save_outlet= array(
                        'visit_status'    => 'Visited'
                        
                    );
                    
                     $result=$this->Api_model->update_data($save_outlet,'tbl_masterdata3',$outlet_visit['id']);
                    
            
                    
               }
            }
            
            if($form_type == 'sell_out_report' || $form_type == 'special_fixture_count' || $form_type == 'market_sensing' || $form_type == '300_store_image' || $form_type == 'display_and_deployment_tracker' || $form_type == 'training_tracker'){
                $image_data= array(
            
                        'outlet_name'    => $outlet_name,      
                        'new_date'                 => date('Y-m-d'),
                        'user_id' => $user_id,
                         'created_date' =>$this->current_date_time,
                         'form_type'=>$form_type,
                         'user' => $username,
                         'region'            => $region,
                         'account_name' => $account_name
                       
                    );
            
            
            
                   $this->Api_model->save_data($image_data,'image_list_data');
            }

              $response ['message'] = 'Data added Successfully';
            $response['statuscode'] = 200;
            $response['data'] = array('id' => (int)$InsertResult);

            $this->response($response, REST_Controller::HTTP_OK);
            }else{
                // echo json_encode(array('msg'=>'failed','status'=>'500'));
                 $response ['message'] = 'Failed';
            $response['statuscode'] = 500;
            $this->response($response, REST_Controller::HTTP_OK);
            }
        
    }

    function uploadsectionImage_post(){
           // $this->form_validation->set_rules('type', 'Type', 'required|trim');

            $this->form_validation->set_rules('imageUpload', '', 'callback_file_check1');
            if ($this->form_validation->run() !== FALSE) {
                $image_file_url = '';
                $type = $this->input->post("type");

                if (!empty($_FILES)) {
                    $image_file_name = $_FILES['imageUpload']['name'];
                  
                    list($msg, $flag, $imageUrl) = $this->upload_image("images/".$type, $_FILES, "imageUpload");
                    if(!empty($flag) && empty($msg)){
                        $dataVal['image_url'] = $imageUrl;
                        $image_file_url = $imageUrl;
                       
                        $image_url = isImageExist($imageUrl, "sell_out_report");
                    }else{
                        $response ['message'] = strip_tags($msg);
                        $response['statuscode'] = 500;
                        $this->response($response, REST_Controller::HTTP_OK);
                    }
                }

               

                $response['statuscode'] = 200;
                $response['message'] = "Image upload successfully";
                $response['data'] = array('image_url' =>$image_url);
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                
                $response['message'] = "Fields are required";
                $response['error'] = $this->validation_errors();
                $response['statuscode'] = 500;
                $this->set_response($response, REST_Controller::HTTP_OK);
                
            }
       

    }
    public function file_check1($str){

        $allowed_mime_type_arr = array('image/gif','image/jpg','image/jpeg','image/png');
        $mime = get_mime_by_extension($_FILES['imageUpload']['name']);

        if(isset($_FILES['imageUpload']['name']) && $_FILES['imageUpload']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check1', 'Please select only gif/jpg/jpeg/png file.');
                return false;
            }
        }else{
            $this->form_validation->set_message('file_check1', 'Please choose a file to upload.');
            return false;
        }
    }

    function upload_image($type, $file, $label) {
//echo realpath($this->target_folder . $type);
        $config['upload_path'] =realpath($this->target_folder . $type);
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $response = array();

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload($label)) {
          
            $response = array($this->upload->display_errors(), 0, NULL);
        } else {

            $fileInfo = $this->upload->data();
            $postData['uploadDocUrl'] = base_url() . $this->target_folder . $type . "/" . $fileInfo ['file_name'];
            chmod(realpath($this->target_folder . $type . "/" . $fileInfo ['file_name']), 0777);

            $response = array($this->upload->display_errors(), 1, $fileInfo ['file_name']);
        }
        return $response;
    }

    function get_master_data_post(){
            $form_name = isset($_POST['form_name']) ? $_POST['form_name'] : NULL;
             $type = isset($_POST['type']) ? $_POST['type'] : NULL;
            $category = isset($_POST['category']) ? $_POST['category'] : NULL;
            $brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : NULL;
            
            if($type == 'category'){
                $select = "DISTINCT(category)";
            }elseif($type == 'brand'){
                $select = "DISTINCT(brand_name)";
            }elseif($type == 'segment'){
                $select = "DISTINCT(segment)";
            }elseif($type == 'model_number'){
                $select = "DISTINCT(model_number)";
            }
           
            $table = "tbl_masterdata";
            $where = "menu_name ='".$form_name."'";
            if($type == 'category'){
                $where .= " and category IS NOT NULL and category != '' ";
            }elseif($type == 'brand'){
                if(!empty($category)){
                    $where .= " and category ='".$category."' and brand_name IS NOT NULL and brand_name != '' ";
                }else{
                    $where .= " and brand_name IS NOT NULL and brand_name != '' ";
                }
                
            }elseif($type == 'segment'){
                $where .= " and category ='".$category."' and brand_name = '".$brand_name."' and segment IS NOT NULL and segment != ''";
            }elseif($type == 'model_number'){
                $where .= " and category ='".$category."' and brand_name ='".$brand_name."' and model_number IS NOT NULL and model_number != ''";
            }
                
           
            if($type == 'brand'){
                $type = 'brand_name';
            }
            $orderBy = $type."  ASC";
            $data = $this->Common_model->fetch_all_data($select, $table, $where,$orderBy);
           //echo $this->db->last_query();
            if (!empty($data)) {
                $response['statuscode'] = 200;
                $response['message'] = 'Data get successfully';
                $response['data'] = $data;
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                $response['message'] =  'Record not found';
                $response['statuscode'] = 500;
                $this->set_response($response, REST_Controller::HTTP_OK);
            }
    }
    
    function get_master_data2_post(){
           
            $type = isset($_POST['type']) ? $_POST['type'] : NULL;
          
            if($type == 'display_type'){
                $select = "DISTINCT(display_type)";
            }elseif($type == 'fixture_type'){
                $select = "DISTINCT(fixture_type)";
            }elseif($type == 'activity_type'){
                $select = "DISTINCT(activity_type)";
            }elseif($type == 'voc_type'){
                $select = "DISTINCT(voc_type)";
            }elseif($type == 'promoter_type'){
                $select = "DISTINCT(promoter_type)";
            }elseif($type == 'condition_fixture'){
                $select = "DISTINCT(condition_fixture)";
            }
           
            $table = "tbl_masterdata2";
            $where = $type." IS NOT NULL and ".$type."!= ''";
            
            
            
           
            

            $orderBy = $type."  ASC";
            $data = $this->Common_model->fetch_all_data($select, $table, $where,$orderBy);
           // echo $this->db->last_query();
            if (!empty($data)) {
                $response['statuscode'] = 200;
                $response['message'] = 'Data get successfully';
                $response['data'] = $data;
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                $response['message'] =  'Record not found';
                $response['statuscode'] = 500;
                $this->set_response($response, REST_Controller::HTTP_OK);
            }
    }
    
    function get_region_with_outlet_post(){
           
            $outlet_id = isset($_POST['outlet_id']) ? $_POST['outlet_id'] : NULL;
          
            if($type == 'display_type'){
                $select = "DISTINCT(display_type)";
            }elseif($type == 'fixture_type'){
                $select = "DISTINCT(fixture_type)";
            }elseif($type == 'activity_type'){
                $select = "DISTINCT(activity_type)";
            }elseif($type == 'voc_type'){
                $select = "DISTINCT(voc_type)";
            }
           
            $table = "tbl_masterdata2";
            $where = $type." IS NOT NULL";
            
            
            
           
            

            $orderBy = $type."  ASC";
            //$data = $this->Common_model->fetch_all_data($select, $table, $where,$orderBy);
           // echo $this->db->last_query();
         //  $user_area[] = array('id'=>'1','region'=>'test');
             //   $user_area[] = array('id'=>'2','region'=>'test1');
                $user_area = array('id'=>'3','region'=>'test2');
                $data = $user_area;
            if (!empty($data)) {
                
                $response['statuscode'] = 200;
                $response['message'] = 'Data get successfully';
                $response['data'] = $data;
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                $response['message'] =  'Record not found';
                $response['statuscode'] = 500;
                $this->set_response($response, REST_Controller::HTTP_OK);
            }
    }
    function user_outlet_list_post(){
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;
        $userdetail = $this->Common_model->get_run_one("SELECT * FROM `tbl_admin` where `id` = '".$user_id."'");
        $msgdetail = $this->Common_model->get_run_one("SELECT * FROM `tbl_msg` where `sending_msg_user` in (".$user_id.") and `created_date` like '".date('Y-m-d')."%' order by `id` desc limit 0,1 ");
        $outlet_master = [];
        if(!empty($userdetail)){
             $date =  date('n/d/Y');
            $outlet_user_checking = $this->Common_model->get_run_one("SELECT outlet_name,region,visit_status  FROM `tbl_masterdata3` where `user` = '".$userdetail['email']."'");
            if(!empty($outlet_user_checking)){
               // echo "SELECT outlet_name,region,visit_status  FROM `tbl_masterdata3` where `new_date` like '%".$date."%' and `user` = '".$userdetail['email']."'";
                $outlet_checking = $this->Common_model->get_run("SELECT outlet_name,region,visit_status,unique_code  FROM `tbl_masterdata3` where `new_date` like '%".$date."%' and `user` = '".$userdetail['email']."'");
                if(!empty($outlet_checking)){
                    
                    foreach($outlet_checking as $outlet_check){
                        $outlet_data = $this->Common_model->get_run_one("SELECT *  FROM `tbl_outlet_master` where `unique_code` = '".$outlet_check['unique_code']."' ");
                       // echo $this->db->last_query();
                        $userdetail['outlet_list'][] = $outlet_data;
                        
                    }
                    
                    if(!empty($userdetail['assigned_form'])){
                        $userdetail['assigned_form'] = explode(',',$userdetail['assigned_form']);
                    }else{
                        $userdetail['assigned_form'] = [];
                    }
                }else{
                    $userdetail['assigned_form'] =[];
                    $userdetail['outlet_list'] =[];
                }
            }else{
                if(!empty($userdetail)){
                    $assigned_outlet = $userdetail['assigned_outlet'];
                    if(!empty($assigned_outlet))
                    $outlet_master = $this->Common_model->get_run("SELECT * FROM `tbl_outlet_master` where `id` in (".$assigned_outlet.")");
                    else
                    $outlet_master = [];
                }
                if(!empty($userdetail['assigned_form'])){
                    $userdetail['assigned_form'] = explode(',',$userdetail['assigned_form']);
                }else{
                    $userdetail['assigned_form'] = [];
                }
                $userdetail['outlet_list'] = $outlet_master;
            }
        }
        if (!empty($userdetail)) {
            if(!empty($msgdetail))
            $userdetail['msg_detail'] = $msgdetail['msg'];
            else
            $userdetail['msg_detail'] = '';
            $response['statuscode'] = 200;
            $response['message'] = 'Data get successfully';
            $response['data'] = $userdetail;
            $this->set_response($response, REST_Controller::HTTP_OK);
        } else {
            $response['message'] =  'Record not found';
            $response['statuscode'] = 500;
            $this->set_response($response, REST_Controller::HTTP_OK);
        }
    }
    
    function attendance_post(){
        $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : NULL;
         $username = isset($_POST['username']) ? $_POST['username'] : NULL;
        
        $date1 =  date('d/m/Y');
       $date =  date('n/d/Y');
        $outlet_checking = $this->Common_model->get_run("SELECT outlet_name,region,visit_status  FROM `tbl_masterdata3` where `new_date` like '%".$date."%' and `user` = '".$username."'");
        $visited = 0;
        $outlet_array = [];
        if(!empty($outlet_checking)){
                foreach($outlet_checking as $outlet_check){
                    if($outlet_check['visit_status'] == 'Visited'){
                        $visited++;
                    }
                    
                }
            
        }
        $visit_percentage = 0;
        if($visited != 0){
            $visit_percentage = ($visited/count($outlet_checking)) * 100;
            $visit_percentage = number_format((float)$visit_percentage, 2, '.', '');
        }
        $userdetail = array('date'=>$date1,'planned'=>count($outlet_checking),'visited'=>$visited,'visit_percentage'=>$visit_percentage);

        $outlet_array = $outlet_checking;
        //$outlet_array[0] = array('outlet_name'=>'test1','region'=>'test2','visit_status'=>'Visited');
        //$outlet_array[1] = array('outlet_name'=>'test2','region'=>'test3','visit_status'=>'Pending');
        
        if (!empty($userdetail)) {
           
            $userdetail['outlet_array'] = $outlet_array;
           
            $response['statuscode'] = 200;
            $response['message'] = 'Data get successfully';
            $response['data'] = $userdetail;
            $this->set_response($response, REST_Controller::HTTP_OK);
        } else {
            $response['message'] =  'Record not found';
            $response['statuscode'] = 500;
            $this->set_response($response, REST_Controller::HTTP_OK);
        }
    }
    
    
    function get_master_data_segment_post(){
            $form_name = isset($_POST['form_name']) ? $_POST['form_name'] : NULL;
             $type = isset($_POST['type']) ? $_POST['type'] : NULL;
            $category = isset($_POST['category']) ? $_POST['category'] : NULL;
            $brand_name = isset($_POST['brand_name']) ? $_POST['brand_name'] : NULL;
            $segment = isset($_POST['segment']) ? $_POST['segment'] : NULL;
            
            if($type == 'category'){
                $select = "DISTINCT(category)";
            }elseif($type == 'brand'){
                $select = "DISTINCT(brand_name)";
            }elseif($type == 'segment'){
                $select = "DISTINCT(segment)";
            }elseif($type == 'model_number'){
               // $select = "DISTINCT(model_number)";
            }
           
            $table = "tbl_masterdata";
            $where = "menu_name ='".$form_name."'";
            
            if($type == 'category'){
                $where .= " and category IS NOT NULL and category != '' ";
            }elseif($type == 'brand'){
                 $where .= " and category ='".$category."' and segment = '".$segment."'  and brand_name IS NOT NULL and brand_name != ''";

            }elseif($type == 'segment'){
                $where .= " and  category = '".$category."' and segment IS NOT NULL and segment != ''";
            }elseif($type == 'model_number'){
                //$where .= " and category ='".$category."' and brand_name ='".$brand_name."' and model_number IS NOT NULL and model_number != ''";
            }
                
           
            if($type == 'brand'){
                $type = 'brand_name';
            }
            $orderBy = $type."  ASC";
            $data = $this->Common_model->fetch_all_data($select, $table, $where,$orderBy);
          // echo $this->db->last_query();
            if (!empty($data)) {
                $response['statuscode'] = 200;
                $response['message'] = 'Data get successfully';
                $response['data'] = $data;
                $this->set_response($response, REST_Controller::HTTP_OK);
            } else {
                $response['message'] =  'Record not found';
                $response['statuscode'] = 500;
                $this->set_response($response, REST_Controller::HTTP_OK);
            }
    }
    

}  
?>