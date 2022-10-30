<?php
defined('BASEPATH') OR exit('No direct script access allowed');
error_reporting(0);
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Product extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('session'); 
         $this->load->library('excel');
         if($this->session->userdata('id')){
             $customer_form = $this->Common_model->get_run("SELECT * FROM tbl_admin where `manager_id` ='".$this->session->userdata('id')."'  ORDER BY id DESC");
             
            $all_user = [];
            $all_username = [];
            $this->all_user_data = 0;
            $this->all_username_data = '';
            if(!empty($customer_form)){
                foreach($customer_form as $customer_f){
                    $all_user[] = $customer_f['id'];
                    $all_username[] = "'".$customer_f['email']."'";
                }
               $this->all_user_data =  implode(',',$all_user);
               $this->all_username_data =  implode(',',$all_username);
            }
        }else{
            redirect(base_url('welcome/login'));
        }
    }
    
    function import_save()
     {
        $this->form_validation->set_rules('fileUpload', 'Upload File', 'callback_checkFileValidation');
        if ($this->form_validation->run() !== FALSE) {
          if(isset($_FILES["fileUpload"]["name"]))
          {
                $inputFileName = $_FILES["fileUpload"]["tmp_name"];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                
                $arrayCount = count($allDataInSheet);
                $flag = 0;
                $createArray = array('CATEGORY', 'BRAND NAME', 'SEGMENT', 'MODEL NUMBER', 'MENU NAME');
                $makeArray = array('CATEGORY' => 'CATEGORY', 'BRAND_NAME' => 'BRAND NAME', 'SEGMENT' => 'SEGMENT', 'MODEL_NUMBER' => 'MODEL NUMBER', 'MENU_NAME' => 'MENU NAME');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '_', $value);
                            $SheetDataKey[trim($value)] = $key;
                        } else {
                            
                        }
                    }
                }
               // echo '<pre>';print_r($SheetDataKey);
                $data = array_diff_key($makeArray, $SheetDataKey);
              // echo '<pre>';print_r($data);
              // exit;
                if (empty($data)) {
                    $flag = 1;
                }
                $error_r = 0;
                  $success_r = 0;
                $total_row = 0;
                $duplicate_data = 0;
                $valid_data_for_insert = array();
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $addresses = array();
                        $category = $SheetDataKey['CATEGORY'];
                        $brand_name = $SheetDataKey['BRAND_NAME'];
                        $segment = $SheetDataKey['SEGMENT'];
                        $model_number = $SheetDataKey['MODEL_NUMBER'];
                        $menu_name = $SheetDataKey['MENU_NAME'];
                        $category = filter_var(trim($allDataInSheet[$i][$category]), FILTER_SANITIZE_STRING);
                        $brand_name = filter_var(trim($allDataInSheet[$i][$brand_name]), FILTER_SANITIZE_STRING);
                        $segment = filter_var(trim($allDataInSheet[$i][$segment]), FILTER_SANITIZE_STRING);
                        $model_number = filter_var(trim($allDataInSheet[$i][$model_number]), FILTER_SANITIZE_STRING);
                        $menu_name = filter_var(trim($allDataInSheet[$i][$menu_name]), FILTER_SANITIZE_STRING);
                        
                           if((empty($category) && empty($brand_name) && empty($model_number)) || empty($menu_name)){
                       $error_data[] = array('category' => $category, 'brand_name' => $brand_name,'model_number'=>$model_number,'menu_name' => $menu_name);
                        $error_r += 1 ; 
                        }else{
                
                             $check_exit_data = $this->Common_model->fetchSingleData(
                            array("id"), "tbl_masterdata", array("category"=>$category,"brand_name"=>$brand_name,'model_number'=>$model_number,"menu_name"=>$menu_name)
                            );
    
                            if(!empty($check_exit_data)){
        
                               
                                    $duplicate_data  += 1;
                                
        
                            }else{
                                $success_r += 1;
                                $fetchData[] = array('category' => $category, 'brand_name' => $brand_name, 'segment' => $segment, 'model_number' => $model_number, 'menu_name' => $menu_name);
                            }
                        }
                         $total_row += 1;
                    }  
                    // echo '<pre>';print_r($fetchData);
                    // exit;
                    //$data['employeeInfo'] = $fetchData;
                    if(!empty($fetchData)){
                        // echo '<pre>';print_r($fetchData);
                        // exit;
                    $this->Common_model->setBatchImport($fetchData);
                    $this->Common_model->importData();
                    }
                    $msg = "File uploaded successfully. No. of Rows is ".$total_row.", Success: ".$success_r." and Failed: ".$error_r." duplicate row: ".$duplicate_data;
                     $this->session->set_flashdata('msg',$msg);
                } else {
                    //echo "Please import correct file";
                    $this->session->set_flashdata('error_msg','Please import correct file');
                }
                
                redirect(base_url('Product/product'));
            
               
          }else{
              $this->session->set_flashdata('error_msg','Please import correct file');
              redirect(base_url('Product/product'));
          }
        }else{
             // $this->session->set_flashdata('error_msg','File is required');
              redirect(base_url('Product/product'));
         }
           
     }
     
     
      
    function import_master2_save()
     {
        $this->form_validation->set_rules('fileUpload', 'Upload File', 'callback_checkFileValidation');
        
        if ($this->form_validation->run() !== FALSE) {
           
          if(isset($_FILES["fileUpload"]["name"]))
          {
                $inputFileName = $_FILES["fileUpload"]["tmp_name"];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
               
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            //   echo '<pre>';print_r($allDataInSheet );
            //   exit;
                $arrayCount = count($allDataInSheet);
                
                $flag = 0;
               
                $createArray = array('ACTIVITY TYPE', 'DISPLAY TYPE', 'FIXTURE TYPE', 'VOC TYPE','Condition of Fixture','PROMOTER TYPE');
                  
                $makeArray = array('ACTIVITY_TYPE' => 'ACTIVITY TYPE', 'DISPLAY_TYPE' => 'DISPLAY TYPE', 'FIXTURE_TYPE' => 'FIXTURE TYPE', 'VOC_TYPE' => 'VOC TYPE','Condition_of_Fixture'=>'Condition of Fixture','PROMOTER_TYPE' => 'PROMOTER TYPE');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '_', $value);
                            $SheetDataKey[trim($value)] = $key;
                        } else {
                            
                        }
                    }
                }
               // echo '<pre>';print_r($SheetDataKey);
                $data = array_diff_key($makeArray, $SheetDataKey);
              // echo '<pre>';print_r($data);
              // exit;
                if (empty($data)) {
                    $flag = 1;
                }
                $error_r = 0;
                  $success_r = 0;
                $total_row = 0;
                $duplicate_data = 0;
                $valid_data_for_insert = array();
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $addresses = array();
                        $activity_type = $SheetDataKey['ACTIVITY_TYPE'];
                        $display_type = $SheetDataKey['DISPLAY_TYPE'];
                        $fixture_type = $SheetDataKey['FIXTURE_TYPE'];
                        $voc_type = $SheetDataKey['VOC_TYPE'];
                        $condition_of_fixture = $SheetDataKey['Condition_of_Fixture'];
                        $promoter_type = $SheetDataKey['PROMOTER_TYPE'];
                        
                        $activity_type = filter_var(trim($allDataInSheet[$i][$activity_type]), FILTER_SANITIZE_STRING);
                        $display_type = filter_var(trim($allDataInSheet[$i][$display_type]), FILTER_SANITIZE_STRING);
                        $fixture_type = filter_var(trim($allDataInSheet[$i][$fixture_type]), FILTER_SANITIZE_STRING);
                        $voc_type = filter_var(trim($allDataInSheet[$i][$voc_type]), FILTER_SANITIZE_STRING);
                        $condition_of_fixture = filter_var(trim($allDataInSheet[$i][$condition_of_fixture]), FILTER_SANITIZE_STRING);
                        $promoter_type = filter_var(trim($allDataInSheet[$i][$promoter_type]), FILTER_SANITIZE_STRING);

                           if(empty($display_type) && empty($activity_type) && empty($fixture_type) &&  empty($voc_type) && empty($condition_of_fixture) && empty($promoter_type)){
                       $error_data[] = array('display_type' => $display_type, 'activity_type' => $activity_type,'fixture_type'=>$fixture_type,'voc_type' => $voc_type,'condition_of_fixture'=>$condition_of_fixture,'promoter_type'=>$promoter_type);
                        $error_r += 1 ; 
                        }else{
                
                             $check_exit_data = $this->Common_model->fetchSingleData(
                            array("id"), " tbl_masterdata2", array("display_type"=>$display_type)
                            );
                            $check_exit_data1 = $this->Common_model->fetchSingleData(
                            array("id"), " tbl_masterdata2", array("activity_type"=>$activity_type)
                            );
                            $check_exit_data2 = $this->Common_model->fetchSingleData(
                            array("id"), " tbl_masterdata2", array("fixture_type"=>$fixture_type)
                            );
                            $check_exit_data3 = $this->Common_model->fetchSingleData(
                            array("id"), " tbl_masterdata2", array("voc_type"=>$voc_type)
                            );
                            
                             $check_exit_data4 = $this->Common_model->fetchSingleData(
                            array("id"), " tbl_masterdata2", array("condition_fixture"=>$condition_of_fixture)
                            );
                            
                             $check_exit_data5 = $this->Common_model->fetchSingleData(
                            array("id"), " tbl_masterdata2", array("promoter_type"=>$promoter_type)
                            );
    
    
                            if(!empty($check_exit_data) || !empty($check_exit_data1) || !empty($check_exit_data2) || !empty($check_exit_data3) || !empty($check_exit_data4) || !empty($check_exit_data5)){
        
                               
                                    $duplicate_data  += 1;
                                
        
                            }else{
                                $success_r += 1;
                                $fetchData[] = array('display_type' => $display_type, 'activity_type' => $activity_type, 'fixture_type' => $fixture_type, 'voc_type' => $voc_type,'condition_fixture'=>$condition_of_fixture,'promoter_type'=>$promoter_type);
                            }
                        }
                         $total_row += 1;
                    }  
                    // echo '<pre>';print_r($fetchData);
                    // exit;
                    //$data['employeeInfo'] = $fetchData;
                    if(!empty($fetchData)){
                        // echo '<pre>';print_r($fetchData);
                        // exit;
                    $this->Common_model->setBatchImport($fetchData);
                    $this->Common_model->importData1();
                    }
                    $msg = "File uploaded successfully. No. of Rows is ".$total_row.", Success: ".$success_r." and Failed: ".$error_r." duplicate row: ".$duplicate_data;
                     $this->session->set_flashdata('msg',$msg);
                } else {
                    //echo "Please import correct file";
                    $this->session->set_flashdata('error_msg','Please import correct file');
                }
                
                redirect(base_url('Product/master2'));
            
               
          }else{
              $this->session->set_flashdata('error_msg','Please import correct file');
              redirect(base_url('Product/master2'));
          }
        }else{
             // $this->session->set_flashdata('error_msg','File is required');
              redirect(base_url('Product/master2'));
         }
           
     }
     
     
        
    function import_master3_save()
     {
        $this->form_validation->set_rules('fileUpload', 'Upload File', 'callback_checkFileValidation');
        
        if ($this->form_validation->run() !== FALSE) {
           
          if(isset($_FILES["fileUpload"]["name"]))
          {
                $inputFileName = $_FILES["fileUpload"]["tmp_name"];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
               
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            //   echo '<pre>';print_r($allDataInSheet );
            //   exit;
                $arrayCount = count($allDataInSheet);
                
                $flag = 0;
               
                $createArray = array('Outlet Name', 'Account Name', 'Region', 'User','Date','Unique Code');
                  
                $makeArray = array('Outlet_Name' => 'Outlet Name', 'Account_Name' => 'Account Name', 'Region' => 'Region', 'User' => 'User','Date'=>'Date','Unique_Code'=>'Unique Code');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '_', $value);
                            $SheetDataKey[trim($value)] = $key;
                        } else {
                            
                        }
                    }
                }
               // echo '<pre>';print_r($SheetDataKey);
                $data = array_diff_key($makeArray, $SheetDataKey);
              // echo '<pre>';print_r($data);
              // exit;
                if (empty($data)) {
                    $flag = 1;
                }
                $error_r = 0;
                  $success_r = 0;
                $total_row = 0;
                $duplicate_data = 0;
                $valid_data_for_insert = array();
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $addresses = array();
                        $outlet_name = $SheetDataKey['Outlet_Name'];
                        $account_name = $SheetDataKey['Account_Name'];
                        $region = $SheetDataKey['Region'];
                        $user = $SheetDataKey['User'];
                        $date = $SheetDataKey['Date'];
                        $unique_code = $SheetDataKey['Unique_Code'];

                        $outlet_name = filter_var(trim($allDataInSheet[$i][$outlet_name]), FILTER_SANITIZE_STRING);
                        $account_name = filter_var(trim($allDataInSheet[$i][$account_name]), FILTER_SANITIZE_STRING);
                        $region = filter_var(trim($allDataInSheet[$i][$region]), FILTER_SANITIZE_STRING);
                        $user = filter_var(trim($allDataInSheet[$i][$user]), FILTER_SANITIZE_STRING);
                        $date = filter_var(trim($allDataInSheet[$i][$date]), FILTER_SANITIZE_STRING);
                        $unique_code = filter_var(trim($allDataInSheet[$i][$unique_code]), FILTER_SANITIZE_STRING);
                        

                           if((empty($outlet_name) && empty($account_name) && empty($region) &&  empty($user)) || empty($date) || empty($unique_code)){
                       $error_data[] = array('outlet_name' => $outlet_name, 'region' => $region,'user'=>$user,'date' => $date,'account_name'=>$account_name,'unique_code'=>$unique_code);
                        $error_r += 1 ; 
                        }else{
                            // $new_date = explode(';',$date);
                            // $check_exit_data = 0;
                            //     foreach($new_date as $new_dat){
                            //         //$new_dat = trim($new_dat,' ');
                            //         $new_dat = date('m/d/Y', strtotime($new_dat));
                            //          $check_exit_data1 = $this->Common_model->fetchSingleData(
                            //         array("id"), "tbl_masterdata3", array("unique_code"=>$unique_code,'new_date' => $new_dat,'user'=>$user)
                            //         );
                            //          if(!empty($check_exit_data1)){
                            //              $check_exit_data++;
                            //          }
                            //     }
                           
    
                            // if(!empty($check_exit_data)){
        
                               
                            //         $duplicate_data  += 1;
                                    
                                   
                                
        
                            // }else{
                                $success_r += 1;
                                $new_date = explode(';',$date);
                                foreach($new_date as $new_dat){
                                    //$new_dat = trim($new_dat,' ');
                                    $new_dat = date('m/d/Y', strtotime($new_dat));
                                     $check_exit_data1 = $this->Common_model->fetchSingleData(
                                    array("id"), "tbl_masterdata3", array("unique_code"=>$unique_code,'new_date' => $new_dat,'user'=>$user)
                                    );
                                     if(!empty($check_exit_data1)){
                                        $duplicate_data  += 1;
                                     }else{
                                        $fetchData = array('outlet_name' => $outlet_name, 'region' => $region,'user'=>$user,'date' => $date,'new_date' => $new_dat,'account_name'=>$account_name,'unique_code'=>$unique_code);
                                        $result=$this->Common_model->save_data($fetchData,'tbl_masterdata3');
                                     }
                                }
                            //}
                        }
                         $total_row += 1;
                    }  
                    // echo '<pre>';print_r($fetchData);
                     //exit;
                    //$data['employeeInfo'] = $fetchData;
                    //if(!empty($fetchData)){
                        // echo '<pre>';print_r($fetchData);
                        // exit;
                    //$this->Common_model->setBatchImport($fetchData);
                    //$this->Common_model->importData3();
                    //}
                   // $msg = "File uploaded successfully. No. of Rows is ".$total_row.", Success: ".$success_r." and Failed: ".$error_r." duplicate row: ".$duplicate_data;
                    $msg = "File uploaded successfully.";
                     $this->session->set_flashdata('msg',$msg);
                } else {
                    //echo "Please import correct file";
                    $this->session->set_flashdata('error_msg','Please import correct file');
                }
                
                redirect(base_url('Product/master3'));
            
               
          }else{
              $this->session->set_flashdata('error_msg','Please import correct file');
              redirect(base_url('Product/master3'));
          }
        }else{
             // $this->session->set_flashdata('error_msg','File is required');
              redirect(base_url('Product/master3'));
         }
           
     }
     public function edit_master3(){
        $id=$this->uri->segment(3);
        $tbl_customer='tbl_masterdata3';
        $result = $this->Common_model->getdata_one($tbl_customer,$id);
        if(!empty($result))
        $data['result'] = $result[0];
        else
        $data['result'] = [];
        // echo $this->db->last_query();
        // exit;
        $data['main']='Product/edit_master3';
        $this->load->view('common/template',$data);         
    }
    
     public function save_master3(){

        $tbl_customer   = 'tbl_masterdata3';
        $id=$this->uri->segment(3);
        $new_date     = $this->input->post('new_date');
       
       // $new_date = strtotime($new_date);
        $date = date('m/d/Y', strtotime($new_date));
        
        $save_role      = array(
            'new_date'    => $date
           
        );
        if(!empty($id)){
                    $result=$this->Common_model->update_data($save_role,$tbl_customer,$id);

            
        }
        
        if(!empty($id)){
           
             $this->session->set_flashdata('msg','Data Update Successfully');
            
             redirect(base_url('product/master3'));
        }
        else{
            $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
            redirect(base_url('product/master3'));
        }
    }
      public function delete_master3(){
        $id=$this->uri->segment(3);
        $tbl_customer='tbl_masterdata3';
        if (!empty($id)) {
            $result=$this->Common_model->do_delete($tbl_customer,$id);
        }
        if($result>0){
         $this->session->set_flashdata('msg','Delete Successfully');
         redirect(base_url('product/master3'));
        }
        else{
          $this->session->set_flashdata('error_msg','Delete Failed');
          redirect(base_url('product/master3'));
        }
    }
     function import_outlet_save()
     {
        $this->form_validation->set_rules('fileUpload', 'Upload File', 'callback_checkFileValidation');
        if ($this->form_validation->run() !== FALSE) {
          if(isset($_FILES["fileUpload"]["name"]))
          {
                $inputFileName = $_FILES["fileUpload"]["tmp_name"];
                try {
                    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                    $objPHPExcel = $objReader->load($inputFileName);
                } catch (Exception $e) {
                    die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME)
                            . '": ' . $e->getMessage());
                }
                $allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                
                $arrayCount = count($allDataInSheet);
                $flag = 0;
                $createArray = array('Outlet Name', 'Region', 'Location Name', 'Latitude','Longitude','GPS STATUS','Unique Code','Account Name');
                $makeArray = array('Outlet_Name' => 'Outlet Name', 'Region' => 'Region', 'Location_Name' => 'Location Name', 'Latitude' => 'Latitude','Longitude' => 'Longitude','GPS_STATUS' => 'GPS STATUS','Unique_Code'=>'Unique Code','Account_Name'=>'Account Name');
                $SheetDataKey = array();
                foreach ($allDataInSheet as $dataInSheet) {
                    foreach ($dataInSheet as $key => $value) {
                        if (in_array(trim($value), $createArray)) {
                            $value = preg_replace('/\s+/', '_', $value);
                            $SheetDataKey[trim($value)] = $key;
                        } else {
                            
                        }
                    }
                }
               // echo '<pre>';print_r($SheetDataKey);
                $data = array_diff_key($makeArray, $SheetDataKey);
              // echo '<pre>';print_r($data);
              // exit;
                if (empty($data)) {
                    $flag = 1;
                }
                $error_r = 0;
                  $success_r = 0;
                $total_row = 0;
                $duplicate_data = 0;
                $valid_data_for_insert = array();
                if ($flag == 1) {
                    for ($i = 2; $i <= $arrayCount; $i++) {
                        $addresses = array();
                        $outlet_name = $SheetDataKey['Outlet_Name'];
                        $region = $SheetDataKey['Region'];
                        $location_name = $SheetDataKey['Location_Name'];
                        $latitude = $SheetDataKey['Latitude'];
                        $longitude = $SheetDataKey['Longitude'];
                        $target = $SheetDataKey['GPS_STATUS'];
                        $unique_code = $SheetDataKey['Unique_Code'];
                        $account_name = $SheetDataKey['Account_Name'];
                        
                        
                        $outlet_name = filter_var(trim($allDataInSheet[$i][$outlet_name]), FILTER_SANITIZE_STRING);
                        $region = filter_var(trim($allDataInSheet[$i][$region]), FILTER_SANITIZE_STRING);
                        $location_name = filter_var(trim($allDataInSheet[$i][$location_name]), FILTER_SANITIZE_STRING);
                        $latitude = filter_var(trim($allDataInSheet[$i][$latitude]), FILTER_SANITIZE_STRING);
                        $longitude = filter_var(trim($allDataInSheet[$i][$longitude]), FILTER_SANITIZE_STRING);
                        $target = filter_var(trim($allDataInSheet[$i][$target]), FILTER_SANITIZE_STRING);
                        $unique_code = filter_var(trim($allDataInSheet[$i][$unique_code]), FILTER_SANITIZE_STRING);
                        $account_name = filter_var(trim($allDataInSheet[$i][$account_name]), FILTER_SANITIZE_STRING);

                           if(empty($outlet_name) && empty($region) && empty($location_name) &&  empty($latitude) && empty($longitude) && empty($unique_code) && empty($account_name)){
                       $error_data[] = array('outlet_name' => $outlet_name, 'region' => $region,'location_name'=>$location_name,'latitude' => $latitude,'longitude' => $longitude,'unique_code'=>$unique_code,'account_name'=>$account_name);
                        $error_r += 1 ; 
                        }else{
                
                             $check_exit_data = $this->Common_model->fetchSingleData(
                            array("id"), "tbl_outlet_master", array('unique_code'=>$unique_code)
                            );
                        //   echo $this->db->last_query().'</br>';
                // echo '<pre>';print_r($check_exit_data);
                // exit;
                            if(!empty($check_exit_data)){
                                    if($target == 'Yes'){
                                    $target = 1;
                                }else{
                                    $target = 0;
                                }
                                    $fetchData = array('outlet_name' => $outlet_name, 'region' => $region,'location_name'=>$location_name,'latitude' => $latitude,'longitude' => $longitude,'gps' => $target,'account_name'=>$account_name);
                                                  
                                                
                                $result=$this->Common_model->update_for_all($fetchData,'tbl_outlet_master',$unique_code,'unique_code');
                            //   echo $this->db->last_query();
                            //     exit;
                                    //$duplicate_data  += 1;
                                
        
                            }else{
                                $success_r += 1;
                                if($target == 'Yes'){
                                    $target = 1;
                                }else{
                                    $target = 0;
                                }
                                $fetchData = array('outlet_name' => $outlet_name, 'region' => $region,'location_name'=>$location_name,'latitude' => $latitude,'longitude' => $longitude,'gps' => $target,'unique_code'=>$unique_code,'account_name'=>$account_name);
                                                $result=$this->Common_model->save_data($fetchData,'tbl_outlet_master');

                            }
                        }
                         $total_row += 1;
                    }  
                    // echo '<pre>';print_r($fetchData);
                     //exit;
                    //$data['employeeInfo'] = $fetchData;
                    // if(!empty($fetchData)){
                    //     // echo '<pre>';print_r($fetchData);
                    //     // exit;
                    // $this->Common_model->setBatchImport($fetchData);
                    // $this->Common_model->importData2();
                    // }
                    $msg = "File uploaded successfully. No. of Rows is ".$total_row.", Success: ".$success_r." and Failed: ".$error_r." duplicate row: ".$duplicate_data;
                     $this->session->set_flashdata('msg',$msg);
                } else {
                    //echo "Please import correct file";
                    $this->session->set_flashdata('error_msg','Please import correct file');
                }
                
                redirect(base_url('Product/outlet_master'));
            
               
          }else{
              $this->session->set_flashdata('error_msg','Please import correct file');
              redirect(base_url('Product/outlet_master'));
          }
        }else{
             // $this->session->set_flashdata('error_msg','File is required');
              redirect(base_url('Product/outlet_master'));
         }
           
     }
     public function checkFileValidation($string) {
      $file_mimes = array('text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain',
        'application/wps-office.xlsx',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
      );
    if(isset($_FILES['fileUpload']['name'])) {
            $arr_file = explode('.', $_FILES['fileUpload']['name']);
            $extension = end($arr_file);
           // echo $_FILES['fileUpload']['type'];
          //  exit;
            if(($extension == 'xlsx' || $extension == 'xls' || $extension == 'csv') && in_array($_FILES['fileUpload']['type'], $file_mimes)){
                
                return true;
            }else{
                $this->session->set_flashdata('error_msg', "Please select only xlsx/csv/xls");
                return false;
            }
        }else{
            $this->session->set_flashdata('error_msg', "Please choose a file to upload.");
            return false;
        }
    }
      



    public function product(){
     $id = $this->uri->segment(3);  
     $data['Product'] = $this->Common_model->get_run("SELECT * FROM `tbl_masterdata` "); 
     $data['main']='Product/product';
     $this->load->view('common/template',$data);        
    }
    public function master2(){
     $id = $this->uri->segment(3);  
     $data['Product'] = $this->Common_model->get_run("SELECT * FROM `tbl_masterdata2` "); 
     $data['main']='Product/master2';
     $this->load->view('common/template',$data);        
    }
     public function master3(){
     $id = $this->uri->segment(3);  
     $data['Product'] = $this->Common_model->get_run("SELECT * FROM `tbl_masterdata3` "); 
     $data['main']='Product/master3';
     $this->load->view('common/template',$data);        
    }
    
     public function outlet_master(){
     $id = $this->uri->segment(3);  
     $data['Product'] = $this->Common_model->get_run("SELECT * FROM  `tbl_outlet_master` "); 
     $data['main']='Product/outlet_master';
     $this->load->view('common/template',$data);        
    }

    public function add_product(){
     $id = $this->uri->segment(3);  
     $data['edit_product'] = $this->Common_model->get_run("SELECT * FROM `tbl_product` where id = '$id'"); 
     $data['main']='Product/add_product';
     $this->load->view('common/template',$data);     
    }

    public function save_product(){
     $tbl_product   = 'tbl_product';
             $id = $this->uri->segment(3);  

        $save_product      = array(
                  'productCode'    =>$this->input->post('productCode'),
                  'address'    =>$this->input->post('address'),
                  'availableFrom'    =>$this->input->post('availableFrom'),
                  'height'    =>$this->input->post('height'),
                  'width'    =>$this->input->post('width'),
                  'productType'    =>$this->input->post('productType'),
                  'availableTo'    =>$this->input->post('availableTo'),
                  'price'    =>$this->input->post('price'),
                  'gstin'    =>$this->input->post('gstin'),
                  'discount'    =>$this->input->post('discount'),
                  'includePrinting'    =>$this->input->post('includePrinting'),
                  'location'    =>$this->input->post('location'),
                  'otherInformation'    =>$this->input->post('otherInformation'),
                  'status'=>$this->input->post('status'),
                  'user_id' =>$this->session->userdata('id'),
                  'lat' =>$this->input->post('lat'),
                  'lng' =>$this->input->post('lng')
        );
        
        
         $image = $_FILES['image']['name'];
                    if (!empty($image)) {
                        $img=time().$_FILES['image']['name'];
                        $path ='images/product_image/';
                        $img_tmp=$_FILES['image']['tmp_name'];
                         $move_upload = move_uploaded_file($img_tmp,$path.$img);
                        if ($move_upload > 0) {
                         $category_image = $path.$img;
                         $save_product['productImage'] = $category_image;
                        }
                    }
                    if (!empty($id)) {
                $result=$this->Common_model->update_data($save_product,$tbl_product,$id);
                    }else{

                $result=$this->Common_model->save_data($save_product,$tbl_product);
                    }
        
        if($result > 0){
              if (!empty($id)) {
                    $this->session->set_flashdata('msg','Product update Successfully');
             redirect(base_url('Product/product'));
              }else{
            $this->session->set_flashdata('msg','Product Add Successfully');
             redirect(base_url('Product/product'));
              }
        }
        else{
            $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
            if (!empty($id)) {
                 redirect(base_url('Product/edit_product'));
            }else{
            redirect(base_url('Product/add_product'));
            }
        }       
    }
    
    public function edit_product(){
     $id = $this->uri->segment(3);  
     $data['edit_product'] = $this->Common_model->get_run("SELECT * FROM `tbl_product` where id = '$id'"); 
     $data['main']='Product/edit_product';
     $this->load->view('common/template',$data);        
    }

    public function update_product(){
         $id = $this->uri->segment(3);  
        $tbl_product   = 'tbl_product';
       
        $update_product      = array(
                  'product_price'    =>$this->input->post('product_price'),
                  'product_name'    =>$this->input->post('product_name'),
                  'product_name_hindi'    =>$this->input->post('product_name_hindi'),
                  'status'=>$this->input->post('status')
        );

        $result=$this->Common_model->update_data($update_product,$tbl_product,$id);
        
        if($result > 0){
            $this->session->set_flashdata('msg','Product Add Successfully');
             redirect(base_url('Product/product'));
        }
        else{
            $this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');
            redirect(base_url('Product/edit_product'));
        }           
    }

    public function delete_product(){
     $id=$this->uri->segment(3);
        $tbl_product='tbl_product';
        if (!empty($id)) {
            $result=$this->Common_model->do_delete($tbl_product,$id);
        }
        if($result>0){
         $this->session->set_flashdata('msg','Delete Successfully');
         redirect(base_url('Product/product'));
        }
        else{
          $this->session->set_flashdata('error_msg','Delete Failed');
          redirect(base_url('Product/product'));
        }   
    }


    public function update_status(){
       $table = "tbl_product"; 
       $id= $this->input->post("id");
       $status= $this->input->post("status");
       $update = array(
       'status'=>$status
       );
       // print_r($update);
       $result = $this->Common_model->update_data($update,$table,$id);
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
    
      function export_data($response , $header , $sheetname){
           if($response ==0 ){
                $response = array("0"=>"No record");
           }

            ob_end_clean();
            ob_start();
            $this->load->library("excel");
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);
            $j=65;
            $z=1;
            //$alphas = range('A', 'Z');
           // echo '<pre>';print_r($alphas);
            //exit;

             //echo '<pre>';print_r($header);
        // exit;
//             for($i=0;$i<=sizeof($header);$i++){
//               // echo $j.'============='.fmod($j, 26);
// //echo '</br>';
// //echo chr($j).$z, $header[$i].'</br>';
//               $objPHPExcel->getActiveSheet()->SetCellValue(chr($j).$z, $header[$i]);
//              if($j == 90){
//                  $z++;
//                  $j=64;
//              }
          
//               $j++;

//             }  
//             //echo '<pre>';print_r($objPHPExcel);
//             //exit;
//             // set Row
//             $rowCount = 2;
        
//             foreach($response as $export_response=>$export_response_1) {
//                 $o=65;
           
//                 foreach ($export_response_1 as $response_1) {
//   // echo chr($o).$rowCount, $response_1;
//                     $objPHPExcel->getActiveSheet()->SetCellValue(chr($o).$rowCount, $response_1);
//                     if($o == 90){
//                  $o=64;
//                 // $j=64;
//              }
//                      $o++;
//                 }
            
               
//                 $rowCount++;

//             }
//exit;

    // $rowNumber=10;


    // foreach($export_response_1 as $response_1){
    //     foreach($response_1 as $respons){
    //      $objPHPExcel->getActiveSheet()->SetCellValue('b'.$rowNumber, $respons);
    //               $rowNumber++;

    //     }

    // }
    $row = 1; // 1-based index
$col = 0;

foreach ($header as $heade => $hea){
    
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $hea);
                        $col++;
                       
}
    $row = 2; // 1-based index
$col = 0;            
      foreach ($response as $order_id => $order)
                {
                    
                       foreach($order as $ord){
                          // echo $row . ", ". $col . "<br>";
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $ord);
                        $col++;
                       }
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['legal_entity']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['restaurant_name']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['payment_method']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['order_number']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['date_created']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['customer_name']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['order_type']);
                        // $col++;
                        // $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $order['amount']);
                        $row++;
                                               // echo $row . ", ". $col . "<br>";

                        $col = 0;
                }
//$objPHPExcel->getActiveSheet()->getStyle(1)->getFont()->setBold(true);

        //Create Styles Array
        $styleArrayFirstRow = [
                    'font' => [
                        'bold' => true,
                    ]
                ];
        
        //Retrieve Highest Column (e.g AE)
        $highestColumn = $objPHPExcel->getActiveSheet()->getHighestColumn();
        
        //set first row bold
        $objPHPExcel->getActiveSheet()->getStyle('A1:' . $highestColumn . '1' )->applyFromArray($styleArrayFirstRow);
            $filename = $sheetname. date("Y-m-d-H-i-s").".xls";
            ob_end_clean();
            header( "Content-type: application/vnd.ms-excel" );
            //header('Content-Disposition: attachment; filename="test.xls"');
             header('Content-Disposition: attachment;filename="'.$filename.'"');
            header("Pragma: no-cache");
            header("Expires: 0");
            ob_end_clean();
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
           
            $objWriter->save('php://output');
            exit;




   
    }
   function sellout_list($page = 0) {
        
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
        
        if($this->session->userdata('role') == 1)
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
            if($this->session->userdata('role') == 1)
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
        
       
        

        $data['main']='Product/sellout_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function sellout_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "sellout";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/sellout_detail';
        $this->load->view('common/template',$data);     
    }
    
    
     function display_by_model_count_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
         $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `display_by_model_count`");
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
           if($this->session->userdata('role') == 1)
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
            
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
        
            $table = 'display_by_model_count';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
            //$myNewOrder = ['outlet_name','region','name'];
            $myNewOrder = [];
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
                                if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Category';
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Model Number';
                                    $myNewOrder[] = 'Display type';
                                    $myNewOrder[] = 'Quantity';
                                }

                                //} 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
                
                 $total_count = 0;
                 foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                            $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              
                              $result['Category'] =  $result1['category'];
                              
                             
                             $result['Brand'] = $result1['brand'];
                            
                           
                             $result['Model Number'] = $result1['model'];
                             
                            
                            $result['Display type'] =  $result1['display_type'];
                            
                            
                             $result['Quantity'] = $result1['quantity'];
                            
                             $export_response[] = $result;

                        }
                      
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
    
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
            $sheetname = 'Display_by_model_count';
            //$header = explode('$$$$', $export_header);
    //echo '<pre>';print_r($export_header);
   // echo '<pre>';print_r($header);
               //  exit;
            // unset($header[sizeof($header)]);
            // unset($header[3]);
            //  echo '<pre>';print_r($header);
            //  exit;
           // echo '<pre>';print_r($header);
            $header = $myNewOrder;
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'display_by_model_count';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
          // echo $this->db->last_query();
           //exit;
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/display_by_model_count_list';
      
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
        
       
        
        $data['main']='Product/display_by_model_count_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function display_by_model_count_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "display_by_model_count";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/display_by_model_count_detail';
        $this->load->view('common/template',$data);     
    }
    
     function display_share_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `display_share`");
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'display_share';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
        
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            //$myNewOrder = ['outlet_name','region','name'];
            $myNewOrder = [];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                               $index_array = ['1','2','3','4','5'];
                                //for ($x = 0; $x <$data['max_count']; $x++) {
                                if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Category';
                                    $myNewOrder[] = 'Segment';
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Number of Display';
                                    $myNewOrder[] = 'Total Number of Display';
                                    
                                   
                                }
                                //} 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
                //$myNewOrder = ['outlet_name','region','date'];
                
                $total_count = 0;
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                            $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              
                              $result['Category'] =  $result1['category'];
                             
                            $result['Segment'] =  $result1['segment'];
                             $result['Brand'] = $result1['brand'];
                            
                             
                             $result['Number of Display'] = $result1['number_of_display'];
                              
                             
                            $result['Total Number of Display'] =  $result1['total_number_of_display'];
                            
                              
                              $export_response[] = $result;
                              
                             
                        }
                       
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
                
                if($total_count == 0){
                    $export_response[] = $result;
                }
               
            }
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
         
            $sheetname = 'Display_share';
            //$header = explode('$$$$', $export_header);
            $header = $myNewOrder;
            //unset($header[sizeof($header)]);
            //unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'display_share';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/display_share_list';
      
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
        
       
        
        $data['main']='Product/display_share_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function display_share_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "display_share";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/display_share_detail';
        $this->load->view('common/template',$data);     
    }
    
     function special_fixture_count_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `special_fixture_count`");
        if(!empty($max_count))
        $data['max_count'] = $max_count['max_count'];
        else
        $data['max_count'] = 0;
        
        
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'special_fixture_count';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            //$myNewOrder = ['outlet_name','region','name'];
            $myNewOrder = [];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                               // for ($x = 0; $x <$data['max_count']; $x++) {
                               if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Type of fixture';
                                    $myNewOrder[] = 'Count';
                                    $myNewOrder[] = 'Condition of fixture';
                                    $myNewOrder[] = 'Remarks';

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
               // $myNewOrder = ['outlet_name','region','date'];
                $total_count = 0;
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Brand'] =  $result1['brand'];
                             $result['Type of fixture'] = $result1['type_fixture'];
                             
                             $result['Count'] = $result1['count'];
                             
                            $result['Condition of fixture'] =  $result1['condition_fixture'];
                            
                             $result['Remarks'] = $result1['remark'];
                            $export_response[] = $result;
                             
                        }
                       
                       // $result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
         
            $sheetname = 'Special_fixture_count';
            //$header = explode('$$$$', $export_header);
    $header = $myNewOrder;

            //unset($header[sizeof($header)]);
            //unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'special_fixture_count';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/special_fixture_count_list';
      
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
        
       
        
        $data['main']='Product/special_fixture_count_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function special_fixture_count_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "special_fixture_count";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/special_fixture_count_detail';
        $this->load->view('common/template',$data);     
    }
    
     function brand_promoter_count_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        
         $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `brand_promoter_count`");
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
           if($this->session->userdata('role') == 1)
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
        
            $table = 'brand_promoter_count';
            $select = "outlet_name as Outlet Name,account_name as Account Name,
region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";

            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            //$myNewOrder = ['outlet_name','region','name'];
            $myNewOrder = [];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'id'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                               // for ($x = 0; $x <$data['max_count']; $x++) {
                               if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Distributor';
                                    $myNewOrder[] = 'Dedicated Brand';
                                    $myNewOrder[] = 'MDA';
                                    $myNewOrder[] = 'SDA';

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }

            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
                //$myNewOrder = ['outlet_name','region','date'];
                
               $total_count = 0;
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Brand'] =  $result1['brand'];
                             $result['Distributor'] = $result1['distributor'];
                             
                             $result['Dedicated Brand'] = $result1['dedicated_brand'];
                             
                            $result['MDA'] =  $result1['mda'];
                            
                             $result['SDA'] = $result1['sda'];
                            
                             $export_response[] = $result;
                        }
                       
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
    
             if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
            $sheetname = 'Brand_promoter_count';
           // $header = explode('$$$$', $export_header);
    
           // unset($header[sizeof($header)]);
           // unset($header[3]);
           // echo '<pre>';print_r($header);
           $header = $myNewOrder;
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'brand_promoter_count';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/brand_promoter_count_list';
      
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
        
       
        
        $data['main']='Product/brand_promoter_count_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function brand_promoter_count_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "brand_promoter_count";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/brand_promoter_count_detail';
        $this->load->view('common/template',$data);     
    }
    
     function price_tracker_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `price_tracker`");
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'price_tracker';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            //$myNewOrder = ['outlet_name','region'];
            $myNewOrder = [];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'id'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                                //for ($x = 0; $x <$data['max_count']; $x++) {
                                if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Category';
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Segment';
                                    $myNewOrder[] = 'Model Number';
                                    $myNewOrder[] = 'RRP(AED)';
                                    $myNewOrder[] = 'OFFER PRICE(AED)';

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }

            
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
                //$myNewOrder = ['outlet_name','region','date'];
                $total_count = 0;
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Category'] =  $result1['category'];
                             $result['Brand'] = $result1['brand'];
                             
                             $result['Segment'] = $result1['segment'];
                             
                            $result['Model Number'] =  $result1['model_number'];
                            
                             $result['RRP(AED)'] = $result1['rrp'];
                              $result['OFFER PRICE(AED)'] = $result1['offer_price'];
                            
                             $export_response[] = $result;
                        }
                       
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
    
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
            $sheetname = 'Price_tracker';
            //$header = explode('$$$$', $export_header);
    
            //unset($header[sizeof($header)]);
            //unset($header[3]);
           // echo '<pre>';print_r($header);
           $header = $myNewOrder;
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'price_tracker';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/price_tracker_list';
      
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
        
       
        
        $data['main']='Product/price_tracker_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function price_tracker_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "price_tracker";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/price_tracker_detail';
        $this->load->view('common/template',$data);     
    }
    
     function market_sensing_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `market_sensing`");
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
           if($this->session->userdata('role') == 1)
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
        
            $table = 'market_sensing';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
           // $myNewOrder = ['outlet_name','region'];
           $myNewOrder = [];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images' && $k != 'id'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                                //for ($x = 0; $x <$data['max_count']; $x++) {
                                if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Activity Type';
                                    $myNewOrder[] = 'Remarks';
                                   

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
                //$myNewOrder = ['outlet_name','region','date'];
                $total_count = 0;
                foreach($myNewOrder as $key){
                   if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Brand'] =  $result1['brand'];
                             $result['Activity Type'] = $result1['activity_type'];
                             
                             $result['Remarks'] = $result1['remark'];
                             
                           
                            $export_response[] = $result;
                             
                        }
                       
                       // $result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                }
    
               //$export_response[$i] = $result;
                if($total_count == 0){
                    $export_response[] = $result;
                }
            }
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
         
            $sheetname = 'Market_sensing';
           // $header = explode('$$$$', $export_header);
            $header = $myNewOrder;
           // unset($header[sizeof($header)]);
          //  unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'market_sensing';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/market_sensing_list';
      
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
        
       
        
        $data['main']='Product/market_sensing_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function market_sensing_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "market_sensing";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/market_sensing_detail';
        $this->load->view('common/template',$data);     
    }
    
     function store_image_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        
        $select = "outlet_name,region,date,id";
        
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
            if($this->session->userdata('role') == 1)
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
        
            $table = '300_store_image';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
                $myNewOrder = ['outlet_name','region','date'];
                
                foreach($myNewOrder as $key){
                    if($key == 'date')
                     $result[$key] =  getNumericDateFormat($invoice_data_val[$i][$key]);
                    else
                        $result[$key] = $invoice_data_val[$i][$key];
                }
    
               $export_response[$i] = $result;
            }
    
         
            $sheetname = '300_store_image';
            $header = explode('$$$$', $export_header);
    
            unset($header[sizeof($header)]);
            unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = '300_store_image';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/store_image_list';
      
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
        
       
        
        $data['main']='Product/300_store_image_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function store_image_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "300_store_image";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/300_store_image_detail';
        $this->load->view('common/template',$data);     
    }
    
     function display_and_deployment_tracker_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `display_and_deployment_tracker`");
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
           if($this->session->userdata('role') == 1)
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
        
            $table = 'display_and_deployment_tracker';
             $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            //$myNewOrder = ['outlet_name','region'];
             $myNewOrder = [];
            if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images_posm_before' &&  $k != 'images_posm_after' && $k != 'id'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                                //for ($x = 0; $x <$data['max_count']; $x++) {
                                if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Category';
                                    $myNewOrder[] = 'Brand';
                                   

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
               // $myNewOrder = ['outlet_name','region','date'];
                $total_count = 0;
                foreach($myNewOrder as $key){
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                             $result['Category'] = $result1['category'];
                             
                              $result['Brand'] =  $result1['brand'];
                             
                            $export_response[] = $result;

                            
                             
                        }
                       
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
    
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
            $sheetname = 'Display_and_deployment_tracker';
           // $header = explode('$$$$', $export_header);
    
           // unset($header[sizeof($header)]);
           // unset($header[3]);
           // echo '<pre>';print_r($header);
           $header = $myNewOrder;
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'display_and_deployment_tracker';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/display_and_deployment_tracker_list';
      
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
        
       
        
        $data['main']='Product/display_and_deployment_tracker_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function display_and_deployment_tracker_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "display_and_deployment_tracker";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/display_and_deployment_tracker_detail';
        $this->load->view('common/template',$data);     
    }
    
     function voc_list($page = 0) {
        
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
       if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `voc`");
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'voc';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            $myNewOrder = [];
            //$myNewOrder = ['outlet_name','region'];
  if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'id' &&  $k != 'images'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                               // for ($x = 0; $x <$data['max_count']; $x++) {
                               if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'VOC Type';
                                    $myNewOrder[] = 'Comments';
                                    

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
               // $myNewOrder = ['outlet_name','region','date'];
                
               foreach($myNewOrder as $key){
                    
                    $total_count = 0;
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['VOC Type'] =  $result1['voc'];
                             $result['Comments'] = $result1['comment'];
                             
                               $export_response[] = $result;

                            
                             
                        }
                       
                       // $result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
         
            $sheetname = 'Voc';
           // $header = explode('$$$$', $export_header);
     $header = $myNewOrder;

            //unset($header[sizeof($header)]);
            //unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'voc';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/voc_list';
      
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
        
       
        
        $data['main']='Product/voc_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function voc_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "voc";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/voc_detail';
        $this->load->view('common/template',$data);     
    }
    
     function market_issues_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `market_issues`");
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'market_issues';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";

            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            $myNewOrder = [];
            //$myNewOrder = ['outlet_name','region'];
              if(!empty($invoice_data_val)){
                            foreach($invoice_data_val[0] as $k => $r){
                                if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images'){
                                    if($k != 'add_more_array' && $k != 'add_more_array_count'){
                                        $myNewOrder[] = $k;
                                    }else{
                                       
                                        if($k == 'add_more_array_count'){
                                          // echo $data['max_count'];
                                          // $index_array = ['1','2','3','4','5'];
                                          //  for ($x = 0; $x <$data['max_count']; $x++) {
                                          if($data['max_count'] > 0){
                                                $y = $x + 1;
                                                $myNewOrder[] = 'Category';
                                                $myNewOrder[] = 'Brand';
                                                $myNewOrder[] = 'No Display Model';
                                                $myNewOrder[] = 'New Fixture OPP';
                                                $myNewOrder[] = 'New Branding OPP';
            
                                            } 
                                             $myNewOrder[] = $k;
                                        }
                                    }
                                }
                            }
                        }
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
              //  $myNewOrder = ['outlet_name','region','date'];
                
                foreach($myNewOrder as $key){
                    
                    $total_count = 0;
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Category'] =  $result1['category'];
                             $result['Brand'] = $result1['brand'];
                             
                             $result['No Display Model'] = $result1['no_display_model'];
                             
                            $result['New Fixture OPP'] =  $result1['new_fixture_opp'];
                            
                             $result['New Branding OPP'] = $result1['new_branding_opp'];
                            $export_response[] = $result;
                             
                        }
                       
                       // $result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
    
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
            $sheetname = 'Market_issues';
            //$header = explode('$$$$', $export_header);
            $header = $myNewOrder;
            //unset($header[sizeof($header)]);
            //unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'market_issues';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/market_issues_list';
      
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
        
       
        
        $data['main']='Product/market_issues_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function market_issues_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "market_issues";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/market_issues_detail';
        $this->load->view('common/template',$data);     
    }
    
    function training_tracker_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `training_tracker`");
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'training_tracker';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            $myNewOrder = [];
            //$myNewOrder = ['outlet_name','region'];
          if(!empty($invoice_data_val)){
                        foreach($invoice_data_val[0] as $k => $r){
                            if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images'){
                                if($k != 'add_more_array' && $k != 'add_more_array_count'){
                                    $myNewOrder[] = $k;
                                }else{
                                   
                                    if($k == 'add_more_array_count'){
                                      // echo $data['max_count'];
                                      // $index_array = ['1','2','3','4','5'];
                                       // for ($x = 0; $x <$data['max_count']; $x++) {
                                       if($data['max_count'] > 0){
                                            $y = $x + 1;
                                            $myNewOrder[] = 'Category';
                                            $myNewOrder[] = 'Brand';
                                            $myNewOrder[] = 'Model Number';
                                            $myNewOrder[] = 'Promoter Type';
                                            $myNewOrder[] = 'Promoter Name';
        
                                        } 
                                         $myNewOrder[] = $k;
                                    }
                                }
                            }
                        }
                    }

            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
               // $myNewOrder = ['outlet_name','region','date'];
                $total_count = 0;
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Category'] =  $result1['category'];
                             $result['Brand'] = $result1['brand'];
                             
                             $result['Model Number'] = $result1['model'];
                             
                            $result['Promoter Type'] =  $result1['promoter_type'];
                            
                             $result['Promoter Name'] = $result1['promoter_name'];
                             $export_response[] = $result;
                            
                             
                        }
                       
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
    
    
                if($total_count == 0){
                    $export_response[] = $result;
                }
            }
    
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
            $sheetname = 'Training_tracker';
            //$header = explode('$$$$', $export_header);
     $header = $myNewOrder;

            //unset($header[sizeof($header)]);
           // unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'training_tracker';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/training_tracker_list';
      
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
        
       
        
        $data['main']='Product/training_tracker_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function training_tracker_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "training_tracker";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/training_tracker_detail';
        $this->load->view('common/template',$data);     
    }
    
    function stock_out_list($page = 0) {
        
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
        if($this->session->userdata('role') == 1)
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
        $max_count = $this->Common_model->get_run_one("SELECT MAX(add_more_array_count)  as max_count  FROM `stock_out`");
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
            if($this->session->userdata('role') == 1)
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
        
            $table = 'stock_out';
            $select = "outlet_name as Outlet Name,account_name as Account Name,region as Region,date as Date,username as User Name,add_more_array_count,add_more_array";
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            $myNewOrder = [];
            //$myNewOrder = ['outlet_name','region'];
             if(!empty($invoice_data_val)){
                foreach($invoice_data_val[0] as $k => $r){
                    if($k != 'outlet_name' && $k != 'region' && $k != 'name' &&  $k != 'images'){
                        if($k != 'add_more_array' && $k != 'add_more_array_count'){
                            $myNewOrder[] = $k;
                        }else{
                           
                            if($k == 'add_more_array_count'){
                              // echo $data['max_count'];
                              // $index_array = ['1','2','3','4','5'];
                                //for ($x = 0; $x <$data['max_count']; $x++) {
                                if($data['max_count'] > 0){
                                    $y = $x + 1;
                                    $myNewOrder[] = 'Category';
                                    $myNewOrder[] = 'Brand';
                                    $myNewOrder[] = 'Model Number';
                                    

                                } 
                                 $myNewOrder[] = $k;
                            }
                        }
                    }
                }
            }
            
            for($i=0;$i<=sizeof($invoice_data_val);$i++){
    
               // $myNewOrder = ['outlet_name','region','date'];
                $total_count = 0;
               
                foreach($myNewOrder as $key){
                    
                    
                    if($key == 'add_more_array_count'){
                               
                        $add_more_array = unserialize(base64_decode($invoice_data_val[$i]['add_more_array']));
                        //echo '<pre>';print_r($add_more_array);
                        //echo '</br>';
                         $total_count = count($add_more_array);
                     
                         $max_data_count = 0;
                        
                        if($data['max_count'] != $total_count){
                            $max_data_count = $data['max_count'] - $total_count;
                            
                           // echo $max_data_count = $max_data_count + $total_count;
                        }
                      //$index_array = ['1','2','3','4','5'];
                        for ($j = 0; $j < $total_count; $j++) {
                           $z= $j + 1;
                             $result1 = json_decode($add_more_array[$j],true);
                              $result['Category'] =  $result1['category'];
                             $result['Brand'] = $result1['brand'];
                             
                             $result['Model Number'] = $result1['model_number'];
                             $export_response[] = $result;
                          
                            
                             
                        }
                       
                        //$result[$key] = $invoice_data_val[$i][$key];
                    }else{
                    
                        $result[$key] = $invoice_data_val[$i][$key];
                    }
                    
                    
                }
               if($total_count == 0){
                    $export_response[] = $result;
                }
            }
        
            if (($key = array_search('add_more_array_count', $myNewOrder)) !== false) {
                unset($myNewOrder[$key]);
            }
         
            $sheetname = 'Stock_out';
             $header = $myNewOrder;

          //  $header = explode('$$$$', $export_header);
    
            //unset($header[sizeof($header)]);
         //   unset($header[3]);
           // echo '<pre>';print_r($header);
            if(!empty($invoice_data_val)){
                $this->export_data($export_response , $header , $sheetname);
            }
            
        }else{
            
            $table = 'stock_out';
            $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);
           //echo $this->db->last_query();
            $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
           // echo $this->db->last_query();
            $count_invoice = 0;
            if(!empty($invoice_total)){
                $count_invoice = count($invoice_total);
            }
            
        }    
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/stock_out_list';
      
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
        
       
        
        $data['main']='Product/stock_out_list';
        $this->load->view('common/template',$data);     
    }

      
    
    function stock_out_detail(){
        $id = $this->uri->segment(3);
        
        $select = "*";
        $table = "stock_out";
        $con = array('id' => $id);
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='Product/stock_out_detail';
        $this->load->view('common/template',$data);     
    }
    
    function images_list(){
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
        if($this->session->userdata('role') == 1)
             $con = "1=1 ";
        else
          $con = "1=1 and `om.user` in (".$this->all_username_data.") ";
          if(!empty($search_term)){
                    //$serach_parameter = explode(" ",$search_term);
                    $serach_parameter = $search_term;
                    //echo  $serach_parameter;
                    //exit;
                    if(!empty($serach_parameter))
                    {
                        $con .= " and ";
                        //foreach($serach_parameter as $k => $serach_param){
                          
                            $con .= "( om.region like '%".$serach_parameter."%' or om.outlet_name like '%".$serach_parameter."%') ";
                           
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
        
        $select = "`om`.`id` as main_id,si.id as si_main_id,ddt.id as ddt_main_id, om.outlet_name,om.account_name,om.region,om.user,om.new_date,st.image_array as sellout_report,sfc.add_more_array as special_fixture_count,ms.add_more_array as market_sensing,si.add_more_array as store_image,ddt.add_more_array as display_and_deployment_tracker,tt.add_more_array as training_tracker";
        
        // if(!empty($sort)){
        //     if($sort['field_name'] == 'created_date'){
        //         $orderBy = " ".$sort['field_name'].' '. $sort['field_value'];
        //     }
        //     else{
        //         $orderBy = $sort['field_name'].' '. $sort['field_value'];
        //     }
        // }else{
            $orderBy = "om.id  " . $by;

       // }
        
       
            
        $table = 'tbl_masterdata3 as om';
        $join = array(
                 array("table" => "sellout AS st", "relation" => "om.outlet_name = st.outlet_name", "type" => "left"),
                 array("table" => "special_fixture_count AS sfc", "relation" => "sfc.outlet_name = om.outlet_name", "type" => "left"),
                 array("table" => "market_sensing AS ms", "relation" => "om.outlet_name = ms.outlet_name", "type" => "left"),
                 array("table" => "300_store_image AS si", "relation" => "om.outlet_name = si.outlet_name", "type" => "left"),
                 array("table" => "display_and_deployment_tracker AS ddt", "relation" => "om.outlet_name = ddt.outlet_name", "type" => "left"),
                 array("table" => "training_tracker AS tt", "relation" => "om.outlet_name = tt.outlet_name", "type" => "left"),
            );
 
        $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit,$join,null,TRUE,'om.outlet_name,om.new_date');
      
        $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, $join,null,TRUE,'om.outlet_name,om.new_date');
       // echo $this->db->last_query();
        $count_invoice = 0;
        if(!empty($invoice_total)){
            $count_invoice = count($invoice_total);
        }
            
          
            


        

     

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'product/images_list';
      
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
      
        $data['main']='Product/images_list';
        $this->load->view('common/template',$data);     
    }
    function show_images(){
        $diff = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        if($diff == 'display_and_deployment_tracker'){
            $select = "*";
            $table = "display_and_deployment_tracker";
            $con = array('id' => $id);
            $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
            $data['result']=$result;
                    $data['main']='Product/ddt_show_images';

        }else{
            $select = "*";
            $table = "300_store_image";
            $con = array('id' => $id);
            $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
            $data['result']=$result;
            $data['main']='Product/store_show_images';
        
        }
        
        
        $this->load->view('common/template',$data);     
    }
    function download_all_file(){
        $this->load->library('zip');
        $id = $this->uri->segment(3);
        
         $select = "`om`.`id` as main_id,si.id as si_main_id,ddt.id as ddt_main_id, om.outlet_name,om.account_name,om.region,om.user,om.new_date,st.image_array as sellout_report,sfc.add_more_array as special_fixture_count,ms.add_more_array as market_sensing,si.add_more_array as store_image,ddt.add_more_array as display_and_deployment_tracker,tt.add_more_array as training_tracker";
        
        // if(!empty($sort)){
        //     if($sort['field_name'] == 'created_date'){
        //         $orderBy = " ".$sort['field_name'].' '. $sort['field_value'];
        //     }
        //     else{
        //         $orderBy = $sort['field_name'].' '. $sort['field_value'];
        //     }
        // }else{
            $orderBy = "om.id  " . $by;

       // }
        
        if($this->session->userdata('role') == 1)
             $con = "1=1 and `om.id` = '".$id."' ";
        else
          $con = "1=1 and `om.id` = '".$id."' and `om.user` in (".$this->all_username_data.") ";
           $orderBy = "om.id  desc ";
            
        $table = 'tbl_masterdata3 as om';
        $join = array(
                 array("table" => "sellout AS st", "relation" => "om.outlet_name = st.outlet_name", "type" => "left"),
                 array("table" => "special_fixture_count AS sfc", "relation" => "sfc.outlet_name = om.outlet_name", "type" => "left"),
                 array("table" => "market_sensing AS ms", "relation" => "om.outlet_name = ms.outlet_name", "type" => "left"),
                 array("table" => "300_store_image AS si", "relation" => "om.outlet_name = si.outlet_name", "type" => "left"),
                 array("table" => "display_and_deployment_tracker AS ddt", "relation" => "om.outlet_name = ddt.outlet_name", "type" => "left"),
                 array("table" => "training_tracker AS tt", "relation" => "om.outlet_name = tt.outlet_name", "type" => "left"),
            );
 
        $row = $this->Common_model->getData($table, $select, $con, $orderBy, null, $join,null,false,'om.outlet_name,om.new_date');
       //echo $this->db->last_query();
        //echo '<pre>';print_r($result);
        //echo FCPATH.'upload/'.$id;
        // $filepath[] = FCPATH.'upload/'.$id;
        // $filepath[] = FCPATH.'upload/'.$id1;
        
        if(!empty($row['sellout_report'])){
                  
            $add_more_array = unserialize(base64_decode($row['sellout_report']));
            
            foreach($add_more_array as $k=>$resul){
                $rd = explode('images',$resul);
               $filepath[] = FCPATH.images.$rd[1];
                        
            } 
                    
                
        }
        if(!empty($row['special_fixture_count'])){
                  
            $add_more_array = unserialize(base64_decode($row['special_fixture_count']));
           // echo '<pre>';print_r( $add_more_array);
            foreach($add_more_array as $resultm){
                $result1 = json_decode($resultm,true);
                                 //   echo '<pre>';print_r( $result1);

                if($result1['images']){
                    $images = explode(',',$result1['images']);
                    foreach($images as $k=>$resul){
                       
                        $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1];
                    }
                }
                                                 
               
                        
            } 
                    
                
        }
        
        if(!empty($row['market_sensing'])){
                  
            $add_more_array = unserialize(base64_decode($row['market_sensing']));
           // echo '<pre>';print_r( $add_more_array);
            foreach($add_more_array as $resultm){
                $result1 = json_decode($resultm,true);
                                 //   echo '<pre>';print_r( $result1);

                if($result1['images']){
                    $images = explode(',',$result1['images']);
                    foreach($images as $k=>$resul){
                       $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                        
                    }
                }
                                                 
               
                        
            } 
                    
                
        }
         if(!empty($row['training_tracker'])){
                  
            $add_more_array = unserialize(base64_decode($row['training_tracker']));
           // echo '<pre>';print_r( $add_more_array);
            foreach($add_more_array as $resultm){
                $result1 = json_decode($resultm,true);
                                 //   echo '<pre>';print_r( $result1);

                if($result1['images']){
                    $images = explode(',',$result1['images']);
                    foreach($images as $k=>$resul){
                        
                        $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                        
                    }
                }
                                                 
               
                        
            } 
                    
                
        }
        if(!empty($row['store_image'])){
                  
            $add_more_array = unserialize(base64_decode($row['store_image']));
            //echo '<pre>';print_r( $add_more_array);
            foreach($add_more_array as $resultm){
                $result1 = json_decode($resultm,true);
                if($result1[0]['entrance_images']){
                    $entrance_images = explode(',',$result1[0]['entrance_images']);
                    foreach($entrance_images as $resul){
                    
                        $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                    
        
                    }
                    
                }
                if($result1[0]['appliance_images']){
                        $appliance_images = explode(',',$result1[0]['appliance_images']);
                    foreach($appliance_images as $resul){
                         $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                    }
                    
                }
                if($result1[0]['oppurtunity_images']){
                        $oppurtunity_images = explode(',',$result1[0]['oppurtunity_images']);

                    foreach($oppurtunity_images as $resul){
                         $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
        
                    }
                    
                }
                if($result1[0]['fixture_images']){
                    $fixture_images = explode(',',$result1[0]['fixture_images']);

                    foreach($fixture_images as $resul){
                         $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                    }
                
                }
                if($result1[0]['other_images']){
                    $other_images = explode(',',$result1[0]['other_images']);

                    foreach($other_images as $resul){
            
                             $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
      
                    }
                   
                }
                      
            } 
               
        }
        if(!empty($row['display_and_deployment_tracker'])){
                  
            $add_more_array = unserialize(base64_decode($row['display_and_deployment_tracker']));
            //echo '<pre>';print_r( $add_more_array);
            foreach($add_more_array as $resultm){
                $result = json_decode($resultm,true);
                                 //   echo '<pre>';print_r( $result1);

                 if($result['images_posm_before']){
                $images_posm_before = explode(',',$result['images_posm_before']);
                
                    foreach($images_posm_before as $resul){
                         $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                    }
                 }
            
                if($result['images_posm_after']){
                    $images_posm_after = explode(',',$result['images_posm_after']);
                    foreach($images_posm_after as $resul){
                         $rd = explode('images',$resul);
                        $filepath[] = FCPATH.images.$rd[1]; 
                    }
                 }
                  
            } 
                    
                
        }
       // echo '<pre>';print_r($filepath);
        // exit;
        //exit;
        
        foreach($filepath as $file) {
          $this->zip->read_file($file);
        }
      // $this->zip->archive($row['outlet_name'].$row['user'].$row['new_date'].'.zip');
        // // Download the file to your desktop. Name it "my_backup.zip"
        $this->zip->download($row['outlet_name'].$row['user'].$row['new_date'].'.zip');
    }
}