<?php 
include "php/db_connection.php";
$state= "";
if(isset($_POST["new_invoice"])){
  $customer_name = $_POST['customer_name'];
  $payment_type = $_POST['payment_type'];
  $invoice_date = $_POST['invoice_date'];
  $bread_name = $_POST['bread_name'];
  $quantity = $_POST['quantity'];
  $total = 0;
  $fetch = "SELECT * FROM medicines WHERE BREAD_NAME = '$bread_name'";
  $ft = mysqli_query($con, $fetch);
$row = mysqli_fetch_array($ft);
  $rate = $total + $row['RATE'];
  $grand_total = $quantity * $rate; 

  $payment_status = ($payment_type == "Payment Due") ? "DUE" : "PAID";
 

  if($con) {
    $toupdate = "SELECT * FROM medicines_stock WHERE NAME = '$bread_name'";
    $resultupdate = mysqli_query($con, $toupdate);
    while($row = mysqli_fetch_array($resultupdate)) {
      $Q =$row['QUANTITY'] - $quantity;
    
       $update = "UPDATE medicines_stock SET QUANTITY = '$Q' WHERE NAME = '$bread_name'";
       $runupdate = mysqli_query($con, $update);
       if($runupdate){
    $query = "INSERT INTO invoices (BREAD_NAME, INVOICE_DATE, CUSTOMER_NAME, TOTAL_AMOUNT, QUANTITY, PAYMENT_STATUS, PAYMENT_TYPE) VALUES('$bread_name', '$invoice_date', '$customer_name', '$grand_total', '$quantity','$payment_status','$payment_type')";
    $result = mysqli_query($con, $query);
    if($result)
      $state =  "Bread Sold";
    else
      $state = "Sorry there is an error!";
  }
}
  }
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>New Invoice</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script src="js/suggestions.js"></script>
    <script src="js/add_new_invoice.js"></script>
    <script src="js/manage_invoice.js"></script>
    <script src="js/validateForm.js"></script>
    <script src="js/restrict.js"></script>
  </head>
  <body>
    <div id="add_new_customer_model">
      <div class="modal-dialog">
      	<div class="modal-content">
      		<div class="modal-header" style="background-color: #ff5252; color: white">
            <div class="font-weight-bold">Add New Customer</div>
      			<button class="close" style="outline: none;" onclick="document.getElementById('add_new_customer_model').style.display = 'none';"><i class="fa fa-close"></i></button>
      		</div>
      		<div class="modal-body">
            <?php
              include('sections/add_new_customer.html');
            ?>
      		</div>
      	</div>
      </div>
    </div>
    <!-- including side navigations -->
   <?php include("sections/sidenav.html"); ?>

    <div class="container-fluid"  >
      <div class="container">

        <!-- header section -->
        <?php
          require "php/header.php";
          createHeader('clipboard', 'New Invoice', 'Create New Invoice');
        ?>
        <!-- header section end -->

        <form action="new_invoice.php" method="post">
        <!-- form content -->
        <div class="row">
          <!-- customer details content -->
          <div class="row col col-md-12">
            <div class="col col-md-6 form-group">
              <label class="font-weight-bold" for="customers_name">Customer Name :</label>
              <input id="customers_name" type="text" class="form-control" placeholder="Customer Name" name="customer_name" onkeyup="showSuggestions(this.value, 'customer');">
              <code class="text-danger small font-weight-bold float-right" id="customer_name_error" style="display: none;"></code>
              <div id="customer_suggestions" class="list-group position-fixed" style="z-index: 1; width: 18.30%; overflow: auto; max-height: 200px;"></div>
            </div>
            <!-- <div class="col col-md-3 form-group">
              <label class="font-weight-bold" for="customers_address">Address :</label>
              <input id="customers_address" type="text" class="form-control" name="customers_address" placeholder="Address" disabled>
            </div>
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="invoice_number">Invoice Number :</label>
              <input id="invoice_number" type="text" class="form-control" name="invoice_number" placeholder="Invoice Number" disabled>
            </div> -->
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="paytype">Payment Type :</label>
              <select id="payment_type" name="payment_type" class="form-control">
              	<option value="Cash Payment">Cash Payment</option>
                <option value="Transfer">Transfer</option>
                <option value="P.O.S">P.O.S</option>
                <option value="Payment Due">Payment Due</option>
              </select>
            </div>
            <div class="col col-md-2 form-group">
               <label class="font-weight-bold" for="">Date :</label>
              <input type="date" name="invoice_date" class="datepicker form-control hasDatepicker" id="invoice_date" value='<?php echo date('Y-m-d'); ?>' onblur="checkDate(this.value, 'date_error');">
              <code class="text-danger small font-weight-bold float-right" id="date_error" style="display: none;"></code>
            </div>
          </div>
</div>
          <!-- customer details content end -->

          <!-- new user button -->
          <div class="row col col-md-6">
            <div class="col col-md-6 form-group">
              <button class="btn btn-primary form-control" onclick="document.getElementById('add_new_customer_model').style.display = 'block';">New Customer</button>
            </div>
            <!-- <div class="col col-md-1 form-group"></div>
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="customers_contact_number">Contact Number :</label>
              <input id="customers_contact_number" type="number" class="form-control" name="customers_contact_number" placeholder="Contact Number" disabled>
            </div>-->
          </div>

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 3px solid  #02b6ff;">
          </div>

          <!-- add medicines -->
          <div class="row col col-md-12">
            <div class="row col col-md-12 font-weight-bold">
              <div class="col col-md-6">Bread Name</div>
              <div class="col col-md-6">Quantity</div>
            </div>
          </div>
          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
          </div>

          <div class="row col col-md-12 " id="invoice_medicine_list_div">
          <!-- customer details content -->
          <div class="row col col-md-12">
            <div class="col col-md-6 form-group">
              <input id="medicine" type="text" class="form-control" placeholder="" name="bread_name" onkeyup="showSuggestions(this.value, 'medicine');">
              <code class="text-danger small font-weight-bold float-right" id="customer_name_error" style="display: none;"></code>
              <div id="customer_suggestions" class="list-group position-fixed" style="z-index: 1; width: 18.30%; overflow: auto; max-height: 200px;"></div>
</div>          <!-- end medicines -->
            <div class="col col-md-6 form-group">
              <input type="text" class="form-control" name="quantity" value="0" id="total_amount">
            </div>
</div>
          <div class="row col col-md-12">
            <div id="save_button" class="col col-md-12 form-group float-right">
              <label class="font-weight-bold" for=""></label>
              <button class="btn btn-success form-control font-weight-bold" type="submit" name="new_invoice">Save</button>
            </div>
             </div>

          <div id="invoice_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family: sans-serif;"><?php echo $state;?></div>

        </div>
</form>
        <!-- form content end -->
        <hr style="border-top: 2px solid #ff5252;">
      </div>
    </div>
  </body>
</html>
