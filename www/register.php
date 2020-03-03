<?php
include_once 'db.php';
?>

<html>

    <head>
        <title>Mobility&sharp;</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, user-scalable=no" />
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
        <script src="js/jquery.min.js"></script>
        <script src="js/bootstrap.bundle.min.js"></script>
        <script src="js/custom.js"></script>
        <style>
            .logo {
                width:150px;
            }
        </style>
    </head>
    <body>
        <?php include "header.php" ?>

        <div class="container-fluid">
            <div class="container border mt-3">
                <ul class="nav nav-tabs" id="registerTab" role="tablist">

                    <li class="nav-item">
                        <a class="nav-link active" href="#partner" id="partnerTab" data-toggle="tab" role="tab" aria-controls="partner" aria-selected="true">Partner</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#institution" id="institutionTab" data-toggle="tab" role="tab" aria-controls="institution" aria-selected="false">Institution</a>
                    </li>
                </ul>


                <form method="POST">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="partner" role="tabpanel" aria-labelledby="partner-tab">
                            
                            <script>createFormStruct()</script>

                            <input class="form-control" type="text" placeholder="First name">
                            <input class="form-control" type="text" placeholder="Last name">
                            


                            </div>

                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                    <input class="form-control" type="text" placeholder="Username"> 
                                </div>
                                <div class="form-col mx-3 my-2 my-md-3">
                                    <input class="form-control" type="text" placeholder="Email">
                                </div>


                            </div>
                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                    <input class="form-control" type="password" placeholder="Password">
                                </div>
                                <div class="form-col mx-3 my-2 my-md-3">
                                    <input class="form-control" type="password" placeholder="Confirm password">
                                </div>


                            </div>

                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                    <input class="form-control" type="text" placeholder="Phone">
                                </div>
                                <div class="form-col mx-3 my-2 my-md-3">
                                    <input class="form-control" type="text" placeholder="VAT">
                                </div>


                            </div>

                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                    <input class="form-control" type="text" placeholder="Department">

                                </div>
                                <div class="form-col mx-3 my-2 my-md-3">
                                    <input class="form-control" type="text" placeholder="Post">
                                </div>


                            </div>
                            <div class="form-row justify-content-center">
                                <div class="form-col mx-3 my-2 my-md-3"> 
                                   <select class="custom-select">

                                <?php
                                getCountries();
                                ?>
                            </select>

                                </div>
                                <div class="form-col mx-3 my-2 my-md-3">
                                    <input type="submit" value="Next" class="btn btn-primary">
                                </div>


                            </div>
                            


                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade" id="institution" role="tabpanel" aria-labelledby="institution-tab">



                            <input class="form-control" type="text" placeholder="">
                            <input class="form-control" type="text" placeholder="">
                            <input class="form-control" type="text" placeholder="">
                            <input class="form-control" type="text" placeholder="">
                            <input class="form-control" type="text" placeholder="">
                            <input class="form-control" type="text" placeholder="">


                        </div>
                    </div>
                </form>



            </div>


        </div>

        <?php include 'footer.html' ?>
    </body>
</html>
