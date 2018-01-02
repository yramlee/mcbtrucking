<?php echo @$prompt ?>
<form method="post">    
    <div class="row">        
        <div class="col">
            <label for="from">From</label>
            <input id="from" name="from" type="text" class="form-control">
        </div> 
        <div class="col">
            <label for="to">To</label>
            <input id="to" required="" name="to" type="text" class="form-control">
        </div> 
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page) ?></button>
        </div>
    </div>  
</form>