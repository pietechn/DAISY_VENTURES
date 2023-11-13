<?php
  require "db_connection.php";

  if($con) {
    if(isset($_GET["action"]) && $_GET["action"] == "delete") {
      $id = $_GET["id"];
      $query = "DELETE FROM medicines WHERE ID = $id";
      $result = mysqli_query($con, $query);
      if(!empty($result))
    		showMedicines(0);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "edit") {
      $id = $_GET["id"];
      showMedicines($id);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "update") {
      $id = $_GET["id"];
      $medicine_name = ucwords($_GET["name"]);
      $suppliers_name = ucwords($_GET["suppliers_name"]);
      $rate = ucwords($_GET["rate"]);
      updateMedicine($id, $suppliers_name, $medicine_name, $rate);
    }

    if(isset($_GET["action"]) && $_GET["action"] == "cancel")
      showMedicines(0);

    if(isset($_GET["action"]) && $_GET["action"] == "search")
      searchMedicine(strtoupper($_GET["text"]), $_GET["tag"]);
  }

  function showMedicines($id) {
    require "db_connection.php";
    if($con) {
      $seq_no = 0;
      $query = "SELECT * FROM medicines";
      $result = mysqli_query($con, $query);
      while($row = mysqli_fetch_array($result)) {
        $seq_no++;
        if($row['ID'] == $id)
          showEditOptionsRow($seq_no, $row);
        else
          showMedicineRow($seq_no, $row);
      }
    }
  }

  function showMedicineRow($seq_no, $row) {
    ?>
    <tr>
      <td><?php echo $seq_no; ?></td>
      <td><?php echo $row['BREAD_NAME']; ?></td>
    <td><?php echo $row['SUPPLIERS_NAME']; ?></td>
    <td><?php echo $row['RATE']; ?></td>
    <td>
        <button href="" class="btn btn-info btn-sm" onclick="editMedicine(<?php echo $row['ID']; ?>);">
          <i class="fa fa-pencil"></i>
        </button>
        <button class="btn btn-danger btn-sm" onclick="deleteMedicine(<?php echo $row['ID']; ?>);">
          <i class="fa fa-trash"></i>
        </button>
      </td>
    </tr>
    <?php
  }

function showEditOptionsRow($seq_no, $row) {
  ?>
  <tr>
    <td><?php echo $seq_no; ?></td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['BREAD_NAME']; ?>" placeholder="Product Name" id="medicine_name" onblur="notNull(this.value, 'medicine_name_error');">
      <code class="text-danger small font-weight-bold float-right" id="medicine_name_error" style="display: none;"></code>
    </td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['SUPPLIERS_NAME']; ?>" placeholder="Supplier Name" id="generic_name" onblur="notNull(this.value, 'generic_name_error');">
      <code class="text-danger small font-weight-bold float-right" id="generic_name_error" style="display: none;"></code>
    </td>
    <td>
      <input type="text" class="form-control" value="<?php echo $row['RATE']; ?>" placeholder="Rate" id="suppliers_name" onblur="notNull(this.value, 'supplier_name_error');">
      <code class="text-danger small font-weight-bold float-right" id="supplier_name_error" style="display: none;"></code>
    </td>
    <td>
      <button href="" class="btn btn-success btn-sm" onclick="updateMedicine(<?php echo $row['ID']; ?>);">
        <i class="fa fa-edit"></i>
      </button>
      <button class="btn btn-danger btn-sm" onclick="cancel();">
        <i class="fa fa-close"></i>
      </button>
    </td>
  </tr>
  <?php
}

function updateMedicine($id, $suppliers_name, $medicine_name, $rate) {
  require "db_connection.php";
  $query = "UPDATE medicines SET SUPPLIERS_NAME = '$suppliers_name', BREAD_NAME = '$medicine_name', RATE = '$rate' WHERE ID = $id";
  $result = mysqli_query($con, $query);
  if(!empty($result))
    showMedicines(0);
}

function searchMedicine($text, $tag) {
  require "db_connection.php";
  if($tag == "name")
    $column = "BREAD_NAME";
  if($tag == "suppliers_name")
    $column = "SUPPLIER_NAME";
    if($tag == "rate")
    $column = "RATE";
    if($con) {
    $seq_no = 0;
    $query = "SELECT * FROM medicines WHERE UPPER($column) LIKE '%$text%'";
    $result = mysqli_query($con, $query);
    while($row = mysqli_fetch_array($result)) {
      $seq_no++;
      showMedicineRow($seq_no, $row);
    }
  }
}

?>
