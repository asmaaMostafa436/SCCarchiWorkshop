<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        //load model
        $this->load->model('home_model');

    }
    public function index()
    {
            $this->load->view('welcome_message');
    }
        
    public function search()
    {
            $search_term = $this->input->get('username');

        //get data from the database
        $data['users'] = $this->home_model->get_users($search_term);
        //load view and pass the data
        $this->load->view('search_results', $data);
    }
}
?>
