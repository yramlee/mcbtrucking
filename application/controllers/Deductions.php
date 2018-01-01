<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deductions extends CI_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('Deductions_model');
       $this->load->model('Truck_model');
       $this->load->model('Company_model');
    }

    public function index() {
        isLoggedIn();
        $data['deductions'] = $this->Deductions_model->get_all();
        $this->load->view('templates/header');
        $this->load->view('deductions/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        isLoggedIn();
        $data['trucks'] = $this->Truck_model->get_all();
        $data['company'] = $this->Company_model->get_all();    
        
        if ($this->input->post()) {
            $myData = $this->input->post();
            
            $myData['date'] = date('Y-m-d', strtotime($myData['date']));           
            $myData['amount'] = $myData['liters'] * $myData['rate'];
            
            $this->Deductions_model->insert($myData);
            $data['prompt'] = promptSuccess('You have successfully added a deduction.');
            redirectWithTime('deductions', 1000);
        }
        
        $this->load->view('templates/header');
        $this->load->view('deductions/add', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit($id = null) {
        isLoggedIn();
        $data = array();
        $data['trucks'] = $this->Truck_model->get_all();
        $data['company'] = $this->Company_model->get_all();
        $data['data'] = $this->Deductions_model->get_by_id($this->uri->segment(3));
        
        if ($this->input->post()) {
            $myData = $this->input->post();
            
            $myData['id'] = $this->uri->segment(3);
            $myData['date'] = date('Y-m-d', strtotime($myData['date']));
            $myData['amount'] = $myData['liters'] * $myData['rate'];           
            
            $this->Deductions_model->update($myData);
            $data['prompt'] = promptSuccess('You have successfully updated a deduction');
            redirectWithTime('deductions', 1000);
        }
        
        $this->load->view('templates/header');
        $this->load->view('deductions/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete($id = null) {
        isLoggedIn();
        $this->Deductions_model->delete_by_id($id);
        echo promptSuccess('You have successfully deleted a deduction.');
        redirectWithTime('deductions', 2000);
    }    
}
