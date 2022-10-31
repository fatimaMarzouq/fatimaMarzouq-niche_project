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
    public function form_login_check()
    {
        $table = 'tbl_admin';
        $usermail = $this->input->post('email');
        $passwords = $this->input->post('password');
        $password = md5($passwords);
        $result = $this->Common_model->login_check($usermail, $password, $table);

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

        $select = "id,outlet_name,account_name,region,date,visit_status";
        $table = 'tbl_masterdata3';
        $con = "1=1 and `user` in ('" . $this->session->userdata('email')."','". $this->session->userdata('username') . "') ";
        $invoice_data_val = $this->Common_model->getPaginationList($start, $table, $select, $con, $orderBy, $limit);

        $invoice_total = $this->Common_model->getData($table, $select, $con, $orderBy, null, null);
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
        $con = array('outlet_name' => $row[0]["outlet_name"]);
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
        $this->load->view('form/template', $data);
    }
    public function get_brand(){
        $category=$_POST["category"];
        $brands= array_unique(array_column($this->Common_model->getData("tbl_masterdata", "brand_name", array('category' => $category)), 'brand_name'));

        echo json_encode($brands);
    }
    public function get_model(){
        $brand=$_POST["brand"];
        $models= array_unique(array_column($this->Common_model->getData("tbl_masterdata", "model_number", array('brand_name' => $brand)), 'model_number'));

        echo json_encode($models);
    }
    public function add_sellout(){
        $region=$_POST["region"];
        $outlet_name=$_POST["outlet_name"];
        $account_name=$_POST["account_name"];
        $name=$_POST["name"];
        $username=$this->session->userdata('username');
        $number=$_POST["contact_number"];
        $email=$_POST["email"];
        $customer_feed=$_POST["feedback"];
        $target=$_POST["user_target"];
        $user_sale=$_POST["user_sale"];
        $analysis_per=$_POST["analysis_per"];
        $add_more_array=array();
        $user_id = $this->session->userdata('id');
        for($i=1;$i<=4;$i++){
            array_push($add_more_array,
            [
                "category"=>$_POST["category"."-".$i],
                "brand"=>$_POST["brand"."-".$i],
                "model"=>$_POST["model"."-".$i],
                "quantity"=>$_POST["quantity"."-".$i],
                "selling_price"=>$_POST["selling_price"."-".$i],
                "offer"=>$_POST["offer"."-".$i],
            ]
        );
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

            // 'image_array'            => $image_array,

            'add_more_array'                 => base64_encode(serialize($add_more_array)),
            'add_more_array_count' => count($add_more_array),

           'created_date' =>$this->current_date_time,
           'account_name' => $account_name
        );


        $this->db->insert('sellout',$save_product);
		$insert_id = $this->db->insert_id();
		redirect('form/sellout_list');
    }
}
