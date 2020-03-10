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
    $location = "Location: $_SERVER[PHP_SELF]?error"; //Redirects to self and flags an error by default
    if($pdo = load("login")) {
        try {
            $name = filter_input(INPUT_POST, "fName")." ".filter_input(INPUT_POST, "lName");
            $email = filter_input(INPUT_POST, "email");
            $phone = filter_input(INPUT_POST, "phone");
            $username = filter_input(INPUT_POST, "username");
            $password = filter_input(INPUT_POST, "password");
            $vat = (filter_input(INPUT_POST, "vat")) ? filter_input(INPUT_POST, "vat") : NULL;
            $post = filter_input(INPUT_POST, "post");
            $department = filter_input(INPUT_POST, "despartment");
            $l_provider = 0; //not a provider
            $rol = 2; // registered user
            $country = filter_input(INPUT_POST, "country");
            
            
            $iName = filter_input(INPUT_POST, "iName");
            $iEmail = filter_input(INPUT_POST, "iEmail");
            $iPhone = filter_input(INPUT_POST, "iPhone");
            $iVat = (filter_input(INPUT_POST, "iVat")) ? filter_input(INPUT_POST, "iVat") : NULL;
            $postalCode = filter_input(INPUT_POST, "postalCode");
            $iLocation = filter_input(INPUT_POST, "location");
            $web = filter_input(INPUT_POST, "web");
            $description = filter_input(INPUT_POST, "description");
            $institutionType = filter_input(INPUT_POST, "institutionType");
            
            $query = $pdo->query("SELECT ID_INSTITUCION FROM INSTITUCIONES WHERE NOMBRE='$iName'")->fetch(PDO::FETCH_ASSOC); //check if the institution already exists
            

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


function searchInstitutions(){
    
    if($pdo = load("login")) {
        $datos = [':nombre'=> filter_input(INPUT_GET, "nombre")];
        $stmt = $pdo->prepare("SELECT * FROM EMPRESAS WHERE NOMBRE LIKE :nombre;");
        $stmt->execute($datos);
        $results=$stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo $results;
        
    }
    
    }
