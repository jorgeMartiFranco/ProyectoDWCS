<?php

namespace MobilitySharp\controller;

require_once 'vendor/autoload.php';

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
        'password' => $account['password']
    ];
    $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);
    $config->setProxyNamespace("MobilitySharp\model");
    $config->setAutoGenerateProxyClasses(true);
    return EntityManager::create($dbParams, $config);
}

function checkUser($username, $password) {

    try {
        $entityM = load("login");
        $user = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["username" => $username]); //falta tener en cuenta que el usuario puede acceder con username o email
        if ($user !== null) {
            if (password_verify($password, $user->getPassword())) {


                return [
                    'id'=>$user->getId(),
                    'usuario' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'password' => $user->getPassword(),
                    'role'=>$user->getRole()->getType()
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

    foreach ($countries as $country) {
        echo "<option value='" . $country->getId() . "'>" . $country->getName() . "</option>";
    }
}

function getInstitutionTypes() {

    $entityM = load("login");
    $insTypes = $entityM->getRepository("MobilitySharp\model\InstitutionType")->findAll();

    foreach ($insTypes as $type) {
        echo "<option value='" . $type->getId() . "'>" . $type->getType() . "</option>";
    }
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
            $entityM->persist($partner);
            $entityM->flush();

            $institution = new \MobilitySharp\model\Institution($iName, $iEmail, $iPhone, $postalCode, $iLocation, $country, $partner, $institutionType, $date);
            $partner->setInstitution($institution);
            $entityM->persist($institution);
            $entityM->persist($partner);
            $entityM->flush();

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
    
    $list= array_merge($enterprises,$institutions);
    
    
    echo "<div class='row text-center my-2 my-lg-5 border justify-content-around'>";
    foreach ($list as $element){
        echo "<div class='col-12 col-md-7 col-lg-5 py-3 py-lg-5'>"
        
            . "<div class='row'><div class='col border'><h1>".$element->getName()."</h1></div>"
                . "<div class='col border'><p class='text-secondary'>".$element->getType()->getType()."</p>"
                . "<p>".$element->getCountry()->getName()."</p></div></div>"
                . "<div class='row'><div class='col border'><p>".$element->getDescription()."</p></div></div></div>";
    }
    echo "</div>";
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
    
    $list= array_merge($enterprises,$institutions);
    
    
    echo "<div class='row text-center my-2 my-lg-5 border justify-content-around'>";
    foreach ($list as $element){
        echo "<div class='col-12 col-md-7 col-lg-5 border border-dark rounded my-2 my-lg-5'>"
        
            . "<div class='row'><div class='col border-right border-dark'><h1>".$element->getName()."</h1></div>"
                . "<div class='col'><h4 class='text-secondary'>".$element->getType()->getType()."</h4>"
                . "<h5>".$element->getCountry()->getName()."</h5></div></div>"
                . "<div class='row'>"
                . "<div class='col border-top border-dark'><p>".$element->getEmail()."</p><p>".$element->getTelephone()."</p><p>".$element->getLocation().", ".$element->getPostal_code()."</p>"
                . "<h6><a href='https://".$element->getWeb()."'>".$element->getWeb()."</a></h6></div></div>"
                . "<div class='row'><div class='col border-top border-dark'><p>".$element->getDescription()."</p></div></div>"
                . "<div class='row'><div class='col border-top border-dark'><p class='text-secondary'><b>Contact:</b> ".$element->getPartner()->getFull_name()."</p><p class='text-secondary'> <b>Email:</b> ".$element->getPartner()->getEmail()."</p></div></div></div>";
    }
    echo "</div>";
}

function insertEnterprise() {
    $entityM = load("registered");

    $enterprise = $entityM->getRepository("MobilitySharp\model\Enterprise")->findOneBy(["email" => filter_input(INPUT_POST, "eEmail")]);

    if (is_null($enterprise)) {
        $ceo_post = filter_input(INPUT_POST, "ceoPost");
        $name = filter_input(INPUT_POST, "eName");
        $email = filter_input(INPUT_POST, "eEmail");
        $telephone = filter_input(INPUT_POST, "ePhone");
        $postal_code = filter_input(INPUT_POST, "postalCode");
        $location = filter_input(INPUT_POST, "location");
        $country = $entityM->find("MobilitySharp\model\Country", filter_input(INPUT_POST, "country"));
        $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
        $ceo = $entityM->find("MobilitySharp\model\CEO", filter_input(INPUT_POST, "ceo"));
        $type = $entityM->find("MobilitySharp\model\EnterpriseType", filter_input(INPUT_POST, "enterpriseType"));
        $registration_date = new \DateTime(date("Y-m-d"));
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
    } else {
        return FALSE;
    }
    header("Location:index.php");
}

function insertStudent() {

    $entityM = load("registered");


    
        $full_name = filter_input(INPUT_POST, "fName")." ". filter_input(INPUT_POST, "lName");
        $gender = filter_input(INPUT_POST, "gender");
        $birth_date = filter_input(INPUT_POST, "birthDate");
        $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
        $registration_date = new \DateTime(date("Y-m-d"));
        if($gender=="Male"){
            $gender='M';
        }
        else {
            $gender='F';
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

    $specialtyType = $entityM->getRepository("MobilitySharp\model\SpecialtyType")->findOneBy(["type" => filter_input(INPUT_POST, "spType")]);

    if (is_null($specialtyType)) {

        $type = filter_input(INPUT_POST, "specialtyType");
        $specialtyType = new \MobilitySharp\model\SpecialtyType($type);
        $entityM->persist($specialtyType);
        $entityM->flush();
    } else {
        return FALSE;
    }
}

function insertInstitutionType() {
    $entityM = load("admin");
    $institutionType = $entityM->getRepository("MobilitySharp\model\InstitutionType")->findOneBy(["type" => filter_input(INPUT_POST, "iType")]);

    if (is_null($institutionType)) {
        $type = filter_input(INPUT_POST, "institutionType");
        $institutionType = new \MobilitySharp\model\InstitutionType($type);

        if ($description = filter_input(INPUT_POST, "description")) {
            $institutionType->setDescription($description);
        }
    } else {
        return FALSE;
    }
}

function insertInstitutionSpecialty() {
    $entityM = load("registered");
    $institution = $entityM->find("\MobilitySharp\model\Institution", filter_input(INPUT_POST, "institution"));   //get this with a select
    $specialty = $entityM->find("\MobilitySharp\model\SpecialtyType", filter_input(INPUT_POST, "specialty")); //get this with a select

    $entityM->getConnection()->beginTransaction();
    $institution->getSpecialties()->add($specialty);
    $specialty->getInstitutions()->add($institution);
    $entityM->persist($institution);
    $entityM->persist($specialty);
    $entityM->flush();
    $entityM->getConnection()->commit();
}

function insertEnterpriseSpecialty() {
    $entityM = load("registered");
    $enterprise = $entityM->find("\MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise"));  //get this with a select
    $specialty = $entityM->find("\MobilitySharp\model\SpecialtyType", filter_input(INPUT_POST, "specialty")); //get this with a select

    $entityM->getConnection()->beginTransaction();
    $enterprise->getSpecialties()->add($specialty);
    $specialty->getEnterprises()->add($institution);
    $entityM->persist($enterprise);
    $entityM->persist($specialty);
    $entityM->flush();
    $entityM->getConnection()->commit();
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
    echo $enterprises;
}

function listAllInstitutions() {
    $entityM = load("registered");
    $institutions = $entityM->getRepository("MobilitySharp\model\Institution")->findAll();
    echo $institutions;
}

function listPartnerEnterprises() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner",$_SESSION["user"]["id"]);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner"=> $partner]);
    echo "<div class='row text-center my-2 my-lg-5 border justify-content-around'>";
    foreach ($enterprises as $enterprise){
        echo "<div class='col-12 col-md-7 col-lg-5 border border-dark rounded my-2 my-lg-5'>"
            
            . "<div class='row'><div class='col border-right border-dark'><h1>".$enterprise->getName()."</h1></div>"
                . "<div class='col'><h4 class='text-secondary'>".$enterprise->getType()->getType()."</h4>"
                . "<h5>".$enterprise->getCountry()->getName()."</h5></div></div>"
                . "<div class='row'>"
                . "<div class='col border-top border-dark'><p>".$enterprise->getEmail()."</p><p>".$enterprise->getTelephone()."</p><p>".$enterprise->getLocation().", ".$enterprise->getPostal_code()."</p>"
                . "<h6><a href='https://".$enterprise->getWeb()."'>".$enterprise->getWeb()."</a></h6></div></div>"
                . "<div class='row'><div class='col border-top border-dark'><p>".$enterprise->getDescription()."</p></div></div>"
                ."</div>";
    }
    echo "</div>";
}

function listPartnerStudents() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner",$_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner"=> $partner]);
    
    echo "<div class='row text-center my-2 my-lg-5 border justify-content-around'>";
    foreach ($students as $student){
        if($student->getGender()=="M"){
            $gender="Male";
        }
        else {
            $gender="Female";
        }
        $date= date_format($student->getBirth_date(), 'Y-m-d');
        echo "<div class='col-12 col-md-7 col-lg-5 border border-dark rounded my-2 my-lg-5'>"
            
            . "<div class='row'><div class='col border-bottom border-dark p-1 p-lg-2'><h2>".$student->getFull_Name()."</h2></div></div>"
                . "<div class='row'><div class='col border-bottom border-dark p-1 p-lg-2'><h5 class='text-secondary'>".$gender."</h5>"
                . "<h4>".$date."</h4></div></div>"
                . "<div class='row'>"
                . "<div class='col border-bottom border-dark p-1 p-lg-2'><h3 class='text-secondary'>Specialties</h3></div></div>";
                
                    foreach ($student->getSpecialties() as $specialty){
                    echo "<div class='row'>"
                . "<div class='col border-top border-dark p-1 p-lg-2'>".
                    "<h4>".$specialty->getType()."</h4>"
                   . "<p>".$specialty->getDescription()."</p></div></div>";
                    
                
                }
                
                 
                echo "</div>"
                ;
    }
    echo "</div>";
}


function getCeos(){
    $entityM = load("registered");
    $ceos = $entityM->getRepository("MobilitySharp\model\CEO")->findAll();
    
    foreach ($ceos as $ceo){
        echo '<option value='.$ceo->getId().'>'.$ceo->getFull_name().'</option>';
    }
}

function getEnterpriseType(){
    $entityM = load("registered");
    $enterprises = $entityM->getRepository("MobilitySharp\model\EnterpriseType")->findAll();
    
    foreach ($enterprises as $enterprise){
        echo '<option value='.$enterprise->getId().'>'.$enterprise->getType().'</option>';
    }
}


function getPartnerStudents(){
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner",$_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner"=>$partner]);
    
    foreach ($students as $student){
        echo '<option value='.$student->getId().'>'.$student->getFull_name().'</option>';
    }
}

function getAllEnterprises(){
    $entityM = load("registered");
    
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findAll();
    
    foreach ($enterprises as $enterprise){
        echo '<option value='.$enterprise->getId().'>'.$enterprise->getName().'</option>';
    }
}


function insertEnterpriseMobility(){
    $entityM = load("registered");
    $startDate= filter_input(INPUT_POST, "startDate");
    $estimatedEndDate= filter_input(INPUT_POST, "estimatedEndDate");
    $student=$entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
    $enterprise=$entityM->find("MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise"));
    $registrationDate=new \DateTime(date("Y-m-d"));
    $mobility=new \MobilitySharp\model\EnterpriseMobility(new \DateTime($startDate), new \DateTime($estimatedEndDate), $registrationDate, $student, $enterprise);
    
    $entityM->persist($mobility);
    $entityM->flush();
}

function getAllInstitutions(){
    $entityM = load("registered");
    
    $institutions = $entityM->getRepository("MobilitySharp\model\Institution")->findAll();
    
    foreach ($institutions as $institution){
        echo '<option value='.$institution->getId().'>'.$institution->getName().'</option>';
    }
}

function insertInstitutionMobility(){
    $entityM = load("registered");
    $startDate= filter_input(INPUT_POST, "startDate");
    $estimatedEndDate= filter_input(INPUT_POST, "estimatedEndDate");
    $student=$entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
    $institution=$entityM->find("MobilitySharp\model\Institution", filter_input(INPUT_POST, "institution"));
    $registrationDate=new \DateTime(date("Y-m-d"));
    $mobility=new \MobilitySharp\model\InstitutionMobility(new \DateTime($startDate), new \DateTime($estimatedEndDate), $registrationDate, $student, $institution);
    
    $entityM->persist($mobility);
    $entityM->flush();
}



function listPartnerMobilities(){
    $entityM= load("registered");
    
    $partner = $entityM->find("MobilitySharp\model\Partner",$_SESSION["user"]["id"]);
    $students=$entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner"=>$partner]);
    $eMobilities=$entityM->getRepository("MobilitySharp\model\EnterpriseMobility")->findBy(["student"=>$students]);
    $iMobilities=$entityM->getRepository("MobilitySharp\model\InstitutionMobility")->findBy(["student"=>$students]);
    
    $mobilities= array_merge($eMobilities,$iMobilities);
    
    
        
    
   echo "<div class='row text-center my-2 my-lg-5 border justify-content-around'>";
   foreach ($mobilities as $mobility){
       
       $startDate=date_format($mobility->getStart_date(), 'Y-m-d');
       $estimatedEndDate=date_format($mobility->getEstimated_end_date(), 'Y-m-d');
        echo "<div class='col-12 col-md-7 col-lg-5 border border-dark rounded my-2 my-lg-5'>".
                "<div class='row'>"
                . "<div class='col border-bottom border-right border-dark'>Student</div>"
                . "<div class='col border-bottom border-dark'>Institution</div>"
                . "</div>"
            
            . "<div class='row'><div class='col border-right border-dark'><h5>".$mobility->getStudent()->getFull_name()."</h5></div>"
                . "<div class='col'><h4 class='text-secondary'>".$mobility->getInstitution()->getName()."</h4>"
                . "<h5>".$mobility->getInstitution()->getCountry()->getName()."</h5></div></div>"
                
                ."<div class='row'>"
                . "<div class='col border-top border-right border-dark pt-2'>"
                . "<h6>Start date</h6></div>"
                . "<div class='col border-top border-dark pt-2'>"
                . "<h6>Estimated end date</h6></div></div>"
                . "<div class='row'>"
                . "<div class='col border-top border-right border-dark'>"
                . "<p>".$startDate."</p></div>"
                . "<div class='col border-top border-dark'>"
                . "<p>".$estimatedEndDate."</p></div></div></div>"
                ;
    }
    echo "</div>";
}







