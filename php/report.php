<?php

if(isset($_GET['action']) && $_GET['action'] == "purchase")
  showPurchases($_GET['start_date'], $_GET['end_date']);

if(isset($_GET['action']) && $_GET['action'] == "sales")
  showSales($_GET['start_date'], $_GET['end_date']);

function showPurchases($start_date, $end_date) {
  ?>
  <thead>
    <tr>
      <th>SL</th>
      <th>Purchase Date</th>
      <th>Voucher Number</th>
      <th>Invoice No</th>
      <th>Supplier Name</th>
      <th>Bread Name</th>
      <th>Quantity</th>
      <th>Total Amount</th>
    </tr>
  </thead>
  <tbody>
  <?php
  require "db_connection.php";
  if($con) {
    $seq_no = 0;
    $total = 0;
    if($start_date == "" || $end_date == "")
      $query = "SELECT * FROM purchases";
    else
      $query = "SELECT * FROM purchases WHERE PURCHASE_DATE BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($con, $query);
    while($row = mysqli_fetch_array($result)) {
      $seq_no++;
      showPurchaseRow($seq_no, $row);
      $total = $total + $row['TOTAL_AMOUNT'];
    }
    ?>
    </tbody>
    <tfoot class="font-weight-bold">
      <tr style="text-align: right; font-size: 24px;">
        <td colspan="5" style="color: green;">&nbsp;Total Purchases Paid =</td>
        <td style="color: red;"><?php echo $total; ?></td>
      </tr>
    </tfoot>
    <?php

$total1 = 0;
if($start_date == "" || $end_date == "")
  $query1 = "SELECT * FROM purchases WHERE PAYMENT_STATUS = 'DUE' ";
else
  $query1 = "SELECT * FROM purchases WHERE PURCHASE_DATE BETWEEN '$start_date' AND '$end_date' AND PAYMENT_STATUS = 'DUE'";
$result1 = mysqli_query($con, $query1);
while($row1 = mysqli_fetch_array($result1)) {
  $total1 = $total1 + $row1['TOTAL_AMOUNT'];
}
?>
</tbody>
<tfoot class="font-weight-bold">
  <tr style="text-align: right; font-size: 24px;">
    <td colspan="5" style="color: green;">&nbsp;Total Purchases Due =</td>
    <td style="color: red;"><?php echo $total1; ?></td>
  </tr>
</tfoot>
<?php
  }
}

function showPurchaseRow($seq_no, $row) {
  ?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['PURCHASE_DATE']; ?></td>
    <td><?php echo $row['VOUCHER_NUMBER']; ?></td>
    <td><?php echo $row['INVOICE_NUMBER']; ?></td>
    <td><?php echo $row['SUPPLIER_NAME'] ?></td>
    <td><?php echo $row['BREAD_NAME'] ?></td>
    <td><?php echo $row['QUANTITY'] ?></td>
    <td><?php echo $row['PAYMENT_STATUS'] ?></td>
    <td><?php echo $row['TOTAL_AMOUNT']; ?></td>
  </tr>
  <?php
}

function showSales($start_date, $end_date) {
  ?>
  <thead>
    <tr>
      <th>SL</th>
      <th>Sales Date</th>
      <th>Invoice Number</th>
      <th>Customer Name</th>
      <th>Total Amount</th>
    </tr>
  </thead>
  <tbody>
  <?php
  require "db_connection.php";
  if($con) {
    $seq_no = 0;
    $total = 0;
    if($start_date == "" || $end_date == "")
      $query = "SELECT * FROM invoices";
    else
      $query = "SELECT * FROM invoices WHERE INVOICE_DATE BETWEEN '$start_date' AND '$end_date'";
    $result = mysqli_query($con, $query);
    while($row = mysqli_fetch_array($result)) { 
      $seq_no++;
      //print_r($row);
      showSalesRow($seq_no, $row);
      $total = $total + $row['TOTAL_AMOUNT'];
    }
    ?>
    </tbody>
    <tfoot class="font-weight-bold">
      <tr style="text-align: right; font-size: 24px;">
        <td colspan="4" style="color: green;">&nbsp;Total Sales =</td>
        <td class="text-primary"><?php echo $total; ?></td>
      </tr>
    </tfoot>
    <?php

$total = 0;
if($start_date == "" || $end_date == "")
  $query = "SELECT * FROM invoices WHERE PAYMENT_STATUS = 'PAID'";
else
  $query = "SELECT * FROM invoices WHERE INVOICE_DATE BETWEEN '$start_date' AND '$end_date' AND PAYMENT_STATUS = 'PAID'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)) { 
  $seq_no++;
  //print_r($row);
  $total = $total + $row['TOTAL_AMOUNT'];
}
?>
</tbody>
<tfoot class="font-weight-bold">
  <tr style="text-align: right; font-size: 24px;">
    <td colspan="4" style="color: green;">&nbsp;Total Paid =</td>
    <td class="text-primary"><?php echo $total; ?></td>
  </tr>
</tfoot>
<?php

$total = 0;
if($start_date == "" || $end_date == "")
  $query = "SELECT * FROM invoices WHERE PAYMENT_STATUS = 'DUE'";
else
  $query = "SELECT * FROM invoices WHERE INVOICE_DATE BETWEEN '$start_date' AND '$end_date' AND PAYMENT_STATUS = 'DUE'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)) { 
  $seq_no++;
  //print_r($row);
  $total = $total + $row['TOTAL_AMOUNT'];
}
?>
</tbody>
<tfoot class="font-weight-bold">
  <tr style="text-align: right; font-size: 24px;">
    <td colspan="4" style="color: green;">&nbsp;Total Debt =</td>
    <td class="text-primary"><?php echo $total; ?></td>
  </tr>
</tfoot>
<?php

$total = 0;
if($start_date == "" || $end_date == "")
  $query = "SELECT * FROM invoices";
else
  $query = "SELECT * FROM invoices WHERE INVOICE_DATE BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)) { 
  $seq_no++;
  //print_r($row);
  $total = $total + $row['QUANTITY'];
}
?>
</tbody>
<tfoot class="font-weight-bold">
  <tr style="text-align: right; font-size: 24px;">
    <td colspan="4" style="color: green;">&nbsp;Total Products Sold =</td>
    <td class="text-primary"><?php echo $total; ?></td>
  </tr>
</tfoot>
<?php

$total = 0;
if($start_date == "" || $end_date == "")
  $query = "SELECT * FROM medicines_stock";
else
  $query = "SELECT * FROM medicines_stock WHERE INVOICE_DATE BETWEEN '$start_date' AND '$end_date'";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)) { 
  $seq_no++;
  //print_r($row);
  $total = $total + $row['QUANTITY'];
}
?>
</tbody>
<tfoot class="font-weight-bold">
  <tr style="text-align: right; font-size: 24px;">
    <td colspan="4" style="color: green;">&nbsp;Total Remaining Products =</td>
    <td class="text-primary"><?php echo $total; ?></td>
  </tr>
</tfoot>
<?php
    
  }
}

function showSalesRow($seq_no, $row) {
  ?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['INVOICE_DATE']; ?></td>
    <td><?php echo $row['INVOICE_ID']; ?></td>
    <td><?php echo $row['CUSTOMER_NAME']; ?></td>
    <td><?php echo $row['TOTAL_AMOUNT'] ?></td>
  </tr>
  <?php
}

?>
