<?php echo @$prompt ?>
<form method="post">
    <div class="row">        
        <div class="col">
            <label for="truck">Name</label>
            <input required="" name="name" type="text" class="form-control">
        </div>
    </div>
    <div class="row">
        <div class="col">
            <label for="type">Form Types</label>
            <select required="" name="form_type" class="form-control" id="type">
                <?php echo select2(TYPE_FORMS()) ?>
            </select>
        </div>
        <div class="col">
            <label for="truck">Address</label>
            <input required="" name="address" type="text" class="form-control">
        </div> 
        <div class="col">
            <label for="truck">Description</label>
            <input name="description" type="text" class="form-control">
        </div> 
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page) ?></button>
        </div>
    </div>  
</form>