<?php

/**
     * Creates a pdf file from an html
     * 
     * @param string $filename
     * @param string $html
     */
    function createPdf($filename = null, $html = null) { 
        isLoggedIn();
        ini_set('memory_limit','50M'); // boost the memory limit if it's low ;)  
        include APPPATH.'third_party/mpdf/mpdf.php';     
        $pdf = new mPDF();            
        $pdf->Bookmark('Start of the document');            
        $pdf->WriteHTML($html);
        $pdf->Output($filename, 'I');
    }
    
    /**
     * Computes the amount
     * 
     * @param double $rate
     * @param double $capacity
     * @param double $distance
     * @return double
     */
    function __computeAmount($rate, $capacity, $distance) {
        return doubleval($rate * $capacity * $distance);
    }
    
    /**
     * Computes deliveries by date
     * 
     * @param string $date
     * @param array $obj
     * @return int or double
     */
    function __computeByDates($date = null, $obj = array()) {
        $instance = array();
        $amount = 0;
        $count = 0;
        foreach ($obj as $key => $value) {
            if ($date == $value->date) {
                $amount += __computeAmount($value->rate_per_cubic_meter, $value->capacity, $value->kilometers);
                $count++;
            }               
        }
        
        $instance['amount'] = $amount;
        $instance['count'] = $count;
        return $instance;
    }
    
    /**
     * Generates a date list
     * 
     * @param array $post
     * @return array
     */
    function __getDatesList($post = array()) {
        $data = array();        
        $date_start = date('Y-m-d', strtotime($post['delivery_date_start']));
        $date_end = date('Y-m-d', strtotime($post['delivery_date_end']));
        $temp_date = null;  
        
        for($i = 0; $i <= 31; $i++) { 
            $date = new DateTime($date_start);
            $date->modify('+'.$i.' day'); 
            $temp_date = $date->format('Y-m-d');
            $data[] = $temp_date;
            if ($temp_date == $date_end) {
                break;
            }
        }        
        
        return $data;
    }
