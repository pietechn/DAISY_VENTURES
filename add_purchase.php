<?php 
include "php/db_connection.php";
$state= "";
$total = 0;
if(isset($_POST["add_new_purchase"])){
  $suppliers_name = $_POST['suppliers_name'];
  $invoice_number = $_POST['invoice_number'];
  $payment_type = $_POST['payment_type'];
  $invoice_date = $_POST['invoice_date'];
  $bread_name = $_POST['bread_name'];
  $quantity = $_POST['quantity'];
  $rate = $_POST['rate'];
  $payment_status = ($payment_type == "Payment Due") ? "DUE" : "PAID";
 $grand_total = $quantity * $rate; 

  if($con) {
    $toupdate = "SELECT * FROM medicines_stock WHERE NAME = '$bread_name'";
    $resultupdate = mysqli_query($con, $toupdate);
    while($row = mysqli_fetch_array($resultupdate)) {
      $Q =$quantity + $row['QUANTITY'];
    
       $update = "UPDATE medicines_stock SET QUANTITY = '$Q' WHERE NAME = '$bread_name'";
       $runupdate = mysqli_query($con, $update);
       if($runupdate){
          $query = "INSERT INTO purchases (SUPPLIER_NAME, INVOICE_NUMBER, PURCHASE_DATE, BREAD_NAME, QUANTITY, RATE, TOTAL_AMOUNT, PAYMENT_STATUS) VALUES('$suppliers_name', '$invoice_number', '$invoice_date', '$bread_name', '$quantity', '$rate', '$grand_total', '$payment_status')";
          $result = mysqli_query($con, $query);
       }else{
          $state = "Failed to save purchase!";
              }if($result)
          $state =  "Purchase saved...";
    else
      $state = "Failed to save purchase!";
      
    }
}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Add New Purchase</title>
    <script src="http://code.jquery.com/jquery-1.10.1.min.js"></script>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<script src="bootstrap/js/jquery.min.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="shortcut icon" href="images/icon.svg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/sidenav.css">
    <link rel="stylesheet" href="css/home.css">
    <script type="text/javascript" src="js/suggestions.js"></script>
    <script type="text/javascript" src="js/add_new_purchase.js"></script>
    <script type="text/javascript" src="js/validateForm.js"></script>
    <script src="js/restrict.js"></script>
  </head>
  <body>
    <div id="add_new_supplier_model">
      <div class="modal-dialog">
      	<div class="modal-content">
      		<div class="modal-header" style="background-color: #ff5252; color: white">
            <div class="font-weight-bold">Add New Supplier</div>
      			<button class="close" style="outline: none;" onclick="document.getElementById('add_new_supplier_model').style.display = 'none';"><i class="fa fa-close"></i></button>
      		</div>
      		<div class="modal-body">
            <?php
              include('sections/add_new_supplier.html');
            ?>
      		</div>
      	</div>
      </div>
    </div>
    <!-- including side navigations -->
    <?php include("sections/sidenav.html"); ?>

    <div class="container-fluid">
      <div class="container">

        <!-- header section -->
        <?php
          require "php/header.php";
          createHeader('bar-chart', 'Add Purchase', 'Add New Purchase');
        ?>
        <!-- header section end -->
<form action="add_purchase.php" method="post">
        <!-- form content -->
        <div class="row">
          <!-- manufacturer details content -->
          <div class="row col col-md-12">

            <div class="col col-md-4 form-group">
              <label class="font-weight-bold" for="suppliers_name">Supplier :</label>
              <input id="suppliers_name" type="text" class="form-control" placeholder="Supplier Name" name="suppliers_name" onkeyup="showSuggestions(this.value, 'supplier');">
              <code class="text-danger small font-weight-bold float-right" id="supplier_name_error" style="display: none;"></code>
              <div id="supplier_suggestions" class="list-group position-fixed" style="z-index: 1; width: 25.10%; overflow: auto; max-height: 200px;"></div>
            </div>

            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="">Invoice Number :</label>
              <input type="number" class="form-control" placeholder="Invoice Number" id="invoice_number" name="invoice_number" onblur="notNull(this.value, 'invoice_number_error'); checkInvoice(this.value, 'invoice_number_error');">
              <code class="text-danger small font-weight-bold float-right" id="invoice_number_error" style="display: none;"></code>
            </div>

            <!--
            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="">Voucher Number :</label>
              <input type="number" class="form-control" placeholder="Voucher Number" name="voucher_number">
            </div>
            -->

            <div class="col col-md-2 form-group">
              <label class="font-weight-bold" for="paytype">Payment Type :</label>
              <select id="payment_type" name="payment_type" class="form-control">
              	<option value="Cash Payment">Cash Payment</option>
                <option value="Net Banking">Net Banking</option>
                <option value="Payment Due">Payment Due</option>
              </select>
            </div>

            <div class="col col-md-2 form-group">
               <label class="font-weight-bold" for="invoice_date">Date :</label>
              <input type="date" class="datepicker form-control hasDatepicker" id="invoice_date" name="invoice_date" value='<?php echo date('Y-m-d'); ?>' onblur="checkDate(this.value, 'date_error');">
              <code class="text-danger small font-weight-bold float-right" id="date_error" style="display: none;"></code>
            </div>

          </div>

          <div class="row col col-md-12">
            <div class="col col-md-2 font-weight-bold" style="color: green; cursor:pointer" onclick="document.getElementById('add_new_supplier_model').style.display = 'block';">
            	<i class="fa fa-plus"></i>&nbsp;Add New Supplier
            </div>
          </div>
          <!-- supplier details content end -->

          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid #02b6ff;">
          </div>

          <!-- add medicines -->
          <div class="row col col-md-12 font-weight-bold">
            <div class="col col-md-4">Bread Name</div>
           <div class="col col-md-4">Quantity</div>
           <div class="col col-md-4">Rate</div>
            </div>
          </div>
          <div class="col col-md-12">
            <hr class="col-md-12" style="padding: 0px; border-top: 2px solid  #02b6ff;">
          </div>
          <div id="purchase_medicine_list_div">
          <div class="row">
          <!-- customer details content -->
          <div class="row col col-md-12">
            <div class="col col-md-4 form-group">
              <input id="bread_name" type="text" class="form-control" placeholder="Bread Name" name="bread_name" onkeyup="showSuggestions(this.value, 'medicine');">
              <code class="text-danger small font-weight-bold float-right" id="customer_name_error" style="display: none;"></code>
              <div id="customer_suggestions" class="list-group position-fixed" style="z-index: 1; width: 18.30%; overflow: auto; max-height: 200px;"></div>
            </div>
            <div class="col col-md-4 form-group">
              <input id="quantity" type="text" class="form-control" placeholder="Quantity" name="quantity"> 
              <code class="text-danger small font-weight-bold float-right" id="customer_name_error" style="display: none;"></code>
              <div id="customer_suggestions" class="list-group position-fixed" style="z-index: 1; width: 18.30%; overflow: auto; max-height: 200px;"></div>
            </div>
            <div class="col col-md-4 form-group">
              <input id="rate" type="text" class="form-control" placeholder="Rate" name="rate" >
              <code class="text-danger small font-weight-bold float-right" id="customer_name_error" style="display: none;"></code>
              <div id="customer_suggestions" class="list-group position-fixed" style="z-index: 1; width: 18.30%; overflow: auto; max-height: 200px;"></div>
            </div>
          </div>
          <!-- end medicines -->

    
          </div>

          <!-- button -->
          <div class="row col col-md-12">
            <div class="col col-md-5"></div>
            <div class="col col-md-2 form-group">
              <button class="btn btn-primary form-control" type="submit" name="add_new_purchase">ADD</button>
            </div>
            <div id="purchase_acknowledgement" class="col-md-12 h5 text-success font-weight-bold text-center" style="font-family: sans-serif;"><?php echo $state;?></div>

</form>
          <!-- closing button -->
        
        </div>
        <!-- form content end -->
        <hr style="border-top: 2px solid #ff5252;">
      </div>
    </div>
  </body>
</html>
