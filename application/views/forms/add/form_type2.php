<form method="post"> 
    <div class="row">
        <div class="col">
            <label for="above">Above?</label>
            <select name="above" class="form-control" id="above">                       
                <?php echo select2(TYPE_YESNO(), (!empty($_POST['above']) ? $_POST['above']:'')) ?>
            </select>
        </div>        
    </div
    <div class="row">
        <div class="col">
            <label for="truck">Delivery Date:</label>
            <input required="" name="date" id="datepicker" class="form-control" type="text" value="<?php echo (!empty($_POST['date']) ? $_POST['date']:date('m/d/Y')) ?>">
        </div>
        <div class="col">
            <label for="shift_id">Shift</label>
            <select required="" name="shift_id" class="form-control" id="shift_id">
            <?php echo select2(SHIFT(),(!empty($_POST['shift_id']) ? $_POST['shift_id']:'')) ?>
            </select>
        </div>
        <div class="col">
            <label for="rate_id">Rate</label>
            <select required="" name="rate_id" class="form-control" id="rate_id">
            <?php echo select2(RATE(),(!empty($_POST['rate_id']) ? $_POST['rate_id']:'')) ?>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="material_id">Material</label>
            <select name="material_id" class="form-control" id="material_id">
                <option selected="" value="">No Material Included</option>
                <?php echo select2(MATERIAL(),(!empty($_POST['material_id']) ? $_POST['material_id']:'')) ?>
            </select>
        </div>
    </div>
    <div class="row">        
        <div class="col">
            <label for="no_of_bags">No. of Bags</label>
            <input id="no_of_bags" name="no_of_bags" type="number" class="form-control" value="<?php echo (!empty($_POST['no_of_bags']) ? $_POST['no_of_bags']:'') ?>">
        </div> 
        <div class="col">
            <label for="flecon_bags">Flecon Bags</label>
            <input id="flecon_bags" name="flecon_bags" type="number" class="form-control" value="<?php echo (!empty($_POST['flecon_bags']) ? $_POST['flecon_bags']:'') ?>">
        </div>         
    </div>
    <div class="row">
        <div class="col">
            <label for="no_of_trips">No. of Trips</label>
            <input id="no_of_trips" name="no_of_trips" type="number" class="form-control" value="<?php echo (!empty($_POST['no_of_trips']) ? $_POST['no_of_trips']:'') ?>">
        </div>
        <div class="col">
            <label for="shift">Destination</label>
            <select name="destination_id" class="form-control" id="shift">
            <?php echo select2(DESTINATION(),(!empty($_POST['destination_id']) ? $_POST['destination_id']:'')) ?>
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