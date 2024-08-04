<!DOCTYPE html>
<html lang="en">

<head>

    <style>
    .nav-bar {
        background-color: #b90f0f;
    }

    .content-div {
        align-self: center;
        /* margin-left: 6%;
        margin-right: 6%;
        */
        margin-bottom: 2%;
        margin-top: 2%;
        padding: 1%;
        border: #d3d3d3fa 2px solid;
        border-radius: 10px;

    }

    
    td{
        text-align:center!important;
        vertical-align: middle;
        padding-top:20px!important;
        padding-bottom:20px!important;
    }
    th{
        text-align:center!important;
    }
    </style>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss','resources/js/app.js'])

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
        <table class="table" style="max-height:100px;overflow:scroll;">
            <thead style="position: sticky;">
                <tr>
                    <th scope="col" style="width:32%;">Product</th>
                    <th scope="col" style="width:17%;">Unit Price</th>
                    <th scope="col" style="width:17%;">Quantity</th>
                    <th scope="col" style="width:17%;">Total Price</th>
                    <th scope="col" style="width:17%;">Action</th>
                </tr>
            </thead>
            <tbody>
              
                <tr>
                    <td>
                        <img src="/img/product.jpg" alt="pokemon" width="460" height="345">
                    </td>
                    <td>RM8.00</td>
                    <td>
                        <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
                            <button class="btn btn-outline-secondary" type="button" style="border-right:none;">-</button>
                            <input style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text" class="form-control" placeholder="1" aria-label=""
                                aria-describedby="basic-addon1">
                            <button class="btn btn-outline-secondary" type="button" style="border-left:none;">+</button>
                        </div>
                    </td>
                    <td>RM8.00</td>
                    <td><button type="button" class="btn btn-danger">DELETE</button>
                    </td>
                </tr>
                <tr>
                    <td>
                        <img src="/img/product.jpg" alt="pokemon" width="460" height="345">
                    </td>
                    <td>RM8.00</td>
                    <td>
                        <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
                            <button class="btn btn-outline-secondary" type="button" style="border-right:none;">-</button>
                            <input style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text" class="form-control" placeholder="1" aria-label=""
                                aria-describedby="basic-addon1">
                            <button class="btn btn-outline-secondary" type="button" style="border-left:none;">+</button>
                        </div>
                    </td>
                    <td>RM8.00</td>
                    <td><button type="button" class="btn btn-danger">DELETE</button>
                    </td>
                </tr><tr>
                    <td>
                        <img src="/img/product.jpg" alt="pokemon" width="460" height="345">
                    </td>
                    <td>RM8.00</td>
                    <td>
                        <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
                            <button class="btn btn-outline-secondary" type="button" style="border-right:none;">-</button>
                            <input style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text" class="form-control" placeholder="1" aria-label=""
                                aria-describedby="basic-addon1">
                            <button class="btn btn-outline-secondary" type="button" style="border-left:none;">+</button>
                        </div>
                    </td>
                    <td>RM8.00</td>
                    <td><button type="button" class="btn btn-danger">DELETE</button>
                    </td>
                </tr>
              

            </tbody>
            <tfoot style="position: sticky;">
                
                <tr>
                    <td>
                        <img src="/img/product.jpg" alt="pokemon" width="460" height="345">
                    </td>
                    <td>RM8.00</td>
                    <td>
                        <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
                            <button class="btn btn-outline-secondary" type="button" style="border-right:none;">-</button>
                            <input style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text" class="form-control" placeholder="1" aria-label=""
                                aria-describedby="basic-addon1">
                            <button class="btn btn-outline-secondary" type="button" style="border-left:none;">+</button>
                        </div>
                    </td>
                    <td>RM8.00</td>
                    <td><button type="button" class="btn btn-danger">DELETE</button>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>