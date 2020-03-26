<?php
namespace MobilitySharp\controller;
include_once 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["ids"])){
        changePetitionStatus($_POST["ids"], $_POST["type"]);
    echo json_encode(["response" => "true"]);
    }
    else {
        echo json_encode(["response" => "false"]);
    }
    
    
    
}
?>