<?php echo @$prompt ?>
<form method="post">    
    <div class="row">        
        <div class="col">
            <label for="name">Name</label>
            <input id="name" required="" name="name" type="text" class="form-control">
        </div>  
        <div class="col">
            <label for="description">Description</label>
            <input id="description" name="description" type="text" class="form-control">
        </div>      
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page) ?></button>
        </div>
    </div>  
</form>