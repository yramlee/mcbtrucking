<?php

    /**
    * Displays all the reports
    * 
    * @param array $where
    * @param boolean $pdfMode
    * @param array $post
    * @return string
    */
    function __displayAll($where = array(), $pdfMode = false, $post = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;
       $data1 = null;
       $data2 = null;
       $heading = null;
       $trucks = $CI->Truck_model->get_all(); 
       $billing = $CI->Billing_model->get_by_id($post['billing_id']); 
       $total = 0;   

       if ($pdfMode) {
           $heading .= '<table style="text-align: center; width: 100%; margin: 0 auto; font-family: Arial">';
           $heading .= '<tr><td style="font-weight: bold; font-size: 25px;">MCB Trucking Services</td></tr>';  
           $heading .= '<tr><td style="position: relative; top: -20px; font-weight: bold; font-size: 18px;">Billing Summary</td></tr>';    
           $heading .= '<tr><td><strong>Period:</strong> '.date('F d, Y', strtotime($billing->start_date)).' to '.date('F d, Y', strtotime($billing->end_date)).' </td></tr>';
           $heading .= '</table>';              
       }

       if (!empty($trucks)) {            
           foreach ($trucks as $key => $value) {                
               $deliveries = $CI->Deliveries_model->get_all_by_where(array_merge(
                   $where,
                   array('truck_id' => $value->id)    
               ));

               // Get the company
               if (!empty($deliveries)) {
                   foreach ($deliveries as $value1) {
                       if (!empty($value1->company_id)) {
                           $company = $CI->Company_model->get_by_id($value1->company_id);  
                           break;
                       }                       
                   }
               }

               $truck = $CI->Truck_model->get_by_id($value->id);

               if ($pdfMode) {
                   $overAllSummary = __displayTruckDeliveryReportSummaryPDF($deliveries, $truck, $post);   
                   $data1 .= @$overAllSummary['data']; 
                   $total += @$overAllSummary['subTotal'];
               }
               else {
                  $overAllDelivery = __displayTruckDeliveryReport($deliveries, $truck); 
                  $overAllSummary = __displayTruckDeliveryReportSummary($deliveries, $truck, $post);
                  $total += @$overAllDelivery['subTotal'];
                  $data1 .= @$overAllSummary['data'];
                  $data2 .= @$overAllDelivery['data'];
               }

               if ($pdfMode) {
                   $data1 .= '<br><br>';                   
               }
           }    

           if ($pdfMode) {
               $heading .= '<hr>';
               $heading .= '<table style="text-align: left; width: 100%; margin: 0 auto; font-family: Arial;border-collapse: collapse;">';
               $heading .= '<tr><td><strong>To: </strong>'.$company->name.'<td></tr>';
               $heading .= '<tr><td><strong>Address: </strong>'.$company->address.'<td></tr>';
               $heading .= '<tr><td><strong>Date:</strong> <td></tr>';
               $heading .= '<tr><td>Marjun R. Balabat<strong>(Manager)</strong>: _______________________________</td>';                
               $heading .= '<td><strong>Received by:</strong> _________________________</td></tr>';
               $heading .= '</table>';
           }

           if ($pdfMode) {
               $deductions = __getDeductionsSummaryPDF($post, $company);
           }
           else {
               $deductions = __getDeductionsSummary($post, $company);
           }

           $data .= $heading.$data1.$data2;
           $data .= '<div style="background-color:#ffffb3;padding: 5px; width:100%; text-align: right;"><span><h2>Total: &#x20B1;'.number_format($total, 2).'</strong></h2></div>'; 
           $data .= $deductions['data']; 
           $data .= '<div style="background-color:#ffb3b3;padding: 5px; width:100%; text-align: right;"><span><h2>Grand Total: &#x20B1;'.number_format($total - @$deductions['subTotal'], 2).'</strong></h2></div>';           
           $data .= '<br><br>';

       }

       return $data;
    }

    /**
    * Gets the deduction Summary
    * 
    * @param array $post
    * @param array $company
    * @return array
    */
    function __getDeductionsSummary($post = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;
       $instance['subTotal'] = 0;
       
        $deductions = $CI->Deductions_model->get_all_by_where(array(
            'billing_id' => @$post['billing_id'],
            'company_id' => $company->id
        ));

        if (!empty($deductions)) {          
           $data .= '<table class="table table-striped" style="margin-top: 50px;"><thead>';
           $data .= '<tr><th colspan="5" style="background-color: #0e4279; color: #fff;"><h2>Fuel Deductions</h2></th></tr>';
           $data .= '<tr>
               <th scope="col">DT.NO</th>
               <th scope="col">Date</th>               
               <th scope="col">Litters</th>
               <th scope="col">Rate</th>                
               <th scope="col">Amount</th>
             </tr>
           </thead>
           <tbody>';

           $subTotal = 0;   
           foreach ($deductions as $key => $value) { 
               $subTotal += $value->amount;  

               $data .= '<tr>';
               $data .= '<td>'.$value->truck_id.'</td>';
               $data .= '<td><strong>'.date('d-M-Y', strtotime($value->date)).'</strong></td>';              
               $data .= '<td>'.number_format($value->liters, 2).'</td>';
               $data .= '<td>'.number_format($value->rate, 2).'</td>';  
               $data .= '<td>'.(empty($value->amount) ? '-':number_format($value->amount, 2)).'</td>';
               $data .= '</tr>';                           
           }   

           $data .= '<tr>';
           $data .= '<td style="background-color: #ffffb3;"><strong>Sub Total</strong></td>';
           $data .= '<td colspan="3" style="background-color: #ffffb3;"></td>';
           $data .= '<td style="font-size: 18px; background-color:#ffffb3;"><strong>&#x20B1;'.number_format($subTotal, 2).'</strong></td>';
           $data .= '</tr>';  
       }     
       $data .= '</tbody></table>';
       $instance['data'] = $data;

       if (!empty($subTotal)) {
           $instance['subTotal'] = $subTotal;
       }
       return $instance;  
    }

    /**
    * Displays the truck delivery report summary
    * 
    * @param array $obj
    * @param array $truck
    * @param array $post
    * @return string
    */
    function __displayTruckDeliveryReportSummary($obj = array(), $truck = array(), $post = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;
       $dates = __getDatesList($post);      

       if (!empty($dates)) {          
           $data .= '<table class="table table-striped" style="margin-top: 50px;"><thead>';
           if (!empty($truck)) {           
               $data .= '<tr><th colspan="7" style="background-color: #0e4279; color: #fff;"><h2>'.$truck->code.' '.$truck->name.'(Summary)</h2></th></tr>';
           }
           $data .= '<tr>
               <th scope="col">DATE</th>
               <th scope="col">No. of Trips</th>               
               <th scope="col">Rate per m3 per km</th>
               <th scope="col">Capacity(m3)</th>
               <th scope="col">K.m.</th>
               <th scope="col">Plate No.</th>
               <th scope="col">Amount</th>
             </tr>
           </thead>
           <tbody>';


           $subTotal = 0;   
           foreach ($dates as $key => $value) { 
               $computation = __computeByDates($value, $obj);
               $amount = $computation['amount'];
               $subTotal += $amount;  

               $data .= '<tr>';
               $data .= '<td><strong>'.date('d-M-Y', strtotime($value)).'</strong></td>';
               $data .= '<td>'.$computation['count'].'</td>';
               $data .= '<td>'.number_format(RATE_PER_KM, 2).'</td>';
               $data .= '<td>'.number_format($truck->capacity, 2).'</td>';
               $data .= '<td>'.number_format(KILOMETERS, 2).'</td>';                
               $data .= '<td><strong>'.$truck->name.'</strong></td>';
               $data .= '<td>'.(empty($amount) ? '-':$amount).'</td>';
               $data .= '</tr>';                           
           }   

           $data .= '<tr>';
           $data .= '<td style="background-color: #ffffb3;"><strong>Sub Total</strong></td>';
           $data .= '<td colspan="5" style="background-color: #ffffb3;"></td>';
           $data .= '<td style="font-size: 18px; background-color:#ffffb3;"><strong>&#x20B1;'.number_format($subTotal, 2).'</strong></td>';
           $data .= '</tr>';  
       }     
       $data .= '</tbody></table>';
       $instance['data'] = $data;
       if (!empty($subTotal)) {
           $instance['subTotal'] = $subTotal;
       }
       return $instance;    
    }

    /**
    * Displays the specific Reports
    * 
    * @param array $obj
    * @return string
    */
    function __displayTruckDeliveryReport($obj = array(), $truck = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;
       $subTotal = 0;   
       $data .= '<table class="table table-striped" style="margin-top: 50px;"><thead>';
       if (!empty($truck)) {           
           $data .= '<tr><th colspan="7" style="background-color: #b3ecff;"><h2>'.$truck->code.' '.$truck->name.'(per Truck)</h2></th></tr>';
       }
       $data.= '<tr>
               <th scope="col">DATE</th>
               <th scope="col">#</th>
               <th scope="col">Ticket No.</th>
               <th scope="col">Rate per m3 per km</th>
               <th scope="col">Capacity(m3)</th>
               <th scope="col">K.m.</th>
               <th scope="col">Amount</th>
             </tr>
           </thead>
           <tbody>';            
       if (!empty($obj)) {
           $tempDate = date('d-M-Y', strtotime($obj[0]->date));
           $amount = 0;
           $total = 0;            
           $ctr = 1;
           foreach ($obj as $key => $value) {                
               $date = date('d-M-Y', strtotime($value->date));               
               $amount = __computeAmount($value->rate_per_cubic_meter, $value->capacity, $value->kilometers);
               $subTotal += $amount;  
               if ($tempDate != $date) {     
                   $total = __computeByDates(date('Y-m-d', strtotime($tempDate)), $obj)['amount'];
                   $data .= '<tr>';
                   $data .= '<td colspan="6"></td>';
                   $data .= '<td><strong>&#x20B1;'.number_format($total, 2).'</strong></td>';
                   $data .= '</tr>';
                   $tempDate = $date;      
                   $ctr = 1;
               }

               $data .= '<tr>';
               $data .= '<td><strong>'.$date.'</strong></td>';
               $data .= '<td>'.$ctr++.'</td>';
               $data .= '<td>'.$value->ticket_no.'</td>';
               $data .= '<td>'.number_format($value->rate_per_cubic_meter, 2).'</td>';
               $data .= '<td>'.number_format($value->capacity, 2).'</td>';
               $data .= '<td>'.number_format($value->kilometers, 2).'</td>';
               $data .= '<td>'.number_format((int)$amount, 2).'</td>';
               $data .= '</tr>';                

               // Display the last total of the array
               if (_lastKeyArray($obj) == $key) {   
                   $total = __computeByDates(date('Y-m-d', strtotime($tempDate)), $obj)['amount'];
                   $data .= '<tr>';
                   $data .= '<td colspan="6"></td>';
                   $data .= '<td><strong>&#x20B1;'.number_format($total, 2).'</strong></td>';
                   $data .= '</tr>';  
               }


           }

           $data .= '<tr>';
           $data .= '<td style="background-color: #ffffb3;"><strong>Sub Total</strong></td>';
           $data .= '<td colspan="5" style="background-color: #ffffb3;"></td>';
           $data .= '<td style="font-size: 18px; background-color:#ffffb3;"><strong>&#x20B1;'.number_format($subTotal, 2).'</strong></td>';
           $data .= '</tr>';  
       }      

       $data .= '</tbody></table>';

       $instance['data'] = $data;
       if (!empty($subTotal)) {
           $instance['subTotal'] = $subTotal;
       }

       return $instance;
    }

    /**
    * Displays the truck delivery report summary
    * 
    * @param array $obj
    * @param array $truck
    * @param array $post
    * @return string
    */
    function __displayTruckDeliveryReportSummaryPDF($obj = array(), $truck = array(), $post = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;
       $dates = __getDatesList($post);  

       if (!empty($dates)) {          
           $data .= '<table style="border-collapse: collapse; border: 1px solid #e9ecef;font-family: Arial; margin-top: 50px;">';
           if (!empty($truck)) {           
               $data .= '<tr><th colspan="7" style="background-color: #0e4279; color: #fff;"><h2>'.$truck->code.' '.$truck->name.'(Summary)</h2></th></tr>';
           }
           $data .= '<tr>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">DATE</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">No. of Trips</th>               
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Rate per m3 per km</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Capacity(m3)</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">K.m.</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Plate No.</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Amount</th>
             </tr>
           </thead>
           <tbody>';

           $subTotal = 0;   
           $ctr = 1;
           foreach ($dates as $value) { 
               $computation = __computeByDates($value, $obj);
               $amount = $computation['amount'];
               $subTotal += $amount;  

               $backgroundColor = (($ctr % 2 == 0) ? 'background-color: #e9ecef;':'');                
               $data .= '<tr style="'.$backgroundColor.'">';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;"><strong>'.date('d-M-Y', strtotime($value)).'</strong></td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.$computation['count'].'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format(RATE_PER_KM, 2).'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format($truck->capacity, 2).'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format(KILOMETERS, 2).'</td>';                
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;"><strong>'.$truck->name.'</strong></td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.(empty($amount) ? '-':$amount).'</td>';
               $data .= '</tr>';
               $ctr++;
           }   

           $data .= '<tr>';
           $data .= '<td style="background-color:#ffffb3;padding: 8px;"><strong>Sub Total</strong></td>';
           $data .= '<td colspan="5" style="padding: 8px;background-color:#ffffb3;"></td>';
           $data .= '<td style="padding: 12px;font-size: 18px;background-color:#ffffb3;"><strong>&#x20B1;'.number_format($subTotal, 2).'</strong></td>';
           $data .= '</tr>'; 
       }     
       $data .= '</tbody></table>';
       $instance['data'] = $data;
       if (!empty($subTotal)) {
           $instance['subTotal'] = $subTotal;
       }
       return $instance;    
    }


    /**
    * Displays the specific Reports
    * 
    * @param array $obj
    * @return string
    */
    function __displayTruckDeliveryReportPDF($obj = array(), $truck = array(), $post = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;        

       if (!empty($obj)) {
           $data .= '<table style="border-collapse: collapse; border: 1px solid #e9ecef;font-family: Arial; margin-top: 50px;">
           <thead style="border: 1px solid black;">';
           if (!empty($truck)) {           
               $data .= '<tr><th colspan="7" style="background-color: #0e4279; color: #fff;"><h2>'.$truck->code.' '.$truck->name.'(per Truck)</h2></th></tr>';
           }
           $data .= '<tr>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">DATE</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">#</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Ticket No.</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Rate per m3 per km</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Capacity(m3)</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">K.m.</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Amount</th>                
             </tr>
           </thead>
           <tbody>';          

           $tempDate = date('d-M-Y', strtotime($obj[0]->date));
           $amount = 0;
           $total = 0;
           $subTotal = 0;   
           $ctr = 1;
           foreach ($obj as $key => $value) {                
               $date = date('d-M-Y', strtotime($value->date));               
               $amount = __computeAmount($value->rate_per_cubic_meter, $value->capacity, $value->kilometers);
               $subTotal += $amount;  
               if ($tempDate != $date) {     
                   $total = __computeByDates(date('Y-m-d', strtotime($tempDate)), $obj)['amount'];
                   $data .= '<tr>';
                   $data .= '<td colspan="6"></td>';
                   $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;"><strong>&#x20B1;'.number_format($total, 2).'</strong></td>';
                   $data .= '</tr>';
                   $tempDate = $date;      
                   $ctr = 1;
               }

               $backgroundColor = (($ctr % 2 == 0) ? 'background-color: #e9ecef;':'');                
               $data .= '<tr style="'.$backgroundColor.'">';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;"><strong>'.$date.'</strong></td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.$ctr++.'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.$value->ticket_no.'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format($value->rate_per_cubic_meter, 2).'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format($value->capacity, 2).'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format($value->kilometers, 2).'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format((int)$amount, 2).'</td>';
               $data .= '</tr>';                

               // Display the last total of the array
               if (_lastKeyArray($obj) == $key) {   
                   $total = __computeByDates(date('Y-m-d', strtotime($tempDate)), $obj)['amount'];
                   $data .= '<tr>';
                   $data .= '<td colspan="6"></td>';
                   $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;"><strong>&#x20B1;'.number_format($total, 2).'</strong></td>';                    
                   $data .= '</tr>';  
               }      
           }

           $data .= '<tr>';
           $data .= '<td style="background-color:#ffffb3;padding: 8px;"><strong>Sub Total</strong></td>';
           $data .= '<td colspan="5" style="padding: 8px;background-color:#ffffb3;"></td>';
           $data .= '<td style="padding: 12px;font-size: 18px;background-color:#ffffb3;"><strong>&#x20B1;'.number_format($subTotal, 2).'</strong></td>';
           $data .= '</tr>';  
       } 

       $data .= '</tbody></table>';

       $instance['data'] = $data;
       if (!empty($subTotal)) {
           $instance['subTotal'] = $subTotal;
       }

       return $instance;
    }

    /**
    * Gets the summary pdf
    * 
    * @param array $post
    * @param array $company
    * @return array
    */
    function __getDeductionsSummaryPDF($post = array(), $company = array()) {
       $CI =& get_instance();
       $data = null;

       $deductions = $CI->Deductions_model->get_all_by_where(array(
           'billing_id' => @$post['billing_id'],
           'company_id' => $company->id
       ));
       
        if (!empty($deductions)) {          
           $data .= '<table style="width: 100%; border-collapse: collapse; border: 1px solid #e9ecef;font-family: Arial; margin-top: 50px;"><thead>';
           $data .= '<tr><th colspan="5" style="background-color: #0e4279; color: #fff;"><h2>Fuel Deductions</h2></th></tr>';
           $data .= '<tr>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">DT.NO</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Date</th>               
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Litters</th>
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Rate</th>                
               <th style="border: 1px solid #e9ecef;padding: 10px;background-color: #007bff;color: #fff;">Amount</th>
             </tr>
           </thead>
           <tbody>';

           $subTotal = 0;   
           foreach ($deductions as $key => $value) { 
               $subTotal += $value->amount;  

               $data .= '<tr>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.$value->truck_id.'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;"><strong>'.date('d-M-Y', strtotime($value->date)).'</strong></td>';              
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format($value->liters, 2).'</td>';
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.number_format($value->rate, 2).'</td>';  
               $data .= '<td style="border: 1px solid #e9ecef;padding: 8px;">'.(empty($value->amount) ? '-':  number_format($value->amount, 2)).'</td>';
               $data .= '</tr>';                           
           }   

           $data .= '<tr>';
           $data .= '<td style="background-color: #ffffb3;"><strong>Sub Total</strong></td>';
           $data .= '<td colspan="3" style="background-color: #ffffb3;"></td>';
           $data .= '<td style="padding: 2px; font-size: 18px; background-color:#ffffb3;"><strong>&#x20B1;'.number_format($subTotal, 2).'</strong></td>';
           $data .= '</tr>';  
       }     
       $data .= '</tbody></table>';
       $instance['data'] = $data;

       if (!empty($subTotal)) {
           $instance['subTotal'] = $subTotal;
       }
       return $instance;  
    }
