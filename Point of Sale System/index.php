<?php
session_start();
// if (!isset($_SESSION["user"])) {
//    header("Location: loginA.php");
// }
// print_r($_SESSION);

// Assuming $_SESSION["admin"] is set after checking if the user is an admin
$isAdmin = isset($_SESSION["admin"]) && $_SESSION["admin"];
// print_r($_SESSION);
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
  <title>POS system</title>
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/ bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/ FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,500,0,0" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">


  <!-- Easy invoice pdf -->
  <script src="https://unpkg.com/easyinvoice/dist/easyinvoice.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/easyinvoice/dist/easyinvoice.min.js"></script>
  <script src="https://unpkg.com/pdfjs-dist@2.3.200/build/pdf.min.js"></script>
</head>



<body>

  <!-- ------------------------ PHP Session ----------------  -->
  <?php
  // Include PHP variable in JavaScript
  echo '<script>var isAdmin = ' . ($isAdmin ? 'true' : 'false') . ';</script>';
  ?>


  <!-- 76vh   height: 76vh -->

  <div class="bg-dark  p-3">
    <div class="row mx-0 py-3 bg-light">
      <!-- ---------| col-sm-8 -->
      <div class="col-sm-9">
        <p>Order #<span id="numberDisplay">0 </span><small class="text-muted"> Today, <span id="showdate"></span> <span id="showtime"></span></small> </p>

        <div class="card rounded-3 mb-3">
          <div class="card-body">
            <ul class="nav nav-pills " id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill" id="pills-food-tab" data-bs-toggle="pill" data-bs-target="#pills-food" type="button" role="tab" aria-controls="pills-food" aria-selected="true">FOOD</button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill" id="pills-drink-tab" data-bs-toggle="pill" data-bs-target="#pills-drink" type="button" role="tab" aria-controls="pills-drink" aria-selected="false">DRINKS</button>
              </li>
              <li class="nav-item d-none " role="presentation">
                <button class="nav-link rounded-pill" id="pills-checkout-tab" data-bs-toggle="pill" data-bs-target="#pills-checkout" type="button" role="tab" aria-controls="pills-checkout" aria-selected="false">CHECK OUT</button>
              </li>
              <div class="ms-auto">
                <div class="d-flex flex-row-reverse"> 
                  <a href="login/logout.php">             
                  <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill" id="pills-Logout-tab" type="button"><span style=" font-size: 30px; color:red" class="material-symbols-outlined">logout</span></button>
                  </li>
                  </a> 

                  <a href="http://localhost/POS/Admin/Adminpage.php" target="_blank">
                    <li class="nav-item" role="presentation">
                      <button  class="nav-link rounded-pill " id="pills-Admin-tab" type="button" role="tab" hidden><span style="font-size: 30px;"class="material-symbols-outlined">manage_accounts</span></button>
                    </li>
                  </a>
                </div>

              </div>

              <!-- <a href="http://localhost/POS/Admin/Adminpage.php" target="_blank">
                <li class="nav-item" role="presentation">
                  <button class="nav-link rounded-pill position-absolute end-0 me-4" id="pills-Admin-tab" type="button" role="tab" hidden >ADMIN</button>
                </li>               
              </a>               -->


              <!-- <li class="nav-item" role="presentation">
                          <button  class="nav-link rounded-pill position-absolute end-0 me-4" id="pills-Admin-tab"  data-bs-toggle="pill" data-bs-target="#pills-Admin" type="button" role="tab" aria-controls="pills-Admin" aria-selected="false">ADMIN</button>
                        </li> -->

            </ul>
          </div>

        </div>



        <!-- 82 vh hight  -->
        <!-- Chrome height: 77vh; -->
        <!-- Opera height: 75vh; -->
        <!-- iPadPro height: 82.39vh; -->

        <!-- row-cols-md-4 g-4  >> row-cols-md-5 g-4 -->



        <div class="tab-content" id="pills-tabContent">
          <div class="tab-pane fade show active" id="pills-food" role="tabpanel" aria-labelledby="pills-food-tab">

            <!-- <======================= food card ========================> -->
            <!-- --------------row-cols-md-5--|-------| g-4 -->
            <!-- Ipad change -->
            <div class="row row-cols-1 row-cols-md-5 g-4 " style="height: 75vh; overflow-y: auto;   ">

              <?php
              try {
                $sql = "SELECT * FROM pointofsale.menuitems WHERE menuItemCategory = 1";
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                  while ($row = $result->fetch()) {  ?>

                    <div class="col">
                      <div class="card" onclick="orderbasket(<?= $row['menuItemId']; ?> ,'<?= $row['menuItemName']; ?> ',<?= $row['menuItemPrice']; ?>,'<?= $row['menuItemImage']; ?>')">

                        <img draggable="false" src="<?= $row['menuItemImage']; ?>" class="card-img-top" alt="FOOD image">

                        <div class="card-body">
                          <h5 class="card-title"> <?= $row['menuItemName']; ?> </h5>
                          <p class="card-text fw-bold">₹ <?= $row['menuItemPrice']; ?> </p>

                        </div>
                      </div>
                    </div>

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

              <!-- fs-6 -->


              <!-- <div class="col">
                          <div class="card" onclick="orderbasket(12,'Pizza 1',4.99,'images/POS image.png');">
                            <img draggable="false" src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Pizza 1</h5>
                              <p class="card-text fw-bold">$ 4.99</p>
                            
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card" onclick="orderbasket(1,'Pizza 2',3.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">pizza 2</h5>
                              <p class="card-text fw-bold">$ 3.99</p>
                              
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card"onclick="orderbasket(14,'Pizza 3',4.49,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">pizza 3</h5>
                              <p class="card-text fw-bold">$ 4.49</p>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card"onclick="orderbasket(1,'Pizza 4',5.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">pizza 4</h5>
                              <p class="card-text fw-bold">$ 5.99</p>
                             
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card"onclick="orderbasket(2,'Pizza 5',8.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Pizza 5</h5>
                              <p class="card-text fw-bold">$ 8.99</p>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card"onclick="orderbasket(3,'Pizza 6',5.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Pizza 6</h5>
                              <p class="card-text fw-bold">$ 5.99</p>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card"onclick="orderbasket(4,'Pizza 7',7.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Pizza 7</h5>
                              <p class="card-text fw-bold">$ 7.99</p>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card"onclick="orderbasket(5,'Pizza 8',10.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Pizza 8</h5>
                              <p class="card-text fw-bold">$ 10.99</p>
                            </div>
                          </div>
                        </div> -->

            </div>
          </div>



        <!-- 82 vh hight  -->
        <!-- Chrome height: 77vh; -->
        <!-- Opera height: 75vh; -->
        <!-- iPadPro height: 82.39vh; -->



          <div class="tab-pane fade" id="pills-drink" role="tabpanel" aria-labelledby="pills-drink-tab">


            <!-- <======================= Drinks card ========================> -->
            <!-- Ipad change -->
            <div class="row row-cols-1 row-cols-md-5 g-4 " style="height: 75vh; overflow-y: auto;  ">

              <!-- $sql = "SELECT * FROM pointofsale.menuitems WHERE menuItemCategory = 2"; -->

              <?php
              try {
                $sql = "SELECT * FROM pointofsale.menuitems WHERE menuItemCategory = 2";
                $result = $pdo->query($sql);
                if ($result->rowCount() > 0) {
                  while ($row = $result->fetch()) {   ?>

                    <div class="col">
                      <div class="card" onclick="orderbasket(<?= $row['menuItemId']; ?> ,'<?= $row['menuItemName']; ?> ',<?= $row['menuItemPrice']; ?>,'<?= $row['menuItemImage']; ?>')">

                        <img draggable="false" src=" <?= $row['menuItemImage']; ?> " class="card-img-top" alt="...">

                        <div class="card-body">
                          <h5 class="card-title"> <?= $row['menuItemName']; ?> </h5>
                          <p class="card-text fw-bold">₹ <?= $row['menuItemPrice']; ?></p>

                        </div>
                      </div>
                    </div>

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
























              <!-- <div class="col">
                          <div class="card" onclick="orderbasket(6,'Coke',1.99,'images/POS image.png');">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Coke 1</h5>
                              <p class="card-text fw-bold">$ 1.99</p>
                            
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card" onclick="orderbasket(7,'Water',0.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Water</h5>
                              <p class="card-text fw-bold">$ 0.99</p>
                              
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card" onclick="orderbasket(8,'Orange juice',2.49,'images/POS image.png'); " >
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title">Orange Juice</h5>
                              <p class="card-text fw-bold">$ 2.49</p>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card" onclick="orderbasket(9,'large text',10.99,'images/POS image.png'); ">
                            <img src="images/POS image.png" class="card-img-top" alt="...">
                            <div class="card-body">
                              <h5 class="card-title text-truncate">Coke water juice large truncket</h5>
                              <p class="card-text fw-bold">$ 10.99</p>
                            </div>
                          </div>
                        </div> -->
            </div>
          </div>




          <!-- <==================================== Check Out ==============================================> -->

          <div class="tab-pane fade" id="pills-checkout" role="tabpanel" aria-labelledby="pills-checkout-tab">
            CHECK OUT



            <div class="row mb-3">
              <label for="customernameCN" class="col-sm-4 col-form-label col-form-label-lg">Customer Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control form-control-lg text-center rounded-pill" id="customernameCN" placeholder="OR#88">
              </div>
            </div>

            <div class="row mb-3">
              <label for="amount" class="col-sm-4 col-form-label col-form-label-lg">Amount</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" class="form-control form-control-lg text-center rounded-pill " id="amount" placeholder="amount" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <label for="calculatorModel" class="col-sm-4 col-form-label col-form-label-lg">Inseart Amount </label>
              <div class="col-sm-8">
                <button onclick="exactAmountCalculator()" id="calculatorModel" class="btn btn-lg btn-dark rounded-pill w-100 " data-bs-toggle="modal" data-bs-target="#amountcalculator">Inseart Paid Amount</button>
              </div>
            </div>





            <div class="row mb-3">
              <label for="customeramountpaid" class="col-sm-4 col-form-label col-form-label-lg">Amount Customer Paid</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" class="form-control  form-control-lg text-center fw-bold  rounded-pill " id="customeramountpaid" placeholder="amount" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <label for="customeramountchange" class="col-sm-4 col-form-label col-form-label-lg">Change</label>
              <div class="col-sm-8">
                <input type="number" step="0.01" class="form-control form-control-lg text-center text-danger fw-bold rounded-pill " id="customeramountchange" placeholder="change" disabled>
              </div>
            </div>

            <div class="row mb-3">
              <label for="printReceiptButton" class="col-sm-4 col-form-label col-form-label-lg">Print Receipt</label>
              <div class="col-sm-8">
                <button onclick="
                          
                          // DataBase Operation
                          // dataBase(); 
                          consoleloop();
                          dataBaseOrderSlip();
                          dataBaseOrder(); 
                          downloadInvoice();
                          " disabled id="printReceiptButton" class="btn btn-lg btn-dark rounded-pill w-100 ">Print Receipt</button>
              </div>
            </div>

            <div class="row mb-3">
              <label for="customerNextButton" class="col-sm-4 col-form-label col-form-label-lg">Next Customer</label>
              <div class="col-sm-8">
                <button onclick="nextCustomerButton(); " disabled id="customerNextButton" class="btn btn-lg btn-primary rounded-pill w-100 ">Next Customer</button>
              </div>
            </div>





          </div>

        </div>





      </div>
      <!-- -------------| col-sm-3 -->
      <div class="col-sm-3">
        <!-- <================================= Order Cart ==================================> -->
        <div class="card">
          <div class="card-body">

            <h5 class="d-flex justify-content-between align-items-center"><span>Order</span>
              <button id="orderBasketClearButton" onclick="orderbasketclear()" class="btn btn-sm btn-danger  rounded-pill">Clear</button>
            </h5>
            <hr>
            <!-- Default Cart Hight style="height: 50vh; -->
            <!-- Default Modified Cart Hight style="height: 52vh; -->
            <!-- ipad Pro Cart Hight style="height: 66vh; -->
            <!-- Ipad change -->
            <ul id="orderlist" class="list-unstyled " style="height: 52vh; overflow-y: auto; ">
              <!-- Order cart function Hear  -->
            </ul>
            <hr>

            <ul class="list-unstyled mg-0">
              <li class="d-flex justify-content-between align-items-center">
                <big>Total Items : </big><big class="fw-bold" id="totalitems" class="card-text">0</big>
              </li>
              <li class="d-flex justify-content-between align-items-center">
                <big>Total Amount : </big><big class="fw-bold ">₹ <span id="totalcost" class="card-text ">0.00</span></big>
              </li>

              <li>
                <hr>
                <button disabled="" id="checkOutButton" onclick="goToCheckOutTab()" class="btn btn-primary btn-lg w-100 rounded-pill">CHECK OUT</button>
              </li>
            </ul>



          </div>
        </div>

      </div>

    </div>


  </div>





  <!--  <============================================ Pop UP Calculator Modal ==================================>   -->
  <div class="modal fade" id="amountcalculator" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <input id="calculatorScreenAmount" type="text" class="bg-dark mb-3 w-100 text-end form-control form-control-lg text-white" value="0" disabled>
          <div class="row">

            <div class="col-4 mb-3" onclick="calculatorInseart('9')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">9</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('8')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">8</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('7')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">7</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('6')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">6</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('5')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">5</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('4')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">4</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('3')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">3</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('2')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">2</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('1')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">1</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('0')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">0</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('00')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">00</button></div>
            <div class="col-4 mb-3" onclick="calculatorInseart('.')"><button class=" rounded-pill text-center btn-outline-dark btn w-100">.</button></div>
            <div class="col-4 mb-3" onclick="calculatorCancle()"><button class=" rounded-pill text-center btn-danger btn w-100">C</button></div>
          </div>
        </div>

        <div class="modal-body">
          <div class="col-12 mb-3">
            <button onclick="exactAmountButton()" class="btn w-100 rounded-pill text-center btn-warning">Exact Amount ( ₹ <span id="exactamountspan" class="fw-bold"></span> )</button>
          </div>
          <div class="row">
            <hr>



            <div class="col-2 mb-3"><button onclick="denominationButton(10)" class="btn w-100 rounded-pill text-center btn-warning">10</button></div>
            <div class="col-2 mb-3"><button onclick="denominationButton(50)" class="btn w-100 rounded-pill text-center btn-warning">50</button></div>
            <div class="col-2 mb-3"><button onclick="denominationButton(100)" class="btn w-100 rounded-pill text-center btn-warning">100</button></div>
            <div class="col-2 mb-3"><button onclick="denominationButton(200)" class="btn w-100 rounded-pill text-center btn-warning">200</button></div>
            <div class="col-2 mb-3"><button onclick="denominationButton(500)" class="btn w-100 rounded-pill text-center btn-warning">500</button></div>
            <div class="col-2 mb-3"><button onclick="denominationButton(2000)" class="btn w-100 rounded-pill text-center btn-warning">2000</button></div>








          </div>
        </div>






        <div class="modal-footer">
          <button onclick="calculatorCancle()" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button id="confirmPaid" onclick="confirmPaidButton(); createInvoice(); " disabled="" class="btn btn-primary" data-bs-dismiss="modal">Confirm</button>
        </div>
      </div>
    </div>
  </div>

















  <script>
    // <======================================= All Array =======================================================>  
    const orderidarray = [];
    const orderItemIdArray = [];
    const orderitemsarray = [];
    const orderPriceArray = [];
    const orderImageArray = [];
    const orderarray = [];
    const orderItemQuantity = [];
    const orderTtemTaxArray = [];



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


    // for id of individual item
    let i = 0;
    // order Counter 


    // "SELECT * FROM pointofsale.menuitems";

    console.log('Is admin:', isAdmin);
    const adminvalue = isAdmin;

    if (adminvalue == true) {
      document.getElementById('pills-Admin-tab').hidden = false;
    }



    // Order Number PHP Code XXXXXXXXX------  Working ON -------XXXXXXXXXXX
    // ====================================================================>
    <?php
    try {
      $stmt = "SELECT * FROM pointofsale.orders ORDER BY orderID DESC LIMIT 1";
      $result = $pdo->query($stmt);

      // Fetch the result and convert it to JSON
      $lastOrder = $result->fetch(PDO::FETCH_ASSOC);
      $lastOrderJson = json_encode($lastOrder);

      // Pass the JSON-encoded data to JavaScript
      echo "var lastOrder = $lastOrderJson;";
    } catch (PDOException $e) {
      die("ERROR: not able to execute $stmt. " . $e->getMessage());
    }
    ?>

    // SELECT * FROM pointofsale.menuitems ORDER BY menuItemId DESC LIMIT 1

    // Call the ordernumber function
    let currentNumber;
    ordernumber();


    function ordernumber() {
      // Access the data retrieved from PHP in JavaScript
      let initcurrentNumber = lastOrder.orderID;
      console.log("Initial Order Number:", initcurrentNumber);
      currentNumber = initcurrentNumber + 1;
    }

    // let currentNumber = initcurrentNumber;


    // ADD Item name price & image to Cart ====================================================================>
    function orderbasket(itemid, itemname, itemprice, itemimage) {

      // console.log( orderitemsarray.indexOf(itemname));
      // const itemIndexNumber=orderitemsarray.indexOf(itemname);

      if (orderitemsarray.indexOf(itemname) > -1) {
        const itemIndexNumber = orderitemsarray.indexOf(itemname);
        orderItemQuantity[itemIndexNumber] = orderItemQuantity[itemIndexNumber] + 1;

        // console.log(orderidarray[itemIndexNumber]);

        incrementItem(orderidarray[itemIndexNumber], 1);
      } else {

        orderidarray.push(i);
        orderItemIdArray.push(itemid)
        orderitemsarray.push(itemname);
        orderPriceArray.push(itemprice);
        orderImageArray.push(itemimage);
        orderarray.push(itemid, itemname, itemprice, itemimage);
        orderItemQuantity.push(1);
        orderTtemTaxArray.push(0);



        let orderlist = document.getElementById('orderlist');


        // Create the Li tag
        const orderitemparent = document.createElement('li');
        const orderitem = document.createElement('span');

        orderitem.className = 'd-flex justify-content-between align-items-center';

        // orderitem.setAttribute('onclick','deleteItem('+i+')');



        // Create a span for red color 
        const orderitempricespan = document.createElement('span');



        // Create the text Node itemname and itemprice
        const orderitemname = document.createTextNode(' ' + itemname);
        const orderitemprice = document.createTextNode(' ₹ ' + itemprice);



        //  Adjest Text color to red color
        orderitempricespan.className = 'text-danger'


        // Add pricetextnode into span
        orderitempricespan.appendChild(orderitemprice);



        // Create a delete button
        const deletebutton = document.createElement('button');
        const deletebuttontext = document.createTextNode('X');

        deletebutton.setAttribute('onclick', 'deleteItem(' + i + ', this)');



        // Append text to delete button
        deletebutton.appendChild(deletebuttontext);
        deletebutton.className = 'btn btn-danger rounded-pill';




        // Image Section
        // Step 1 : Add image text
        const orderitemimgtag = document.createElement('img')

        // Assign the src itemimage to img 
        orderitemimgtag.src = itemimage;
        // classname w25 for image 
        orderitemimgtag.className = 'w-25 rounded border border-dark';
        // console.log(itemname);
        // LEft side span
        const orderitemleftsidespan = document.createElement('span');



        // combine the span =========================>
        // Append to li 
        orderitemleftsidespan.appendChild(orderitemimgtag);
        // Attach the itemname text to LI Tag
        orderitemleftsidespan.appendChild(orderitemname);
        // End of combine span ======================>


        // ADD the price at the end
        orderitemleftsidespan.appendChild(orderitempricespan);




        orderitem.appendChild(orderitemleftsidespan);


        // Attach the Delete button into SPAN Tag
        orderitem.appendChild(deletebutton);
        // New CREAT Parent LI >> SPAN
        orderitemparent.appendChild(orderitem);
        // Attach or Append the SPAN tag (Child ) to parent id = Orderlist
        orderlist.appendChild(orderitemparent);


        // <====== Button Section ====================================== Start =======================>

        const decrementButton = document.createElement('button');
        const incrementButton = document.createElement('button');
        const decrementButtonText = document.createTextNode('–');
        const incrementButtonText = document.createTextNode('+');

        decrementButton.setAttribute('onclick', 'incrementItem(' + i + ',-1)');
        incrementButton.setAttribute('onclick', 'incrementItem(' + i + ',1)');



        const amountItemSpan = document.createElement('span');
        amountItemSpan.className = 'px-2  fw-bold item' + i;
        const amountItemText = document.createTextNode('1');

        decrementButton.className = 'btn btn-sm btn-danger rounded-pill px-3 my-1 ms-1 fw-bold';
        incrementButton.className = 'btn btn-sm btn-success rounded-pill px-3 my-1 ms-1 fw-bold';

        decrementButton.appendChild(decrementButtonText);
        incrementButton.appendChild(incrementButtonText);

        amountItemSpan.appendChild(amountItemText);

        orderitemparent.appendChild(incrementButton);
        orderitemparent.appendChild(amountItemSpan);
        orderitemparent.appendChild(decrementButton);

        // <====== Button Section ====================================== End =======================>

        // increment the order id by 1
        i++;

      }

      totalitems();
      costitems();


      // console.log(orderidarray)
      // to enable Check Out button 
      enableCheckOutButton();

    };

    // function decrementItem(){
    // };




    // <====  Increment Items in Cart  =================================================================>
    function incrementItem(orderid, val) {

      const itemSpan = document.querySelector('.item' + orderid);
      itemSpan.innerText = parseInt(itemSpan.innerText) + val;

      const indexnum = orderidarray.indexOf(orderid);

      orderItemQuantity[indexnum] = parseInt(itemSpan.innerText);
      totalitems();
      costitems();

      // console.log(itemSpan.innerText)
      if (itemSpan.innerText == 0) {




        orderItemIdArray.splice(indexnum, 1);

        orderidarray.splice(indexnum, 1);
        orderitemsarray.splice(indexnum, 1);
        orderPriceArray.splice(indexnum, 1);
        orderImageArray.splice(indexnum, 1);
        orderItemQuantity.splice(indexnum, 1);


        totalitems();
        costitems();
        // console.log(itemSpan.parentElement)
        orderlist.removeChild(itemSpan.parentElement);

        if (orderPriceArray.length == 0) {
          document.getElementById('amount').value = 0;
        }
        enableCheckOutButton();

      }
    };




    // <======= Total item in cart =======================================================================>
    function totalitems() {
      //  document.getElementById('totalitems').innerText = orderitemsarray.length;
      if (orderItemQuantity.length) {
        document.getElementById('totalitems').innerText = orderItemQuantity.reduce((total, num) => {
          return total + num
        });
      } else {
        document.getElementById('totalitems').innerText = '0';
      }
    };




    // <======== Total cost for items in cart ============================================================>
    function costitems() {

      if (orderPriceArray == 0) {
        document.getElementById('totalcost').innerText = 0;
      } else {

        const totalTempArray = [];
        orderItemQuantity.map((quantity, index) => {
          totalTempArray.push(quantity * orderPriceArray[index])
        })

        document.getElementById('totalcost').innerText = totalTempArray.reduce(sumarray).toFixed(2);

        document.getElementById('amount').value = totalTempArray.reduce(sumarray).toFixed(2);

        // Return total price for cart
        function sumarray(total, sum) {
          return total + sum;

          //  document.getElementById('amount').value=orderPriceArray.reduce(sumarray).toFixed(2); 

        };
      };
    };

    function totalamountinput() {

    };




    // <======= TO clear order Basket list ===================================================================>
    function orderbasketclear() {
      let orderlist = document.getElementById('orderlist');
      document.getElementById('amount').value = 0;
      orderlist.innerHTML = '';
      orderitemsarray.length = 0;
      orderPriceArray.length = 0;
      orderImageArray.length = 0;
      orderarray.length = 0;
      orderidarray.length = 0;
      orderItemQuantity.length = 0;
      i = 0;

      totalitems();
      costitems();
      clearCustomerName();
      enableCheckOutButton();
      resetValues();
    };




    // <===================================== Delete item in cart =====================================>
    function deleteItem(orderid, button) {
      // orderidarray ;
      const indexnum = orderidarray.indexOf(orderid);

      // splice = manupilates the original array
      // slice =clone +edit the clone array
      // itemID
      orderItemIdArray.splice(indexnum, 1);


      orderidarray.splice(indexnum, 1);
      orderitemsarray.splice(indexnum, 1);
      orderPriceArray.splice(indexnum, 1);
      orderImageArray.splice(indexnum, 1);
      orderItemQuantity.splice(indexnum, 1);

      console.log(orderidarray);
      totalitems();
      costitems();
      console.log(button)
      orderlist.removeChild(button.parentElement.parentElement);
      // orderitemparent.removeChild(button.parentElement);

      if (orderPriceArray.length == 0) {
        document.getElementById('amount').value = 0;
      }
      enableCheckOutButton();

    };



    // <========================================== Calculator Section ===================================================>
    // Show text in calculator box
    const calculatorScreenAmount = document.getElementById('calculatorScreenAmount');

    // To show number in calculator box

    // function calculatorInseart(value){
    //   calculatorScreenAmount.value+=value;
    // };

    // To show number in calculator box And eleminate revpeted 000 & ....

    // Get the amount
    function exactAmountCalculator() {
      document.getElementById('exactamountspan').innerText = document.getElementById('amount').value;
    };

    function resetExactAmountCalculator() {
      document.getElementById('amount').value = 0;
    }





    // To inseart number in calculator input ------------------------------------------------>
    function calculatorInseart(number) {

      // console.log(calculatorScreenAmount.length);
      if (calculatorScreenAmount.value == 0 && number == '00') {
        calculatorScreenAmount.value = '0.';
      } else if (calculatorScreenAmount.value == 0 && number == '0') {
        calculatorScreenAmount.value = '0.';
      } else if (calculatorScreenAmount.value == '' && number == '00') {
        calculatorScreenAmount.value = '0';
      } else if (calculatorScreenAmount.value.includes('.') == true && number == '.') {
        calculatorScreenAmount.value = calculatorScreenAmount.value;
      } else if (calculatorScreenAmount.value == '0' && number > 0) {
        calculatorScreenAmount.value = number;
      } else {
        calculatorScreenAmount.value += number;
      }

      if (calculatorScreenAmount == '.') {
        calculatorScreenAmount.value = '0.';
      };
      enableConfirmPaidButton();

    };





    // Return Exact amount to screen ------------------------------------------------------------------>
    function exactAmountButton() {
      calculatorScreenAmount.value = document.getElementById('amount').value;
      enableConfirmPaidButton();
    };



    //  Later change Bill with Notes 5 10 20 50 100 
    function denominationButton(bill) {
      calculatorScreenAmount.value = parseFloat(calculatorScreenAmount.value) + bill;
      enableConfirmPaidButton();
    };




    // To empty number in box
    function calculatorCancle() {
      calculatorScreenAmount.value = '0';
      enableConfirmPaidButton();
    };





    // TO Enable button of if amount is higher or equal on calculator screen --------------------------->
    function enableConfirmPaidButton() {
      // confirm button is desable by default
      document.getElementById('confirmPaid').disabled = true;

      if (parseFloat(calculatorScreenAmount.value) >= parseFloat(document.getElementById('amount').value)) {
        document.getElementById('confirmPaid').disabled = false;

      };

    };




    // Disable the inseart button after click---------------------------------------------------------------->
    // function confirmPaidButton(){


    //   const customerAmountPaid =document.getElementById('customeramountpaid');
    //   customerAmountPaid.value= calculatorScreenAmount.value;

    //   const customerAmountChange = document.getElementById('customeramountchange')
    //   customerAmountChange.value=customerAmountPaid.value - document.getElementById('amount').value;

    //   // document.getElementById('customerAmountChange').innerText = totalTempArray.reduce(sumarray).toFixed(2); 

    //   // consol.log('calculatorScreenAmount.value');

    //   document.getElementById( 'calculatorModel').disabled=true;

    //   enableNextCustomerAndPrintbutton();
    //   // disableAllButton();

    // };

    function confirmPaidButton() {
      const calculatorScreenAmount = document.getElementById('calculatorScreenAmount');
      const customerAmountPaid = document.getElementById('customeramountpaid');
      const customerAmountChange = document.getElementById('customeramountchange');
      const amountElement = document.getElementById('amount');
      const calculatorModel = document.getElementById('calculatorModel');

      // Set customerAmountPaid and customerAmountChange values
      customerAmountPaid.value = calculatorScreenAmount.value;

      // customerAmountChange.value = customerAmountPaid.value - amountElement.value;
      // Calculate the change and format it to 2 decimal places
      const change = parseFloat(customerAmountPaid.value) - parseFloat(amountElement.value);
      customerAmountChange.value = change.toFixed(2);

      // Disable the calculatorModel element
      calculatorModel.disabled = true;

      // Reset all values using the resetValues function


      // Enable the next customer and print button
      enableNextCustomerAndPrintbutton();
    }

    // <======= to resetall value ====================================>
    function resetValues() {
      // Replace these IDs with the actual IDs of your elements
      const calculatorScreenAmount = document.getElementById('calculatorScreenAmount');
      const customerAmountPaid = document.getElementById('customeramountpaid');
      const customerAmountChange = document.getElementById('customeramountchange');
      const amountElement = document.getElementById('amount');
      const calculatorModel = document.getElementById('calculatorModel');

      // Reset the values of the specified elements
      if (calculatorScreenAmount) {
        calculatorScreenAmount.value = '0';
      }

      if (customerAmountPaid) {
        customerAmountPaid.value = '0';
      }

      if (customerAmountChange) {
        customerAmountChange.value = '';
      }

      if (amountElement) {
        amountElement.value = '';
      }

      if (calculatorModel) {
        calculatorModel.disabled = false;
      }
    }





    function enableCalculatorModle() {
      document.getElementById('calculatorModel').disabled = false;
    }




    function enableNextCustomerAndPrintbutton() {
      document.getElementById('printReceiptButton').disabled = false;
      document.getElementById('customerNextButton').disabled = false;

    }




    // function disableAllButton(){
    //   document.getElementById('pills-food-tab').disabled=true; 
    //   document.getElementById('pills-drink-tab').disabled=true; 
    //   document.getElementById('orderBasketClearButton').disabled=true; 
    //   document.getElementById ('checkOutButton').disabled=true;

    //   const allButton1 =  document.getElementById('orderlist').querySelectorAll('button'); 
    //   for(let i=0; i<allButton1.length;i++){
    //     allButton1[i].disabled = true;
    //   }



    // }







    // To enable Check Out button if there is element in the List----------------------------------------------> 
    function enableCheckOutButton() {

      const checkOutButton = document.getElementById('checkOutButton');

      checkOutButton.disabled = true;

      if (orderidarray.length > 0) {
        checkOutButton.disabled = false;
      }

      if (orderidarray.length == 0) {
        const backToFoodTab = document.getElementById('pills-food-tab');
        const FoodTab = new bootstrap.Tab(backToFoodTab);

        FoodTab.show();
      }
    };




    // Move to Check Out Tab or Link  -------------------------------------------------------------------------->
    function goToCheckOutTab() {

      const firstTabEl = document.getElementById('pills-checkout-tab');

      const firstTab = new bootstrap.Tab(firstTabEl);


      // consol.log(firstTabEl)
      // consol.log(checkOutButton.disabled)

      firstTab.show();

    };

    // <============================ extraFeature ========================>

    function GetcustomerName() {
      const cname = document.getElementById('customernameCN')

    }

    function clearCustomerName() {

      document.getElementById('customernameCN').value = "";

    }


    displayOrderNumber();

    function displayOrderNumber() {
      document.getElementById('numberDisplay').textContent = currentNumber;
    }

    function incrementNumber() {
      currentNumber += 1;
      // document.getElementById('numberDisplay').textContent = currentNumber;
      console.log(currentNumber);
      displayOrderNumber();
    }


    function nextCustomerButton() {
      orderbasketclear();
      // totalitems();
      // costitems();
      // enableCheckOutButton();
      // resetExactAmountCalculator()
      enableCalculatorModle();
      // ordercounter();
      enableConfirmPaidButton();
      clearCustomerName();
      // enableAllButtonNC();
      calculatorCancle();
      resetAmountAll();
      resetValues();
      incrementNumber();

    }


    // enableAllButtonNC(){

    //   document.getElementById('pills-food-tab').disabled=false; 
    //   document.getElementById('pills-drink-tab').disabled=false; 
    // document.getElementById('orderBasketClearButton').disabled=false; 
    //   document.getElementById ('checkOutButton').disabled=false;

    //   const allButton2 =  document.getElementById('orderlist').querySelectorAll('button'); 
    //   for(let i=0; i<allButton2.length;i++){
    //     allButton2[i].disabled = false;
    //   }
    // }
    // ========================================= working====

    function resetAmountAll() {
      calculatorScreenAmount.value = '0';
      document.getElementById('amount').value = '0';

      customeramountchange.value = 0;
      // customerAmountPaid.value='';

    }



    // function ordercounter(){
    //   var or=87;
    //   or++;
    //   // consol.log(or);
    // }


    // <================================ DATA BASE Code ==================================>


    //  Test database operation on crud 

    // function dataBase() {
    //   let customernameDB = document.getElementById('customernameCN');
    //   let amountDB = document.getElementById('amount');
    //   let customerPaidDB = document.getElementById('customeramountpaid');
    //   let customerChangeDB =document.getElementById('customeramountchange');


    //       var variable1 = customernameDB.value;
    //       console.log(customernameDB.value);
    //       var variable2 = amountDB.value;
    //       var variable3 = customerPaidDB.value;
    //       var variable4 = customerChangeDB.value;

    //       // Using AJAX to send the values to a PHP script
    //       var xhr = new XMLHttpRequest();
    //       xhr.open("POST", "process.php", true);
    //       xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    //       xhr.onreadystatechange = function () {
    //           if (xhr.readyState == 4 && xhr.status == 200) {
    //               // Console LOG
    //               // console.log(xhr.responseText);
    //           }
    //       };

    //       // Multiple variables as a query string
    //       var data = "variable1=" + encodeURIComponent(variable1) +
    //                  "&variable2=" + encodeURIComponent(variable2) +
    //                  "&variable3=" + encodeURIComponent(variable3) +
    //                  "&variable4=" + encodeURIComponent(variable4);

    //       xhr.send(data);
    // }

    // console.log(orderitemsarray);


    // Function to inseart data of order into SQL [ Order Table] ==============>

    function dataBaseOrder() {


      let amountODB = document.getElementById('amount');
      let customerPaidODB = document.getElementById('customeramountpaid');
      let customerChangeODB = document.getElementById('customeramountchange');
      let customernameODB = document.getElementById('customernameCN');

      var variable1 = amountODB.value;
      var variable2 = customerPaidODB.value;
      var variable3 = customerChangeODB.value;
      var variable4 = customernameODB.value;
      var variable5 = currentNumber;
      console.log(customernameODB.value);




      // Using AJAX to send the values to a PHP script
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "Orders_DB.php", true);
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
        "&variable4=" + encodeURIComponent(variable4) +
        "&variable5=" + encodeURIComponent(variable5);

      xhr.send(data);
    }



    function consoleloop() {
      console.log(orderItemIdArray);
      console.log(orderitemsarray);
      console.log(orderPriceArray);
      console.log(orderItemQuantity);
      // console.log(variable5);
    }


    // Function to inseart data of order slip into SQL  [ Orderslip ]

    function dataBaseOrderSlip() {
      // const name = document.createElement("")
      // const n = document.get

      // const array1 = [1, 2, 3, 4];
      // const array2 = [6, 7, 8, 9];
      // const array3 = ['a', 'b', 'c', 'd'];
      // const array4 = ['e', 'f', 'g', 'h'];

      orderItemIdArray;
      orderitemsarray;
      orderPriceArray;
      orderItemQuantity;
      // counternumber;

      // Function for intervariable elements from multiple arrays
      function interleaveArrays(...arrays) {
        const maxLength = Math.max(...arrays.map(arr => arr.length));
        const result = [];

        for (let i = 0; i < maxLength; i++) {
          for (const arr of arrays) {
            if (arr[i] !== undefined) {
              result.push(arr[i]);
            }
          }
        }

        return result;
      }

      // merge all 4 arrays in a pattern
      const arrayall = interleaveArrays(orderItemIdArray, orderitemsarray, orderPriceArray, orderItemQuantity);

      // console
      // console.log(arrayall);


      // const arrayall = [1, 6, 'a', 'e', 2, 7, 'b', 'f', 3, 8, 'c', 'g', 4, 9, 'd', 'h'];


      const numberOfVar = 4;
      const numberOfLoops = arrayall.length / numberOfVar;
      for (let i = 0; i < numberOfLoops; i++) {
        // index for iteration
        const index1 = i * numberOfVar;
        const index2 = index1 + 1;
        const index3 = index1 + 2;
        const index4 = index1 + 3;
        const var5 = currentNumber

        // values in separate variables
        const var1 = arrayall[index1];
        const var2 = arrayall[index2];
        const var3 = arrayall[index3];
        const var4 = arrayall[index4];

        // variable for console       
        console.log(var1);
        console.log(var2);
        console.log(var3);
        console.log(var4);

        var variable11 = var1;
        var variable21 = var2;
        var variable31 = var3;
        var variable41 = var4;
        var variable51 = var5;


        // Using AJAX to send the values to a PHP script
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "OrderSlip_DB.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
          if (xhr.readyState == 4 && xhr.status == 200) {
            // Handle the response from PHP if needed
            console.log(xhr.responseText);
          }
        };

        // Encode the variables as a query string
        var data =
          "variable11=" + encodeURIComponent(variable11) +
          "&variable21=" + encodeURIComponent(variable21) +
          "&variable31=" + encodeURIComponent(variable31) +
          "&variable41=" + encodeURIComponent(variable41) +
          "&variable51=" + encodeURIComponent(variable51);

        xhr.send(data);


      }

    }




    // function 
    // <<<===========*******************=================  pdf function ==================**************************=================>>>>>>>>>

    function createInvoice() {
      var data = getSampleData();
      easyinvoice.createInvoice(data, function(result) {
        document.getElementById('invoiceBase64').innerText = result.pdf;

      });
    }

    function downloadInvoice() {
      var data = getSampleData();
      easyinvoice.createInvoice(data, function(result) {
        easyinvoice.download('Order #' + currentNumber + '.pdf', result.pdf);
        // easyinvoice.download('Receipt'+orderincrement+'.pdf', result.pdf);
        // easyinvoice.save('myInvoice.pdf', result.pdf);
      });
    }
    // let orderincrement = 23;
    const clientCompany = 'Dynamic Client Company';
    const clientAddress = 'Dynamic Client Address';
    const combOrderwithhash = 'Or #' + currentNumber;
    console.log(currentNumber)
    // console.log(combOrderwithhash)

    // const invoiceData = getSampleData(clientCompany, clientAddress);
    // let date =new Date();

    function updateTimepdf() {
    let Monthshort = date.toLocaleString('en-US', {
      month: 'short'
    })
    let dayd = date.toLocaleString('en-US', {
      day: '2-digit'
    })


    let MonthsNum = date.toLocaleString('en-US', {
      month: '2-digit'
    })
    let daynum = date.toLocaleString('en-US', {
      day: '2-digit'
    })
    let yearnum = date.toLocaleString('en-US', {
      year: 'numeric'
    })
   }
   updateTimepdf();

    // Update the time every minute (60,000 milliseconds)
    setInterval(updateTimepdf, 60000);


    let DayMonYearCrrnum = yearnum + MonthsNum + '.' + daynum + '.' + currentNumber;
    console.log(DayMonYearCrrnum)

    // let Year = date.toLocaleString ('en-US', { year: 'numeric'})
    let DayMon = dayd + '-' + Monthshort;

    console.log(DayMon);

    function getSampleData() {
      //  Data from separate arrays 
      const itemName = orderitemsarray;
      const itemPrice = orderPriceArray;
      // console.log(itemPrice);
      const itemQuantity = orderItemQuantity;
      // console.log(itemQuantity);
      const itemtax = orderTtemTaxArray;


      // const itemName = ['Product A', 'Product B', 'Product C'];
      // const itemPrice = [30, 20, 50];
      // const itemQuantity = ['3', '2', 1];
      // const itemtax = ['0',0,0];



      // let cname = 'raj';
      // Create productData array by combining data from separate arrays
      const productData = itemName.map((name, index) => ({
        description: name,
        quantity: itemQuantity[index],
        price: itemPrice[index],
        'tax-rate': itemtax[index],
      }));

      // Company name is client name
      let Companyname = document.getElementById('customernameCN').value;
      let Companyadd = combOrderwithhash;
      let dateMonYear = DayMon;
      let infoNumber = DayMonYearCrrnum;
      // let number = "Serial No.";

      console.log(infoNumber);
      // console.log('1');
      // console.log('a');


      return {

        images: {
          // logo: 'https://public.easyinvoice.cloud/img/logo_en_original.png',
          // background: 'https://public.easyinvoice.cloud/img/watermark-draft.jpg'
        },
        sender: {
          company: 'Pizza Camp',
          address: 'The Bay Club, BKC',
          zip: '400051 S.B',
          city: 'Mumbai',

        },
        // client:{
        // company: 'Pizza Camp Or#88',
        // address: 'Raj Lodh'
        // },
        client: {
          company: Companyname, // Dynamically provided client company
          address: Companyadd, // Dynamically provided client address
        },

        information: {
          number: infoNumber,
          date: dateMonYear,
          // number: '2021.0001',
          // 'due-date': '31-12-2021'
        },
        products: productData,


        // h700 w 300
        'bottom-notice': '  ☺☺         Thankyou visit Again.          ☺☺',
        settings: {
          currency: 'INR',

          "format": "Letter",
          "height": "850px",
          "width": "330px",

        },
        "translate": {
          "invoice": "Order Receipt",

          //  "vat": "Tax"
        },
      };
    }














    //  use case    Variable  Db variable
    // total item amount = amountElement = orderAmount, 
    // customer name = cname   =  orderCustomerName ,
    // customer paid = customerAmountPaid   = orderCustomerPaid ,
    // amount change = customerAmountChange  = orderChange ,
  </script>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-b5kHyXgcpbZJ0/ tY9U17kGkf1S0CWUKCCD3818YkeH8z8QjE0GmW1gYU5S9F0nJ0" crossorigin="anonymous"> -->

  </script>



</body>

</html>