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
            <label for="truck">Delivery Date:</label>
            <input required="" name="date" id="datepicker" class="form-control" type="text" value="<?php echo (!empty($_POST['date']) ? $_POST['date']:date('m/d/Y')) ?>">
        </div>
    </div>
    <div class="row">        
        <div class="col">
            <label for="truck">Ticket #</label>
            <input required="" name="ticket_no" type="text" class="form-control">
        </div>
        <div class="col">
            <label for="truck">Truck</label>
            <select required="" name="truck_id" class="form-control" id="truck">
            <?php echo select2(TRUCK(),(!empty($_POST['truck_id']) ? $_POST['truck_id']:'')) ?>
            </select>
        </div>        
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save</button>
        </div>
    </div>  
</form>