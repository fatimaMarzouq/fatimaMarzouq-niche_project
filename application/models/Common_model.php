<?php



class Common_model extends CI_Model {


    private $_batchImport;
	function __construct()

	{

		parent::__construct();

		$this->load->library('upload');

		$this->load->library('session'); 

	}


    public function setBatchImport($batchImport) {
        $this->_batchImport = $batchImport;
    }
 
    // save data
    public function importData() {
        $data = $this->_batchImport;
        // echo '<pre>';print_r($data);
        // exit;
        $this->db->insert_batch('tbl_masterdata', $data);
        //echo $this->db->last_query();
        //exit;
    }
    public function importData1() {
        $data = $this->_batchImport;
        // echo '<pre>';print_r($data);
        // exit;
        $this->db->insert_batch('tbl_masterdata2', $data);
        //echo $this->db->last_query();
        //exit;
    }
     public function importData3() {
        $data = $this->_batchImport;
        // echo '<pre>';print_r($data);
        // exit;
        $this->db->insert_batch('tbl_masterdata3', $data);
        //echo $this->db->last_query();
        //exit;
    }
     public function importData2() {
        $data = $this->_batchImport;
        // echo '<pre>';print_r($data);
        // exit;
        $this->db->insert_batch('tbl_outlet_master', $data);
        //echo $this->db->last_query();
        //exit;
    }
    // get employee list
    public function employeeList() {
        $this->db->select(array('e.id', 'e.first_name', 'e.last_name', 'e.email', 'e.dob', 'e.contact_no'));
        $this->db->from('import as e');
        $query = $this->db->get();
        return $query->result_array();
    }
 
	public function login_check($email,$password)

	{

		$this->db->where('email',$email);

		$this->db->where('password',$password);

		$query = $this->db->get('tbl_admin');

		



		if($query->num_rows() == 1)  

		{



			$result=$query->result();
            if($result[0]->role != 2){
    			$sessiondata = array(
    
    									'id'  =>$result[0]->id,
    
    									'username'  =>$result[0]->username,
    
    									'email'  =>$result[0]->email,
    
    									'role'  =>$result[0]->role,
    
    									'image'  =>$result[0]->image             
    
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





	public function session_check()

	{

		if($this->session->userdata('id')=='')

		{

		    return false;

		}

		else

		{

     		return true;        



		}

	}







	public function save_data($insert_data,$table)

	{

		$this->db->insert($table,$insert_data);

		$insert_id = $this->db->insert_id();

		return $insert_id;

	}



		public function get_data($table){

		$query=$this->db->get($table);

		return $query->result_array();

	}



		public function do_delete($table,$id){

		$this->db->where('id',$id);

		$this->db->delete($table);

		return ($this->db->affected_rows()!=1)? false : true;

	}

	public function do_delete_comment($table,$id){

		$this->db->where('comment_id',$id);

		$this->db->delete($table);

		return ($this->db->affected_rows()!=1)? false : true;

	}



	public function getdata_one($table,$id)

	{

		$this->db->where('id',$id);

		$q = $this->db->get($table);

		return $result = $q->result_array();

	}



	public function update_data($save,$table,$id) 

	{

	    $this->db->where('id', $id);

	    $data=$this->db->update($table, $save);

		if($data)

		   return true;

		else

		    return false;

	}

  public function update_status($save,$table,$status) 

	{

	    $this->db->where('status', $status);

	    $data=$this->db->update($table, $save);

		if($data)

		   return true;

		else

		    return false;

	}

	public function my_success($msg)

    {

     	$this->session->set_flashdata('msg',$msg);

    }



    public function my_failed()

    {

     	$this->session->set_flashdata('error_msg','Something Went Wrong!!! Try Again');

    } 



    public function my_return()

    {

     	redirect($_SERVER['HTTP_REFERER']);

    } 



//     public function get_run($run)

// 	{

// 		$query = $this->db->query($run);

// 		return $query->result_array();	

// 	}





    function upload_file($path,$image_name,$tmp_name)

    {

		if(move_uploaded_file($tmp_name,$path.$image_name) && is_writable($path))

		{

		    $display_message = 1;

		    $display_message = $path.$image_name;

		}

		else

		{

	    	$display_message = '';

		}

       return $display_message;

    }



    public function Change_Forget_Password($email){

		$this->db->where('email',$email);

		$query = $this->db->get('tbl_admin');

		if($query->num_rows() == 1)  {

		$result=$query->result_array();

		return $result;

		} 

		else{   

		return -1;

		}

	}



	public function update_for_all($update_data,$table,$id,$col_name)

	{

		$this->db->where($col_name,$id);

		return ( $this->db->update($table, $update_data) != 1) ? false : true;

	}
      //Function for update
    public function customUpdate($options) {
        $table = false;
        $where = false;
        $orwhere = false;
        $data = false;

        extract($options);

        if (!empty($where)) {
            $this->db->where($where);
        }

        // using or condition in where  
        if (!empty($orwhere)) {
            $this->db->or_where($orwhere);
        }
        $this->db->update($table, $data);

        return $this->db->affected_rows();
    }

    //Function for delete
    public function customDelete($options) {
        $table = false;
        $where = false;
        $where_in = false;

        extract($options); 
        
        if (!empty($where))
            $this->db->where($where);

        if (!empty($where_in))
            $this->db->where_in($where_in['column'], $where_in['list']);

        $this->db->delete($table);

        return $this->db->affected_rows();
    }

    //Function for insert
    public function custom_insert($options) {
        $table = false;
        $data = false;

        extract($options);

        //$data = $this->_filter_data($table, $data);

        $this->db->insert($table, $data);

        return $this->db->insert_id();
    }



    public function customGet($options) {

        $select = false;
        $table = false;
        $join = false;
        $order = false;
        $limit = false;
        $offset = false;
        $where = false;
        $or_where = false;
        $where_not_in = false;
        $single = false;
        $group_by = false;
        $distinct = false;

        extract($options);

        if ($distinct != false)
            $this->db->distinct();

        if ($select != false)
            $this->db->select($select);

        if ($table != false)
            $this->db->from($table);

        if ($where != false)
            $this->db->where($where);

        if ($or_where != false)
            $this->db->or_where($or_where);

        if ($where_not_in != false)
            $this->db->where_not_in($where_not_in);

        if ($limit != false) {

            if (!is_array($limit)) {
                $this->db->limit($limit);
            } else {
                foreach ($limit as $limitval => $offset) {
                    $this->db->limit($limitval, $offset);
                }
            }
        }

        if ($group_by != false) {

            $this->db->group_by($group_by);
        }

        if ($order != false) {

            foreach ($order as $key => $value) {

                if (is_array($value)) {
                    foreach ($order as $orderby => $orderval) {
                        $this->db->order_by($orderby, $orderval);
                    }
                } else {
                    $this->db->order_by($key, $value);
                }
            }
        }
        if ($join != false) {
            foreach ($join as $key => $value) {
                if (is_array($value)) {
                    if (count($value) == 3) {
                        $this->db->join($value[0], $value[1], $value[2]);
                    } else {
                        foreach ($value as $key1 => $value1) {
                            $this->db->join($key1, $value1);
                        }
                    }
                } else {
                    $this->db->join($key, $value);
                }
            }
        }
        $query = $this->db->get();
        if ($single) {
            return $query->row();
        }
        return $query->result();
    }

    public function customQuery($query, $single = false, $updDelete = false, $noReturn = false) {
        $query = $this->db->query($query);

        if ($single) {
            return $query->row();
        } elseif ($updDelete) {
            return $this->db->affected_rows();
        } elseif (!$noReturn) {
            return $query->result();
        } else {
            return true;
        }
    }

    public function customQueryCount($query) {
        return $this->db->query($query)->num_rows();
    }

    function customCount($options) {
        $table = false;
        $join = false;
        $order = false;
        $limit = false;
        $offset = false;
        $where = false;
        $or_where = false;
        $single = false;

        extract($options);

        if ($table != false)
            $this->db->from($table);

        if ($where != false)
            $this->db->where($where);

        if ($or_where != false)
            $this->db->or_where($or_where);

        if ($limit != false) {

            if (!is_array($limit)) {
                $this->db->limit($limit);
            } else {
                foreach ($limit as $limitval => $offset) {
                    $this->db->limit($limitval, $offset);
                }
            }
        }
        if ($order != false) {
            foreach ($order as $key => $value) {
                if (is_array($value)) {
                    foreach ($order as $orderby => $orderval) {
                        $this->db->order_by($orderby, $orderval);
                    }
                } else {
                    $this->db->order_by($key, $value);
                }
            }
        }

        if ($join != false) {
            foreach ($join as $key => $value) {
                if (is_array($value)) {
                    if (count($value) == 3) {
                        $this->db->join($value[0], $value[1], $value[2]);
                    } else {
                        foreach ($value as $key1 => $value1) {
                            $this->db->join($key1, $value1);
                        }
                    }
                } else {
                    $this->db->join($key, $value);
                }
            }
        }
        return $this->db->count_all_results();
    }

   
   

    function getData($tbl = null, $select = null, $con = null, $orderBy = null, $limit = null, $join = null, $between = null, $multiple = TRUE, $group_by = null) {

        if ($select != null) {
            $this->db->select($select);
        } else {
            $this->db->select('*');
        }

        $this->db->from($tbl);

        if ($join != null) {
            foreach ($join as $j) {
                $type = 'inner';
                if (isset($j['type']))
                    $type = $j['type'];
                $this->db->join($j['table'], $j['relation'], $type);
            }
        }

        if ($con != null)
            $this->db->where($con);

        if ($between != null)
            $this->db->where($between);

        if ($orderBy != null) //$this->db->order_by('title desc, name asc'); 
            $this->db->order_by($orderBy);

        if ($limit != null) //$this->db->order_by('title desc, name asc'); 
            $this->db->limit($limit);

        if ($group_by != null)
            $this->db->group_by($group_by); 

        $query = $this->db->get();
        //echo $this->db->last_query();
        //exit;
        if ($query->num_rows() > 0) {
            if ($multiple) {
                return $query->result_array();
            } else {
                return $query->row_array();
            }
        } else
            return FALSE;
    }

    function fetchSingleData($select, $table, $where) {
        $this->db->select($select);
        $this->db->from($table);
        $this->db->where($where);
        $res = $this->db->get()->row();
        return $res;
    }

    function fetch_all_data($select, $table, $where=null,$order_by=null) {
        $this->db->select($select);
        $this->db->from($table);
        if($where){
            $this->db->where($where);
        }
        if($order_by){
            $this->db->order_by($order_by);
        }
        $res = $this->db->get()->result();
        return $res;
    }

    function sendMail($from, $to, $message) {
        $this->email->from($from, 'Team Vento');
        $this->email->to($to);
        $this->email->subject("Vento");
        $this->email->message($message);
        $send = $this->email->send();

        if ($send) {
            return '1';
        } else {
            return '0';
        }
    }

  

    function getPaginationList($start= null, $tbl = null, $select = null, $con = null, $orderBy = null, $limit = null, $join = null, $between = null, $multiple = TRUE,$group_by = null) {

        if ($select != null) {
            $this->db->select($select);
        } else {
            $this->db->select('*');
        }

        $this->db->from($tbl);

        if ($join != null) {
            foreach ($join as $j) {
                $type = 'inner';
                if (isset($j['type']))
                    $type = $j['type'];
                $this->db->join($j['table'], $j['relation'], $type);
            }
        }

        if ($con != null)
            $this->db->where($con);

        if ($between != null)
            $this->db->where($between);

        if ($orderBy != null) //$this->db->order_by('title desc, name asc'); 
            $this->db->order_by($orderBy);

        if ($limit != null) //$this->db->order_by('title desc, name asc'); 
            $this->db->limit($limit, $start);
        if ($group_by != null)
            $this->db->group_by($group_by); 


        $query = $this->db->get();
        
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($multiple) {
                return $query->result_array();
            } else {
                return $query->row_array();
            }
        } else
            return FALSE;
    }
    
	
    public function get_run($run)
	{

	$query = $this->db->query($run);
    return $query->result_array();	

	}
	
	
	public function get_run_one($run)
	{

	$query = $this->db->query($run);
    return $query->row_array();	

	}
	
   
   







}





?>