<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct()
    {
            parent::__construct();
            $this->edak=$this->load->database('mysql',true);
            $this->oracle=$this->load->database('default',true);
    }	

    function count_all()
    {
        return $this->edak->count_all('users');
    }

    public function get_all()
    {
        $query = $this->edak->get("users");
        return $query->result_array();
    }

    public function get_paged_list($limit = 10, $offset = 0)
    {
        $this->edak->order_by('id','asc');
        return $this->edak->get("users", $limit, $offset);
    }

    public function get_by_id($id)
    {
        $this->edak->where('id', $id);
        $query = $this->edak->get("users");
        return $query->row_array();
    }

    public function get_by_code($code)
    {
        $this->edak->where('code', $code);
        $query = $this->edak->get("users");
        return $query->row_array();
    }

    public function insert($User){
        $this->edak->insert("users", $User);
        return $this->edak->insert_id();
    }
    
    public function update($id, $User){
        $this->edak->where('id', $id);
        $this->edak->update("users", $User);
        return $this->edak->affected_rows();
    }
    
    public function reset($id){
        $this->edak->set('password','md5(username)', FALSE);
        $this->edak->where('id', $id);
        $this->edak->update("users");
        return $this->edak->affected_rows()+1;
    }

    public function password($id, $password){
        $this->edak->set('password',md5($password));
        $this->edak->where('id', $id);
        $this->edak->update("users");
        return $this->edak->affected_rows();
    }

    public function delete($id){
        $this->edak->where('id', $id);
        $this->edak->delete("users");
        return $this->edak->affected_rows();
    }    

    public function auth($user, $pass)
    {
        $query = $this->edak->get_where('users', array('username' => $user, 'password'=> md5($pass)));
        

        if ($query->num_rows() == 1)
        {
            $row = $query->row();
            $data = array('id' => $row->id, 'name' => $row->name, 'username' => $row->username, 'unit' => $row->unit );
        } 
        else
        {
            $data = null;
        }
        return $data;
    }  

    public function edakusers()
    {
        $sql= "SELECT id,username, name , designation,mobile from Users";
         $query = $this->edak->query($sql); // To Run the Query in mysql Database as per the Configuration in /config/database.php
        return $query->result_array();
    }    

}