<?php echo @$prompt ?>
<form method="post">    
    <div class="row">        
        <div class="col">
            <label for="name">Name</label>
            <input id="name" required="" name="name" type="text" class="form-control" value="<?php echo (!empty($_POST['name']) ? $_POST['name']:@$data->name) ?>">
        </div>        
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page)?></button>
        </div>
    </div>  
</form>