<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home_model extends CI_Model {
    public function __construct()
    {
        $this->load->database();//load database which should have been changed in the config file
    }
    
    public function get_users($user)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->like('name',$user);

        // Execute the query.
        $query = $this->db->get();//execute query

        // Return the results.
        return $query->result_array();// return to caller, in this case controller
    }
}
?>
