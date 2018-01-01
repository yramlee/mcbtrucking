<?php echo @$prompt ?>
<center><h2>Editing a Delivery to <strong><?= $company_data->name ?></strong></h2></center>
<?php     
    if ($company_data->form_type == FORM_TYPE1) {
        include APPPATH.'views/forms/edit/form_type1.php';
    }
    elseif ($company_data->form_type == FORM_TYPE2) {
         include APPPATH.'views/forms/edit/form_type2.php';
    }

?>