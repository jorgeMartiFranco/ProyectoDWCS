<?php

namespace MobilitySharp\controller;

require_once __DIR__ . '/../vendor/autoload.php';

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

function load($user): EntityManager {
    $global = parse_ini_file("config/db-global.ini");
    $account = parse_ini_file("config/db-$user.ini");
    $isDevMode = false;

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
        'password' => $account['password'] ?? ""
    ];
    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
    $config->setProxyNamespace("MobilitySharp\model");
    $config->setAutoGenerateProxyClasses(true);
    return EntityManager::create($dbParams, $config);
}

function checkUser($username, $password) {

    try {
        $entityM = load("login");
        $queryUser = $entityM->createQueryBuilder();

        $queryUser->addSelect("p")
                ->from("MobilitySharp\model\Partner", 'p')
                ->where("p.username = :username")
                ->orWhere("p.email = :username")
                ->setParameter("username", $username);
        $user = $queryUser->getQuery()->getSingleResult();

        if ($user !== null) {
            if (password_verify($password, $user->getPassword())) {


                return [
                    'id' => $user->getId(),
                    'usuario' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'password' => $user->getPassword(),
                    'role' => $user->getRole()->getType()
                ];
            }
        }
        return FALSE;
    } catch (Exception $ex) {
        echo $ex->getMessage();
    }
}

function getCountries() {

    $entityM = load("login");
    $countries = $entityM->getRepository("MobilitySharp\model\Country")->findAll();
    $json = [];

    foreach ($countries as $country) {
        array_push($json, ["value" => $country->getId(), "text" => $country->getName()]);
    }

    echo json_encode($json);
}

function getInstitutionTypes() {

    $entityM = load("login");
    $insTypes = $entityM->getRepository("MobilitySharp\model\InstitutionType")->findAll();
    $json = [];

    foreach ($insTypes as $type) {
        array_push($json, ["value" => $type->getId(), "text" => $type->getType()]);
    }

    echo json_encode($json);
}

function registerPartnerInstitution() {
    $location = "Location: $_SERVER[PHP_SELF]?error"; //Redirects to self and flags an error by default

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
        $l_provider = filter_input(INPUT_POST, "lodgingProvider");
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

        $institution = $entityM->getRepository("MobilitySharp\model\Institution")->findOneBy(["name" => $iName]);





        if (is_null($institution)) {
            $entityM->getConnection()->beginTransaction();
            $partner = new \MobilitySharp\model\Partner(password_hash($password, PASSWORD_DEFAULT), $username, $name, $email, $phone, $post, $department, $role, $country, $date);
            $score = $entityM->getRepository("MobilitySharp\model\ScoreType")->findOneBy(["type" => 'REGISTER']);
            $partner->setScore($score->getValue());
            if ($vat) {
                $partner->setVat($vat);
            }
            if ($l_provider) {
                $partner->setLodging_provider($l_provider);
            }
            $entityM->persist($partner);
            $entityM->flush();
            $institution = new \MobilitySharp\model\Institution($iName, $iEmail, $iPhone, $postalCode, $iLocation, $country, $partner, $institutionType, $date);
            $partner->setInstitution($institution);

            if ($iVat) {
                $institution->setVat($iVat);
            }
            if ($web) {
                $institution->setWeb($web);
            }
            if ($description) {
                $institution->setDescription($description);
            }
            $entityM->persist($institution);
            $entityM->persist($partner);
            $entityM->flush();

            if ($entityM->getConnection()->commit()) {
                $partnerParams = [
                    ':id' => $partner->getId(),
                    ':email' => $email,
                    ':username' => $username,
                    ':password' => password_hash($password, PASSWORD_DEFAULT),
                    ':role' => $partner->getRole()->getId()
                ];
                sessionStoreUser($partnerParams);
                $location = "Location:index.php?registered";
            } else {
                $entityM->getConnection()->rollback();
            }
        } else {

            $partner = new \MobilitySharp\model\Partner(password_hash($password, PASSWORD_DEFAULT), $username, $name, $email, $phone, $post, $department, $role, $country, $date);
            $partner->setInstitution($institution);
            $score = $entityM->getRepository("MobilitySharp\model\ScoreType")->findOneBy(["type" => 'REGISTER']);
            $partner->setScore($score->getValue());
            if ($vat) {
                $partner->setVat($vat);
            }
            if ($l_provider) {
                $partner->setLodging_provider($l_provider);
            }
            $entityM->persist($partner);
            $entityM->flush();
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
        'id' => $userParams[':id'],
        'usuario' => $userParams[':username'],
        'email' => $userParams[':email'],
        'password' => $userParams[':password'],
        'role' => $userParams[':role']
    ];

    $_SESSION['user'] = $user;
}

function searchInstitutionsBasic() {

    $entityM = load("login");
    $queryEnterprise = $entityM->createQueryBuilder();

    $queryEnterprise->addSelect("e")
            ->from("MobilitySharp\model\Enterprise", 'e')
            ->where("e.name LIKE :enterprise")
            ->setParameter("enterprise", '%' . filter_input(INPUT_GET, "enterpriseName") . '%');
    $enterprises = $queryEnterprise->getQuery()->getResult();

    $queryInstitution = $entityM->createQueryBuilder();

    $queryInstitution->addSelect("i")
            ->from("MobilitySharp\model\Institution", 'i')
            ->where("i.name LIKE :enterprise")
            ->setParameter("enterprise", '%' . filter_input(INPUT_GET, "enterpriseName") . '%');
    $institutions = $queryInstitution->getQuery()->getResult();

    $list = array_merge($enterprises, $institutions);


    echo "<div class='container my-3 my-lg-5 mx-3 mx-lg-5'>"
    . "<div class='row border-bottom border-dark'><div class='col'><h2>Search results</h2></div></div><div class='row text-center justify-content-around'>";
    foreach ($list as $element) {

        echo "<div class='col-14 col-md-9 col-lg-5 py-3 py-lg-5 '>"
        . "<div class='row border border-dark '><div class='col border-right border-dark bg-secondary p-1'><h3>" . $element->getName() . "</h3></div>"
        . "<div class='col border'><h4 class='text-secondary'>" . $element->getType()->getType() . "</h4>"
        . "<h5>" . $element->getCountry()->getName() . "</h5></div></div>";
        if ($element->getDescription()) {
            echo "<div class='row border border-dark'><div class='col p-3'><p>" . $element->getDescription() . "</p></div></div>";
        }
        echo "</div>";
    }
    echo "</div></div>";
}

function searchInstitutionsAdvanced() {

    $entityM = load("login");
    $queryEnterprise = $entityM->createQueryBuilder();

    $queryEnterprise->addSelect("e")
            ->from("MobilitySharp\model\Enterprise", 'e')
            ->where("e.name LIKE :enterprise")
            ->setParameter("enterprise", '%' . filter_input(INPUT_GET, "enterpriseName") . '%');
    $enterprises = $queryEnterprise->getQuery()->getResult();

    $queryInstitution = $entityM->createQueryBuilder();

    $queryInstitution->addSelect("i")
            ->from("MobilitySharp\model\Institution", 'i')
            ->where("i.name LIKE :enterprise")
            ->setParameter("enterprise", '%' . filter_input(INPUT_GET, "enterpriseName") . '%');
    $institutions = $queryInstitution->getQuery()->getResult();

    $list = array_merge($enterprises, $institutions);


    echo "<div class='container mt-3 mt-lg-5 mx-3 mx-lg-5'>"
    . "<div class='row border-bottom border-dark'><div class='col'><h2>Search results</h2></div></div><div class='row text-center border-bottom border-dark mb-3 mb-lg-5 justify-content-around'>";
    foreach ($list as $element) {
        echo "<div class='col-12 col-md-7 col-lg-5 my-2 my-lg-5'>"
        . "<div class='row border-bottom border-dark'><div class='col border border-dark bg-secondary p-3'><h1>" . $element->getName() . "</h1></div>"
        . "<div class='col border border-dark'><div class='row'><div class='col'><h4 class='text-secondary'>" . $element->getType()->getType() . "</h4></div></div>"
        . "<div class='row'><div class='col'><h5>" . $element->getCountry()->getName() . "</h5></div></div></div></div>"
        . "<div class='row border border-dark'>"
        . "<div class='col'><p>" . $element->getEmail() . "</p></div></div>"
        . "<div class='row border border-dark pt-2'><div class='col'><p>" . $element->getTelephone() . "</p></div></div>"
        . "<div class='row border border-dark'><div class='col'><p>" . $element->getLocation() . ", " . $element->getPostal_code() . "</p></div></div>";
        if ($element->getWeb()) {
            echo "<div class='row pt-2 border border-dark'><div class='col'><h6><a href='https://" . $element->getWeb() . "'>" . $element->getWeb() . "</a></h6></div></div>";
        }
        if ($element->getDescription()) {
            echo "<div class='row'><div class='col border border-dark'><p>" . $element->getDescription() . "</p></div></div>";
        }
        echo "<div class='row border border-dark bg-secondary'><div class='col border-top border-dark p-2'><p><b>Contact:</b> " . $element->getPartner()->getFull_name() . "</p></div></div>"
        . "<div class='row border border-dark bg-secondary'><div class='col'><p> <b>Email:</b> " . $element->getPartner()->getEmail() . "</p></div></div></div>";
    }
    echo "</div></div></div>";
}

function insertEnterprise() {
    $entityM = load("registered");

    $enterprise = $entityM->getRepository("MobilitySharp\model\Enterprise")->findOneBy(["email" => filter_input(INPUT_POST, "eEmail")]);
    $ceo = $entityM->getRepository("MobilitySharp\model\CEO")->findOneBy(["email" => filter_input(INPUT_POST, "email")]);
    if (is_null($enterprise)) {
        $entityM->getConnection()->beginTransaction();
        $ceo_post = filter_input(INPUT_POST, "ceoPost");
        $name = filter_input(INPUT_POST, "eName");
        $email = filter_input(INPUT_POST, "eEmail");
        $telephone = filter_input(INPUT_POST, "ePhone");
        $postal_code = filter_input(INPUT_POST, "postalCode");
        $location = filter_input(INPUT_POST, "location");
        $country = $entityM->find("MobilitySharp\model\Country", filter_input(INPUT_POST, "country"));
        $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
        $type = $entityM->find("MobilitySharp\model\EnterpriseType", filter_input(INPUT_POST, "enterpriseType"));
        $registration_date = new \DateTime(date("Y-m-d"));
        $ceoEmail = filter_input(INPUT_POST, "email");
        $full_name = filter_input(INPUT_POST, "fName") . " " . filter_input(INPUT_POST, "lName");
        if (!$ceo) {
            $ceo = new \MobilitySharp\model\CEO($ceoEmail, $full_name);
        }

        if ($ceoPhone = filter_input(INPUT_POST, "phone")) {
            $ceo->setTelephone($ceoPhone);
        }
        $entityM->persist($ceo);
        $entityM->flush();
        $enterprise = new \MobilitySharp\model\Enterprise($ceo_post, $name, $email, $telephone, $postal_code, $location, $country, $partner, $ceo, $type, $registration_date);

        if ($vat = filter_input(INPUT_POST, "eVat")) {
            $enterprise->setVat($vat);
        }
        if ($web = filter_input(INPUT_POST, "web")) {
            $enterprise->setWeb($web);
        }
        if ($description = filter_input(INPUT_POST, "description")) {
            $enterprise->setDescription($description);
        }
        $entityM->persist($enterprise);
        $entityM->flush();
        $entityM->getConnection()->commit();
    } else {
        return FALSE;
    }
    header("Location:index.php");
}

function insertStudent() {

    $entityM = load("registered");



    $full_name = filter_input(INPUT_POST, "fName") . " " . filter_input(INPUT_POST, "lName");
    $gender = filter_input(INPUT_POST, "gender");
    $birth_date = filter_input(INPUT_POST, "birthDate");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $registration_date = new \DateTime(date("Y-m-d"));
    if ($gender == "Male") {
        $gender = 'M';
    } else {
        $gender = 'F';
    }
    $student = new \MobilitySharp\model\Student($full_name, $gender, new \DateTime($birth_date), $partner, $registration_date);

    if ($vat = filter_input(INPUT_POST, "sVat")) {
        $student->setVat($vat);
    }

    $entityM->persist($student);
    $entityM->flush();
    header("Location:index.php");
}

function insertSpecialty() {

    $entityM = load("admin");

    $specialtyType = $entityM->getRepository("MobilitySharp\model\SpecialtyType")->findOneBy(["type" => filter_input(INPUT_POST, "type")]);

    if (is_null($specialtyType)) {

        $type = filter_input(INPUT_POST, "type");
        $specialtyType = new \MobilitySharp\model\SpecialtyType($type);
        if ($description = filter_input(INPUT_POST, "description")) {
            $specialtyType->setDescription($description);
        }
        $entityM->persist($specialtyType);
        $entityM->flush();
    } else {
        return FALSE;
    }
}

function insertInstitutionType() {
    $entityM = load("admin");
    $institutionType = $entityM->getRepository("MobilitySharp\model\InstitutionType")->findOneBy(["type" => filter_input(INPUT_POST, "type")]);

    if (is_null($institutionType)) {
        $type = filter_input(INPUT_POST, "type");
        $institutionType = new \MobilitySharp\model\InstitutionType($type);

        if ($description = filter_input(INPUT_POST, "description")) {
            $institutionType->setDescription($description);
        }

        $entityM->persist($institutionType);
        $entityM->flush();
    } else {
        return FALSE;
    }
}

function insertInstitutionSpecialty() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $institution = $entityM->getRepository("\MobilitySharp\model\Institution")->findOneBy(["partner" => $partner]);

    $specialty = $entityM->find("\MobilitySharp\model\SpecialtyType", filter_input(INPUT_POST, "specialty"));
    try {
        $entityM->getConnection()->beginTransaction();
        $institution->getSpecialties()->add($specialty);
        $specialty->getInstitutions()->add($institution);
        $entityM->persist($institution);
        $entityM->persist($specialty);
        $entityM->flush();
        $entityM->getConnection()->commit();
    } catch (Exception $ex) {
        $entityM->getConnection()->rollback();
    }
}

function insertEnterpriseSpecialty() {
    $entityM = load("registered");
    $enterprise = $entityM->find("\MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise"));  //get this with a select
    $specialty = $entityM->find("\MobilitySharp\model\SpecialtyType", filter_input(INPUT_POST, "specialty")); //get this with a select
    try {
        $entityM->getConnection()->beginTransaction();
        $enterprise->getSpecialties()->add($specialty);
        $specialty->getEnterprises()->add($enterprise);
        $entityM->persist($enterprise);
        $entityM->persist($specialty);
        $entityM->flush();
        $entityM->getConnection()->commit();
    } catch (Exception $ex) {
        $entityM->getConnection()->rollback();
    }
}

function insertStudentSpecialty() {
    $entityM = load("registered");
    $student = $entityM->find("\MobilitySharp\model\Student", filter_input(INPUT_POST, "student")); //get this with a select
    $specialty = $entityM->find("\MobilitySharp\model\SpecialtyType", filter_input(INPUT_POST, "specialty")); //get this with a select

    $entityM->getConnection()->beginTransaction();
    $student->getSpecialties()->add($specialty);
    $specialty->getStudents()->add($student);
    $entityM->persist($student);
    $entityM->persist($specialty);
    $entityM->flush();
    $entityM->getConnection()->commit();
}

function registerMobility() {
    $entityM = load("registered");
    $student = $entityM->find("\MobilitySharp\model\Student", filter_input(INPUT_POST, "student")); // get this with a select
    $start_date = filter_input(INPUT_POST, "start_date");
    $estimated_end_date = filter_input(INPUT_POST, "estimated_end_date");
    $registration_date = new \DateTime(date("Y-m-d"));

    $array = ['entityM' => $entityM, 'student' => $student, 'start_date' => $start_date, 'estimated_end_date' => $estimated_end_date, 'registration_date' => $registration_date];
    return $array;
}

function registerEnterpriseMobility() {
    $array = registerMobility();
    $enterprise = $array["entityM"]->find("\MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise")); //get this with a select
    $mobility = new \MobilitySharp\model\EnterpriseMobility($array["start_date"], $array["estimated_end_date"], $array["registration_date"], $array["student"], $enterprise);
    $array["entityM"]->persist($mobility);
    $array["entityM"]->flush();
}

function registerStudentMobility() {

    $array = registerMobility();
    $institution = $array["entityM"]->find("\MobilitySharp\model\Institution", filter_input(INPUT_POST, "institution")); //get this with a select
    $mobility = new \MobilitySharp\model\InstitutionMobility($array["start_date"], $array["estimated_end_date"], $array["registration_date"], $array["student"], $institution);
    $array["entityM"]->persist($mobility);
    $array["entityM"]->flush();
}

function deleteEnterprise() {

    $entityM = load("registered");
    $enterprise = $entityM->find("MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise"));
    $enterprise->setTerminationDate(new \DateTime(date("Y-m-d")));
    $entityM->persist($enterprise);
    $entityM->flush();
}

function deleteStudent() {
    $entityM = load("registered");
    $student = $entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
    $student->setTerminationDate(new \DateTime(date("Y-m-d")));
    $entityM->persist($student);
    $entityM->flush();
}

function deleteInstitution() {
    $entityM = load("registered");
    $institution = $entityM->find("MobilitySharp\model\Institution", filter_input(INPUT_POST, "institution"));
    $institution->setTerminationDate(new \DateTime(date("Y-m-d")));
    $entityM->persist($institution);
    $entityM->flush();
}

function listAllEnterprises() {

    $entityM = load("registered");
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findAll();
    return $enterprises;
}

function listAllInstitutions() {
    $entityM = load("registered");
    $institutions = $entityM->getRepository("MobilitySharp\model\Institution")->findAll();
    echo $institutions;
}

function listPartnerEnterprises() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner" => $partner]);
   
    echo "<div class='row text-center justify-content-around'>";
    foreach ($enterprises as $enterprise) {
        echo "<div class='col-12 col-md-7 col-lg-5 rounded my-2 my-lg-5'>"
        ."<div class='row justify-content-end'>
            <div class='dropleft'>
                <button class='btn btn-primary' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa fa-ellipsis-v' aria-hidden='true'></i>
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <a class='dropdown-item' href='#'>Edit</a>
                    <a class='dropdown-item' href='#'>Delete</a>
                </div>
            </div>
        </div>"
        . "<div class='row border-bottom border border-dark'><div class='col border-right'><h1>" . $enterprise->getName() . "</h1></div>"
        . "<div class='col'><div class='row'><div class='col'><h4 class='text-secondary'>" . $enterprise->getType()->getType() . "</h4></div></div>"
        . "<div class='row'><div class='col border-right'><h5>" . $enterprise->getCountry()->getName() . "</h5></div></div></div></div>"
        . "<div class='row bg-secondary p-2 border-right border-left border-dark'><div class='col border-right border-dark'><h3>Email</h3></div><div class='col'><h3>Phone</h3></div></div>"
        . "<div class='row border-bottom border border-dark'>"
        . "<div class='col border-right p-2'><h6>" . $enterprise->getEmail() . "</h6></div><div class='col p-2'><h6>" . $enterprise->getTelephone() . "</h6></div></div>"
        . "<div class='row border-right border-left border-dark bg-secondary p-2'><div class='col border-right border-dark'><h3>Location</h3></div><div class='col'><h3>Web</h3></div></div>"
        . "<div class='row border border-dark'><div class='col border-right p-2'><h6>" . $enterprise->getLocation() . ", " . $enterprise->getPostal_code() . "</h6></div><div class='col border-right p-2'><h6><a href='https://" . $enterprise->getWeb() . "'>" . $enterprise->getWeb() . "</a></h6></div></div>"
        . "<div class='row bg-secondary p-2 border-right border-left border-dark'><div class='col'><h3>Description</h3></div></div>"
        . "<div class='row p-2 border border-dark'><div class='col'><h6>" . $enterprise->getDescription() . "</h6></div></div>"
        . "</div>";
    }
    echo "</div>";
}

function listPartnerStudents() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);

    echo "<section class='container'><div class='row text-center mb-3 mb-lg-5 justify-content-around'>";
    foreach ($students as $student) {
        if ($student->getGender() == "M") {
            $gender = "Male";
        } else {
            $gender = "Female";
        }
        $date = date_format($student->getBirth_date(), 'Y-m-d');
        echo "<div class='col-12 col-md-7 col-lg-5 my-2 my-lg-5'>"
        . "<div class='row bg-secondary border border-dark'><div class='col border-bottom border-dark p-1 p-lg-2'><h2>" . $student->getFull_Name() . "</h2></div></div>"
        . "<div class='row border border-dark'><div class='col border-bottom border-dark p-1 p-lg-2'><h5 class='text-secondary'>" . $gender . "</h5>"
        . "<h4>" . $date . "</h4></div></div>";
        
        if($student->getSpecialties()->count()>0){
        echo "<div class='row bg-secondary border border-dark'><div class='col border-bottom border-dark p-1 p-lg-2'><h3>Specialties</h3></div></div>";

        foreach ($student->getSpecialties() as $specialty) {
            echo "<div class='row'>"
            . "<div class='col p-1 p-lg-2 border-left border-right border-dark'>" .
            "<h4>" . $specialty->getType() . "</h4></div></div>"
            . "<div class='row border-bottom border-dark border-right border-left'>"
            ."</div>";
        }
        }




        echo "</div>"
        ;
    }
    echo "</div></section>";
}

function getCeos() {
    $entityM = load("registered");
    $ceos = $entityM->getRepository("MobilitySharp\model\CEO")->findAll();
    $json = [];

    foreach ($ceos as $ceo) {
        array_push($json, ["value" => $ceo->getId(), "text" => $ceo->getFull_name()]);
    }
}

function getEnterpriseTypes() {
    $entityM = load("registered");
    $enterprises = $entityM->getRepository("MobilitySharp\model\EnterpriseType")->findAll();
    $json = [];

    foreach ($enterprises as $enterprise) {
        array_push($json, ["value" => $enterprise->getId(), "text" => $enterprise->getType()]);
    }
    echo json_encode($json);
}

function getPartnerStudents() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);

    foreach ($students as $student) {
        echo '<option value=' . $student->getId() . '>' . $student->getFull_name() . '</option>';
    }
}

function getAllEnterprises() {
    $entityM = load("registered");

    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findAll();

    foreach ($enterprises as $enterprise) {
        echo '<option value=' . $enterprise->getId() . '>' . $enterprise->getName() . '</option>';
    }
}

function insertEnterpriseMobility() {
    $entityM = load("registered");
    $startDate = filter_input(INPUT_POST, "startDate");
    $estimatedEndDate = filter_input(INPUT_POST, "estimatedEndDate");
    $student = $entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
    $enterprise = $entityM->find("MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise"));
    $registrationDate = new \DateTime(date("Y-m-d"));
    $mobility = new \MobilitySharp\model\EnterpriseMobility(new \DateTime($startDate), new \DateTime($estimatedEndDate), $registrationDate, $student, $enterprise);

    $entityM->persist($mobility);
    $entityM->flush();
}

function getAllInstitutions() {
    $entityM = load("registered");

    $institutions = $entityM->getRepository("MobilitySharp\model\Institution")->findAll();

    foreach ($institutions as $institution) {
        echo '<option value=' . $institution->getId() . '>' . $institution->getName() . '</option>';
    }
}

function insertInstitutionMobility() {
    $entityM = load("registered");
    $startDate = filter_input(INPUT_POST, "startDate");
    $estimatedEndDate = filter_input(INPUT_POST, "estimatedEndDate");
    $student = $entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
    $institution = $entityM->find("MobilitySharp\model\Institution", filter_input(INPUT_POST, "institution"));
    $registrationDate = new \DateTime(date("Y-m-d"));
    $mobility = new \MobilitySharp\model\InstitutionMobility(new \DateTime($startDate), new \DateTime($estimatedEndDate), $registrationDate, $student, $institution);

    $entityM->persist($mobility);
    $entityM->flush();
}

function listPartnerMobilities() {
    $entityM = load("registered");

    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);
    $eMobilities = $entityM->getRepository("MobilitySharp\model\EnterpriseMobility")->findBy(["student" => $students]);
    $iMobilities = $entityM->getRepository("MobilitySharp\model\InstitutionMobility")->findBy(["student" => $students]);

    $mobilities = array_merge($eMobilities, $iMobilities);




    echo "<section class='container'><div class='row text-center mb-3 mb-lg-5 justify-content-around'>";
    foreach ($mobilities as $mobility) {

        $startDate = date_format($mobility->getStart_date(), 'Y-m-d');
        $estimatedEndDate = date_format($mobility->getEstimated_end_date(), 'Y-m-d');
        if ($mobility instanceof \MobilitySharp\model\EnterpriseMobility) {
            $institution = "Enterprise";
            $name = $mobility->getEnterprise()->getName();
            $country = $mobility->getEnterprise()->getCountry()->getName();
        } else {
            $institution = "Institution";
            $name = $mobility->getInstitution()->getName();
            $country = $mobility->getInstitution()->getCountry()->getName();
        }
        echo "<div class='col-12 col-md-7 col-lg-5 border border-dark rounded my-2 my-lg-5'>" .
        "<div class='row bg-secondary'>"
        . "<div class='col border-bottom border-right border-dark'><h3>Student</h3></div>"
        . "<div class='col border-bottom border-dark'><h3>$institution</h3></div>"
        . "</div>"
        . "<div class='row'><div class='col mt-3'><h5>" . $mobility->getStudent()->getFull_name() . "</h5></div>"
        . "<div class='col border-left'><h4 class='text-secondary'>" . $name . "</h4>"
        . "<h5>" . $country . "</h5></div></div>"
        . "<div class='row bg-secondary'>"
        . "<div class='col border-top border-right border-dark pt-2'>"
        . "<h5>Start date</h5></div>"
        . "<div class='col border-top border-dark pt-2'>"
        . "<h5>Estimated end date</h5></div></div>"
        . "<div class='row'>"
        . "<div class='col p-2 border-top border-right border-dark'>"
        . "<h5>" . $startDate . "</h5></div>"
        . "<div class='col p-2 border-top border-dark'>"
        . "<h5>" . $estimatedEndDate . "</h5></div></div></div>"
        ;
    }
    echo "</div></section>";
}

function listAllSpecialties() {

    $entityM = load("admin");
    $specialties = $entityM->getRepository("MobilitySharp\model\SpecialtyType")->findAll();
    
    echo "<section class='container'><div class='row text-center mb-3 mb-lg-5 justify-content-around'>";
    foreach ($specialties as $specialty) {
        echo "<div class='col-12 col-md-7 col-lg-5 border border-dark rounded my-2 my-lg-5'>"
        . "<div class='row '><div class='col border-right border-bottom border-dark bg-secondary'><h1>" . $specialty->getType() . "</h1></div></div>"
        . "<div class='row p-3'>"
        . "<div class='col'><h5>" . $specialty->getDescription() . "</h5></div></div>"
        . "</div>";
    }
    echo "</div></section>";
}

function listLastPartnerScores() {

    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);

    $queryScores = $entityM->createQueryBuilder();

    $queryScores->addSelect('s')
            ->from("MobilitySharp\model\ScoreHistory", 's')
            ->where("s.partner = :partner")
            ->orderBy("s.date", "DESC")
            ->setParameter("partner", $partner)
            ->setMaxResults(5);
    $scores = $queryScores->getQuery()->getResult();
    echo "<section class='container mt-3 mt-lg-5'><div class='row border-bottom border-dark mb-3 mx-3 mx-lg-5'><div class='col col-12 col-lg-10 col-xl-8'><h3>Your last scores</h3></div></div><div class='row text-center justify-content-center'>"
    . "<div class='col col-12 col-lg-10 col-xl-8 border border-dark my-3 my-lg-5'>"
    . "<div class='row border-bottom border-dark p-2 bg-secondary '><div class='col border-right border-dark'><h3>Action</h3></div><div class='col border-right border-dark '><h3>Date</h3></div><div class='col'><h3>Score</h3></div></div>";

    foreach ($scores as $score) {
        echo
        "<div class='row p-1'><div class='col'><h6>" . $score->getScore_type()->getType() . "</h6></div><div class='col'><h6>" . date_format($score->getDate(), "Y-m-d H:i:s") . "</h6></div><div class='col'><h6>" . $score->getScore_type()->getValue() . "</h6></div></div>";
    }
    echo "<div class='row border-top border-dark bg-secondary p-2'><div class='col'><h4>Your score: " . $partner->getScore() . "</h4></div></div>"
    . "</div></div></section>";
}

function listTopInstitutions() {
    $entityM = load("registered");
    $queryInstitutions = $entityM->createQueryBuilder();
    $queryInstitutions->addSelect('i')
            ->from("MobilitySharp\model\InstitutionMobility", 'i')
            ->groupBy("i.institution")
            ->orderBy("COUNT(i.institution)", "DESC")
            ->setMaxResults(3);
    $institutions = $queryInstitutions->getQuery()->getResult();



    echo "<section class='container mt-3'>"
    . "<div class='row border-bottom border-dark mx-3 mx-lg-5'><div class='col'><h2>Top institutions</h2></div></div><div class='row text-center my-3 my-lg-5 py-3 justify-content-around'>";
    foreach ($institutions as $institution) {
        $query = $entityM->createQuery('SELECT COUNT(i.institution) FROM MobilitySharp\model\InstitutionMobility i WHERE i.institution=(SELECT ins.id FROM MobilitySharp\model\Institution ins where ins.id=' . $institution->getInstitution()->getId() . ')');
        $result = $query->getSingleScalarResult();
        if ($result == 1) {
            $message = "mobility";
        } else {
            $message = "mobilities";
        }
        echo "<div class='col col-7 col-lg-5 col-xl-3 mb-3'>";
        echo "<div class='row bg-secondary border border-dark p-2'><div class='col'><h3>" . $institution->getInstitution()->getName() . "<h3></div></div>"
        . "<div class='row p-2 border border-dark'><div class='col'>-&nbsp;&nbsp;<b>" . $result . " $message</b>&nbsp;&nbsp;-</div></div>";
        echo "</div>";
    }
    echo "</div></section>";
}

function listTopEnterprises() {
    $entityM = load("registered");
    $queryEnterprise = $entityM->createQueryBuilder();
    $queryEnterprise->addSelect('e')
            ->from("MobilitySharp\model\EnterpriseMobility", 'e')
            ->groupBy("e.enterprise")
            ->orderBy("COUNT(e.enterprise)", "DESC")
            ->setMaxResults(3);
    $enterprises = $queryEnterprise->getQuery()->getResult();



    echo "<section class='container mt-3'>"
    . "<div class='row border-bottom border-dark mx-3 mx-lg-5'><div class='col'><h2>Top enterprises</h2></div></div><div class='row text-center my-3 my-lg-5 py-3 justify-content-around'>";
    foreach ($enterprises as $enterprise) {
        $query = $entityM->createQuery('SELECT COUNT(e.enterprise) FROM MobilitySharp\model\EnterpriseMobility e WHERE e.enterprise=(SELECT en.id FROM MobilitySharp\model\Enterprise en where en.id=' . $enterprise->getEnterprise()->getId() . ')');
        $result = $query->getSingleScalarResult();
        if ($result == 1) {
            $message = "mobility";
        } else {
            $message = "mobilities";
        }
        echo "<div class='col col-7 col-lg-5 col-xl-3 border border-dark mb-3'>";
        echo "<div class='row bg-secondary'><div class='col p-2'><h3>" . $enterprise->getEnterprise()->getName() . "<h3></div></div>"
        . "<div class='row p-2'><div class='col'>-&nbsp;&nbsp;<b>" . $result . " $message</b>&nbsp;&nbsp;-</div></div>";
        echo "</div>";
    }
    echo "</div></section>";
}

function listPartnerInstitution() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $institution = $entityM->getRepository("MobilitySharp\model\Institution")->findOneBy(["partner" => $partner]);

    echo "<section class='container text-center mb-3 mb-lg-5'><div class='row text-center my-2 my-lg-5 justify-content-center '>"
    . "<div class='col col-12 col-lg-8 col-xl-6 border border-dark mb-3'>"
    . "<div class='row bg-secondary p-3'><div class='col'><h3>" . $institution->getName() . "</h3></div></div>"
    . "<div class='row p-2'><div class='col'><h4>" . $institution->getEmail() . "</h4></div></div>"
    . "<div class='row p-2'><div class='col'><h6>" . $institution->getLocation() . ", " . $institution->getPostal_code() . "</h6></div></div>"
    . "<div class='row p-2'><div class='col'><b>" . $institution->getTelephone() . "</b></div></div>"
    . "<div class='row p-2'><div class='col'>" . $institution->getWeb() . "</div></div>"
    . "</div></div></section>";
}

function insertEnterpriseType() {
    $entityM = load("admin");
    $type = filter_input(INPUT_POST, "type");

    $enterpriseType = new \MobilitySharp\model\EnterpriseType($type);

    if ($description = filter_input(INPUT_POST, "description")) {
        $enterpriseType->setDescription($description);
    }

    $entityM->persist($enterpriseType);
    $entityM->flush();
}

function partnerStudents() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);

    return $students;
}

function getAllSpecialties() {
    $entityM = load("admin");
    $specialties = $entityM->getRepository("MobilitySharp\model\SpecialtyType")->findAll();

    foreach ($specialties as $specialty) {
        echo "<option value=" . $specialty->getId() . ">" . $specialty->getType() . "</option>";
    }
}

function partnerEnterprises() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION['user']['id']);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner" => $partner]);
    foreach ($enterprises as $enterprise) {
        echo "<option value=" . $enterprise->getId() . ">" . $enterprise->getName() . "</option>";
    }
}

function getPartnerEnterprises() {

    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION['user']['id']);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner" => $partner]);
    return $enterprises;
}

function findMobilitiesBetweenDates() {
    $entityM = load("admin");
    $date1 = filter_input(INPUT_GET, "date1");

    $date2 = filter_input(INPUT_GET, "date2");


    $queryMobilitiesEnterprise = $entityM->createQueryBuilder();
    $queryMobilitiesEnterprise->addSelect('em')
            ->from("MobilitySharp\model\EnterpriseMobility", 'em')
            ->where("em.start_date > '" . $date1 . "' ")
            ->andWhere("em.estimated_end_date < '" . $date2 . "'")


    ;
    $queryMobilitiesInstitution = $entityM->createQueryBuilder();
    $queryMobilitiesInstitution->addSelect('im')
            ->from("MobilitySharp\model\InstitutionMobility", 'im')
            ->where("im.start_date > '" . $date1 . "' ")
            ->andWhere("im.estimated_end_date < '" . $date2 . "'");
    $enterpriseMobilities = $queryMobilitiesEnterprise->getQuery()->getResult();
    $institutionMobilities = $queryMobilitiesInstitution->getQuery()->getResult();

    $mobilities = array_merge($enterpriseMobilities, $institutionMobilities);

    echo "<div class='container mx-3 mx-lg-5 py-3 py-lg-5'><div class='row'><div class='col'><h3>Mobilities between " . $date1 . " and " . $date2 . "</h3></div></div><div class='row border-top border-dark justify-content-around '>";
    foreach ($mobilities as $mobility) {

        $startDate = date_format($mobility->getStart_date(), 'Y-m-d');
        $estimatedEndDate = date_format($mobility->getEstimated_end_date(), 'Y-m-d');
        if ($mobility instanceof \MobilitySharp\model\EnterpriseMobility) {
            $institution = "Enterprise";
            $name = $mobility->getEnterprise()->getName();
            $country = $mobility->getEnterprise()->getCountry()->getName();
        } else {
            $institution = "Institution";
            $name = $mobility->getInstitution()->getName();
            $country = $mobility->getInstitution()->getCountry()->getName();
        }
        echo "<div class='col col-12 col-lg-7 col-xl-5 border border-dark rounded my-2 my-lg-5 text-center'>" .
        "<div class='row bg-secondary'>"
        . "<div class='col border-bottom border-right border-dark'><h4>Student</h4></div>"
        . "<div class='col border-bottom border-dark'><h4>$institution</h4></div>"
        . "</div>"
        . "<div class='row'><div class='col p-2 border-right'><h5>" . $mobility->getStudent()->getFull_name() . "</h5></div>"
        . "<div class='col p-2'><div class='row'><div class='col'><h4 class='text-secondary'>" . $name . "</h4></col>"
        . "<div class='col'><h5>" . $country . "</h5></div></div></div></div></div>"
        . "<div class='row bg-secondary border-bottom border-dark'>"
        . "<div class='col border-top border-right border-dark pt-2'>"
        . "<h5>Start date</h5></div>"
        . "<div class='col border-top border-dark pt-2'>"
        . "<h5>Estimated end date</h5></div></div>"
        . "<div class='row'>"
        . "<div class='col border-right'>"
        . "<h5>" . $startDate . "</h5></div>"
        . "<div class='col'>"
        . "<h5>" . $estimatedEndDate . "</h5></div></div></div>"
        ;
    }
    echo "</div></div>";
}



function partnerMobilities(){
     $entityM = load("registered");

    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);
    $eMobilities = $entityM->getRepository("MobilitySharp\model\EnterpriseMobility")->findBy(["student" => $students]);
    $iMobilities = $entityM->getRepository("MobilitySharp\model\InstitutionMobility")->findBy(["student" => $students]);

    $mobilities = array_merge($eMobilities, $iMobilities);
    return $mobilities;
}

function partnerProfile(){
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    
    
    echo "<section class='container'><div class='row border-bottom border-dark'><div class='col'><h2>" . $partner->getFull_name() . "</h2></div></div>"
    . "<div class='container text-center border-bottom border-dark mb-3 mb-lg-5'><div class='row text-center mt-2 mt-lg-5 justify-content-center '>"
    . "<div class='col col-12 col-lg-10 col-xl-8 border border-dark mb-3'>"
    . "<div class='row bg-secondary p-2 border-bottom border-dark'><div class='col border-right border-dark'><h4>Email</h4></div><div class='col'><h4>Username</h4></div></div>"
    . "<div class='row border-bottom border-dark p-2'><div class='col'><h6>" . $partner->getEmail() . "</h6></div><div class='col'><h6>" . $partner->getUsername() . "</h6></div></div>"
    . "<div class='row bg-secondary border-bottom border-dark p-2'><div class='col border-right border-dark'><h4>Phone</h4></div><div class='col'><h4>VAT</h4></div></div>"
    . "<div class='row border-bottom border-dark p-2'><div class='col'><h6>" . $partner->getTelephone() . "</h6></div><div class='col'><h6>" . $partner->getVat() . "</h6></div></div>"
    . "<div class='row bg-secondary border-bottom border-dark p-2'><div class='col border-right border-dark'><h4>Department</h4></div><div class='col'><h4>Post</h4></div></div>"
    . "<div class='row border-bottom border-dark p-2'><div class='col'><h6>" . $partner->getDepartment() . "</h6></div><div class='col'><h6>" . $partner->getPost() . "</h6></div></div>"
    . "<div class='row bg-secondary border-bottom border-dark p-2'><div class='col border-right border-dark'><h4>Institution</h4></div><div class='col'><h4>Country</h4></div></div>"
    . "<div class='row p-2'><div class='col'><h6>" . $partner->getInstitution()->getName() . "</h6></div><div class='col'><h6>" . $partner->getCountry()->getName() . "</h6></div></div>"
    . "</div></div>"
    . "<div class='row mb-3 mb-lg-5 justify-content-center '>"
    . "<div class='col col-sm-6 col-md-4 col-lg-3 btn-group my-2 my-md-3'><button class='btn btn-secondary rounded ml-2 ml-md-3 ml-md-4' type='button' href='#'>Modify profile</button</div></div>"
    . "<div class='col col-sm-6 col-md-4 col-lg-3 btn-group my-2 my-md-3'><button class='btn btn-dark rounded ml-2 ml-md-3 ml-md-4' type='button' href='#'>Deactivate profile</button</div></div>"
    . "</div></div></div></section>";
    
}

function sendPetition(){
    $entityM= load("registered");
    $senderPartner=$entityM->find("MobilitySharp\model\Partner",$_SESSION["user"]["id"]);
    $date=new \DateTime(date("Y-m-d H:i:s"));
    $role=$entityM->getRepository("MobilitySharp\model\Role")->findOneBy(["type"=>"ADMIN"]);
    $subject= filter_input(INPUT_POST, "subject");
    $status=$entityM->getRepository("MobilitySharp\model\Status")->findOneBy(["status"=>"REQUESTED"]);
    
    $queryPetition = $entityM->createQueryBuilder();
    $queryPetition->addSelect('p')
            ->from("MobilitySharp\model\PetitionHistory", 'p')
            ->join("MobilitySharp\model\Partner",'pa')
            ->where("pa.id=p.receiver_partner")
            ->andWhere("pa.role=".$role->getId())
            ->andWhere("p.status='".$status->getId()."'")
            ->groupBy("p.receiver_partner")
            ->orderBy("COUNT(p.receiver_partner)")
            ->setMaxResults(1);
    $petition = $queryPetition->getQuery()->getSingleResult();
    $receiverPartner=$petition->getReceiver_partner();
    $newPetition = new \MobilitySharp\model\PetitionHistory($subject, $date, $status, $senderPartner, $receiverPartner);
    if($description= filter_input(INPUT_POST, "description")){
        $newPetition->setDescription($description);
    }
    require_once 'sendMail.php';
    if(sendMail($newPetition)){
        $entityM->persist($newPetition);
        $entityM->flush();
    
    }
    
}

/**
 * Finds the requested Doctrine entity.
 * 
 * @param string $class The class name of the requested entity.
 * @param mixed $id The ID of the entity to find.
 * 
 * @return object|null The entity instance or NULL if the entity cannot be found.
 */
function findEntity($class, $id){
    $entityM=load("registered");
    $entity=$entityM->find("MobilitySharp\\model\\".$class, $id);
    
    return $entity;
}