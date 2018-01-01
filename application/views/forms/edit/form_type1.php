<form method="post">
    <div class="row">
        <div class="col">
            <label for="truck">Delivery Date:</label>
            <input required="" name="date" id="datepicker" class="form-control" type="text" value="<?php echo (empty($_POST['date']) ? date('m/d/Y', strtotime($data->date)): date('m/d/Y')) ?>">
        </div>      
    </div>
    <div class="row">        
        <div class="col">
            <label for="truck">Ticket #</label>
            <input name="ticket_no" value="<?php echo (empty($_POST['ticket_no']) ? $data->ticket_no: $_POST['ticket_no']) ?>" type="text" class="form-control">
        </div>
        <div class="col">
            <label for="truck">Truck</label>
            <select required="" name="truck_id" class="form-control" id="truck">
            <?php echo select2(TRUCK(), (empty($_POST['truck_id']) ? $data->truck_id: $_POST['truck_id'])) ?>
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