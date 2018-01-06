<?php echo @$prompt ?>
<form method="post">
    <div class="row">
        <div class="col">
            <label for="company">Company</label>
            <select required="" name="company_id" class="form-control" id="company">
            <?php echo select2(COMPANY(), (!empty($_POST['company_id']) ? $_POST['company_id']:'')) ?>
            </select>
        </div>
    </div>
    <?php if(!empty($_POST['company_id'])):?>
        <div class="row">
            <div class="col">
                <label for="biling_date">Billing Date</label>
                <select required="" name="billing_id" class="form-control" id="biling_date">
                <?php echo select2(BILLING_PER_COMPANY($_POST['company_id']),(!empty($_POST['billing_id']) ? $_POST['billing_id']:'')) ?>
                </select>
            </div>
        </div>
    <?php endif; ?>
    <?php if(!empty($company)): ?>    
        <?php if($company->form_type == FORM_TYPE1): ?>
            <div class="row">
                <div class="col">
                    <label for="truck">Truck</label>
                    <select name="truck_id" class="form-control" id="truck">
                        <option value="">All</option>
                        <?php echo select2(TRUCK(), @$_POST['truck_id']) ?>
                    </select>
                </div>        
            </div>
        <?php elseif($company->form_type == FORM_TYPE2): ?>
            <div class="row">
                <div class="col">
                    <label for="destination_id">Destination</label>
                    <select name="destination_id" class="form-control" id="destination_id">
                        <option value="">All</option>
                        <?php echo select2(DESTINATION(), @$_POST['destination_id']) ?>
                    </select>
                </div>        
            </div>
        <?php endif; ?>
    <?php endif;?>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Search</button>
        </div>
    </div>  
</form>
<br><br>

<?php if(!empty($deliveries)): ?>
<form method="post">
    <?php if($company->form_type == FORM_TYPE1): ?>
    <input type="hidden" name="company_id" value="<?php echo @$_POST['company_id'] ?>">
    <input type="hidden" name="billing_id" value="<?php echo @$_POST['billing_id'] ?>">
    <input type="hidden" name="truck_id" value="<?php echo @$_POST['truck_id'] ?>">
    <?php elseif($company->form_type == FORM_TYPE2): ?>
    <input type="hidden" name="company_id" value="<?php echo @$_POST['company_id'] ?>">
    <input type="hidden" name="billing_id" value="<?php echo @$_POST['billing_id'] ?>">
    <input type="hidden" name="destination_id" value="<?php echo @$_POST['destination_id'] ?>">
    <?php endif; ?>
<button name="download_pdf" type="submit" class="btn btn-lg btn-block btn-success" value="1">Download PDF Report</button>  
</form>
<br>
<h1><?= @$company->name ?></h1><hr>
<?php echo @$summary ?>
<?php echo @$deliveries ?>
<?php endif; ?>
