function deleteMedicine(id) {
  var confirmation = confirm("Are you sure?");
  if(confirmation) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if(xhttp.readyState = 4 && xhttp.status == 200)
        document.getElementById('medicines_div').innerHTML = xhttp.responseText;
    };
    xhttp.open("GET", "php/manage_medicine.php?action=delete&id=" + id, true);
    xhttp.send();
  }
}

function editMedicine(id) {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      document.getElementById('medicines_div').innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/manage_medicine.php?action=edit&id=" + id, true);
  xhttp.send();
}

function updateMedicine(id) {
  var medicine_name = document.getElementById("name");
  var suppliers_name = document.getElementById("suppliers_name");
  var rate = document.getElementById("rate");

  if(!notNull(medicine_name.value, "medicine_name_error"))
    medicine_name.focus();
  else if(!notNull(suppliers_name.value, "suppliers_name_error"))
    suppliers_name.focus();
  else if(!notNull(rate.value, "rate_error"))
    rate.focus();
  else {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if(xhttp.readyState = 4 && xhttp.status == 200)
        document.getElementById('medicines_div').innerHTML = xhttp.responseText;
    };
    xhttp.open("GET", "php/manage_medicine.php?action=update&id=" + id + "&name=" + medicine_name.value + "&suppliers_name=" + suppliers_name.value + "&rate=" + rate.value, true);
    xhttp.send();
  }
}

function cancel() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      document.getElementById('medicines_div').innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/manage_medicine.php?action=cancel", true);
  xhttp.send();
}

function searchMedicine(text, tag) {
  if(tag == "name") {
    document.getElementById("by_generic_name").value = "";
    document.getElementById("by_suppliers_name").value = "";
  }
  if(tag == "generic_name") {
    document.getElementById("by_name").value = "";
    document.getElementById("by_suppliers_name").value = "";
  }
  if(tag == "suppliers_name") {
    document.getElementById("by_name").value = "";
    document.getElementById("by_generic_name").value = "";
  }

  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if(xhttp.readyState = 4 && xhttp.status == 200)
      document.getElementById('medicines_div').innerHTML = xhttp.responseText;
  };
  xhttp.open("GET", "php/manage_medicine.php?action=search&text=" + text + "&tag=" + tag, true);
  xhttp.send();
}
