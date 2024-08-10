<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss','resources/js/app.js','resources/css/general.css'])
    <style>
    .sticky-bottom {
        border-top: solid #d3d3d3fa 1px;
        position: sticky;
        bottom: 0;
        z-index: 2;
        background-color: white;
    }

    .sticky-top {
        position: sticky;
        top: 0;
        background-color: white;
        z-index: 2;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg nav-bar">

        <a class="navbar-brand" href="#">
            <img src="/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" alt="">
        </a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <div class="container-xl content-div">
        <div class="cart-table-body">
            <div class="sticky-top">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col" style="width:32%;">Product</th>
                            <th scope="col" style="width:17%;">Unit Price</th>
                            <th scope="col" style="width:17%;">Quantity</th>
                            <th scope="col" style="width:17%;">Total Price</th>
                            <th scope="col" style="width:17%;">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <table class="table">
                <tbody>

                    <?php
for ($x = 0; $x <= 10; $x++) {
    echo '
      <tr>
        <td style="width:32%;">
          <img src="' . URL('storage/images/pika.jpg') . '" alt="pokemon" width="250" height="250">
        </td>
        <td style="width:17%;">RM8.00</td>
        <td style="width:17%;">
          <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
            <button id="'.$x.'decrease" class="btn btn-outline-secondary decrease-btn" onclick=minus("'.$x.'quantity") type="button" style="border-right:none;">-</button>
            <input id="'.$x.'quantity" value=1 style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text" class="form-control" aria-describedby="basic-addon1">
            <button id="'.$x.'increase" class="btn btn-outline-secondary increase-btn" onclick=add("'.$x.'quantity") type="button" style="border-left:none;">+</button>
          </div>
        </td>
        <td style="width:17%;">RM8.00</td>
        <td style="width:17%;"><button type="button" class="btn btn-danger">DELETE</button></td>
      </tr>';
}
?>
                </tbody>

            </table>
            
        </div>
        <div class="sticky-bottom">
            <table style="width:100%" class="table">
                <tbody>
                    <tr>
                        <td></td>
                        <td>-RM8.00 <button style="background-color: #ffffff;border:0" onclick=showDiscount()><i
                                    id="show-discount-icon" style="display:inline">&#9650;</i><i id="hide-discount-icon"
                                    style="display:none;">&#9660;</i></button></td>

                    </tr>
                    <?php
                echo 
                '<tr class="discount-row" style="display:none">  
                    <td>description</td>
                    <td>-RM8.00</td>
                </tr>';
                ?>
                    <tr>
                        <td style="width:80%;text-align:right !important;">RM8.00</td>
                        <td style="width:20%;"><button type="button" class="btn btn-success">CHECKOUT</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>

<script>
function add(quantityid) {
    var quantityInput = document.getElementById(quantityid);
    var currentValue = parseInt(quantityInput.value, 10);
    var newValue = currentValue + 1;
    quantityInput.value = newValue;
}

function minus(quantityid) {
    var quantityInput = document.getElementById(quantityid);
    var currentValue = parseInt(quantityInput.value, 10);
    var newValue = currentValue - 1;
    quantityInput.value = newValue;
}

function showDiscount() {
    var discountRows = document.getElementsByClassName("discount-row");
    var showDiscountIcon = document.getElementById("show-discount-icon");
    var hideDiscountIcon = document.getElementById("hide-discount-icon");

    for (var i = 0; i < discountRows.length; i++) {
        if (discountRows[i].style.display != "table-row") {
            discountRows[i].style.display = "table-row";
            showDiscountIcon.style.display = "none";
            hideDiscountIcon.style.display = "inline";

        } else {
            discountRows[i].style.display = "none";
            showDiscountIcon.style.display = "inline";
            hideDiscountIcon.style.display = "none";

        }
    }
}
</script>