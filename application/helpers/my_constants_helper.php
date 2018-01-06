<?php

/**
 * Types of TONS
 * 
 * @return array
 */
function TYPE_TONS() {
    return array(
        TONS_TYPE1 => '<span><i class="fa fa-file-word-o fa-fw">'.TONS_TYPE1.'</span>',
        TONS_TYPE2 => '<span><i class="fa fa-video-camera fa-fw">'.TONS_TYPE2.'</span>'
    );
}

/**
 * Types of Deductions
 * 
 * @return array
 */
function TYPE_YESNO() {
    return array(
        array('id' => TYPE_NO, 'name' => 'No'),
        array('id' => TYPE_YES, 'name' => 'Yes'),       
    );
}

/**
 * Types of Deductions
 * 
 * @return array
 */
function TYPE_DEDUCTIONS() {
    return array(
        array('id' => DEDUCTIONS_TYPE_FUEL, 'name' => 'Fuel'),
        array('id' => DEDUCTIONS_TYPE_OTHER, 'name' => 'Other'),
    );
}

/**
 * Types of Forms
 * 
 * @return array
 */
function TYPE_FORMS() {
    return array(
        array('id' => FORM_TYPE1, 'name' => '1'),
        array('id' => FORM_TYPE2, 'name' => '2'),
        array('id' => FORM_TYPE3, 'name' => '3'),
        array('id' => FORM_TYPE4, 'name' => '4'),
    );
}

/**
 * Company list
 * 
 * @return array
 */
function COMPANY() {
     $CI =& get_instance();
     
     $CI->load->model('Company_model');
     $result = $CI->Company_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$key]['id'] = $values->id;
            $data[$key]['name'] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Company list
 * 
 * @return array
 */
function my_company() {
     $CI =& get_instance();
     
     $CI->load->model('Company_model');
     $result = $CI->Company_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $values) {
            $data[$values->id] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Truck list
 * 
 * @return array
 */
function TRUCK() {
     $CI =& get_instance();
     
     $CI->load->model('Truck_model');
     $result = $CI->Truck_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$key]['id'] = $values->id;
            $data[$key]['name'] = $values->code.' ('.$values->name.')';
         }
     }
     
     return $data;
}

/**
 * Truck list
 * 
 * @return array
 */
function my_truck() {
     $CI =& get_instance();
     
     $CI->load->model('Truck_model');
     $result = $CI->Truck_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {           
            $data[$values->id] = $values->code.' ('.$values->name.')';
         }
     }
     
     return $data;
}

/**
 * Destination list
 * 
 * @return array
 */
function DESTINATION() {
     $CI =& get_instance();
     
     $CI->load->model('Destination_model');
     $result = $CI->Destination_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
             $data[$key]['id'] = $values->id;
             $data[$key]['name'] = $values->from.' to '.$values->to;
         }
     }
     
     return $data;
}

/**
 * Destination list
 * 
 * @return array
 */
function my_destination() {
     $CI =& get_instance();
     
     $CI->load->model('Destination_model');
     $result = $CI->Destination_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$values->id] = $values->from.' to '.$values->to;
         }
     }
     
     return $data;
}


/**
 * Material list
 * 
 * @return array
 */
function MATERIAL() {
     $CI =& get_instance();
     
     $CI->load->model('Material_model');
     $result = $CI->Material_model->get_all();
     $data = array();
     
     if (!empty($result)) {            
         foreach ($result as $key => $values) {
            $data[$key]['id'] = $values->id;
            $data[$key]['name'] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Material list
 * 
 * @return array
 */
function my_material() {
     $CI =& get_instance();
     
     $CI->load->model('Material_model');
     $result = $CI->Material_model->get_all();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$values->id] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Shift list
 * 
 * @return array
 */
function SHIFT() {
     $CI =& get_instance();
     
     $CI->load->model('Shift_model');
     $result = $CI->Shift_model->get_all();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
             $data[$key]['id'] = $values->id;
             $data[$key]['name'] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Shift list
 * 
 * @return array
 */
function my_shift() {
     $CI =& get_instance();
     
     $CI->load->model('Shift_model');
     $result = $CI->Shift_model->get_all();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$values->id] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Vessel list
 * 
 * @return array
 */
function VESSEL() {
     $CI =& get_instance();
     
     $CI->load->model('Vessel_model');
     $result = $CI->Vessel_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $values) {
             $data[$values->id] = $values->name;
         }
     }
     
     return $data;
}

/**
 * Rate list
 * 
 * @return array
 */
function RATE() {
    $CI =& get_instance();

    $CI->load->model('Rate_model');
    $result = $CI->Rate_model->get_all();
    $data = array();

    if (!empty($result)) {
        foreach ($result as $key => $values) {
           $data[$key]['id'] = $values->id;
           $data[$key]['name'] = $values->amount;
        }
    }
     
     return $data;
}

/**
 * Rate list
 * 
 * @return array
 */
function my_rate() {
    $CI =& get_instance();

    $CI->load->model('Rate_model');
    $result = $CI->Rate_model->get_all();
    $data = array();

    if (!empty($result)) {
        foreach ($result as $key => $values) {
           $data[$values->id] = $values->amount;
        }
    }
     
     return $data;
}

/**
 * Biling list
 * 
 * @return array
 */
function BILLING() {
     $CI =& get_instance();
     
     $CI->load->model('Billing_model');
     $result = $CI->Billing_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$key]['id'] = $values->id;
            $data[$key]['name'] = my_company()[$values->company_id].' ('.$values->start_date.' to '.$values->end_date.')';
         }
     }
     
     return $data;
}

/**
 * Biling list
 * 
 * @return array
 */
function my_billing() {
     $CI =& get_instance();
     
     $CI->load->model('Billing_model');
     $result = $CI->Billing_model->get_all();
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $values) {
            $data[$values->id] = my_company()[$values->company_id].' '.date('F d, Y', strtotime($values->start_date)).' to '.date('F d, Y', strtotime($values->end_date));;
         }
     }
     
     return $data;
}

/**
 * Biling list
 * 
 * @return array
 */
function BILLING_PER_COMPANY($company_id = null) {
     $CI =& get_instance();
     
     $CI->load->model('Billing_model');
     $result = $CI->Billing_model->get_all_by_company($company_id);
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $key => $values) {
            $data[$key]['id'] = $values->id;
            $data[$key]['name'] = date('F d, Y', strtotime($values->start_date)).' to '.date('F d, Y', strtotime($values->end_date));
         }
     }
     
     return $data;
}

/**
 * Biling list
 * 
 * @return array
 */
function my_billing_per_company() {
     $CI =& get_instance();
     
     $CI->load->model('Billing_model');
     $result = $CI->Billing_model->get_all_by_company($company_id);
     $data = array();
     
     if (!empty($result)) {
         foreach ($result as $values) {
            $data[$values->id] = date('F d, Y', strtotime($values->start_date)).' to '.date('F d, Y', strtotime($values->end_date));
         }
     }
     
     return $data;
}

/**
 * Checks if the user is Logged In
 */
function isLoggedIn() {
    $CI =& get_instance();    
    if (!$CI->session->userdata('logged_in')) {
        redirectWithTime('login', 1);
    }
}
