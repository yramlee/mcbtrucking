    </main><!-- /.container -->
    <script src="<?php echo base_url() ?>includes/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url() ?>includes/jquery.popper.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>includes/datatables/datatables.min.css"/> 
    <script type="text/javascript" src="<?php echo base_url() ?>includes/datatables/datatables.min.js"></script>
    <script src="<?php echo base_url() ?>includes/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url() ?>includes/datepicker/js/gijgo.min.js" type="text/javascript"></script>
    <link href="<?php echo base_url() ?>includes/datepicker/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <script>
        $(document).ready(function() {
            $('#deliveries').DataTable();
            $('#datepicker').datepicker({
                uiLibrary: 'bootstrap4'
            });
            
            $('#delivery_date_start').datepicker({
                uiLibrary: 'bootstrap4'
            });
            
            $('#delivery_date_end').datepicker({
                uiLibrary: 'bootstrap4'
            });
        });
    </script>
  </body>
</html>