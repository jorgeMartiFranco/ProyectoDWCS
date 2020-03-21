<?php
namespace MobilitySharp\controller;
include_once 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET) && !empty($_GET)) {
        $params = array_keys($_GET);
        $function_request = '';

        //gets only the first parameter
        foreach($params as $param) {
            $function_request = $param;
            break;
        }
        
        switch($function_request){
            case "ceos":
                if(is_logged_in()) {
                    getCeos();
                }
                break;
            case "countries":
                getCountries();
                break;
            case "enterpriseTypes":
                if(is_logged_in()) {
                    getEnterpriseTypes();
                }
                break;
            case "institutionTypes":
                getInstitutionTypes();
        }
        
    }
}

//Añadir rol cuando esté todo listo
function is_logged_in() : bool {
    $is_logged = false;

    session_start();

    if(isset($_SESSION['user'])) {      //Añadir comprobación rol
        $is_logged = true;
    }

    return $is_logged;
}