<?php

function load($user) {
    $global = parse_ini_file("db-global.ini");
    $account = parse_ini_file("db-$user.ini");
    $pdo = new PDO("mysql:host=$global[host];dbname=$global[dbname];charset=$global[charset]", $account['username'], $account['password'] ?? NULL);
    
    if($global['debug'] && $global['debug'] === "true") {
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    return $pdo;
}

function checkUser($username, $password) {
    if($pdo = load("login")) {
        $stmt = $pdo->prepare('SELECT usuario, email, `password` FROM socios WHERE lower(usuario)=:username OR lower(email)=:username');
        $stmt->execute([':username' => strtolower($username)]);
    
    
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($user !== FALSE) {
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
    
    }
    return FALSE;
}

function getCountries() {
    if($pdo = load("login")) {
        $stmt = $pdo->query("SELECT ID_PAIS as id, nombre  FROM PAISES");
        $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($countries as $country) {
            echo "<option value='$country[id]'>$country[nombre]</option>";
        }
    }
}


function getInstitutionTypes(){
    if($pdo = load("login")) {
        $stmt = $pdo->query("SELECT ID_TIPO_INSTITUCION, TIPO FROM TIPOS_INSTITUCION;");
        $insTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($insTypes as $type){
            echo "<option value='$type[ID_TIPO_INSTITUCION]]'>$type[TIPO]</option>";
        }
    }
}



function registerPartnerInstitution(){
    if($pdo = load("login")) {
        try {
            $name = $_POST["fName"]." ".$_POST["lName"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $username = $_POST["username"];
            $password = $_POST["password"];
            $vat = ($_POST["vat"]) ? $_POST["vat"] : NULL;
            $post = $_POST["post"];
            $department = $_POST["department"];
            $l_provider = 0; //not a provider
            $rol = 2; // registered user
            $country = $_POST["country"];
            
            
            $iName = $_POST["iName"];
            $iEmail = $_POST["iEmail"];
            $iPhone = $_POST["iPhone"];
            $iVat = $_POST["iVat"];
            $postalCode = $_POST["postalCode"];
            $iLocation = $_POST["location"];
            $web = $_POST["web"];
            $description = $_POST["description"];
            $institutionType = $_POST["institutionType"];
            
            $query = $pdo->query("SELECT ID_INSTITUCION FROM INSTITUCIONES WHERE NOMBRE='$iName'")->fetch(PDO::FETCH_ASSOC); //check if the institution already exists
            $location = "Location: $_SERVER[PHP_SELF]?error"; //Redirects to self and flags an error by default

            $partnerParams = [
                ':name' => $name,
                ':email' => $email,
                ':phone' => $phone,
                ':username' => $username,
                ':password' => password_hash($password, PASSWORD_DEFAULT),
                ':vat' => $vat,
                ':post' => $post,
                ':department' => $department,
                ':l_provider' => $l_provider,
                ':rol' => $rol,
                ':country' => $country
            ];
            
            $institutionParams = [
                ':iName' => $iName,
                ':iEmail' => $iEmail,
                ':iPhone' => $iPhone,
                ':postalCode' => $postalCode,
                ':iLocation' => $iLocation,
                ':iVat' => $iVat,
                ':web' => $web,
                ':description' => $description,
                ':institutionType' => $institutionType,
                ':country' => $country
            ];
            
            if(!$query){

                $pdo->beginTransaction();
                $stmt = $pdo->prepare("INSERT INTO SOCIOS (NOMBRE_COMPLETO,EMAIL,TELEFONO,USUARIO,PASSWORD,VAT,CARGO,DEPARTAMENTO,R_ALOJAMIENTO,ROL,PAIS)"
                        . "VALUES (:name, :email, :phone, :username, :password, :vat, :post, :department, :l_provider, :rol, :country);");
                
                if($stmt->execute($partnerParams)) {
                    $stmt = $pdo->prepare("INSERT INTO INSTITUCIONES (VAT,NOMBRE,EMAIL,TELEFONO,CODIGO_POSTAL,DIRECCION,WEB,PAIS,SOCIO,TIPO,DESCRIPCION)"
                            . "VALUES (:iVat, :iName, :iEmail, :iPhone, :postalCode, :iLocation, :web, :country, :partner, :institutionType, :description);");
                    
                    //Adds the partner ID to the institution params before insertion.
                    $institutionParams['partner'] = $pdo->lastInsertId();

                    if($stmt->execute($institutionParams)) {
                        $pdo->exec("UPDATE SOCIOS SET INSTITUCION=".$pdo->lastInsertId()." WHERE EMAIL='$email'");
                        
                        if($pdo->commit()) {
                            sessionStoreUser($partnerParams);
                            $location = "Location:index.php?registered";
                        }
                    } else {
                        $pdo->rollBack();
                    }
                }
            } else {
                $partnerParams[':institution'] = $query["ID_INSTITUCION"]; 
                $stmt = $pdo->prepare("INSERT INTO SOCIOS (NOMBRE_COMPLETO,EMAIL,TELEFONO,USUARIO,PASSWORD,VAT,CARGO,DEPARTAMENTO,R_ALOJAMIENTO,ROL,PAIS,INSTITUCION)"
                    . "VALUES (:name, :email, :phone, :username, :password, :vat, :post, :department, :l_provider, :rol, :country, :institution);");
                if($stmt->execute($partnerParams)) {
                    sessionStoreUser($partnerParams);
                    $location = "Location:index.php?registered";
                }
            }

            header($location);
    
        }catch(Exception $e){
            $pdo->rollBack();
            header($location);
        }
    
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