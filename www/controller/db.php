<?php

/**
 * This file contains all the database functions neccesary to make MobilitySharp work.
 * @author Diego Rodríguez Vicente <diego_pkv@hotmail.com>
 * @author Jorge Martínez Franco <jorgemarti123@hotmail.com>
 */

namespace MobilitySharp\controller;

require_once __DIR__ . '/../vendor/autoload.php';

use \Doctrine\ORM\Tools\Setup;
use \Doctrine\ORM\EntityManager;

/**
 * Loads Doctrine configuration from files.
 * 
 * <p>Loads the configuration from the config directory.<br>
 * This configuration is divided in two files:</p>
 * <ul>
 *  <li>db-global.ini -> Contains global configuration such as hostname, database name, charset...</li>
 *  <li>db-{user}.ini -> Contains authentication configuration like username and password, you can have as many files as users you need to connect to the database.</li>
 * </ul>
 * 
 * @param string $user The name of the custom authentication configuration file to connect to the database.
 * 
 * @return EntityManager
 */
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

/**
 * Checks if the username/email and password matches.
 * 
 * @param string $username The username which is going to be checked (can be username or email).
 * @param string $password The password which is going to be checked.
 * 
 * @return array|bool user information once is confirmed that exists or FALSE if something goes wrong.
 */
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
        if ($user->getTermination_date() == null) {
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
        } else {
            
        }
    } catch (\Exception $ex) {
        echo $ex->getMessage();
    }
}

/**
 * Gets all countries from the database.
 * 
 * After retrieving the countries from the database, sends their Id(value) and Name(text) as JSON data.
 *
 * @see \MobilitySharp\model\Country
 * @see \json_encode
 */
function getCountries() {

    $entityM = load("login");
    $countries = $entityM->getRepository("MobilitySharp\model\Country")->findAll();
    $json = [];

    foreach ($countries as $country) {
        array_push($json, ["value" => $country->getId(), "text" => $country->getName()]);
    }

    echo json_encode($json);
}

/**
 * Gets all institutions types from the database.
 * 
 * After retrieving the institution types from the database, sends Id(value) and Type(text) as JSON data.
 *
 * @see \MobilitySharp\model\InstitutionType
 * @see \json_encode
 */
function getInstitutionTypes() {

    $entityM = load("login");
    $insTypes = $entityM->getRepository("MobilitySharp\model\InstitutionType")->findAll();
    $json = [];

    foreach ($insTypes as $type) {
        array_push($json, ["value" => $type->getId(), "text" => $type->getType()]);
    }

    echo json_encode($json);
}

/**
 * Registers a partner and institution.
 * 
 * If the {@link \MobilitySharp\model\Institution Institution} already exists only the {@link \MobilitySharp\model\Partner Partner} gets registered,
 * making an association with the previously registered institution.<br>
 * Gets the whole data filtering user's input.
 * 
 * @see \MobilitySharp\model\Partner
 * @see \MobilitySharp\model\Institution
 * 
 * @return void
 */
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
        $confirmPassword = filter_input(INPUT_POST, "password2");
        $vat = (filter_input(INPUT_POST, "vat")) ? filter_input(INPUT_POST, "vat") : NULL;
        $post = filter_input(INPUT_POST, "post");
        $department = filter_input(INPUT_POST, "department");
        $l_provider = filter_input(INPUT_POST, "lodgingProvider");
        $role = $entityM->getRepository("MobilitySharp\model\Role")->findOneBy(["type" => 'REGISTERED']); // registered user
        $country = $entityM->find("MobilitySharp\model\Country", filter_input(INPUT_POST, "country"));
        $repeatedEmailPartner = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["email" => $email]);
        $repeatedUser = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["username" => $username]);
        $repeatedPartnerVat = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["vat" => $vat]);
        $iName = filter_input(INPUT_POST, "iName");
        $iEmail = filter_input(INPUT_POST, "iEmail");
        $iPhone = filter_input(INPUT_POST, "iPhone");
        $iVat = (filter_input(INPUT_POST, "iVat")) ? filter_input(INPUT_POST, "iVat") : NULL;
        $postalCode = filter_input(INPUT_POST, "postalCode");
        $iLocation = filter_input(INPUT_POST, "location");
        $web = filter_input(INPUT_POST, "web");
        $description = filter_input(INPUT_POST, "description");
        $institutionType = $entityM->find("MobilitySharp\model\InstitutionType", filter_input(INPUT_POST, "institutionType"));
        
        $institution = $entityM->getRepository("MobilitySharp\model\Institution")->findOneBy(["email" => $iEmail]);

        if ($password == $confirmPassword or $repeatedEmailPartner == null or $repeatedPartnerVat == null or $repeatedUser == null) {
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
                        ':role' => $partner->getRole()->getType()
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
                $partnerParams = [
                        ':id' => $partner->getId(),
                        ':email' => $email,
                        ':username' => $username,
                        ':password' => password_hash($password, PASSWORD_DEFAULT),
                        ':role' => $partner->getRole()->getType()
                    ];
                sessionStoreUser($partnerParams);
                $location = "Location:index.php?registered";
            }
        }
        header($location);
    } catch (\Exception $e) {

        header($location);
    }
}

/**
 * Stores user information in {@link https://www.php.net/manual/en/reserved.variables.session.php $_SESSION}.
 * 
 * @param array $userParams User information to be stored.
 * 
 * @return void
 */
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

/**
 * Searches institutions in the database.
 * 
 * Retrieves the requested data from the database filtering user's input. It also prints the data as HTML code.
 * 
 * @see \MobilitySharp\model\Enterprise
 * @see \MobilitySharp\model\Institutions
 * 
 * @return void
 */
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

        echo "<div class='col-14 col-md-9 col-lg-5 my-3 my-lg-5 '>"
        . "<div class='row border border-dark '><div class='col centerCol border-right border-dark bg-secondary p-1'><h3>" . $element->getName() . "</h3></div>"
        . "<div class='col border centerCol'><div class='row'><div class='col'><h4 class='text-secondary'>" . $element->getType()->getType() . "</h4></div></div>"
        . "<div class='row'><div class='col'><h5>" . $element->getCountry()->getName() . "</h5></div></div></div></div>";
        if ($element->getDescription()) {
            echo "<div class='row border border-dark '><div class='col centerCol'><p>" . $element->getDescription() . "</p></div></div>";
        }
        echo "</div>";
    }
    echo "</div></div>";
}

/**
 * Searches institutions in the database.
 * 
 * Retrieves the requested data from the database filtering user's input. It also prints the data as HTML code.
 * This function retrieves more information than {@link \MobilitySharp\controller\searchInstitutionsBasic searchInstitutionsBasic} function.
 * 
 * @see \MobilitySharp\model\Enterprise
 * @see \MobilitySharp\model\Institutions
 * 
 * @return void
 */
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
        . "<div class='row border-bottom border-dark'><div class='col border border-dark bg-secondary p-3 centerCol'><h2>" . $element->getName() . "</h2></div>"
        . "<div class='col border border-dark centerCol'><div class='row'><div class='col'><h4 class='text-secondary'>" . $element->getType()->getType() . "</h4></div></div>"
        . "<div class='row'><div class='col '><h5>" . $element->getCountry()->getName() . "</h5></div></div></div></div>"
        . "<div class='row border border-dark'><div class='col col-3 centerCol bg-secondary p-2'><h5>Email</h5></div>"
        . "<div class='col col-9 centerCol p-2'><h6>" . $element->getEmail() . "</h6></div></div>"
        . "<div class='row border border-dark'><div class='col col-3 centerCol bg-secondary p-2'><h5>Phone</h5></div><div class='col centerCol p-2'><h6>" . $element->getTelephone() . "</h6></div></div>"
        . "<div class='row border border-dark'><div class='col col-3 centerCol bg-secondary p-2'><h5>Location</h5></div><div class='col centerCol p-2'><h6>" . $element->getLocation() . ", " . $element->getPostal_code() . "</h6></div></div>";
        if ($element->getWeb()) {
            echo "<div class='row border border-dark'><div class='col col-3 centerCol bg-secondary p-2'><h5>Web</h5></div><div class='col p-2 centerCol'><h6><a href='https://" . $element->getWeb() . "'>" . $element->getWeb() . "</a></h6></div></div>";
        }
        if ($element->getDescription()) {
            echo "<div class='row'><div class='col col-3 centerCol bg-secondary'><h6>Description</h6></div><div class='col border-right border-dark centerCol p-2'><h6>" . $element->getDescription() . "</h6></div></div>";
        }
        echo "<div class='row border border-dark bg-secondary'><div class='col border-top border-dark p-2'><p><b>Contact:</b> " . $element->getPartner()->getFull_name() . "</p></div></div>"
        . "<div class='row border border-dark bg-secondary'><div class='col'><p> <b>Email:</b> " . $element->getPartner()->getEmail() . "</p></div></div></div>";
    }
    echo "</div></div></div>";
}

/**
 * Inserts an enterprise in the database.
 * 
 * <p>Retrieves the requested data from the database filtering user's input.<br>
 * If the email already exists in the database, it will fail.</p>
 * 
 * @see \MobilitySharp\model\Enterprise
 * @see \MobilitySharp\model\CEO
 */
function insertEnterprise() {
    $entityM = load("registered");

    $enterprise = $entityM->getRepository("MobilitySharp\model\Enterprise")->findOneBy(["email" => filter_input(INPUT_POST, "eEmail")]);
    $ceo = $entityM->getRepository("MobilitySharp\model\CEO")->findOneBy(["email" => filter_input(INPUT_POST, "email")]);

    if ($vat = filter_input(INPUT_POST, "eVat")) {
        $repeatedVat = $entityM->getRepository("MobilitySharp\model\Enterprise")->findOneBy(["vat" => $vat]);
    } else {
        $vat = null;
        $repeatedVat = null;
    }

    if ($repeatedVat == null) {
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


            $enterprise->setVat($vat);

            if ($web = filter_input(INPUT_POST, "web")) {
                $enterprise->setWeb($web);
            }
            if ($description = filter_input(INPUT_POST, "description")) {
                $enterprise->setDescription($description);
            }
            $entityM->persist($enterprise);
            $entityM->flush();
            $entityM->getConnection()->commit();
        }
    }
    header("Location:index.php");
}

/**
 * Modifies a selected enterprise in the database.
 * Retrieves the requested data from the database filtering user's input and modifies the {@link \MobilitySharp\model\Enterprise Enterprise} data through it's ID.
 * 
 * @see \MobilitySharp\model\Enterprise
 * 
 * @param int $id Enterprise's identificator.
 */
function modifyEnterprise($id) {
    $entityM = load("registered");
    $enterprise = $entityM->find("MobilitySharp\model\Enterprise", $id);
    $date = new \DateTime(date("Y-m-d H:i:s"));
    $enterprise->setName(filter_input(INPUT_POST, "eName"));
    $enterprise->setEmail(filter_input(INPUT_POST, "eEmail"));
    $enterprise->setTelephone(filter_input(INPUT_POST, "ePhone"));
    if ($vat = filter_input(INPUT_POST, "eVat")) {
        $repeatedVat = $entityM->getRepository("MobilitySharp\model\Enterprise")->findOneBy(["vat" => $vat]);
        if (!is_null($repeatedVat)) {
            if ($repeatedVat->getId() == $id) {
                $repeatedVat = null;
            }
        }
    } else {
        $repeatedVat = null;
        $vat = null;
    }
    if ($repeatedVat == null) {
        $enterprise->setVat($vat);
        $enterprise->setPostal_code(filter_input(INPUT_POST, "postalCode"));
        $enterprise->setLocation(filter_input(INPUT_POST, "location"));
        $enterprise->setWeb(filter_input(INPUT_POST, "web") ?? NULL);
        $enterprise->setCeo_post(filter_input(INPUT_POST, "ceoPost") ?? NULL);
        $enterprise->setCountry($entityM->find("MobilitySharp\model\Country", filter_input(INPUT_POST, "country")));
        $enterprise->setType($entityM->find("MobilitySharp\model\EnterpriseType", filter_input(INPUT_POST, "enterpriseType")));
        $enterprise->setModification_date($date);
        $entityM->flush();
    }
}

/**
 * Inserts a student in the database.
 * Retrieves the requested data from the database filtering user's input.
 * 
 * @see \MobilitySharp\model\Student
 */
function insertStudent() {

    $entityM = load("registered");
    $full_name = filter_input(INPUT_POST, "fName") . " " . filter_input(INPUT_POST, "lName");
    $gender = filter_input(INPUT_POST, "gender");
    $birth_date = filter_input(INPUT_POST, "birthDate");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $registration_date = new \DateTime(date("Y-m-d"));

    if ($vat = filter_input(INPUT_POST, "sVat")) {
        $repeatedVat = $entityM->getRepository("MobilitySharp\model\Student")->findOneBy(["vat" => $vat]);
    } else {
        $repeatedVat = null;
        $vat = null;
    }

    if ($gender == "Male") {
        $gender = 'M';
    } else {
        $gender = 'F';
    }
    if ($repeatedVat == null) {
        $student = new \MobilitySharp\model\Student($full_name, $gender, new \DateTime($birth_date), $partner, $registration_date);


        $student->setVat($vat);


        $entityM->persist($student);
        $entityM->flush();
    }
    header("Location:index.php");
}

/**
 * Inserts a new specialty type if the type do not exists in the DB. Gets all data to insert from a form with POST method.
 */
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
    }
}

/**
 * Inserts a new institution type if the type do not exists in the DB. Gets all data to insert from a form with POST method.
 */
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
    }
}

/**
 * Inserts a specialty in an institution. Gets all data to insert from a form with POST method.
 */
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
    } catch (\Exception $ex) {
        $entityM->getConnection()->rollback();
    }
}

/**
 * Inserts a specialty in an enterprise. Gets all data to insert from a form with POST method.
 */
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
    } catch (\Exception $ex) {
        $entityM->getConnection()->rollback();
    }
}

/**
 * Inserts a specialty in a student. Gets all data to insert from a form with POST method.
 */
function insertStudentSpecialty() {
    $entityM = load("registered");
    $student = $entityM->find("\MobilitySharp\model\Student", filter_input(INPUT_POST, "student")); //get this with a select
    $specialty = $entityM->find("\MobilitySharp\model\SpecialtyType", filter_input(INPUT_POST, "specialty")); //get this with a select
    try {
        $entityM->getConnection()->beginTransaction();
        $student->getSpecialties()->add($specialty);
        $specialty->getStudents()->add($student);
        $entityM->persist($student);
        $entityM->persist($specialty);
        $entityM->flush();
        $entityM->getConnection()->commit();
    } catch (\Exception $ex) {
        $entityM->getConnection()->rollback();
    }
}

/**
 * Set enterprise as deleted but persisting in the DB. Gets all data to delete from a form with POST method.
 */
function deleteEnterprise($id) {

    $entityM = load("registered");
    $enterprise = $entityM->find("MobilitySharp\model\Enterprise", $id);
    $enterprise->setTermination_date(new \DateTime(date("Y-m-d")));
    $entityM->persist($enterprise);
    $entityM->flush();
}

/**
 * Set student as deleted but persisting in the DB. Gets all data to delete from a form with POST method.
 */
function deleteStudent($id) {
    $entityM = load("registered");
    $student = $entityM->find("MobilitySharp\model\Student", $id);
    $student->setTermination_date(new \DateTime(date("Y-m-d")));
    $entityM->persist($student);
    $entityM->flush();
}

/**
 * Set institution as deleted but persisting in the DB. Gets all data to delete from a form with POST method.
 */
function deleteInstitution($id) {
    $entityM = load("registered");
    $institution = $entityM->find("MobilitySharp\model\Institution", $id);
    $institution->setTermination_date(new \DateTime(date("Y-m-d")));
    $entityM->persist($institution);
    $entityM->flush();
}

/**
 * Finds all enterprises in the DB.
 * @return array Enterprises data.
 */
function listAllEnterprises() {

    $entityM = load("registered");
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findAll();
    return $enterprises;
}

/**
 * List all enterprises who the logged in partner has registered.
 */
function listPartnerEnterprises() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner" => $partner]);

    echo "<div class='row text-center justify-content-around'>";
    foreach ($enterprises as $enterprise) {

        if ($enterprise->getTermination_date() == null) {
            echo "<div class='col-12 col-md-7 col-lg-5 my-2 my-lg-5'>
        
        <div class='row'><div class='col col-10 bg-secondary border-right border-top border-left border-dark'><h2>Enterprise</h2></div><div class='col border border-top border-right'>
            <div class='dropleft'>
                <button class='btn btn-primary' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                    <i class='fa fa-ellipsis-v' aria-hidden='true'></i>
                </button>
                <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>
                    <a class='dropdown-item' href='registerEnterprise.php?id=" . $enterprise->getId() . "'>Edit</a>
                    <a class='dropdown-item' href='" . $_SERVER['PHP_SELF'] . "?id=" . $enterprise->getId() . "'>Delete</a>
                </div>
            </div>
        </div></div>
        <div class='row border-top border-right border-left border-dark'><div class='col border-right centerCol'><h3>" . $enterprise->getName() . "</h3></div>
        <div class='col centerCol'><div class='row'><div class='col'><h4 class='text-secondary'>" . $enterprise->getType()->getType() . "</h4></div></div>
        <div class='row '><div class='col border-right'><h5>" . $enterprise->getCountry()->getName() . "</h5></div></div></div></div>
        <div class='row bg-secondary p-2 border-right border-left border-top border-dark'><div class='col border-right border-dark'><h3>Email</h3></div><div class='col '><h3>Phone</h3></div></div>
        <div class='row border-right border-left border-top border-dark '>
        <div class='col border-right p-2 centerCol'><h6>" . $enterprise->getEmail() . "</h6></div><div class='col p-2 centerCol'><h6>" . $enterprise->getTelephone() . "</h6></div></div>
        <div class='row border-right border-left border-top border-dark bg-secondary p-2 '><div class='col border-right border-dark centerCol'><h3>Location</h3></div><div class='col centerCol'><h3>Web</h3></div></div>
        <div class='row border-right border-left border-top border-dark'><div class='col border-right p-2 centerCol'><h6>" . $enterprise->getLocation() . ", " . $enterprise->getPostal_code() . "</h6></div><div class='col border-right p-2 centerCol'><h6><a href='https://{$enterprise->getWeb()}'>{$enterprise->getWeb()}</a></h6></div></div>
        <div class='row bg-secondary p-2 border-right border-left border-top border-dark'><div class='col centerCol'><h3>Description</h3></div></div>
        <div class='row p-2 border border-dark'><div class='col centerCol'><h6>" . $enterprise->getDescription() . "</h6></div></div>
        </div>";
        }
    }
    echo "</div>";
}

/**
 * List all students who the logged partner has registered.
 */
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

        if ($student->getSpecialties()->count() > 0) {
            echo "<div class='row bg-secondary border border-dark'><div class='col border-bottom border-dark p-1 p-lg-2'><h3>Specialties</h3></div></div>";

            foreach ($student->getSpecialties() as $specialty) {
                echo "<div class='row'>"
                . "<div class='col p-1 p-lg-2 border-left border-right border-dark'>" .
                "<h4>" . $specialty->getType() . "</h4></div></div>"
                . "<div class='row border-bottom border-dark border-right border-left'>"
                . "</div>";
            }
        }




        echo "</div>"
        ;
    }
    echo "</div></section>";
}

/**
 * Sends a JSON of all CEOS which exist in the DB.
 */
function getCeos() {
    $entityM = load("registered");
    $ceos = $entityM->getRepository("MobilitySharp\model\CEO")->findAll();
    $json = [];

    foreach ($ceos as $ceo) {
        array_push($json, ["value" => $ceo->getId(), "text" => $ceo->getFull_name()]);
    }
}

/**
 * Gets all enterprise types. Sends a JSON with Id and type. 
 */
function getEnterpriseTypes() {
    $entityM = load("registered");
    $enterprises = $entityM->getRepository("MobilitySharp\model\EnterpriseType")->findAll();
    $json = [];

    foreach ($enterprises as $enterprise) {
        array_push($json, ["value" => $enterprise->getId(), "text" => $enterprise->getType()]);
    }
    echo json_encode($json);
}

/**
 * Sends all partner students in option tags.
 */
function getPartnerStudents() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);

    foreach ($students as $student) {
        echo '<option value=' . $student->getId() . '>' . $student->getFull_name() . '</option>';
    }
}

/**
 * Sends all enterprises in option tags.
 */
function getAllEnterprises() {
    $entityM = load("registered");

    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findAll();

    foreach ($enterprises as $enterprise) {
        echo '<option value=' . $enterprise->getId() . '>' . $enterprise->getName() . '</option>';
    }
}

/**
 * Inserts an enterprise mobility. Gets all data to insert from a form with POST method.
 */
function insertEnterpriseMobility() {
    $entityM = load("registered");
    $startDate = new \DateTime(filter_input(INPUT_POST, "startDate"));
    $estimatedEndDate = new \DateTime(filter_input(INPUT_POST, "estimatedEndDate"));
    $startDate->format("Y-m-d");
    $estimatedEndDate->format("Y-m-d");
    if ($startDate < $estimatedEndDate) {
        $student = $entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
        $queryEnterpriseMobilities = $entityM->createQueryBuilder();
        $queryInstitutionMobilities = $entityM->createQueryBuilder();

        $queryEnterpriseMobilities->addSelect('em')
                ->from("MobilitySharp\model\EnterpriseMobility", 'em')
                ->where("em.student = :student")
                ->andWhere(":start_date BETWEEN em.start_date AND em.estimated_end_date")
                ->orWhere(":estimated_end_date BETWEEN em.start_date AND em.estimated_end_date")
                ->setParameter("student", $student)
                ->setParameter("start_date", $startDate)
                ->setParameter("estimated_end_date", $estimatedEndDate);
        $enterpriseMobilities = $queryEnterpriseMobilities->getQuery()->getResult();

        $queryInstitutionMobilities->addSelect('im')
                ->from("MobilitySharp\model\InstitutionMobility", 'im')
                ->where("im.student = :student")
                ->andWhere(":start_date BETWEEN im.start_date AND im.estimated_end_date")
                ->orWhere(":estimated_end_date BETWEEN im.start_date AND im.estimated_end_date")
                ->setParameter("student", $student)
                ->setParameter("start_date", $startDate)
                ->setParameter("estimated_end_date", $estimatedEndDate);

        $institutionMobilities = $queryInstitutionMobilities->getQuery()->getResult();
        $mobilities = array_merge($enterpriseMobilities, $institutionMobilities);
        $enterprise = $entityM->find("MobilitySharp\model\Enterprise", filter_input(INPUT_POST, "enterprise"));
        $registrationDate = new \DateTime(date("Y-m-d"));

        if ($mobilities == null) {
            $mobility = new \MobilitySharp\model\EnterpriseMobility($startDate, $estimatedEndDate, $registrationDate, $student, $enterprise);

            $entityM->persist($mobility);
            $entityM->flush();
        }
    }
}

/**
 * Sends all institutions in option tags.
 */
function getAllInstitutions() {
    $entityM = load("registered");

    $institutions = $entityM->getRepository("MobilitySharp\model\Institution")->findAll();

    foreach ($institutions as $institution) {
        echo '<option value=' . $institution->getId() . '>' . $institution->getName() . '</option>';
    }
}

/**
 * Inserts an institution mobility. Gets all data to insert from a form with POST method.
 */
function insertInstitutionMobility() {
    $entityM = load("registered");
    $startDate = new \DateTime(filter_input(INPUT_POST, "startDate"));
    $estimatedEndDate = new \DateTime(filter_input(INPUT_POST, "estimatedEndDate"));
    $startDate->format("Y-m-d");
    $estimatedEndDate->format("Y-m-d");
    if ($startDate < $estimatedEndDate) {
        $student = $entityM->find("MobilitySharp\model\Student", filter_input(INPUT_POST, "student"));
        $institution = $entityM->find("MobilitySharp\model\Institution", filter_input(INPUT_POST, "institution"));
        $registrationDate = new \DateTime(date("Y-m-d"));
        $queryEnterpriseMobilities = $entityM->createQueryBuilder();
        $queryInstitutionMobilities = $entityM->createQueryBuilder();

        $queryEnterpriseMobilities->addSelect('em')
                ->from("MobilitySharp\model\EnterpriseMobility", 'em')
                ->where("em.student = :student")
                ->andWhere(":start_date BETWEEN em.start_date AND em.estimated_end_date")
                ->orWhere(":estimated_end_date BETWEEN em.start_date AND em.estimated_end_date")
                ->setParameter("student", $student)
                ->setParameter("start_date", $startDate)
                ->setParameter("estimated_end_date", $estimatedEndDate);
        $enterpriseMobilities = $queryEnterpriseMobilities->getQuery()->getResult();

        $queryInstitutionMobilities->addSelect('im')
                ->from("MobilitySharp\model\InstitutionMobility", 'im')
                ->where("im.student = :student")
                ->andWhere(":start_date BETWEEN im.start_date AND im.estimated_end_date")
                ->orWhere(":estimated_end_date BETWEEN im.start_date AND im.estimated_end_date")
                ->setParameter("student", $student)
                ->setParameter("start_date", $startDate)
                ->setParameter("estimated_end_date", $estimatedEndDate);

        $institutionMobilities = $queryInstitutionMobilities->getQuery()->getResult();
        $mobilities = array_merge($enterpriseMobilities, $institutionMobilities);
        if ($mobilities == null) {
            $mobility = new \MobilitySharp\model\InstitutionMobility($startDate, $estimatedEndDate, $registrationDate, $student, $institution);

            $entityM->persist($mobility);
            $entityM->flush();
        }
    }
}

/**
 * List all partner mobilities sending HTML code.
 */
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
        echo "<div class='col-12 col-md-7 col-lg-5 my-2 my-lg-5'>" .
        "<div class='row bg-secondary border-top border-right border-left border-dark'>"
        . "<div class='col border-bottom border-right border-dark'><h3>Student</h3></div>"
        . "<div class='col border-bottom border-dark'><h3>$institution</h3></div>"
        . "</div>"
        . "<div class='row border-bottom border-right border-left border-dark'><div class='col centerCol'><h5>" . $mobility->getStudent()->getFull_name() . "</h5></div>"
        . "<div class='col border-left centerCol'><h4 class='text-secondary'>" . $name . "</h4>"
        . "<h5>" . $country . "</h5></div></div>"
        . "<div class='row bg-secondary border-bottom border-right border-left border-dark'>"
        . "<div class='col pt-2 border-right border-dark'>"
        . "<h5>Start date</h5></div>"
        . "<div class='col pt-2'>"
        . "<h5>Estimated end date</h5></div></div>"
        . "<div class='row border-bottom border-right border-left border-dark'>"
        . "<div class='col p-2 border-right'>"
        . "<h5>" . $startDate . "</h5></div>"
        . "<div class='col p-2 border-dark'>"
        . "<h5>" . $estimatedEndDate . "</h5></div></div></div>"
        ;
    }
    echo "</div></section>";
}

/**
 * List all specialties sending HTML code.
 */
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

/**
 * List last 5 partner scores sending HTML code.
 */
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

/**
 * List Top Institutions ordered by number of mobilities with HTML code.
 */
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

/**
 * List Top Enterprises ordered by number of mobilities with HTML code.
 */
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

/**
 * List institutions registered by the partner logged in and sends HTML code.
 */
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

/**
 * Inserts new enterprise type. Gets all data to insert from a form with POST method.
 */
function insertEnterpriseType() {
    $entityM = load("admin");
    $type = filter_input(INPUT_POST, "type");
    $repeatedType = $entityM->getRepository("MobilitySharp\model\EnterpriseType")->findOneBy(["type" => $type]);
    if ($repeatedType == null) {
        $enterpriseType = new \MobilitySharp\model\EnterpriseType($type);

        if ($description = filter_input(INPUT_POST, "description")) {
            $enterpriseType->setDescription($description);
        }

        $entityM->persist($enterpriseType);
        $entityM->flush();
    }
}

/**
 * Gets all partner students.
 * @return array Partner Students' data
 */
function partnerStudents() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);

    return $students;
}

/**
 * Sends all specialties in option tags.
 */
function getAllSpecialties() {
    $entityM = load("admin");
    $specialties = $entityM->getRepository("MobilitySharp\model\SpecialtyType")->findAll();

    foreach ($specialties as $specialty) {
        echo "<option value=" . $specialty->getId() . ">" . $specialty->getType() . "</option>";
    }
}

/**
 * Sends all partner enterprises in option tags.
 */
function partnerEnterprises() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION['user']['id']);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner" => $partner]);
    foreach ($enterprises as $enterprise) {
        echo "<option value=" . $enterprise->getId() . ">" . $enterprise->getName() . "</option>";
    }
}

/**
 * Gets all partner enterprises
 * @return array Partner Enterprises' data.
 */
function getPartnerEnterprises() {

    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION['user']['id']);
    $enterprises = $entityM->getRepository("MobilitySharp\model\Enterprise")->findBy(["partner" => $partner]);
    return $enterprises;
}

/**
 * Find mobilities between two dates and sends it in HTML code. Gets all data to find from a form with POST method.
 */
function findMobilitiesBetweenDates() {
    $entityM = load("admin");
    $date1 = filter_input(INPUT_GET, "date1");

    $date2 = filter_input(INPUT_GET, "date2");
    if ($date1 < $date2) {

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

        echo "<div class='container-fluid mx-3 mx-lg-5'>"
        . "<div class='container py-3 py-lg-5 border-bottom border-dark my-3 my-lg-5'><div class='row border-bottom border-dark mb-3 mb-lg-5'><div class='col'><h3>Mobilities between " . $date1 . " and " . $date2 . "</h3></div></div>"
        . "
                <div class='row'><div class='col-12'>
                <ul>
                <li><h5><a href='findMobilities.php'>Search more mobilities</a></h5></div></li>
                </ul>
                </div>"
        . "<div class='row justify-content-around '>";

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
            . "<div class='row'><div class='col centerCol p-2 border-right'><h5>" . $mobility->getStudent()->getFull_name() . "</h5></div>"
            . "<div class='col p-2'><div class='row'><div class='col centerCol'><h4 class='text-secondary'>" . $name . "</h4></col>"
            . "<div class='col centerCol'><h5>" . $country . "</h5></div></div></div></div></div>"
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
        echo "</div></div></div>";
    } else {

        echo "<section class='container mt-3 pt-3 mb-3 mb-lg-5'>
                <div class='row'><div class='col'><h4>You have to search valid dates.</h4></div></div>
                <ul>
                    <li><div class='row text-left m-3'><div class='col'><h5><a href='findMobilities.php'>Search mobilities</a></h5></div></div></li>
                </ul>
                </section>";
    }
}

/**
 * Gets all partner mobilities.
 * @return array Partner mobilities' data.
 */
function partnerMobilities() {
    $entityM = load("registered");

    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $students = $entityM->getRepository("MobilitySharp\model\Student")->findBy(["partner" => $partner]);
    $eMobilities = $entityM->getRepository("MobilitySharp\model\EnterpriseMobility")->findBy(["student" => $students]);
    $iMobilities = $entityM->getRepository("MobilitySharp\model\InstitutionMobility")->findBy(["student" => $students]);

    $mobilities = array_merge($eMobilities, $iMobilities);
    return $mobilities;
}

/**
 * Sends partner profile in HTML code.
 */
function partnerProfile() {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);


    echo "<section class='container'><div class='row border-bottom border-dark'><div class='col'><h2>" . $partner->getFull_name() . "</h2></div></div>"
    . "<div class='container text-center border-bottom border-dark mb-3 mb-lg-5'><div class='row text-center mt-2 mt-lg-5 justify-content-center '>"
    . "<div class='col col-12 col-lg-10 col-xl-8 border border-dark mb-3'>"
    . "<div class='row bg-secondary p-2 border-bottom border-dark'><div class='col border-right border-dark'><h4>Email</h4></div><div class='col'><h4>Username</h4></div></div>"
    . "<div class='row border-bottom border-dark p-2'><div class='col centerCol'><h6 name='email'>" . $partner->getEmail() . "</h6></div><div class='col centerCol'><h6>" . $partner->getUsername() . "</h6></div></div>"
    . "<div class='row bg-secondary border-bottom border-dark p-2'><div class='col border-right border-dark'><h4>Phone</h4></div><div class='col'><h4>VAT</h4></div></div>"
    . "<div class='row border-bottom border-dark p-2'><div class='col centerCol'><h6>" . $partner->getTelephone() . "</h6></div><div class='col centerCol'><h6>" . $partner->getVat() . "</h6></div></div>"
    . "<div class='row bg-secondary border-bottom border-dark p-2'><div class='col border-right border-dark'><h4>Department</h4></div><div class='col'><h4>Post</h4></div></div>"
    . "<div class='row border-bottom border-dark p-2'><div class='col centerCol'><h6>" . $partner->getDepartment() . "</h6></div><div class='col centerCol'><h6>" . $partner->getPost() . "</h6></div></div>"
    . "<div class='row bg-secondary border-bottom border-dark p-2'><div class='col border-right border-dark'><h4>Institution</h4></div><div class='col'><h4>Country</h4></div></div>"
    . "<div class='row p-2'><div class='col centerCol'><h6>" . $partner->getInstitution()->getName() . "</h6></div><div class='col centerCol'><h6>" . $partner->getCountry()->getName() . "</h6></div></div>"
    . "</div></div>"
    . "<div class='row mb-3 mb-lg-5 justify-content-center '>"
    . "<div class='col col-sm-6 col-md-4 col-lg-3 btn-group my-2 my-md-3'><a class='btn btn-secondary rounded ml-2 ml-md-3 ml-md-4' href='register.php?id={$_SESSION['user']['id']}' role='button'>Modify profile</button</div></div>"
    . "<div class='col col-sm-6 col-md-4 col-lg-3 btn-group my-2 my-md-3'><a class='btn btn-danger rounded ml-2 ml-md-3 ml-md-4' href='" . $_SERVER['PHP_SELF'] . "?account_deactivate' role='button'>Deactivate account</a></div></div>"
    . "</div></div></div></section>";
}

/**
 * Registers a new petition in the DB. Gets all data to send from a form with POST method.
 */
//IMPORTANT! QUERY NEEDS REWORK!!
function sendPetition() {
    $entityM = load("registered");
    $senderPartner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $date = new \DateTime(date("Y-m-d H:i:s"));
    $role = $entityM->getRepository("MobilitySharp\model\Role")->findOneBy(["type" => "ADMIN"]);
    $subject = filter_input(INPUT_POST, "subject");
    $status = $entityM->getRepository("MobilitySharp\model\Status")->findOneBy(["status" => "REQUESTED"]);


    /*$totalAdminsQuery = $entityM->createQueryBuilder();
    $totalAdminsQuery->select('p.id')
            ->from("MobilitySharp\model\Partner", 'p')
            ->where("p.role=" . $role->getId());

    $totalAdmins = $totalAdminsQuery->getQuery()->getResult();
    $admins = [];
    foreach ($totalAdmins as $admin) {
        array_push($admins, $admin);
    }
    $index = array_rand($admins);

    $adminQuery = $entityM->createQueryBuilder();
    $adminQuery->select('p')
            ->from("MobilitySharp\model\Partner", 'p')
            ->where("p.role=" . $role->getId())
            ->andWhere("p.id=" . $admins[$index]["id"]);

    $receiverPartner = $adminQuery->getQuery()->getSingleResult();*/
    $adminsWithoutPetitionQuery=$entityM->createQueryBuilder();
    $adminsWithoutPetitionQuery->addSelect('p')
            ->from("MobilitySharp\model\Partner",'p')
            ->where("p.role=".$role->getId())
            ->andWhere("p.id NOT IN(SELECT DISTINCT(pe.receiver_partner) FROM MobilitySharp\model\PetitionHistory pe)")
            ->setMaxResults(1);
    $adminWithoutPetition=$adminsWithoutPetitionQuery->getQuery()->getOneOrNullResult();
    if(!is_null($adminWithoutPetition)){
        $receiverPartner=$adminWithoutPetition;
    }else{
        $adminWithLessPetitionsQuery=$entityM->createQueryBuilder();
        $adminWithLessPetitionsQuery->select("pe")
                ->from("MobilitySharp\model\PetitionHistory","pe")
                ->groupBy("pe.receiver_partner")
                ->orderBy("COUNT(pe.receiver_partner)")
                ->setMaxResults(1);
        $adminWithLessPetitions=$adminWithLessPetitionsQuery->getQuery()->getOneOrNullResult();
        $receiverPartner=$adminWithLessPetitions->getReceiver_partner();
    }

    $newPetition = new \MobilitySharp\model\PetitionHistory(ucfirst($subject), $date, $status, $senderPartner, $receiverPartner);
    if ($description = filter_input(INPUT_POST, "description")) {
        $newPetition->setDescription(ucfirst($description));
    }
    require_once 'sendMail.php';
    if (sendMail($newPetition)) {
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
function findEntity($class, $id) {
    $entityM = load("registered");
    $entity = $entityM->find("MobilitySharp\\model\\" . $class, $id);

    return $entity;
}

/**
 * List partner messages of the sender partner depending of the status type.
 * @param string $type Status type.
 */
function listPartnerMessages($type) {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);


    $queryPetition = $entityM->createQueryBuilder();
    $queryPetition->addSelect('p')
            ->from("MobilitySharp\model\PetitionHistory", 'p')
            ->where("p.sender_partner=" . $partner->getId())
            ->andWhere("p.status=(SELECT s FROM MobilitySharp\model\Status s WHERE s.status='$type')")
            ->orderBy("p.date", "DESC");
    $petitions = $queryPetition->getQuery()->getResult();

    foreach ($petitions as $petition) {

        echo "
            <li class='unread' id='" . $petition->getId() . "'>
		
		<input type='checkbox' class='form-check-input'>
		<span class='date'><span class='fa fa-paper-clip'></span>" . date_format($petition->getDate(), "m-d h:i") . "</span>
		
		<div class='title'>
		
		" . $petition->getSubject() . "
		</div>	
		<div class='description'>
                " . $petition->getDescription() . "
                </div>
			
		</li>
                ";
    }
}

/**
 * Gets number of messages of the sender partner depending of the status type.
 * @param string $type Status type.

 */
function countMessages($type) {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);


    $queryPetition = $entityM->createQueryBuilder();
    $queryPetition->addSelect('COUNT(p)')
            ->from("MobilitySharp\model\PetitionHistory", 'p')
            ->where("p.sender_partner=" . $partner->getId())
            ->andWhere("p.status=(SELECT s FROM MobilitySharp\model\Status s WHERE s.status='$type')");
    $petitions = $queryPetition->getQuery()->getSingleScalarResult();

    if ($petitions != 0) {
        echo $petitions;
    }
}

/**
 * Gets number of messages of the receiver partner depending of the status type.
 * @param string $type Status type.
 */
function countMessagesAdmin($type) {
    $entityM = load("admin");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);


    $queryPetition = $entityM->createQueryBuilder();
    $queryPetition->addSelect('COUNT(p)')
            ->from("MobilitySharp\model\PetitionHistory", 'p')
            ->where("p.receiver_partner=" . $partner->getId())
            ->andWhere("p.status=(SELECT s FROM MobilitySharp\model\Status s WHERE s.status='$type')");
    $petitions = $queryPetition->getQuery()->getSingleScalarResult();

    if ($petitions != 0) {
        echo $petitions;
    } else {
        return;
    }
}

/**
 * List partner messages of the receiver partner depending of the status type.
 * @param string $type Status type.
 */
function listPartnerMessagesAdmin($type) {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);


    $queryPetition = $entityM->createQueryBuilder();
    $queryPetition->addSelect('p')
            ->from("MobilitySharp\model\PetitionHistory", 'p')
            ->where("p.receiver_partner=" . $partner->getId())
            ->andWhere("p.status=(SELECT s FROM MobilitySharp\model\Status s WHERE s.status='$type')")
            ->orderBy("p.date", "DESC");
    $petitions = $queryPetition->getQuery()->getResult();
    if ($petitions > 0) {
        foreach ($petitions as $petition) {

            echo "<li class='unread' id='" . $petition->getId() . "'>
            
            <input type='checkbox' class='form-check-input'>
            <span class='from'>" . $petition->getSender_partner()->getFull_name() . "</span>
            <span class='date'><span class='fa fa-paper-clip'></span>" . date_format($petition->getDate(), "m-d H:i") . "</span><small> &#60" . $petition->getSender_partner()->getEmail() . "&#62</small>
            
            <div class='title'>
            
            " . $petition->getSubject() . "
            </div>	
            <div class='description'>
                    " . $petition->getDescription() . "
                    </div>
            
            </li>
                    ";
        }
    } else {
        echo "<div class='container-fluid'><section class='container text-center'>"
        . "<div class='row '><div class='col'><h4>Not messages yet</h4></div></div></div></div>";
    }
}
/**
 * Changes petitions status from array of ids and sets the status as petitionStatus parameter.
 * @param array $ids
 * @param string $petitionStatus
 */
function changePetitionStatus($ids, $petitionStatus) {
    $entityM = load("admin");
    $status = $entityM->getRepository("MobilitySharp\model\Status")->findOneBy(["status" => $petitionStatus]);
    foreach ($ids as $id) {
        $petition = $entityM->find("MobilitySharp\model\PetitionHistory", $id);
        $petition->setStatus($status);
    }

    $entityM->flush();
}
/**
 * Modifies the partner which is logged in with parameters received with $_POST
 */
function modifyPartner($id) {
    $entityM = load("registered");
    $partner = $entityM->find("MobilitySharp\model\Partner", $id);
    $email = filter_input(INPUT_POST, "email");
    $username = filter_input(INPUT_POST, "username");
    $repeatedUser = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["username" => $username]);
    $repeatedEmail = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["email" => $email]);
    $country = $entityM->find("MobilitySharp\model\Country", filter_input(INPUT_POST, "country"));
    if ($vat = filter_input(INPUT_POST, "vat")) {
        $repeatedVat = $entityM->getRepository("MobilitySharp\model\Partner")->findOneBy(["vat" => $vat]);
        if (!is_null($repeatedVat)) {
            if ($repeatedVat->getId() == $id) {
                $repeatedVat = null;
            }
        }
    } else {
        $repeatedVat = null;
        $vat = null;
    }
    if (!is_null($repeatedUser)) {
        if ($repeatedUser->getId() == $id) {
            $repeatedUser = null;
        }
    }

    if (!is_null($repeatedEmail)) {
        if ($repeatedEmail->getId() == $id) {
            $repeatedEmail = null;
        }
    }


    if (is_null($repeatedUser) and is_null($repeatedVat) and is_null($repeatedEmail)) {
        $partner->setFull_name(filter_input(INPUT_POST, "fName") . " " . filter_input(INPUT_POST, "lName"));
        $partner->setUsername(filter_input(INPUT_POST, "username"));
        $partner->setVat($vat);
        $partner->setEmail(filter_input(INPUT_POST, "email"));
        $partner->setTelephone(filter_input(INPUT_POST, "phone"));
        $partner->setDepartment(filter_input(INPUT_POST, "department"));
        $partner->setCountry($country);
        $partner->setPost(filter_input(INPUT_POST, "post"));
        $entityM->flush();
    }
}

function modifyStudent($id) {

    $entityM = load("registered");
    $student = $entityM->find("MobilitySharp\model\Student", $id);
    $date = new \DateTime(date("Y-m-d H:i:s"));
    $student->setFull_name(filter_input(INPUT_POST, "fName") . " " . filter_input(INPUT_POST, "lName"));
    $student->setBirth_date(filter_input(INPUT_POST, "birthDate"));
    $vat = filter_input(INPUT_POST, "sVat");
    $repeatedVat = $entityM->getRepository("MobilitySharp\model\Student")->findOneby(["vat" => $vat]);
    if ($repeatedVat == null) {
        $student->setVat($vat);
        $student->setModification_date($date);
        if (filter_input(INPUT_POST, "gender") == "Male") {
            $student->setGender('M');
        } else {
            $student->setGender('F');
        }
        $entityM->flush();
    }
}

function modifyMobility($id, $mobilityType) {

    $entityM = load("registered");

    if ($mobilityType instanceof \MobilitySharp\model\EnterpriseMobility) {
        $enterpriseId = filter_input(INPUT_POST, "enterprise");
        $mobility = $entityM->find("MobilitySharp\model\EnterpriseMobility", $id);
        $mobility->setEnterprise($entityM->find("MobilitySharp\model\Enterprise", $enterpriseId));
    } else {
        $institutionId = filter_input(INPUT_POST, "institution");
        $mobility = $entityM->find("MobilitySharp\model\InstitutionMobility", $id);
        $mobility->setInstitution($entityM->find("MobilitySharp\model\Institution", $institutionId));
    }

    $date = new \DateTime(date("Y-m-d H:i:s"));
    $mobility->setStart_date(filter_input(INPUT_POST, "startDate"));
    $mobility->setEstimated_end_date(filter_input(INPUT_POST, "estimatedEndDate"));
    $mobility->setStudent(filter_input(INPUT_POST, ""));
    $mobility->setModification_date($date);

    $entityM->flush();
}
/**
 * Sets the user which is logged in as inactive setting his termination date
 * and clears the session login out
 */
function deleteUser() {
    $entityM = load("registered");
    $user = $entityM->find("MobilitySharp\model\Partner", $_SESSION["user"]["id"]);
    $user->setTermination_date(new \DateTime(date("Y-m-d")));
    $entityM->flush();

    header("Location: logout.php");
}


