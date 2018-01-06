<?php echo @$prompt ?>
<form method="post">    
    <div class="row">
        <div class="col">
            <label for="company">Company</label>
            <select required="" name="company_id" class="form-control" id="company">
            <?php echo select2(COMPANY(),(!empty($_POST['company_id']) ? $_POST['company_id']:'')) ?>
            </select>
        </div> 
    </div>
    <div class="row">
        <div class="col">
            <label>Start Date:</label>
            <input name="start_date" id="delivery_date_start" class="form-control" type="text" value="<?php echo (!empty($_POST['start_date']) ? $_POST['start_date']:date('m/d/Y')) ?>">
        </div>
        <div class="col">
            <label>End Date:</label>
            <input name="end_date" id="delivery_date_end" class="form-control" type="text" value="<?php echo (!empty($_POST['end_date']) ? $_POST['end_date']:date('m/d/Y')) ?>">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page) ?></button>
        </div>
    </div>  
</form>