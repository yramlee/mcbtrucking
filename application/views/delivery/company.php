<div class="row">
    <div class="col-md-12">
        <h2>Select Company</h2>
        
        <table id="deliveries" class="table table-striped">
            <thead>
              <tr>
                <th scope="col">#</th> 
                <th scope="col">ID</th>  
                <th scope="col">Company</th>                
                <th scope="col">Form Type</th>
              </tr>
            </thead>
            <tbody>
                <?php 
                    if (!empty($company)) { 
                        $ctr = 1;
                        foreach ($company as $value) {
                           echo '<tr>';
                           echo '<td>'.$ctr++.'</td>';
                           echo '<td>'.$value->id.'</td>';
                           echo '<td><a href="'.base_url().'delivery/'.$this->uri->segment(2).'/company/'.$value->id.'">'.$value->name.'</a></td>';
                           echo '<td>'.$value->form_type.'</td>';
                           echo '</tr>';
                        } 
                    }
                
                ?>
            </tbody>        
        </table>
    </div>
</div>


