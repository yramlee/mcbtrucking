<?php

function __displayEachReportPerDestinationAll($where = array(), $post = array(), $pdf_mode = false) {
    $CI =& get_instance();
    $destination = my_destination();
    $data = null;
    $heading = null;
  
    $company = $CI->Company_model->get_by_id(@$where['company_id']);       
    if ($pdf_mode) {  
        $heading .= '<table style="text-align: center; width: 100%; margin: 0 auto; font-family: Arial">';
        $heading .= '<tr><td style="font-weight: bold; font-size: 25px;">MCB Trucking Services</td></tr>';  
        $heading .= '<tr><td style="position: relative; top: -20px; font-weight: bold; font-size: 18px;">Billing Summary</td></tr>';    
        $heading .= '<tr><td><strong>Period:</strong> '.date('F d, Y', strtotime($post['delivery_date_start'])).' to '.date('F d, Y', strtotime($post['delivery_date_end'])).' </td></tr>';
        $heading .= '</table>';          
        $heading .= '<hr>';
        $heading .= '<table style="text-align: left; width: 100%; margin: 0 auto; font-family: Arial;border-collapse: collapse;">';
        $heading .= '<tr><td><strong>To: </strong>'.$company->name.'<td></tr>';
        $heading .= '<tr><td><strong>Address: </strong>'.$company->address.'<td></tr>';
        $heading .= '<tr><td><strong>Date:</strong> <td></tr>';
        $heading .= '<tr><td>Mary Luz C. Balabat<strong>(Owner)</strong>: _____________________________</td>';                
        $heading .= '<td><strong>Received by:</strong> _________________________</td></tr>';
        $heading .= '</table>';
    }

    if (!empty($destination)) {
        foreach ($destination as $key => $value) {                          
            $destination = $CI->Destination_model->get_by_id($key);  
            
            $where = array_merge($where, array(
                'destination_id' => $key
            ));
            
            $deliveries = $CI->Deliveries_model->get_all_by_where($where);
            
            if (!empty($deliveries) && !empty($company) && !empty($destination)) {
              $data .= __displayEachReportPerDestination($deliveries, $company, $destination, $pdf_mode, $post, true)['data'];
            }           
        }
    }
    
    $instance['data'] = $heading.$data;
    
    return $instance;
}

function __displayEachReportPerDestination($obj = array(), $company = array(), $destination = array(), $pdf_mode = false, $post = array(), $all = false) {
    $data = null;     
    
    if (!empty($obj)) {
        if ($pdf_mode) {
            if (!$all) {
                $data .= '<table style="text-align: center; width: 100%; margin: 0 auto; font-family: Arial">';
                $data .= '<tr><td style="font-weight: bold; font-size: 25px;">MCB Trucking Services</td></tr>';  
                $data .= '<tr><td style="position: relative; top: -20px; font-weight: bold; font-size: 18px;">Billing Summary</td></tr>';    
                //$data .= '<tr><td><strong>Period:</strong> '.date('F d, Y', strtotime($post['delivery_date_start'])).' to '.date('F d, Y', strtotime($post['delivery_date_end'])).' </td></tr>';
                $data .= '<tr><td><strong>Period:</strong>_________________________________</strong></td></tr>';
                $data .= '</table>';          
                $data .= '<hr>';  
            }          
            $data .= '<table style="border-collapse: collapse; border: 1px solid #e9ecef;font-family: Arial; margin-top: 50px; width:100%;">';
        }
        else {
            $data .= '<table class="table table-striped">';
        }
        if (!empty($destination)) {
            $data .= '<tr>';
            $data .= '<th colspan="9" style="padding: 15px;"><h2>'.@$destination->from.' to '.@$destination->to.'</h2></th>';
            $data .= '</tr>';
        }
        if ($pdf_mode) {
            $data .= '<tr>
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 5%;">#</th>
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">DATE</th>
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">Shift</th> 
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">Material</th> 
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">Trips</th>
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">Flecon Bags</th>
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">Rate</th>
                <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;width: 14%;">No. of bags</th>
              </tr>';
        }
        else {
            $data .= '<tr>
                 <th style="width: 5%;">#</th>
                 <th>DATE</th>
                 <th>Shift</th> 
                 <th>Material</th> 
                 <th>Trips</th>
                 <th>Destination</th>
                 <th>Flecon Bags</th>
                 <th>Rate</th>
                 <th>No. of bags</th>
               </tr>';
        }
        $data .= '</thead>
         <tbody>';
        $ctr = 1;
        $no_of_bags = 0;
        $subTotal = 0;
        foreach ($obj as $value) {       
            if ($value->above) {
                $subTotal += $value->no_of_trips * my_rate()[$value->rate_id];      
            }
            else {
                $subTotal += $value->no_of_bags * my_rate()[$value->rate_id]; 
            }
                            
            $no_of_bags += $value->no_of_bags; 
            
            if ($pdf_mode) {
                $data .= '<tr>';
                $data .= '<td>'.$ctr++.'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><strong>'.date('d-M-Y', strtotime($value->date)).'</strong></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'. my_shift()[$value->shift_id].'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'. (!empty($value->material_id) ? my_material()[$value->material_id]:'-').'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'.$value->no_of_trips.'</td>';                
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'.$value->flecon_bags.'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'.my_rate()[$value->rate_id].'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'.$value->no_of_bags.'</td>';
                $data .= '</tr>'; 
            }
            else {
                $data .= '<tr>';
                $data .= '<td>'.$ctr++.'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><strong>'.date('d-M-Y', strtotime($value->date)).'</strong></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><a target="_blank" href="'.base_url().'delivery/edit/'.$value->id.'">'. my_shift()[$value->shift_id].'</a></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;">'. (!empty($value->material_id) ? my_material()[$value->material_id]:'-').'</td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><a target="_blank" href="'.base_url().'delivery/edit/'.$value->id.'">'.$value->no_of_trips.'</a></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><a target="_blank" href="'.base_url().'delivery/edit/'.$value->id.'">'.  my_destination()[$value->destination_id].'</a></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><a target="_blank" href="'.base_url().'delivery/edit/'.$value->id.'">'.$value->flecon_bags.'</a></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><a target="_blank" href="'.base_url().'delivery/edit/'.$value->id.'">'.my_rate()[$value->rate_id].'</a></td>';
                $data .= '<td style="border: 1px solid #e9ecef;padding: 4px;"><a target="_blank" href="'.base_url().'delivery/edit/'.$value->id.'">'.$value->no_of_bags.'</a></td>';
                $data .= '</tr>'; 
            }
            
        }
        $data .= '</tbody>';
        
        if ($pdf_mode) {
            $data .= '<tfoot>';
            $data .= '<tr>';
            $data .= '<td colspan="5" style="background-color: #ffffb3; width: 20px;"><strong>Total No. of Bags</strong></td>';
            $data .= '<td style="background-color: #ffffb3;"></td>';
            $data .= '<td  colspan="2" style="text-align: right;font-size: 18px; background-color:#ffffb3;padding:15px"><strong>'.number_format(@$no_of_bags, 0).'</strong></td>';
            $data .= '</tr>';  
            $data .= '<tr>';
            $data .= '<td colspan="5" style="background-color: #ffffb3; width: 50px;"><strong>Sub Total</strong></td>';
            $data .= '<td style="background-color: #ffffb3;"></td>';
            $data .= '<td colspan="2" style="text-align: right;font-size: 18px; background-color:#ffffb3;padding:15px"><strong>&#x20B1;'.number_format(@$subTotal, 2).'</strong></td>';
            $data .= '</tr>';  
            $data .= '</tfoot>'; 
        }
        else {
            $data .= '<tfoot>';
            $data .= '<tr>';
            $data .= '<td colspan="7"style="background-color: #ffffb3;"><strong>Total No. of Bags</strong></td>';
            $data .= '<td style="background-color: #ffffb3;"></td>';
            $data .= '<td coslpan="4" style="font-size: 18px; background-color:#ffffb3;"><strong>'.$no_of_bags.'</strong></td>';
            $data .= '</tr>';  
            $data .= '<tr>';
            $data .= '<td colspan="7" style="background-color: #ffffb3;"><strong>Sub Total</strong></td>';
            $data .= '<td style="background-color: #ffffb3;"></td>';
            $data .= '<td colspan="4" style="font-size: 18px; background-color:#ffffb3;"><strong>&#x20B1;'.number_format(@$subTotal, 2).'</strong></td>';
            $data .= '</tr>';  
            $data .= '</tfoot>'; 
        }
        
        $data .= '</table>';
    }
    
    $instance['no_of_bags'] = $no_of_bags;
    $instance['subTotal'] = $subTotal;
    $instance['data'] = $data;
    
    return $instance;
}
