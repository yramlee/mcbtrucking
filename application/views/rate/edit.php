<?php echo @$prompt ?>
<form method="post">    
    <div class="row">        
        <div class="col">
            <label for="amount">Amount</label>
            <input id="amount" required="" name="amount" type="text" class="form-control" value="<?php echo (!empty($_POST['amount']) ? $_POST['amount']:@$data->amount) ?>">
        </div>        
    </div>
    <div class="row">
        <div class="col">
            <br>
            <button type="submit" class="btn btn-primary btn-block btn-lg">Save <?php echo ucwords($page) ?></button>
        </div>
    </div>  
</form>