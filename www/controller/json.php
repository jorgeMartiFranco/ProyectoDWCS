<?php
namespace MobilitySharp\controller;
include_once 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET) && !empty($_GET)) {
        
        if(isset($_GET['countries'])) {
            getCountries();
        }
    }
}