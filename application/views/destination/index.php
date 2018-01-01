<div class="row">
    <div class="col-md-12">
        <a class="btn btn-primary btn-block btn-lg" href="<?php echo base_url().$page ?>/add">Add <?php echo ucwords($page)?></a>
        <br>
    </div>
    <div class="col-md-12">
        <table id="deliveries" class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">From</th>
                <th scope="col">To</th>
                <th scope="col">Action?</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($model)): $ctr = 1; ?>
                <?php foreach($model as $values): ?>
                    <tr>
                        <th scope="row"><?php echo $ctr++ ?></th>
                        <td><?php echo $values->from ?></td>
                        <td><?php echo $values->to ?></td>
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