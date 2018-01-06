<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary btn-block btn-lg" href="<?php echo base_url() ?>delivery/add/company">Add Delivery</a>
        <br>
    </div>
    <div class="col-md-12">
        <form method="POST">
            <div class="row">
                <div class="col">
                    <label for="truck">Company</label>
                    <select required="" name="company_id" class="form-control" id="truck">
                        <option value="">Select a Company</option>
                    <?php echo select2(COMPANY(), (empty($_POST['company_id']) ? $data->company_id: $_POST['company_id'])) ?>
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
            <br>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-primary btn-block btn-lg">Search</button>
                </div>
            </div><br>
        </form>
    </div>
    <?php if (!empty($deliveries)): $ctr = 1; ?>
    <div class="col-md-12">
        <h2><?= $company->name ?></h2>
    </div>
    <div class="col-md-12">
        <table id="deliveries" class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>              
                <th scope="col">Date</th>
                <?php if($company->form_type == FORM_TYPE1):?>
                    <th scope="col">ID</th>
                    <th scope="col">Ticket #</th>
                    <th scope="col">Rate per m3</th>
                    <th scope="col">Capacity</th> 
                    <th scope="col">Km.</th> 
                <?php elseif($company->form_type == FORM_TYPE2): ?>
                    <th scope="col">ID</th>
                    <th scope="col">Shift</th>
                    <th scope="col">Destination</th>
                    <th scope="col">No. of Bags</th>
                    <th scope="col">Flecon Bags</th>
                    <th scope="col">Rate</th>
                    <th scope="col">Trips</th> 
                <?php endif; ?>
                    <th scope="col">Action?</th>
              </tr>
            </thead>
            <tbody>
              
                <?php foreach($deliveries as $values): ?>
                    <tr>
                        <th scope="row"><?php echo $ctr++ ?></th>
                        <td><?php echo date('F d, Y', strtotime($values->date)); ?></td>                        
                        <?php if($company->form_type == FORM_TYPE1):?> 
                            <td><?php echo $values->id ?></td>
                            <td><?php echo $values->ticket_no ?></td>
                            <td><?php echo $values->rate_per_cubic_meter ?></td>
                            <td><?php echo $values->capacity ?></td>
                            <td><?php echo $values->kilometers ?></td>
                        <?php elseif($company->form_type == FORM_TYPE2): ?>     
                            <td><?php echo $values->id ?></td>
                            <td><?php echo @my_shift()[@$values->shift_id] ?></td>
                            <td><?php echo @my_destination()[@$values->destination_id] ?></td>
                            <td><?php echo @$values->no_of_bags ?></td>
                            <td><?php echo @$values->flecon_bags ?></td>
                            <td><?php echo @my_rate()[$values->rate_id] ?></td>
                            <td><?php echo @$values->no_of_trips ?></td>
                        <?php endif; ?>                           
                            
                        <td><a class="btn btn-success btn-xs" href="<?= base_url().'delivery/edit/'.$values->id ?>">Edit</a>
                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteItem<?= $values->id ?>" href="<?= base_url().'delivery/delete/'.$values->id ?>">Delete</a>
                            <?= showModal('Delete Item', '<a class="btn btn-danger btn-lg btn-block" href="'.base_url().'delivery/delete/'.$values->id.' ">Yes</a>', 'deleteItem'.$values->id) ?>
                        </td>
                    </tr>
                <?php endforeach; ?> 
            </tbody>
        </table>
        <div class="col-md-12">
            <h2><?= $company->name ?></h2>
        </div>
    </div>
     <?php endif; ?>
</div>