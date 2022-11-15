<?php
defined('BASEPATH') or exit('No direct script access allowed');
error_reporting(0);
class Form extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('upload');
        $this->load->library('session');

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
    public function get_pagination_config()
    {
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
    public function form_logout()
    {
        session_destroy();
        $this->session->set_flashdata('msg', 'Logout Successfully');
        redirect('form/form_login');
    }
    public function form_login()
    {
        $this->load->view('form/form_login');
    }
    public function login_check($email,$password)

	{

		$this->db->where('email',$email);

		$this->db->where('password',$password);

		$query = $this->db->get('tbl_admin');

		



		if($query->num_rows() == 1)  

		{


// $result[0]->role != 2 && 
			$result=$query->result();
            if($result[0]->type == 1){
    			$sessiondata = array(
    
    									'id'  =>$result[0]->id,
    
    									'username'  =>$result[0]->username,
    
    									'email'  =>$result[0]->email,
    
    									'role'  =>$result[0]->role,
    
    									'image'  =>$result[0]->image,
                                        'language'=>"en"           
    
    			                    );
    
    			$this->session->set_userdata($sessiondata);
    
    			return $result[0]->id;
            }else{
                return '-1';
            }
		} 

		else

		{		

     		return false;

		}

	}
    public function form_login_check()
    {
        $table = 'tbl_admin';
        $usermail = $this->input->post('email');
        $passwords = $this->input->post('password');
        $password = md5($passwords);
        $result = $this->login_check($usermail, $password);

        if ($result > 0) {

            $this->session->set_flashdata('msg', 'Login Successfully');
            redirect(base_url('form/newspapper_index'));

        } else {
            if ($result == '-1') {
                $this->session->set_flashdata('error_msg', "You don't have permission to login");
            } else {
                $this->session->set_flashdata('error_msg', 'Invalid Email ID or Password');
            }

            redirect(base_url('form/form_login'));
        }
    }
    public function newspapper_index()
    {
        $user_id = $this->session->userdata('id');
        if ($user_id) {
            $msgs = $this->Common_model->get_run("SELECT * FROM tbl_msg where DATE(`created_date`) = CURDATE()  ORDER BY created_date DESC");
            // print_r($msgs);
            $current_user_msgs = [];
            if (!empty($msgs)) {
                foreach ($msgs as $msg) {
                    if (in_array($user_id, explode(',', $msg["sending_msg_user"]))) {
                        array_push($current_user_msgs, $msg);
                    }
                }
            }
            // print_r($current_user_msgs);
            $data['main'] = 'form/newspapper';
            $data['user_msgs'] = $current_user_msgs;
            $this->load->view('form/template', $data);
        }
    }
    public function sellout_list($page = 0)
    {

        $export = isset($_POST['export']) ? $_POST['export'] : "0";
        $record_count = isset($_POST['record_count']) ? $_POST['record_count'] : "0";
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

        // if ($this->session->userdata('role') == 1 || $this->session->userdata('role') == 5) {
        //     $con = "1=1 ";
        // } else {
            // $con = "1=1 and `user_id` in (" . $this->all_user_data . ") ";
        // }

        $select = "*";

        $max_count = $this->Common_model->get_run_one("SELECT MAX(outlet_name)  as max_count  FROM `tbl_masterdata3`");
        if (!empty($max_count)) {
            $data['max_count'] = $max_count['max_count'];
        } else {
            $data['max_count'] = 0;
        }

        $select = "id,outlet_name,account_name,region,visit_status,(select longitude from tbl_outlet_master where outlet_name=tbl_masterdata3.outlet_name) as longitude,(select latitude from tbl_outlet_master where outlet_name=tbl_masterdata3.outlet_name) as latitude";
        $table = 'tbl_masterdata3';
        $con = "1=1 and `user` in ('" . $this->session->userdata('email')."','". $this->session->userdata('username') . "') ";
        $invoice_data_val = array_unique($this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit));
        $invoice_total = array_unique($this->Common_model->getData($table, $select, $con, $orderBy, null, null));
        // echo $this->db->last_query();
        $count_invoice = 0;
        if (!empty($invoice_total)) {
            $count_invoice = count($invoice_total);
        }

        $allcount = $count_invoice;
        $config = $this->get_pagination_config();
        $config['base_url'] = base_url() . 'form/sellout_list';

        $config['total_rows'] = $allcount;
        $config['per_page'] = $limit;
        $config['use_page_numbers'] = true;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $invoice_data_val;
        $data['row'] = $page;

        $data['record_count'] = $allcount;

        // echo '<pre>';print_r($data['result']);
        //exit;

        $data['main'] = 'form/sellout_list';
        $this->load->view('form/template', $data);
    }
    function sellout_detail(){
        $id = $this->uri->segment(3);
        $row = $this->Common_model->getData("tbl_masterdata3", "outlet_name", array('id' => $id));
        $select = "*";
        $table = "sellout";
        $con = array('outlet_name' => $row[0]["outlet_name"],'user_id' =>  $this->session->userdata('id'));
        $result = $this->Common_model->getData($table, $select, $con, NULL, null, null,null,false);
        
        $data['result']=$result;
        $data['main']='form/sellout_detail';
        $this->load->view('form/template',$data); 	
    }
    public function sellout_form()
    {
        $id = $this->uri->segment(3);
        $row=$this->Common_model->getData("tbl_masterdata3", "outlet_name", array('id' => $id), null, null, null, null, false);
        $select = "*";
        $table = "tbl_outlet_master";
        $con = array('outlet_name' => $row['outlet_name']);
        $result = $this->Common_model->getData($table, $select, $con, null, null, null, null, false);
        $result['date']= date("Y-m-d H:i:s");
        $data['result'] = $result;
        $unique_values_by_key = array_unique(array_column($this->Common_model->getData("tbl_masterdata", "category"), 'category'));
        $data['categories']=$unique_values_by_key;
        $data['user_target']=$this->Common_model->getData("tbl_admin", "target", array('id' => $this->session->userdata('id')), null, null, null, null, false)["target"];
        $data['main'] = 'form/sellout_form';
        $data["id"]=$id;
        $this->load->view('form/template', $data);
    }
    public function get_brand(){
        $category=$_POST["category"];
        // $brands= array_unique(array_column($this->Common_model->getData("tbl_masterdata", "brand_name", array('category' => $category)), 'brand_name'));
        $brands= array_unique(array_column($this->Common_model->getData("tbl_masterdata", "brand_name", 'category = "'.$category.'" and brand_name="ELECTROLUX" or brand_name ="FRIGIDAIRE"'), 'brand_name'));
        $models= array_unique(array_column($this->Common_model->getData("tbl_masterdata", "model_number", array('category' => $category,'brand_name' => $brands[0])), 'model_number'));
        echo json_encode(["brands"=>$brands,"models"=>$models]);
    }
    public function get_model(){
        $brand=$_POST["brand"];
        $category=$_POST["category"];
        $models= array_unique(array_column($this->Common_model->getData("tbl_masterdata", "model_number", array('brand_name' => $brand)), 'model_number'));

        echo json_encode($models);
    }
    public function add_sellout(){
        $region=$_POST["region"];
        $outlet_name=$_POST["outlet_name"];
        $account_name=$_POST["account_name"];
        $name=$_POST["name"];
        $number=$_POST["contact_number"];
        $email=$_POST["email"];
        $customer_feed=$_POST["feedback"];
        $target=$_POST["user_target"];
        $user_sale=$_POST["user_sale"];
        $analysis_per=$_POST["analysis_per"];
        $add_more_array=array();
        $user_id = $this->session->userdata('id');
        $username=$this->session->userdata('username');
        $reports_ids=$_POST["reports_ids"];
        foreach($reports_ids as $report_id){
            if(isset($_POST["category"."-".$report_id])){
                array_push($add_more_array,
            [
                "category"=>$_POST["category"."-".$report_id],
                "brand"=>$_POST["brand"."-".$report_id],
                "model"=>$_POST["model"."-".$report_id],
                "quantity"=>$_POST["quantity"."-".$report_id],
                "selling_price"=>$_POST["selling_price"."-".$report_id],
                "offer"=>$_POST["offer"."-".$report_id],
            ]
        );
            }
            
        }
                $image_array = array();
                if (!empty($_FILES)) {
                    $image_file_name = $_FILES['invoice_image']['name'];
                  
                    list($msg, $flag, $imageUrl) = $this->upload_image("images/sell_out_report/".$type, $_FILES, "invoice_image");
                    if(!empty($flag) && empty($msg)){
                        $dataVal['image_url'] = $imageUrl;
                        array_push($image_array,base_url()."images/sell_out_report/".$imageUrl);
                    }
                }
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

            'image_array'            => base64_encode(serialize($image_array)),

            'add_more_array'                 => base64_encode(serialize($add_more_array)),
            'add_more_array_count' => count($add_more_array),

           'created_date' =>$this->current_date_time,
           'account_name' => $account_name
        );


        $this->db->insert('sellout',$save_product);
		$insert_id = $this->db->insert_id();
        $result=$this->Common_model->update_data(array(
            'visit_status'    => "Visited",
        ),"tbl_masterdata3",$_POST["id"]);
		redirect('form/sellout_detail/'.$_POST["id"]);
    }
    public function switch_language(){
        $language = $this->session->userdata('language');
        if($language=="en"){
            $this->session->set_userdata('language',"ar");
        }
        if($language=="ar"){
            $this->session->set_userdata('language',"en");
        }
        redirect(($_SERVER['HTTP_REFERER']));
    }

//     public function removeDup(){
// //         SELECT DISTINCT [col1],[col2],[col3],[col4],[col5],[col6],[col7]

// // INTO [newTable]

// // FROM [oldTable]
//  $query =$this->db->select("outlet_name,region,user,account_name,visit_status,unique_code")->distinct()->from("tbl_masterdata3")->get();
        
//         foreach($query->result_array() as $row){
//             echo "<pre>";
//             print_r($this->db->select("*")->from("tbl_masterdata3")->where(
//                 array(
//                     "outlet_name"=>$row["outlet_name"],
//                     "region"=>$row["region"],
//                     "user"=>$row["user"],
//                     "account_name"=>$row["account_name"],
//                     "visit_status"=>$row["visit_status"],
//                     "unique_code"=>$row["unique_code"],
//                 ))->get()->result_array()[0]);
//             echo "</pre>";
//     $insert = $this->db->insert('tbl_masterdata3_unique', 
//     $this->db->select("*")->from("tbl_masterdata3")->where(
//         array(
//             "outlet_name"=>$row["outlet_name"],
//             "region"=>$row["region"],
//             "user"=>$row["user"],
//             "account_name"=>$row["account_name"],
//             "visit_status"=>$row["visit_status"],
//             "unique_code"=>$row["unique_code"],
//         ))->get()->result_array()[0]);

//         }
//     // $insert = $this->db->insert_batch('tbl_masterdata3_unique', $query->result_array());

    

//     }
}
