<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary btn-block btn-lg" href="<?php echo base_url() ?>deductions/add/company">Add Deductions</a>
        <br>
    </div>
    <div class="col-md-12">
        <table id="deliveries" class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Billing</th>
                <th scope="col">DT. No.</th>
                <th scope="col">Company</th>
                <th scope="col">Date</th>
                <th scope="col">Liters</th>
                <th scope="col">Rate</th>
                <th scope="col">Amount</th>
                <th scope="col">Action?</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($deductions)): $ctr = 1; ?>
                <?php foreach($deductions as $values): ?>
                    <tr>
                        <th scope="row"><?php echo $ctr++ ?></th>
                        <td><?php echo my_billing()[$values->billing_id] ?></td>
                        <td><?php echo my_truck()[$values->truck_id] ?></td>
                        <td><?php echo my_company()[$values->company_id] ?></td>
                        <td><?php echo date('F d, Y', strtotime($values->date)); ?></td>
                        <td><?= number_format($values->liters, 2)  ?></td>
                        <td><?= number_format($values->rate, 2) ?></td>
                        <td><?= number_format($values->amount, 2) ?></td>
                        <td><a class="btn btn-success btn-xs" href="<?= base_url().'deductions/edit/'.$values->id ?>">Edit</a>
                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteItem<?= $values->id ?>" href="#">Delete</a>
                            <?= showModal('Delete Item', '<a class="btn btn-danger btn-lg btn-block" href="'.base_url().'deductions/delete/'.$values->id.' ">Yes</a>', 'deleteItem'.$values->id) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>              
              <?php else: ?>
              <tr><td colspan="6"><h3>No results found!</h3></td></tr>
              <?php endif; ?>
            </tbody>
          </table>
    </div>
</div>