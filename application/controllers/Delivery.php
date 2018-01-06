<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Delivery extends CI_Controller {
    public function __construct() {
       parent::__construct();
       $this->load->model('Deliveries_model');
       $this->load->model('Truck_model');
       $this->load->model('Company_model');
       $this->load->model('Users_model');
    }

    public function index() {
        isLoggedIn();
        $where = array();
        $data = array();
        
        if ($this->input->post()) {
            $myData = $this->input->post();  
            if (!empty($myData['company_id'])) {
               $where = array_merge($where, array(
                   'company_id' => @$myData['company_id']
               ));
            }
            
            if (!empty($myData['billing_id'])) {
               $where = array_merge($where, array(
                   'billing_id' => @$myData['billing_id']
               ));
            }            
            
            $data['company'] = $this->Company_model->get_by_id($this->input->post('company_id'));
            if (!empty($myData['billing_id'])) {
                $data['deliveries'] = $this->Deliveries_model->get_all_by_where($where);
            }
            else {
                $data['deliveries'] = array();
            }
            
        }
        
        $this->load->view('templates/header');
        $this->load->view('delivery/index', $data);
        $this->load->view('templates/footer');
    }

    public function add() {
        isLoggedIn();
        $data['trucks'] = $this->Truck_model->get_all();
        $data['company'] = $this->Company_model->get_all();
        $data['company_data'] = $this->Company_model->get_by_id($this->uri->segment(4));
        //$data['ticket_no'] = strtoupper(random_string('alnum', 20));     
        
        if ($this->input->post()) {
            $myData = $this->input->post();            
            $myData['company_id'] = $this->uri->segment(4);
            $myData['form_type'] = $data['company_data']->form_type;
            $myData['date'] = date('Y-m-d', strtotime($myData['date']));  
            
            if ($data['company_data']->form_type == FORM_TYPE1) {
                $myData['rate_per_cubic_meter'] = RATE_PER_KM;
                $getTruck = $this->Truck_model->get_by_id($myData['truck_id']);                        
                $myData['capacity'] = $getTruck->capacity;
                $myData['kilometers'] = KILOMETERS;
                $myData['amount'] = $this->_getAmount($getTruck->capacity); 
            }
            elseif($data['company_data']->form_type == FORM_TYPE2) {
                
            }            
            
            $this->Deliveries_model->insert($myData);
            $data['prompt'] = promptSuccess('You have successfully added a delivery');
            //redirectWithTime('home', 5);
        }
        
        $this->load->view('templates/header');
        $this->load->view('delivery/add', $data);
        $this->load->view('templates/footer');
    }
    
    public function edit($id = null) {
        isLoggedIn();
        $data = array();
        $data['trucks'] = $this->Truck_model->get_all();
        $data['company'] = $this->Company_model->get_all();
        $data['data'] = $this->Deliveries_model->get_by_id($this->uri->segment(3));
        $data['company_data'] = $this->Company_model->get_by_id($data['data']->company_id);
        
        if ($this->input->post()) {
            $myData = $this->input->post();
            $myData['id'] = $this->uri->segment(3);
            $myData['date'] = date('Y-m-d', strtotime($myData['date']));
            
            if ($data['company_data']->form_type == FORM_TYPE1) {
                $getTruck = $this->Truck_model->get_by_id($myData['truck_id']);  
                
                $myData['amount'] = $this->_getAmount($getTruck->capacity);
                $myData['capacity'] = $getTruck->capacity;
            }
            elseif($data['company_data']->form_type == FORM_TYPE2) {
                
            } 
            
            $this->Deliveries_model->update($myData);
            $data['prompt'] = promptSuccess('You have successfully updated a delivery');
            redirectWithTime('delivery', 5);
        }
        
        $this->load->view('templates/header');
        $this->load->view('delivery/edit', $data);
        $this->load->view('templates/footer');
    }
    
    public function delete($id = null) {
        isLoggedIn();
        $this->Deliveries_model->delete_by_id($id);
        echo promptSuccess('You have successfully deleted a delivery');
        redirectWithTime('delivery', 2000);
    }
    
    public function company(){
        $data = [];
        $data['company'] = $this->Company_model->get_all();
        
        $this->load->view('templates/header');
        $this->load->view('delivery/company', $data);
        $this->load->view('templates/footer');
    }
    
   /**
     * Login admin
     */
    public function login() {   
        if ($this->input->post()) {
            $user = $this->Users_model->get_user_by_username_and_password($this->input->post('username'), $this->input->post('password'));
            if (!empty($user)) {
                foreach ($user as $key => $value) {
                    $this->session->set_userdata($key, $value);
                }
                $this->session->set_userdata('logged_in', TRUE);                
                redirectWithTime('delivery', 5);
            }    
            else {
                session_destroy();
            }
        }
        
        $this->load->view('login');    
    }
    
    public function logout() {
        session_destroy();
        redirectWithTime('login', 5);
    }
    
    
    
    private function _getAmount($capacity = null) {
        return RATE_PER_KM * $capacity * KILOMETERS;
    }
}
