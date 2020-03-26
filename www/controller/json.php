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
                break;
            case "enterprise":
                getEnterprise(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
                break;
            case "profile":
                getProfile(filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
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


function getEnterprise($id) {
    
    if(isset($id)){
        $enterprise = findEntity("Enterprise", $id);
        
        if($enterprise){
            echo json_encode([
                'eName' => $enterprise->getName(),
                'eEmail' => $enterprise->getEmail(),
                'ePhone' => $enterprise->getTelephone(),
                'eVat' => $enterprise->getVat() ?? '',
                'postalCode' => $enterprise->getPostal_code(),
                'location' => $enterprise->getLocation(),
                'web' => $enterprise->getWeb() ?? '',
                'description' => $enterprise->getDescription() ?? '',
                'ceoPost' => $enterprise->getCeo_Post(),
                'enterpriseType' => $enterprise->getType()->getId(),
                'country' => $enterprise->getCountry()->getId()
            ]);
        }
    }
}

function getProfile($id) {
    
    if(isset($id)){
        $partner = findEntity("Partner", $id);

        if($partner) {
            $fullName = explode(" ", $partner->getFull_name());
            $firstName = $fullName[0];
            $lastName = (isset($fullName[2])) ? "$fullName[1] $fullName[2]" : "$fullName[1]";

            echo json_encode([
                'fName' => $firstName,
                'lName' => $lastName,
                'username' => $partner->getUsername(),
                'email' => $partner->getEmail(),
                'phone' => $partner->getTelephone(),
                'vat' => $partner->getVat(),
                'department' => $partner->getDepartment(),
                'post' => $partner->getPost(),
                'country' => $partner->getCountry()->getId()
            ]);
        }
    }
}