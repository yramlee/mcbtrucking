<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Material extends CI_Controller {
    private $_page = 'material';
    public function __construct() {
       parent::__construct();
       $this->load->model('Material_model');
    }

    public function index() {
        isLoggedIn();
        $data['model'] = $this->Material_model->get_all();
        $data['page'] = $this->_page;
        $this->load->view('templates/header');
        $this->load->view($this->_page.'/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        isLoggedIn(); 
        $data['page'] = $this->_page;
        if ($this->input->post()) {
            $myData = $this->input->post();            
            $this->Material_model->insert($myData);
            $data['prompt'] = promptSuccess('You have successfully added a '.$this->_page.'.');
            redirectWithTime($this->_page, 1000);
        }
        
        $this->load->view('templates/header');
        $this->load->view($this->_page.'/add', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit($id = null) {
        isLoggedIn();
        $data = array();
        $data['page'] = $this->_page;
        $data['data'] = $this->Material_model->get_by_id($this->uri->segment(3));
        
        if ($this->input->post()) {
            $myData = $this->input->post();            
            $myData['id'] = $this->uri->segment(3); 
            $this->Material_model->update($myData);
            $data['prompt'] = promptSuccess('You have successfully updated a '.$this->_page.'.');
            redirectWithTime($this->_page, 1000);
        }
        
        $this->load->view('templates/header');
        $this->load->view($this->_page.'/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete($id = null) {
        isLoggedIn();
        $this->Material_model->delete_by_id($id);
        echo promptSuccess('You have successfully deleted a '.$this->_page.'.');
        redirectWithTime($this->_page, 2000);
    }    
}
