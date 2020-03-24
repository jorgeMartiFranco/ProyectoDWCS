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
                getEnterprise($_GET['id']);
                break;
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
            $enterprise = findEntity("Enterprise", filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT));
            
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