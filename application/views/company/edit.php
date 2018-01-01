<?php echo @$prompt ?>
<form method="post">
    <div class="row">        
        <div class="col">
            <label for="truck">Name</label>
            <input required="" name="name" type="text" class="form-control" value="<?php echo (!empty($_POST['name']) ? $_POST['name']:@$data->name) ?>">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="type">Form Type</label>
            <select required="" name="form_type" class="form-control" id="type">
                <?php echo select2(TYPE_FORMS(), (!empty($_POST['form_type']) ? $_POST['form_type']:@$data->form_type)) ?>
            </select>
        </div>
        <div class="col">
            <label for="truck">Address</label>
            <input required="" name="address" type="text" class="form-control" value="<?php echo (!empty($_POST['address']) ? $_POST['address']:@$data->address) ?>">
        </div> 
        <div class="col">
            <label for="truck">Description</label>
            <input name="description" type="text" class="form-control" value="<?php echo (!empty($_POST['description']) ? $_POST['description']:@$data->description) ?>">
        </div> 
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page) ?></button>
        </div>
    </div>  
</form>