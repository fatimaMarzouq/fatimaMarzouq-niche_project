<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Api_model extends CI_Model {

	function __construct()
	{
		parent::__construct();
	    $this->load->library('upload');
		$this->load->library('session');
	}

	public function save_data($insert_data,$table)
	{
		$this->db->insert($table,$insert_data);
		$insert_id = $this->db->insert_id();
		return $insert_id;
	}

	 public function LoginCheck($email,$password)
    {
        $this->db->where('email',$email);
        $this->db->where('password',$password);
        $query = $this->db->get('tbl_admin');
        if($query->num_rows() > 0)  
        {
        $result=$query->result();
        // print_r($result);
        // die();
        $sessiondata = array(
                              'id'       	=> $result[0]->id,
                              'email'    	=> $result[0]->email, 
                              'name'    	=> $result[0]->companyName,
                            );
        $this->session->set_userdata($sessiondata);
        // return $result[0]->id;
        return $sessiondata;
        } 
        else
        {		
        return -1;
        }
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
                return $query->result();
            } else {
                return $query->row();
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

    /* Old funtion replaced by new priya api  */

    function _getPaginationList($start, $tbl = null, $select = null, $con = null, $orderBy = null, $limit = null, $join = null, $between = null, $multiple = TRUE) {

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

        $query = $this->db->get();
//        echo $this->db->last_query();
        if ($query->num_rows() > 0) {
            if ($multiple) {
                return $query->result();
            } else {
                return $query->row();
            }
        } else
            return FALSE;
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
                return $query->result();
            } else {
                return $query->row();
            }
        } else
            return FALSE;
    }
    
    



}
?>

