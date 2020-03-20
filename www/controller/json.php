<?php
namespace MobilitySharp\controller;
include_once 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET) && !empty($_GET)) {
        $params = array_keys($_GET);
        $function_request = '';

        foreach($params as $param) {
            $function_request = $param;
            break;
        }
        switch($function_request){
            case "countries":
                getCountries();
                break;
            case "institutionTypes":
                getInstitutionTypes();
                break;
        }
    }
}