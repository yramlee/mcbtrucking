<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>MCB - Trucking Services</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url() ?>includes/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url() ?>includes/css/style.css" rel="stylesheet">
    
  </head>

  <body>

    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
      <a class="navbar-brand" href="#">MCB</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown <?php echo ($this->uri->segment(1) == 'delivery' || $this->uri->segment(1) == '' ? 'active':'') ?>">
            <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Deliveries</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="<?php echo base_url().'delivery' ?>">List</a>   
              <a class="dropdown-item" href="<?php echo base_url().'destination' ?>">Destination</a> 
              <a class="dropdown-item" href="<?php echo base_url().'shift' ?>">Shift</a>
              <a class="dropdown-item" href="<?php echo base_url().'vessel' ?>">Vessel</a>
              <a class="dropdown-item" href="<?php echo base_url().'rate' ?>">Rate</a>
              <a class="dropdown-item" href="<?php echo base_url().'material' ?>">Material</a>
            </div>
          </li>
          <li class="nav-item <?php echo ($this->uri->segment(1) == 'reports' ? 'active':'') ?>">
            <a class="nav-link" href="<?php echo base_url().'reports' ?>">Reports</a>
          </li>  
          <li class="nav-item <?php echo ($this->uri->segment(1) == 'deductions' ? 'active':'') ?>">
            <a class="nav-link" href="<?php echo base_url().'deductions' ?>">Deductions</a>
          </li>           
          <li class="nav-item <?php echo ($this->uri->segment(1) == 'company' ? 'active':'') ?>">
            <a class="nav-link" href="<?php echo base_url().'company' ?>">Company</a>
          </li> 
          <li class="nav-item <?php echo ($this->uri->segment(1) == 'logout' ? 'active':'') ?>">
            <a class="nav-link" href="<?php echo base_url().'logout' ?>">Logout</a>
          </li>
        </ul>
<!--        <form class="form-inline my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>-->
      </div>
    </nav>

    <main role="main" class="container">

      <div class="starter-template">
        <h1>MCB Trucking Services</h1>        
      </div>

    

