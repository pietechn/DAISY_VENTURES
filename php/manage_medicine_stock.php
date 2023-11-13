<?php
  require "db_connection.php";

  if($con) {
    if(isset($_GET["action"]) && $_GET["action"] == "delete") {
      $id = $_GET["id"];
      $query = "DELETE FROM medicines WHERE ID = $id";
      $result = mysqli_query($con, $query);
      if(!empty($result))
    		showMedicinesStock("0");
    }

    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
      $id = $_GET["id"];
      showMedicinesStock($id);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "update") {
      $id = $_GET["id"];
      $batch_id = $_GET["batch_id"];
      $expiry_date = ucwords($_GET["expiry_date"]);
      $quantity = ucwords($_GET["quantity"]);
      $mrp = ucwords($_GET["mrp"]);
      $rate = ucwords($_GET["rate"]);
      updateMedicineStock($id, $batch_id, $expiry_date, $quantity, $mrp, $rate);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "cancel")
      showMedicinesStock("0");

    if(isset($_GET["action"]) && $_GET["action"] == "search")
      searchMedicineStock(strtoupper($_GET["text"]), $_GET["tag"]);
  }

  function showMedicinesStock($id) {
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      $query = "SELECT * FROM medicines_stock";
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        if($row['ID'] == $id)
          showEditOptionsRow($seq_no, $row);
        else
          showMedicineStockRow($seq_no, $row);
      }
    }
  }

  function showMedicineStockRow($seq_no, $row) {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo $row['NAME']; ?></td>
      <td><?php echo $row['QUANTITY']; ?></td>
      <td>
        <!-- <button href="" class="btn btn-info btn-sm" onclick="editMedicineStock('<?php echo $row['ID']; ?>');">
          <i class="fa fa-pencil"></i>
        </button>
        
        <button class="btn btn-danger btn-sm" onclick="deleteMedicineStock(<?php echo $row['ID']; ?>);">
          <i class="fa fa-trash"></i>
        </button> -->
     
      </td>
    </tr>
    <?php
  }

function showEditOptionsRow($seq_no, $row) {
  ?>
  <!--<tr><td colspan="11"><?php //echo $row[5]; ?></tr>-->
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td><?php echo $row['NAME']; ?></td>
    <td><?php echo $row['QUANTITY']; ?></td>
    
    <td>
      <button href="" class="btn btn-success btn-sm" onclick="updateMedicineStock(<?php echo $row[5]; ?>);">
        <i class="fa fa-edit"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="cancel();">
        <i class="fa fa-close"></i>
      </button>
    </td>
  </tr>
  <?php
}

function updateMedicineStock($id, $batch_id, $expiry_date, $quantity, $mrp, $rate) {
  require "db_connection.php";
  $query = "UPDATE medicines_stock SET BATCH_ID = '$batch_id', EXPIRY_DATE = '$expiry_date', QUANTITY = $quantity, MRP = $mrp, RATE = $rate WHERE ID = $id";
  $result = mysqli_query($con, $query);
  if(!empty($result))
    showMedicinesStock("0");
}

function searchMedicineStock($text, $column) {
  require "db_connection.php";
  if($con) {
    $seq_no = 0;

    if($column == "EXPIRY_DATE")
      $query = "SELECT * FROM medicines INNER JOIN medicines_stock ON medicines.NAME = medicines_stock.NAME";
    else if($column == 'QUANTITY')
      $query = "SELECT * FROM medicines INNER JOIN medicines_stock ON medicines.NAME = medicines_stock.NAME WHERE medicines_stock.$column = 0";
    else
      $query = "SELECT * FROM medicines INNER JOIN medicines_stock ON medicines.NAME = medicines_stock.NAME WHERE UPPER(medicines.$column) LIKE '%$text%'";

    $result = mysqli_query($con, $query);

    if($column == 'EXPIRY_DATE') {
      while($row = mysqli_fetch_array($result)) {
        $expiry_date = $row['EXPIRY_DATE'];
        if(substr($expiry_date, 3) < date('y'))
          showMedicineStockRow($seq_no, $row);
        else if(substr($expiry_date, 3) == date('y')) {
          if(substr($expiry_date, 0, 2) < date('m'))
            showMedicineStockRow($seq_no, $row);
        }
      }
    }
    else {
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        showMedicineStockRow($seq_no, $row);
      }
    }
  }
}

?>
