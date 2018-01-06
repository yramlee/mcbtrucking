<?php echo @$prompt ?>
<center><h2>Adding Deductions to <strong><?= $company->name ?></strong></h2></center>
<form method="post">
    <div class="row">
        <div class="col">
            <label for="biling_date">Billing Date</label>
            <select required="" name="billing_id" class="form-control" id="biling_date">
            <?php echo select2(BILLING_PER_COMPANY($this->uri->segment(4)),(!empty($_POST['billing_id']) ? $_POST['billing_id']:'')) ?>
            </select>
        </div>
    </div>
    <div class="row">
         <div class="col">
            <label for="truck">Date:</label>
            <input required="" name="date" id="datepicker" class="form-control" type="text" value="<?php echo date('m/d/Y') ?>">
        </div>
        <div class="col">
            <label for="type">Type</label>
            <select required="" name="type" class="form-control" id="type">
                <?php echo select2(TYPE_DEDUCTIONS()) ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="truck">Truck</label>
            <select required="" name="truck_id" class="form-control" id="truck">
            <?php echo select($trucks, @$_POST['truck_id']) ?>
            </select>
        </div>
    </div>
    <div class="row">        
        <div class="col">
            <label for="truck">Liters</label>
            <input required="" name="liters" type="text" class="form-control">
        </div>  
        <div class="col">
            <label for="truck">Rate</label>
            <input required="" name="rate" type="text" class="form-control">
        </div>         
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save Deduction</button>
        </div>
    </div>  
</form>