<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary btn-block btn-lg" href="<?php echo base_url().$page ?>/add">Add <?php echo ucwords($page)?> Date</a>
        <br>
    </div>
    <div class="col-md-12">
        <table id="deliveries" class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Ref#</th>
                <th scope="col">Company</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Action?</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($model)): $ctr = 1; ?>
                <?php foreach($model as $values): ?>
                    <tr>
                        <th scope="row"><?php echo $ctr++ ?></th>
                        <td><?php echo $values->ref_no ?></td>
                        <td><?php echo my_company()[$values->company_id] ?></td>
                        <td><?php echo date('F d, Y', strtotime($values->start_date)); ?></td>
                        <td><?php echo date('F d, Y', strtotime($values->end_date)); ?></td>
                        <td><a class="btn btn-success btn-xs" href="<?= base_url().$page.'/edit/'.$values->id ?>">Edit</a>
                            <a class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteItem<?= $values->id ?>" href="#">Delete</a>
                            <?= showModal('Delete Item', '<a class="btn btn-danger btn-lg btn-block" href="'.base_url().$page.'/delete/'.$values->id.' ">Yes</a>', 'deleteItem'.$values->id) ?>
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