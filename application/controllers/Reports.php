<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
    
    private $_pdf = null;
    private $_manager = 'Marjun R. Balabat';

    public function __construct() {
        parent::__construct();
        $this->load->model('Deliveries_model');
        $this->load->model('Truck_model');
        $this->load->model('Company_model');
        $this->load->model('Deductions_model');
        $this->load->model('Destination_model');
    }
    
    /**
     * The default page
     */
    public function index()
    {
        isLoggedIn();
        $data['trucks'] = $this->Truck_model->get_all();         
        $data['company'] = array();
        $where = array();
        
        if ($this->input->post()) { 
            $summary_pdf = null;
            $myData = $this->input->post();
            
            if (!empty($myData['company_id'])) {
                $company = $this->Company_model->get_by_id($myData['company_id']);
                $data['company'] = $company;
                
                if (!empty($myData['company_id'])) {
                    $where = array_merge($where, array(
                        'company_id' => $myData['company_id']
                    ));
                }
                
                if (!empty($myData['delivery_date_start']) && $myData['delivery_date_end']) {
                    $where = array_merge($where, array(
                        'date >=' => date('Y-m-d', strtotime($myData['delivery_date_start'])),
                        'date <=' => date('Y-m-d', strtotime($myData['delivery_date_end']))               
                    ));
                }
                
                

                if ($company->form_type == FORM_TYPE1) {
                    if (!empty($myData['truck_id'])) {
                        $where = array_merge($where, array(
                            'truck_id' => $myData['truck_id']
                        ));
                    }
                    if (!empty($myData['truck_id'])) {           
                        
                        // Deliveries
                        $deliveries = $this->Deliveries_model->get_all_by_where($where);
                        $truck = $this->Truck_model->get_by_id($myData['truck_id']);
                        
                        if (!empty($deliveries)) {
                            $data['deliveries'] = __displayTruckDeliveryReport($deliveries, $truck, $company)['data'];
                            $data['summary'] = __displayTruckDeliveryReportSummary($deliveries, $truck, $myData, $company)['data'];
                            $deliveries_pdf = __displayTruckDeliveryReportPDF($deliveries, $truck, $myData, $company)['data'];
                            $this->_pdf = $deliveries_pdf; 
                            $myFilename = $truck->code.'-'.$truck->name.'_trucking.pdf';
                        }
                    }
                    else {
                        $data['deliveries'] = __displayAll($where, false, $myData);               
                        $deliveries_pdf = __displayAll($where, true, $myData);
                        $this->_pdf = $deliveries_pdf;
                        $myFilename = 'MCB_billing_summary_'.$company->name.'.pdf';  
                    }  
                    
                }
                elseif($company->form_type == FORM_TYPE2) {
                    $destination = array();
                    if (!empty($myData['destination_id'])) {
                        $where = array_merge($where, array(
                            'destination_id' => @$myData['destination_id']
                        ));
                        $destination = $this->Destination_model->get_by_id(@$myData['destination_id']);  
                        $deliveries = $this->Deliveries_model->get_all_by_where($where);
                        $data['deliveries'] = __displayEachReportPerDestination($deliveries, $company, $destination, false, $myData, false)['data'];
                        $this->_pdf = __displayEachReportPerDestination($deliveries, $company, $destination, true, $myData, false)['data'];
                    }
                    else {
                        $data['deliveries'] = __displayEachReportPerDestinationAll($where, $myData, false)['data'];
                        $this->_pdf = __displayEachReportPerDestinationAll($where, $myData, true)['data'];
                    }                             
                    
                    $myFilename = 'MCB_billing_summary_'.$company->name.'.pdf';                
                }
                
                if ($this->input->post('download_pdf')) { 
                    createPdf($myFilename, $this->_pdf);
                }
            }
            
        }
       
        $this->load->view('templates/header');
        $this->load->view('reports/index', $data);
        $this->load->view('templates/footer');
    }   
    
}
