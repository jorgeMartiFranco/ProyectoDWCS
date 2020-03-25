<?php
include_once 'controller/db.php';
?>
<!DOCTYPE html>
<html>
<?php include 'head.html' ?>

<body>
    <?php include "header.php"; ?>
    <div class="wrapper">
        <?php include "sidenav.php"; ?>
        <div class="container mt-3 mt-lg-5 border-bottom border-dark my-3 my-lg-5 mx-3 mx-lg-5">
            <div class="row border-bottom border-dark my-3">
                <div class="col"><h3>Your inbox</h3></div>
            </div>
            <div class="row inbox">
                <div class="col-md-3">
                    <div class="panel panel-default">
                        <div class="panel-body inbox-menu">
                            <?php 
                            if($_SESSION["user"]["role"]=="REGISTERED"){
                            ?>
                            <a href="contact.php" class="btn btn-danger btn-block">New Petition</a>
                                    <?php
                            }
                                    ?>
                            <ul class="list-group mb-3 mb-lg-5" id="inboxList" role="tablist">
                                <?php
                                if ($_SESSION["user"]["role"] == "REGISTERED") {
                                ?>
                                <li>
                                    <a href="#requested" class="active" id="requested-tab" data-toggle="tab" role="tab" aria-controls="requested" aria-selected="true">
                                        <i class="fa fa-inbox"></i>Requested
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessages("REQUESTED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#inProcess" id="inProcess-tab" data-toggle="tab" role="tab" aria-controls="inProcess" aria-selected="false">
                                        <i class="fas fa-lightbulb"></i>In Process
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessages("IN PROCCESS"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#solved" id="solved-tab" data-toggle="tab" role="tab" aria-controls="solved" aria-selected="false">
                                        <i class="fas fa-check-circle"></i>Solved
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessages("SOLVED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#cancelled" id="cancelled-tab" data-toggle="tab" role="tab" aria-controls="cancelled" aria-selected="false">
                                        <i class="fa fa-trash"></i>Cancelled
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessages("CANCELLED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#declined" id="declined-tab" data-toggle="tab" role="tab" aria-controls="declined" aria-selected="false">
                                        <i class="fas fa-times-circle"></i>Declined
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessages("DECLINED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <?php
                                } else if ($_SESSION["user"]["role"] == "ADMIN") {
                                ?>
                                <li>
                                    <a href="#requested" class="active" id="requested-tab" data-toggle="tab" role="tab" aria-controls="requested" aria-selected="true">
                                        <i class="fa fa-inbox"></i>Requested
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessagesAdmin("REQUESTED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#inProcess" id="inProcess-tab" data-toggle="tab" role="tab" aria-controls="inProcess" aria-selected="false">
                                        <i class="fas fa-lightbulb"></i>In Process
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessagesAdmin("IN PROCCESS"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#solved" id="solved-tab" data-toggle="tab" role="tab" aria-controls="solved" aria-selected="false">
                                        <i class="fas fa-check-circle"></i>Solved
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessagesAdmin("SOLVED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#declined" id="declined-tab" data-toggle="tab" role="tab" aria-controls="declined" aria-selected="false">
                                        <i class="fas fa-times-circle"></i>Declined
                                        <span class="label">
                                            <?php \MobilitySharp\controller\countMessagesAdmin("DECLINED"); ?>
                                        </span>
                                    </a>
                                </li>
                                <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--/.col-->
                <div class="col-md-9">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <span class="btn-group">
                                <?php
                                if ($_SESSION["user"]["role"] == "ADMIN") {
                                ?>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="Set petition requested"><span class="fa fa-inbox"></span></button>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="Set petition in Process"><span class="fas fa-lightbulb"></span></button>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="Set petition solved"><span class="fas fa-check-circle"></span></button>
                                    <button class="btn btn-primary" data-toggle="tooltip" title="Set petition declined"><span class="fas fa-times-circle"></span></button>
                                <?php
                                } else if ($_SESSION["user"]["role"] == "REGISTERED") {
                                ?>
                                <!-- Code -->
                                <?php
                                }
                                ?>
                            </span>
                            <span class="btn-group pull-right">
                                <button class="btn btn-default"><span class="fa fa-chevron-left"></span></button>
                                <button class="btn btn-default"><span class="fa fa-chevron-right"></span></button>
                            </span>
                            <div class="tab-content">
                                <?php
                                if ($_SESSION["user"]["role"] == "REGISTERED") {
                                ?>
                                <div class="tab-pane fade show active" id="requested" role="tabpanel" aria-labelledby="requested-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessages("REQUESTED"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="inProcess" role="tabpanel" aria-labelledby="inProcess-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessages("IN PROCCESS"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="solved" role="tabpanel" aria-labelledby="solved-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessages("SOLVED"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                                    <ul class="messages-list mb-3 mb-lg-5" id="cancelled">
                                        <?php MobilitySharp\controller\listPartnerMessages("CANCELLED"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="declined-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessages("DECLINED"); ?>
                                    </ul>
                                </div>
                                <?php
                                } else if ($_SESSION["user"]["role"] == "ADMIN") {
                                ?>
                                <div class="tab-pane fade show active" id="requested" role="tabpanel" aria-labelledby="requested-tab">
                                    <ul class="messages-list mb-3 mb-lg-5" id="requested">
                                        <?php MobilitySharp\controller\listPartnerMessagesAdmin("REQUESTED"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="inProcess" role="tabpanel" aria-labelledby="inProcess-tab">
                                    <ul class="messages-list mb-3 mb-lg-5" id="inProcess">
                                        <?php MobilitySharp\controller\listPartnerMessagesAdmin("IN PROCCESS"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="solved" role="tabpanel" aria-labelledby="solved-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessagesAdmin("SOLVED"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessagesAdmin("CANCELLED"); ?>
                                    </ul>
                                </div>
                                <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="declined-tab">
                                    <ul class="messages-list mb-3 mb-lg-5">
                                        <?php MobilitySharp\controller\listPartnerMessagesAdmin("DECLINED"); ?>
                                    </ul>
                                </div>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!--/.col-->
            </div>
        </div>
    </div>
    <?php
    include "footer.html";
    ?>
</html>