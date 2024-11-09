<?php
// session_start();
// if (!isset($_SESSION["admin"]))
// // $_SESSION["admin"]
// // // if (isset($_SESSION["user"])) 
// {
//   header("Location: http://localhost/POS/login/login.php");
// }
?>
<?php
$username =  "root";
$password = "";
$database = "pointofsale";

try {
  $pdo = new PDO("mysql:host=localhost;database=$database", $username, $password);
  // Set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("ERROR: Could not connect. " . $e->getMessage());
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>POS Admin </title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/ bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/ FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- Easy invoice pdf -->
  <!-- <script src="https://unpkg.com/easyinvoice/dist/easyinvoice.min.js"></script> -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/easyinvoice/dist/easyinvoice.min.js"></script> -->
  <script src="https://unpkg.com/pdfjs-dist@2.3.200/build/pdf.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>



</head>

<body>

  <div id="blurforuser">

    <div class="bg-dark p-3">
      <div class="row mx-0 py-3 bg-light" style="height: 95vh; ">
        <div class="col-sm-12">
          <!-- <p>Order #88 <small class="text-muted"> Today, Mar 2021 <span></span>, 02:24 PM</small></p> -->
          <p><small class="text-muted"> Today, <span id="showdate"></span> <span id="showtime"></span></small></p>
          Admin Panal
          <!-- Nav tab for Food Drink Amdin -->
          <div class="card rounded-3 mb-3">
            <div class="card-body">
              <ul class="nav nav-pills " id="pills-tab" role="tablist">

                <!-- <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill" id="pills-AddItem-tab" data-bs-toggle="pill" data-bs-target="#pills-AddItem" type="button" role="tab" aria-controls="pills-AddItem" aria-selected="true">Add Item</button>
              </li> -->

                <li class="nav-item" role="presentation">
                  <button class="nav-link active rounded-pill" id="pills-RemoveItem-tab" data-bs-toggle="pill" data-bs-target="#pills-RemoveItem" type="button" role="tab" aria-controls="pills-RemoveItem" aria-selected="true">Remove Item</button>
                </li>

                <li class="nav-item" role="presentation">
                  <!-- <i class="fa-solid fa-arrows-rotate"></i> -->
                  <button onclick="refreshPage();" class=" nav-link rounded-pill" id="pills-RefreshItem-tab" data-bs-toggle="pill" data-bs-target="#pills-RefreshItem" type="button" role="tab" aria-controls="pills-RefreshItem" aria-selected="false"><span class="material-symbols-outlined">sync</span></button>
                </li>

                <li class="nav-item" role="presentation">
                  <button onclick="" class="nav-link rounded-pill" id="pills-AddItem-tab" data-bs-toggle="pill" data-bs-target="#pills-AddItem" type="button" role="tab" aria-controls="pills-AddItem" aria-selected="false">Add Item</button>
                </li>


                <!-- <li class="nav-item" role="presentation">
                <button onclick="" class="nav-link rounded-pill" id="pills-RemoveItem-tab" data-bs-toggle="pill" data-bs-target="#pills-RemoveItem" type="button" role="tab" aria-controls="pills-RemoveItem" aria-selected="false">Remove Item</button>
              </li> -->

                <li class="nav-item" role="presentation">
                  <button class="nav-link rounded-pill" id="pills-changeItem-tab" data-bs-toggle="pill" data-bs-target="#pills-changeItem" type="button" role="tab" aria-controls="pills-changeItem" aria-selected="false">Change Item details</button>
                </li>

                <li class="nav-item position-absolute end-0 me-4 " role="presentation">
                  <button class="nav-link rounded-pill" id="pills-Admin-tab" data-bs-toggle="pill" data-bs-target="#pills-Sales" type="button" role="tab" aria-controls="pills-Sales" aria-selected="false">Sales</button>
                </li>

                <!-- nav-item position-absolute end-0 me-4 -->
                <!-- refreshPage -->
                <!-- position-absolute top-0 end-0  |  d-flex justify-content-between -->

              </ul>
            </div>

          </div>
          <div class="tab-content" id="pills-tabContent">

            <div class="tab-pane fade show " id="pills-AddItem" role="tabpanel" aria-labelledby="pills-AddItem-tab">

              <!--  -->

              <div>
                <div class="row mb-3">
                  <label for="adminItemName" class="col-sm-3 col-form-label col-form-label-lg">Item Name</label>
                  <div class="col-sm-6">
                    <input type="text" autocomplete="off" required class="form-control form-control-lg text-center rounded-pill" id="adminItemName" placeholder="Name of the item ">
                  </div>
                </div>
                <!-- step step="0.01" -->
                <div class="row mb-3">
                  <label for="adminItemPrice" required class="col-sm-3 col-form-label col-form-label-lg">Item Price</label>
                  <div class="col-sm-6">
                    <input type="number" step="" autocomplete="off" class="form-control form-control-lg text-center rounded-pill " id="adminItemPrice" placeholder="Price of the item">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="adminItemImage" required class="col-sm-3 col-form-label col-form-label-lg">Item Image Src</label>
                  <div class="col-sm-6">
                    <div>
                      <!-- <label for="formFileLg" class="form-label">Large file input example</label> -->
                      <!-- <input class="form-control form-control-lg text-center rounded-pill" id="adminItemImage" type="file"> -->
                    </div>
                    <input type="text" autocomplete="off" class="form-control form-control-lg text-center rounded-pill" id="adminItemImage" placeholder="File Path       eg:-  images\\food.png ">
                  </div>
                </div>

                <div class="row mb-3">
                  <label for="adminItemCategory" class="col-sm-3 col-form-label col-form-label-lg rounded-pill">Item Category</label>
                  <div class="col-sm-6 rounded-pill">
                    <div class="input-group input-group-lg rounded-pill mb-3">
                      <label class="input-group-text rounded-pill m-1" for="adminItemCategory"> Category</label>
                      <select required class="form-select text-center rounded-pill m-1" id="adminItemCategory">
                        <option selected>Select Category</option>
                        <option value="1">FOOD</option>
                        <option value="2">DRINK</option>
                      </select>
                    </div>

                  </div>
                </div>



                <div class="row mb-3">
                  <label for="AdditemtoDB" class="col-sm-3 col-form-label col-form-label-lg">Add To MenuItem</label>
                  <div class="col-sm-6">
                    <button id="AdditemtoDB" onclick="
                  addItemToDB();" class="btn btn-lg btn-primary rounded-pill w-100 ">Add Item to Data Base</button>
                  </div>
                </div>

              </div>


            </div>
            <!-- Ipad cahnge  -->
            <!-- Default style="height: 70vh; -->
            <!-- Ipad style="height: 77vh; -->
            <div class="tab-pane fade show active" id="pills-RemoveItem" role="tabpanel" aria-labelledby="pills-RemoveItem-tab" style="height: 70vh; overflow-y: auto; ">
              <div>

                <table class="table" id="dataTable">
                  <thead>
                    <tr>
                      <th scope="col">Item ID</th>
                      <th scope="col">Item Name</th>
                      <th scope="col">Item Price</th>
                      <th scope="col">Image Src</th>
                      <th scope="col">Delete Item</th>
                    </tr>
                  </thead>
                  <tbody class="">

                    <!-- Table hear  -->

                  </tbody>
                </table>



              </div>
              <!--  -->
            </div>

            <div class="tab-pane fade show" id="pills-changeItem" role="tabpanel" aria-labelledby="pills-changeItem-tab">
              <div>


                <div>
                  <div class="row mb-3">

                    <label for="adminItemIdc" class="col-sm-3 col-form-label col-form-label-lg">Item ID</label>
                    <div class="col-sm-6">
                      <input type="number" required autocomplete="off" class="form-control form-control-lg text-center rounded-pill" id="adminItemIdc" placeholder="ID of the item ">
                    </div>
                    <div class="col-sm-2">
                      <button onclick="
                    search();
                    " required class="btn btn-lg btn-primary rounded-pill w-100 ">Search</button>
                    </div>
                  </div>


                  <div class="row mb-3">
                    <label for="adminItemNamec" class="col-sm-3 col-form-label col-form-label-lg">Item Name</label>
                    <div class="col-sm-6">
                      <input type="text" autocomplete="off" class="form-control form-control-lg text-center rounded-pill" id="adminItemNamec" placeholder="Name of the item ">
                    </div>
                  </div>
                  <!-- step step="0.01" -->
                  <div class="row mb-3">
                    <label for="adminItemPricec" class="col-sm-3 col-form-label col-form-label-lg">Item Price</label>
                    <div class="col-sm-6">
                      <input type="number" autocomplete="off" step="" class="form-control form-control-lg text-center rounded-pill " id="adminItemPricec" placeholder="amount">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="adminItemImagec" class="col-sm-3 col-form-label    col-form-label-lg">Item Image Src</label>
                    <div class="col-sm-6">
                      <div>
                        <!-- <label for="formFileLg" class="form-label">Large file input example</label> -->
                        <!-- <input class="form-control form-control-lg text-center rounded-pill" id="adminItemImage" type="file"> -->
                      </div>
                      <input type="text" autocomplete="off" class="form-control form-control-lg text-center rounded-pill" id="adminItemImagec" placeholder="File Path       eg:-   images\\food.png ">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="adminItemCategoryc" class="col-sm-3 col-form-label col-form-label-lg rounded-pill">Item Category</label>
                    <div class="col-sm-8 rounded-pill">
                      <div class="  input-group input-group-lg rounded-pill mb-3">
                        <label class="input-group-text rounded-pill m-1" for="adminItemCategoryc"> Category</label>
                        <select class="col-sm-4 form-select  text-center rounded-pill m-1" id="adminItemCategoryc">
                          <option selected>Select Category</option>
                          <option value="1">FOOD</option>
                          <option value="2">DRINK</option>
                        </select>
                        <input type="text" disabled autocomplete="off" class="col-sm-2 form-control form-control-lg text-center rounded-pill " id="adminItemCategoryci" placeholder="Category">

                      </div>
                    </div>

                  </div>
                </div>



                <div class="row mb-3">
                  <label for="addItemDB" class=" col-sm-3 col-form-label col-form-label-lg">Add To MenuItem</label>
                  <div class="col-sm-6">
                    <button onclick="ChangeIDB();" id="addItemDB" class="btn btn-lg btn-primary rounded-pill w-100 ">Change Item in Data Base</button>
                  </div>
                </div>


              </div>


            </div>

            <div class="tab-pane fade show " id="pills-Sales" role="tabpanel" aria-labelledby="pills-Sales-tab">
              <div>
                <nav>
                  <div class="nav nav-tabs" id="nav-tab" role="tablist">

                    <button class="nav-link active" id="nav-SyncChart-tab" data-bs-toggle="tab" data-bs-target="#nav-SyncChart" type="button" role="tab" aria-controls="nav-SyncChart" aria-selected="true">Sales Chart</button>

                    <button class="nav-link" id="nav-bargraph-tab" data-bs-toggle="tab" data-bs-target="#nav-bargraph" type="button" role="tab" aria-controls="nav-bargraph" aria-selected="false">Monthly Sales</button>


                    <button class="nav-link" id="nav-Dougnut-tab" data-bs-toggle="tab" data-bs-target="#nav-Dougnut" type="button" role="tab" aria-controls="nav-Dougnut" aria-selected="false">Best Sellers</button>

                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false" hidden>Contact</button>

                  </div>
                </nav>


                <div class="tab-content" id="nav-tabContent">

                  <div class="tab-pane fade show active" id="nav-SyncChart" role="tabpanel" aria-labelledby="nav-SyncChart-tab" tabindex="0">
                    <div class="p-2">
                      <div class="d-flex ">
                        <div id="chart1canavas" class=" border border-dark-subtle pr-2 pl-1 rounded-5"></div>
                        <div id="chart2canavas" class=" border border-dark-subtle p-2 rounded-5 mx-2"></div>
                        <div id="chart3canavas" class=" border border-dark-subtle p-2 rounded-5 p-2"></div>
                      </div>
                    </div>


                  </div>

                  <div class="tab-pane fade" id="nav-bargraph" role="tabpanel" aria-labelledby="nav-bargraph-tab" tabindex="0">

                    <div style="height: 60vh;">
                      <canvas id="BarGraph12MON" width="1150" height="330"></canvas>
                    </div>

                  </div>

                  <div class="tab-pane fade" id="nav-Dougnut" role="tabpanel" aria-labelledby="nav-Dougnut-tab" tabindex="0">
                    <div style="height: 68vh;">
                      <span class="d-flex justify-content-around">
                        <canvas id="DougnutTOP" width="600" height="370"></canvas>
                        <canvas id="DougnutTOPSide" width="600" height="370"></canvas>
                      </span>
                    </div>
                  </div>

                  <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab" tabindex="0">...
                    <div style="height: 40vh;  width:100vh">
                      <span class="d-flex ">
                        <!-- <canvas id="Line1" width="200px" height="150px" ></canvas>
                  <canvas id="Line2" width="200px" height="150px" ></canvas>
                  <canvas id="Line3" width="200px" height="150px"></canvas> -->
                        <!-- style="height: 200px; width: 150px;" -->


                        <canvas id="Line1" width="400" height="200"></canvas>
                        <canvas id="Line2" width="400" height="200"></canvas>
                        <!-- <canvas id="Line3" width="400" height="200"  ></canvas> -->

                        <!-- width:1000px !important; height:600px !important; -->

                      </span>

                    </div>

                  </div>

                </div>





              </div>

              <!--  -->
            </div>



            <!--  -->
          </div>


        </div>
      </div>

    </div>

  </div>
  </div>

  <!-- =========================== database code ============================= -->
  <!-- ______________________SQL DB_________________________________________________ -->
  <?php
  try {
    $sql = "SELECT MONTHNAME(orderDateTime) AS month, SUM(orderAmount) AS totalAmount
            FROM pointofsale.orders
            GROUP BY MONTH(orderDateTime)
            HAVING totalAmount > 0";

    $result = $pdo->query($sql);


    $monthsTS = array();
    $totalSalesTS = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $monthsTS[] = $row['month'];
      $totalSalesTS[] = $row['totalAmount'];
    }

    // Convert data to JSON
    $j_months = json_encode($monthsTS);
    $j_totalSales = json_encode($totalSalesTS);
  } catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
  }
  ?>
  <!-- ______________________SQL DB_________________________________________________ -->
  <?php

  try {
    $sql2 = "SELECT DATE_FORMAT(`DateOS`, '%m-%d-%Y GMT') as monthQ ,sum(orderSlipQuantity) as totalQuantity
FROM pointofsale.orderslips
group by month(`DateOS`)
HAVING sum(orderSlipQuantity) > 20";

    $result = $pdo->query($sql2);

    $months = array();
    $totalSales = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $months[] = $row['monthQ'];
      $totalSales[] = $row['totalQuantity'];
    }

    // Convert data to JSON
    $json_months = json_encode($months);
    $json_totalSales = json_encode($totalSales);
  } catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
  }
  ?>


  <!-- ______________________SQL DB_________________________________________________ -->
  <?php
  try {
    $sql3 = "SELECT DISTINCT(month(DateOS)) as month,orderSlipId as total_slip
from pointofsale.orderslips
group by month(DateOS)
having month>0;";

    $result = $pdo->query($sql3);

    $months = array();
    $totalSales = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
      $monthsID[] = $row['month'];
      $totalSlip[] = $row['total_slip'];
    }

    // Convert data to JSON
    $json_monthsID = json_encode($monthsID);
    $json_totalSlip = json_encode($totalSlip);
  } catch (PDOException $e) {
    die("Error executing query: " . $e->getMessage());
  }
  ?>


  <!-- =========================== database code END ========================= -->




  <script>
    // function for time ======================== ADD Final=================


    function updateTime() {
      let date = new Date();
      document.getElementById("showdate").innerHTML = date.toLocaleString('en-US', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
      });
      document.getElementById("showtime").innerHTML = date.toLocaleString('en-US', {
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
      });
    }
    updateTime();
    setInterval(updateTime, 60000);


    // const itemIdDel = [];

    function deleteItemPop() {

    }

    // <<---------------------------- Add item function for Admin panal ---------------------->>

    // let amountODB = document.getElementById('amount');
    // let aitemName = ;

    function addItemToDB() {

      let aitemName = document.getElementById('adminItemName');
      let aitemprice = document.getElementById('adminItemPrice');
      let aitemimage = document.getElementById('adminItemImage');
      let aitemcategory = document.getElementById('adminItemCategory');

      // <========================== Data Base Code to Add Item ================>

      var variable1 = aitemName.value;
      var variable2 = aitemprice.value;
      var variable3 = aitemimage.value;
      var variable4 = aitemcategory.value;

      // console.log(variable1);
      // console.log(variable2);
      // console.log(variable3);
      // console.log(variable4);

      // Using AJAX to send the values to a PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "AddItemDB.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Console LOG
          console.log(xhr.responseText);
        }
      };

      // Multiple variables as a query string
      var data = "variable1=" + encodeURIComponent(variable1) +
        "&variable2=" + encodeURIComponent(variable2) +
        "&variable3=" + encodeURIComponent(variable3) +
        "&variable4=" + encodeURIComponent(variable4);

      xhr.send(data);

      loadarray();
      // reloadarray();

    }










    // <<---------------------- End Of Add item function for Admin panal ---------------------->>






    // +++++++++++++++++++++++++++++++++=============================+++++++++++++++++++++++++++++++++++







    // <<---------------------------- Remove item function for Admin panal ---------------------->>

    //  <=================================== DB retrive for retrive item =============================>



    let orderidarraydel = [];
    let orderitemsarraydel = [];
    let orderPriceArraydel = [];
    let orderImageArraydel = [];
    let orderCategoryArraydel = [];


    function emptyArray() {






      orderidarraydel = [];
      orderitemsarraydel = [];
      orderPriceArraydel = [];
      orderImageArraydel = [];
      orderCategoryArraydel = [];

      //  orderidarraydel.length = 0;
      //  orderitemsarraydel.length = 0;
      //  orderPriceArraydel.length = 0;
      //  orderImageArraydel.length = 0;
      //  orderCategoryArraydel.length = 0;


      //  orderidarraydel.splice(0, orderidarraydel.length);
      //  orderitemsarraydel.splice(0, orderitemsarraydel.length);
      //  orderPriceArraydel.splice(0, orderPriceArraydel.length);
      //  orderImageArraydel.splice(0, orderImageArraydel.length);
      //  orderCategoryArraydel.splice(0, orderCategoryArraydel.length);


      console.log(orderitemsarraydel);

    }

    loadarray();

    function loadarray() {
      <?php

      try {
        $sql = "SELECT * FROM pointofsale.menuitems";
        $result = $pdo->query($sql);
        if ($result->rowCount() > 0) {
          while ($row = $result->fetch()) {  ?>

            orderidarraydel.push(<?= $row['menuItemId']; ?>);
            orderitemsarraydel.push("<?= $row['menuItemName']; ?>");
            orderPriceArraydel.push(<?= $row['menuItemPrice']; ?>);
            orderImageArraydel.push("<?= $row['menuItemImage']; ?>");
            orderCategoryArraydel.push("<?= $row['menuItemCategory']; ?>");

      <?php
          }
          unset($result);
        } else {
          echo 'no value found';
        }
      } catch (PDOException $e) {
        die("ERROR: not able to execute  $sql. " . $e->getMessage());
      }
      ?>
      console.log(orderidarraydel);
    }


    // <==================== modify data array for remove Item ====================>
    function modifyDataArrays() {
      let data = [];

      for (let i = 0; i < orderidarraydel.length; i++) {
        let newItem = {
          iId: orderidarraydel[i],
          iName: orderitemsarraydel[i],
          iImage: orderImageArraydel[i],
          iPrice: orderPriceArraydel[i],
        };

        data.push(newItem);
      }

      return data;
    }

    // Call the function to get the modified data array
    let modifiedDataforDel = modifyDataArrays();
    console.log(modifiedDataforDel);

    // console.log(modifiedDataforDel);

    // Function to display data in the table
    function displayData() {
      let tableBody = document.querySelector('#dataTable tbody');

      // Clear existing rows
      tableBody.innerHTML = '';

      // Loop through the data and create table rows
      modifiedDataforDel.forEach(item => {
        let row = document.createElement('tr');

        // Add columns
        row.innerHTML = `
                      <th scope="row">${item.iId}</th>
                      <td>${item.iName}</td>
                      
                      <td class="text-danger">₹ ${item.iPrice}</td>
                      <td>${item.iImage}</td>
                      <td><button class="btn btn-danger rounded-pill"  onclick="deleteRow(${item.iId})">Delete Item</button></td>
                  `;

        // Append the row to the table body
        tableBody.appendChild(row);
      });
    }




    // <========================== Data Base Code to Remove Item ================>

    function deleteRow(iId) {
      // Find the index of the item with the specified ID
      let index = modifiedDataforDel.findIndex(item => item.iId === iId);

      // <========== delete function Hear ======>

      var variable1 = iId;
      // console.log(variable1);




      // Using AJAX to send the values to a PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "itemDeleteAdmin.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Console LOG
          console.log(xhr.responseText);
        }
      };

      // Multiple variables as a query string
      var data = "variable1=" + encodeURIComponent(variable1);

      xhr.send(data);






      // Remove the item from the data array
      if (index !== -1) {
        modifiedDataforDel.splice(index, 1);
      }

      // Redisplay the updated data
      displayData();
    }

    // Display the initial data
    displayData();

    // <<-----------------------End Of Remove item function for Admin panal ---------------------->>






    // +++++++++++++++++++++++++++++++++=============================+++++++++++++++++++++++++++++++++++






    // <<---------------------------- Change item function for Admin panal ---------------------->>

    function searchIteminDB() {


      // let citemID = search

      let citemName = document.getElementById('adminItemNamec');
      let citemprice = document.getElementById('adminItemPricec');
      let citemimage = document.getElementById('adminItemImagec');
      let citemcategory = document.getElementById('adminItemCategoryc');

    }

    // 230 
    // let citemID = parseInt(document.getElementById('adminItemIdc').value);
    //   console.log(citemID);

    // var searchCounter =0;

    function search() {



      // let citemName = document.getElementById('adminItemNamec');
      // let citemprice = document.getElementById('adminItemPricec');
      // let citemimage = document.getElementById('adminItemImagec');
      // let citemcategory = document.getElementById('adminItemCategoryc');

      // searchCounter += 1;
      // console.log(searchCounter)


      let citemID = parseInt(document.getElementById('adminItemIdc').value);
      // console.log(citemID);
      // console.log(orderidarraydel);

      let item_id = orderidarraydel.indexOf(citemID);
      // console.log(item_id);


      if (item_id == -1) {
        alert(`Item not found at DataBase .`);
      } else {
        164

        let getItemNameDB = orderitemsarraydel.at(item_id);
        console.log(getItemNameDB);

        let getItemPriceDB = orderPriceArraydel.at(item_id);
        // console.log(getItemPriceDB);

        let getItemImageDB = orderImageArraydel.at(item_id);
        // console.log(getItemImageDB);

        let getItemCategoryDB = parseInt(orderCategoryArraydel.at(item_id));
        // console.log(getItemCategoryDB);

        if (getItemCategoryDB == 1) {
          getItemCategoryDB = "Food";
          // console.log(getItemCategoryDB);
        } else {
          getItemCategoryDB = "Drink";
        }

        // let nm =document.getElementById("adminItemNamec").textContent = getItemNameDB;
        // // console.log(getItemNameDB);
        // console.log(nm);

        let inputgetItemNameDB = document.getElementById("adminItemNamec");
        // inputgetItemNameDB.setAttribute("value",getItemNameDB);
        inputgetItemNameDB.value = getItemNameDB;

        console.log(inputgetItemNameDB.value);

        let inputgetItemPriceDB = document.getElementById("adminItemPricec");
        // inputgetItemPriceDB.setAttribute("value",getItemPriceDB);
        inputgetItemPriceDB.value = getItemPriceDB;


        let inputgetItemImageDB = document.getElementById("adminItemImagec");
        // inputgetItemImageDB.setAttribute("value",getItemImageDB);
        inputgetItemImageDB.value = getItemImageDB;


        // let inputgetItemCategoryDB = document.getElementById("adminItemCategoryc");
        // inputgetItemCategoryDB.setAttribute("value",getItemCategoryDB);
        // console.log(inputgetItemCategoryDB);

        let inputgetItemCategoryDB = document.getElementById("adminItemCategoryci");
        // inputgetItemCategoryDB.setAttribute("value",getItemCategoryDB);
        // console.log(inputgetItemCategoryDB);
        inputgetItemCategoryDB.value = getItemCategoryDB;



        // let getItemNameDB = orderidarraydel.getValue(item_id);
        // console.log(getItemNameDB);
        // console.log(orderidarraydel.getvalue(item_id));

      }





    }


    function ChangeIDB() {

      let citemIDB = parseInt(document.getElementById('adminItemIdc').value);
      let CIDBitemName = document.getElementById('adminItemNamec').value;
      let CIDBitemprice = document.getElementById('adminItemPricec').value;
      let CIDBitemimage = document.getElementById('adminItemImagec').value;
      let CIDBitemcategory = document.getElementById('adminItemCategoryc').value;
      // console.log(CIDBitemName);
      // console.log(CIDBitemprice);
      // console.log(CIDBitemimage);
      // console.log(CIDBitemcategory);




      // function changeItemInDB() {

      // let aitemName = document.getElementById('adminItemName');
      // let aitemprice = document.getElementById('adminItemPrice');
      // let aitemimage = document.getElementById('adminItemImage');
      // let aitemcategory = document.getElementById('adminItemCategory');

      // <========================== Data Base Code to Change Item ================>

      var variable10 = citemIDB;
      var variable1 = CIDBitemName;
      var variable2 = CIDBitemprice;
      var variable3 = CIDBitemimage;
      var variable4 = CIDBitemcategory;

      // console.log(variable0);
      // console.log(variable1);
      // console.log(variable2);
      // console.log(variable3);
      // console.log(variable4);

      // Using AJAX to send the values to a PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "ChangeItemInDB.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
          // Console LOG
          console.log(xhr.responseText);
        }
      };

      // Multiple variables as a query string
      var data = "variable10=" + encodeURIComponent(variable10) +
        "&variable1=" + encodeURIComponent(variable1) +
        "&variable2=" + encodeURIComponent(variable2) +
        "&variable3=" + encodeURIComponent(variable3) +
        "&variable4=" + encodeURIComponent(variable4);

      xhr.send(data);


      // reloadarray();
      // }

    }

    function refreshPage() {
      // Reload the current page
      location.reload();
    }



    // function reloadarray(){


    //   emptyArray();
    //   // timear();

    //   setTimeout(timear,600);
    //   // loadarray();
    //   // modifyDataArrays();
    //   // displayData();


    // }
    // function timear(){
    //   loadarray();
    //   modifyDataArrays();
    //   displayData();

    // }

    // Bargraph PHP code 
    // select month(orderDateTime),sum(orderAmount)
    // FROM orders
    // group by month(orderDateTime)
    // HAVING sum(orderAmount)>0;
    // --------------------------- BAR GRAPH ---------------------------->>>>>

    let bargraphMonth = [];
    let bargraphSales = [];
    loadBargraphData();

    function loadBargraphData() {
      <?php
      // Fetch data from the database
      try {
        $sql = "SELECT MONTHNAME(orderDateTime) AS month, SUM(orderAmount) AS totalAmount
                FROM pointofsale.orders
                GROUP BY MONTH(orderDateTime)
                HAVING totalAmount > 0";

        $result = $pdo->query($sql);

        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $data[] = $row;
        }
      } catch (PDOException $e) {
        die("Error executing query: " . $e->getMessage());
      }
      ?>

      <?php foreach ($data as $row) : ?>

        bargraphMonth.push("<?= $row['month'] ?>")
        bargraphSales.push(<?= $row['totalAmount'] ?>)

      <?php endforeach; ?>

      console.log(bargraphMonth);
      console.log(bargraphSales);

    }


    // ----------------------- APEX CHArt -----------------------------------

    var jMonths = <?php echo $j_months; ?>;
    var jTotalSales = <?php echo $j_totalSales; ?>;


    var jsonDataMonths = <?php echo $json_months; ?>;
    var jsonDataTotalSales = <?php echo $json_totalSales; ?>;

    var MonthsID = <?php echo $json_monthsID; ?>;
    var Totalslip = <?php echo $json_totalSlip; ?>;

    const seriesDATA = [{
      name: "Total Sales",
      data: jTotalSales,
    }, ]

    const seriesDATA2 = [{
      name: "Total item Slod",
      data: jsonDataTotalSales,
    }, ]

    const seriesDATA3 = [{
      name: "Total Order",
      data: Totalslip,
    }, ]

    // ------------------ T chart 1 color----------------------->>>>>
    const chartstylecolor1 = {
      chart: {
        height: 350,
        width: 450,
        id: 'lineChartGroup',
        group: 'visitorsLeads',
        type: 'line',
        zoom: {
          enabled: false
        },
        dropShadow: {
          enabled: true,
          color: ['#CF7CDD', '#6394FF'],
          top: 0,
          left: 3,
          blur: 6,
          opacity: 0.3
        },
        toolbar: {
          show: false
        },
        selection: {
          enabled: false,
        },
      },
      colors: ['#CF7CDD', '#6394FF'],
      dataLabels: {
        enabled: false,
      },
      yaxis: {
        labels: {
          minWidth: 70,
          style: {
            colors: '#AFB4BB',
            fontSize: '10px',
            fontFamily: 'Open Sans',
          },
          formatter: (value) => {
            return '₹' + value / 1000 + 'k'
          },
        }
      },
    }

    const chartstylecolor2 = {
      chart: {
        height: 350,
        width: 450,
        id: 'lineChartGroup',
        group: 'visitorsLeads',
        type: 'line',
        zoom: {
          enabled: false
        },
        dropShadow: {
          enabled: true,
          color: ['#EEB892', '#CF7CDD'],
          top: 0,
          left: 3,
          blur: 6,
          opacity: 0.3
        },
        toolbar: {
          show: false
        },
        selection: {
          enabled: false,
        },
      },
      colors: ['#EEB892', '#CF7CDD'],
      dataLabels: {
        enabled: false,
      },
      yaxis: {
        labels: {
          minWidth: 70,
          style: {
            colors: '#AFB4BB',
            fontSize: '10px',
            fontFamily: 'Open Sans',
          },
          formatter: (value) => {
            return value
          },
        }
      },
    }
    //  6394FF CF7CDD

    const chartstylecolor3 = {
      chart: {
        height: 350,
        width: 450,
        id: 'lineChartGroup',
        group: 'visitorsLeads',
        type: 'line',
        zoom: {
          enabled: false
        },
        dropShadow: {
          enabled: true,
          color: ['#6394FF', '#6394FF'],
          top: 0,
          left: 3,
          blur: 6,
          opacity: 0.3
        },
        toolbar: {
          show: false
        },
        selection: {
          enabled: false,
        },
      },
      colors: ['#6394FF', '#6394FF'],
      dataLabels: {
        enabled: false,
      },
      yaxis: {
        labels: {
          minWidth: 70,
          style: {
            colors: '#AFB4BB',
            fontSize: '10px',
            fontFamily: 'Open Sans',
          },
          formatter: (value) => {
            return value
          },
        }
      },
    }




    const chartstyletext = {

      stroke: {
        curve: 'smooth',
        width: 3
      },
      grid: {
        show: true,
        borderColor: '#f3f3f3',
        xaxis: {
          lines: {
            show: true
          }
        },
        yaxis: {
          lines: {
            show: false
          }
        },
        row: {
          colors: ['#f3f3f3', 'transparent'],
          opacity: 0.5
        },
      },
      markers: {
        size: 0
      },
      xaxis: {
        type: 'numeric',
        labels: {
          style: {
            colors: '#AFB4BB',
            fontSize: '10px',
            fontFamily: 'Open Sans',
          },
          offsetY: -5,
        },
        axisBorder: {
          color: '#f3f3f3',
        },
        axisTicks: {
          show: false,
        },
        tooltip: {
          enabled: false
        }
      },


      legend: {
        position: 'bottom',
        horizontalAlign: 'center',
        floating: false,
        height: 40,
        markers: {
          width: 28,
          height: 8
        }
      },
      tooltip: {
        shared: true,
        style: {
          fontFamily: '"Open Sans", "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
        },
      },
      states: {
        hover: {
          filter: {
            type: 'darken',
            value: 0.8,
          }
        }
      }
    }

    var chart1 = {
      series: seriesDATA,
      ...chartstylecolor1,
      ...chartstyletext,

    };
    var chart2 = {
      series: seriesDATA2,
      ...chartstylecolor2,
      ...chartstyletext,

    };
    var chart3 = {
      series: seriesDATA3,

      ...chartstylecolor3,
      ...chartstyletext,



    };

    var chart1RENDER = new ApexCharts(document.querySelector("#chart1canavas"), chart1);
    chart1RENDER.render();

    var chart2RENDER = new ApexCharts(document.querySelector("#chart2canavas"), chart2);
    chart2RENDER.render();

    var chart3RENDER = new ApexCharts(document.querySelector("#chart3canavas"), chart3);
    chart3RENDER.render();






    // ---------------------------  Chart JS BAR ---------------------------->>>>>

    const chartData = {
      labels: bargraphMonth,
      // ['January', 'February', 'March', 'April', 'May' ,'june' ,'July', 'August', 'September', 'October', 'November' ,'Decembe'],
      datasets: [{
        label: 'Sales By Month in ₹ ',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        data: bargraphSales

        // data: [65, 59, 80, 81, 56 ,73,58,52,67,75,88,80]
      }]
    };


    const ctx = document.getElementById('BarGraph12MON').getContext('2d');

    // Create a bar chart
    const myChart = new Chart(ctx, {
      type: 'bar',
      data: chartData,
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    // -------------------------  Chart JS BAR END----------------------->>>>>

    // --------------------------- BAR GRAPH ---------------------------->>>>>

    // --------------------------- Dougnut Chart ---------------------------->>>>>
    let itemNameD1 = [];
    let itemSalesD1 = [];
    loadDougnut1Data();

    function loadDougnut1Data() {
      <?php
      // Fetch data from the database
      try {
        $sql = "SELECT orderSlipItemName as itemName ,count(*) as item_count,menuItemCategory FROM pointofsale.orderslips 
        group by orderSlipItemName
        HAVING menuItemCategory=1
        order by item_count DESC
        limit 5";

        $result = $pdo->query($sql);

        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $data[] = $row;
        }
      } catch (PDOException $e) {
        die("Error executing query: " . $e->getMessage());
      }
      ?>

      <?php foreach ($data as $row) : ?>

        itemNameD1.push("<?= $row['itemName'] ?>")
        itemSalesD1.push(<?= $row['item_count'] ?>)

      <?php endforeach; ?>

    }

    // ---------------------------  Chart JS Dougnut ---------------------------->>>>>

    var chrt = document.getElementById("DougnutTOP").getContext("2d");
    var chartId = new Chart(chrt, {
      type: 'doughnut',
      data: {
        labels: itemNameD1,
        // ["HTML", "CSS", "JAVASCRIPT", "CHART.JS", "JQUERY", "BOOTSTRP"],
        datasets: [{
          label: "Pizza",
          data: itemSalesD1,
          // [20, 40, 13, 35, 20, 38],
          backgroundColor: [
            // 'yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 205, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(54, 162, 235, 0.6)'

          ],
          hoverOffset: 8
        }],
      },
      options: {
        responsive: false,
      },
    });

    // -------------------------- Chart JS Dougnut END  -------------------->>>>>

    // --------------------------- Dougnut Chart END ---------------------------->>>>>


    // ===========================================================================

    // --------------------------- Dougnut Chart ---------------------------->>>>>
    let itemNameD2 = [];
    let itemSalesD2 = [];
    loadDougnut2Data();

    function loadDougnut2Data() {
      <?php
      // Fetch data from the database
      try {
        $sql = "SELECT orderSlipItemName as itemName2,count(*) as item_count2,menuItemCategory FROM pointofsale.orderslips 
        group by orderSlipItemName
        HAVING menuItemCategory=2
        order by item_count2 DESC
        limit 5";

        $result = $pdo->query($sql);

        $data = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
          $data[] = $row;
        }
      } catch (PDOException $e) {
        die("Error executing query: " . $e->getMessage());
      }
      ?>

      <?php foreach ($data as $row) : ?>

        itemNameD2.push("<?= $row['itemName2'] ?>")
        itemSalesD2.push(<?= $row['item_count2'] ?>)

      <?php endforeach; ?>

      console.log(itemNameD2);
      console.log(itemSalesD2);

    }

    // ---------------------------  Chart JS Dougnut ---------------------------->>>>>

    var chrt = document.getElementById("DougnutTOPSide").getContext("2d");
    var chartId = new Chart(chrt, {
      type: 'doughnut',
      data: {
        labels: itemNameD2,
        // ["HTML", "CSS", "JAVASCRIPT", "CHART.JS", "JQUERY", "BOOTSTRP"],
        datasets: [{
          label: "Drink",
          data: itemSalesD2,
          // [20, 40, 13, 35, 20, 38],
          backgroundColor: [
            // 'yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 205, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(54, 162, 235, 0.6)'

          ],
          hoverOffset: 8
        }],
      },
      options: {
        responsive: false,
      },
    });





    // -------------------------- Chart JS Dougnut END  -------------------->>>>>

    // --------------------------- Dougnut Chart END ---------------------------->>>>>

    // ================================================>>>>>>>>>>>>>>>>>>>>>>>>>>>


    // --------------------------- TRIP CHART Begins ---------------------------->>>>>

    // ------------------ Line 1------->>>>>
    // let bargraphMonth =[];
    //  let bargraphSales =[];

    // const data = {
    //         labels: bargraphMonth,
    //         // ['January', 'February', 'March', 'April', 'May'],
    //         datasets: [{
    //             label: 'Monthly Sales',
    //             backgroundColor: 'rgba(75, 192, 192, 0.2)',
    //             borderColor: 'rgba(75, 192, 192, 1)',
    //             borderWidth: 2,
    //             data: bargraphSales,
    //             // [65, 59, 80, 81, 56],
    //         }]
    //     };

    //     // Chart configuration
    //     const config = {
    //         type: 'line',
    //         data: data,
    //         options: {
    //             scales: {
    //                 x: {
    //                     type: 'category',
    //                     labels: data.labels,
    //                 },
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     };

    // ---------------------------  Chart JS BAR ---------------------------->>>>>

    const LineData = {
      labels: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
      // bargraphMonth ,
      // ['January', 'February', 'March', 'April', 'May' ,'june' ,'July', 'August', 'September', 'October', 'November' ,'Decembe'],
      datasets: [{
        label: 'Sales By Month in ₹ ',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderColor: 'rgba(75, 192, 192, 1)',
        borderWidth: 1,
        data: bargraphSales

        // data: [65, 59, 80, 81, 56 ,73,58,52,67,75,88,80]
      }]
    };


    const Ltx1 = document.getElementById('Line1').getContext('2d');
    const Ltx2 = document.getElementById('Line2').getContext('2d');
    // const Ltx3 = document.getElementById('Line3').getContext('2d');

    // Create a bar chart
    const linechart1 = new Chart(Ltx1, {
      type: 'line',
      data: LineData,
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    const linechart2 = new Chart(Ltx2, {
      type: 'line',
      data: LineData,
      options: {
        maintainAspectRatio: false,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    
    // const linechart3 = new Chart(Ltx3, {
    //     type: 'line',
    //     data: LineData,
    //     options: {
    //       maintainAspectRatio: false,
    //         scales: {
    //             y: {
    //                 beginAtZero: true
    //             }
    //         }
    //     }
    // });

    // -------------------------  Chart JS BAR END----------------------->>>>>       





    // --------------------------- TRIP CHART END ---------------------------->>>>>












    // ---------------------------  Chart JS Dougnut ---------------------------->>>>>

    // var chrt = document.getElementById("DougnutTOPSide").getContext("2d");
    // var chartId = new Chart(chrt, {
    //    type: 'doughnut',
    //    data: {
    //       labels: ["HTML", "CSS", "JAVASCRIPT", "CHART.JS", "JQUERY", "BOOTSTRP"],
    //       datasets: [{
    //       label: "online tutorial subjects",
    //       data: [20, 40, 13, 35, 20, 38],
    //       backgroundColor: [
    //         // 'yellow', 'aqua', 'pink', 'lightgreen', 'gold', 'lightblue'
    //               'rgba(255, 99, 132, 0.6)',
    //               'rgba(255, 159, 64, 0.6)',
    //               'rgba(255, 205, 86, 0.6)',
    //               'rgba(75, 192, 192, 0.6)',
    //               'rgba(54, 162, 235, 0.6)',
    //               'rgba(153, 102, 255, 0.6)'

    //       ],
    //       hoverOffset: 8
    //       }],
    //    },
    //    options: {
    //       responsive: false,
    //    },
    // });





    // -------------------------- Chart JS Dougnut END  -------------------->>>>>

    // ---------------------------  Chart JS ---------------------------->>>>>

    // ---------------------------  Chart JS ---------------------------->>>>>







    // <<-----------------------End Of Change item function for Admin panal ---------------------->>
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>