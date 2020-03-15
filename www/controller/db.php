<?php

namespace MobilitySharp\controller;

require_once 'vendor/autoload.php';

use \PDO;
use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

function load($user): EntityManager {
    $global = parse_ini_file("config/db-global.ini");
    $account = parse_ini_file("config/db-$user.ini");
    $isDevMode = false;

    /*
      $pdo = new PDO("mysql:host=$global[host];dbname=$global[dbname];charset=$global[charset]", $account['username'], $account['password'] ?? NULL);

      if($global['debug'] && $global['debug'] === "true") {
      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      }

      return $pdo; */

    if ($global['debug'] && $global['debug'] === "true") {
        $isDevMode = true;
    }
    $paths = ["model"];
    $dbParams = [
        'driver' => 'pdo_mysql',
        'host' => $global['host'],
        'dbname' => $global['dbname'],
        'charset' => $global['charset'],
        'user' => $account['username'],
        'password' => $account['password']
    ];
    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
    $config->setProxyNamespace("MobilitySharp\model");
    $config->setAutoGenerateProxyClasses(true);
    return EntityManager::create($dbParams, $config);
}

function checkUser($username, $password) {
    /* if($pdo = load("login")) {
      $stmt = $pdo->prepare('SELECT usuario, email, `password` FROM socios WHERE lower(usuario)=:username OR lower(email)=:username');
      $stmt->execute([':username' => strtolower($username)]);


      $user = $stmt->fetch(PDO::FETCH_ASSOC);

      if ($user !== FALSE) {
      if (password_verify($password, $user['password'])) {
      return $user;
      }
      }

      }
      return FALSE; */
    try {
        $entityM = load("login");
        $user = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["username" => $username]); //falta tener en cuenta que el usuario puede acceder con username o email
        if ($user !== null) {
            if (password_verify($password, $user->getPassword())) {


                return ['usuario' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'password' => $user->getPassword()
                ];
            }
        }
        return FALSE;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

function getCountries() {
    /* if($pdo = load("login")) {
      $stmt = $pdo->query("SELECT ID_PAIS as id, nombre  FROM PAISES");
      $countries = $stmt->fetchAll(PDO::FETCH_ASSOC); */

    $entityM = load("login");
    $countries = $entityM->getRepository("MobilitySharp\model\Country")->findAll();

    foreach ($countries as $country) {
        echo "<option value='" . $country->getId() . "'>" . $country->getName() . "</option>";
    }
}

function getInstitutionTypes() {
    /* if($pdo = load("login")) {
      $stmt = $pdo->query("SELECT ID_TIPO_INSTITUCION, TIPO FROM TIPOS_INSTITUCION;");
      $insTypes = $stmt->fetchAll(PDO::FETCH_ASSOC); */

    $entityM = load("login");
    $insTypes = $entityM->getRepository("MobilitySharp\model\InstitutionType")->findAll();

    foreach ($insTypes as $type) {
        echo "<option value='" . $type->getId() . "'>" . $type->getType() . "</option>";
    }
}

function registerPartnerInstitution() {
    $location = "Location: $_SERVER[PHP_SELF]?error"; //Redirects to self and flags an error by default
    //if($pdo = load("login")) {
    $entityM = load("login");
    try {
        $date = new \DateTime(date('Y-m-d'));
        $name = filter_input(INPUT_POST, "fName") . " " . filter_input(INPUT_POST, "lName");
        $email = filter_input(INPUT_POST, "email");
        $phone = filter_input(INPUT_POST, "phone");
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        $vat = (filter_input(INPUT_POST, "vat")) ? filter_input(INPUT_POST, "vat") : NULL;
        $post = filter_input(INPUT_POST, "post");
        $department = filter_input(INPUT_POST, "department");
        $l_provider = 0; //not a provider
        $role = $entityM->getRepository("MobilitySharp\model\Role")->findOneBy(["type" => 'REGISTERED']); // registered user
        $country = $entityM->find("MobilitySharp\model\Country", filter_input(INPUT_POST, "country"));


        $iName = filter_input(INPUT_POST, "iName");
        $iEmail = filter_input(INPUT_POST, "iEmail");
        $iPhone = filter_input(INPUT_POST, "iPhone");
        $iVat = (filter_input(INPUT_POST, "iVat")) ? filter_input(INPUT_POST, "iVat") : NULL;
        $postalCode = filter_input(INPUT_POST, "postalCode");
        $iLocation = filter_input(INPUT_POST, "location");
        $web = filter_input(INPUT_POST, "web");
        $description = filter_input(INPUT_POST, "description");
        $institutionType = $entityM->find("MobilitySharp\model\InstitutionType", filter_input(INPUT_POST, "institutionType"));

        //$query = $pdo->query("SELECT ID_INSTITUCION FROM INSTITUCIONES WHERE NOMBRE='$iName'")->fetch(PDO::FETCH_ASSOC); //check if the institution already exists
        $institution = $entityM->getRepository("MobilitySharp\model\Institution")->findOneBy(["name" => $iName]);

        $partnerParams = [
            ':email' => $email,
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
        ];



        if (is_null($institution)) {
            $entityM->getConnection()->beginTransaction();
            $partner = new \MobilitySharp\model\Partner(password_hash($password, PASSWORD_DEFAULT), $username, $name, $email, $phone, $post, $department, $role, $country, $date);
            //$pdo->beginTransaction();
            // $stmt = $pdo->prepare("INSERT INTO SOCIOS (NOMBRE_COMPLETO,EMAIL,TELEFONO,USUARIO,PASSWORD,VAT,CARGO,DEPARTAMENTO,R_ALOJAMIENTO,ROL,PAIS)"
            //         . "VALUES (:name, :email, :phone, :username, :password, :vat, :post, :department, :l_provider, :rol, :country);");
            $entityM->persist($partner);
            $entityM->flush();

            $institution = new \MobilitySharp\model\Institution($iName, $iEmail, $iPhone, $postalCode, $iLocation, $country, $partner, $institutionType, $date);
            $entityM->persist($institution);
            $entityM->flush();
            //if($stmt->execute($partnerParams)) {
            //  $stmt = $pdo->prepare("INSERT INTO INSTITUCIONES (VAT,NOMBRE,EMAIL,TELEFONO,CODIGO_POSTAL,DIRECCION,WEB,PAIS,SOCIO,TIPO,DESCRIPCION)"
            //          . "VALUES (:iVat, :iName, :iEmail, :iPhone, :postalCode, :iLocation, :web, :country, :partner, :institutionType, :description);");

            $partner->setInstitution($institution);
            $entityM->persist($partner);
            $entityM->flush();

            //if($stmt->execute($institutionParams)) {
            //$pdo->exec("UPDATE SOCIOS SET INSTITUCION=".$pdo->lastInsertId()." WHERE EMAIL='$email'");

            if ($entityM->getConnection()->commit()) {
                sessionStoreUser($partnerParams);
                $location = "Location:index.php?registered";
            } else {
                $entityM->getConnection()->rollback();
            }
        } else {

            $partner = new \MobilitySharp\model\Partner(password_hash($password, PASSWORD_DEFAULT), $username, $name, $email, $phone, $post, $department, $role, $country, $date);
            $partner->setInstitution($institution);
            $entityM->persist($partner);
            $entityM->flush();
            //$stmt = $pdo->prepare("INSERT INTO SOCIOS (NOMBRE_COMPLETO,EMAIL,TELEFONO,USUARIO,PASSWORD,VAT,CARGO,DEPARTAMENTO,R_ALOJAMIENTO,ROL,PAIS,INSTITUCION)"
            //  . "VALUES (:name, :email, :phone, :username, :password, :vat, :post, :department, :l_provider, :rol, :country, :institution);");

            sessionStoreUser($partnerParams);
            $location = "Location:index.php?registered";
        }
        header($location);
    } catch (Exception $e) {

        header($location);
    }
}

function sessionStoreUser($userParams) {
    $user = [
        'usuario' => $userParams[':username'],
        'email' => $userParams[':email'],
        'password' => $userParams[':password']
    ];

    $_SESSION['user'] = $user;
}

function searchInstitutions() {

    $entityM = load("login");

    //if ($pdo = load("login")) {

    /* $stmt = $pdo->prepare("SELECT * FROM EMPRESAS WHERE NOMBRE LIKE :nombre;");
      $stmt->execute($datos);
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC); */
    $query = $entityM->createQuery("SELECT e FROM MobilitySharp\model\Enterprise e WHERE e.name LIKE :enterprise")
            ->setParameter('enterprise','%'. filter_input(INPUT_GET, "enterpriseName").'%');
    $enterprises = $query->getResult();
    return $enterprises;
}


