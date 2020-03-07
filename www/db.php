<?php

function load($user) {
    $params = parse_ini_file("db-$user.ini");
    $pdo = new PDO("mysql:host=$params[host];dbname=$params[dbname];charset=$params[charset]", "$params[username]");
    return $pdo;
}

function checkUser($username, $password) {
    if($pdo = load("root")) {
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
    if($pdo = load("root")) {
        $stmt = $pdo->query("SELECT ID_PAIS as id, nombre  FROM PAISES");
        $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($countries as $country) {
            echo "<option value='$country[id]'>$country[nombre]</option>";
        }
    }
}


function getInstitutionTypes(){
    if($pdo = load("root")) {
        $stmt = $pdo->query("SELECT ID_TIPO_INSTITUCION, TIPO FROM TIPOS_INSTITUCION;");
        $insTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach($insTypes as $type){
            echo "<option value='$type[ID_TIPO_INSTITUCION]]'>$type[TIPO]</option>";
        }
    }
}



function registerPartnerInstitution(){
    if($pdo = load("root")) {
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

            $params = [
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

            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO SOCIOS (NOMBRE_COMPLETO,EMAIL,TELEFONO,USUARIO,PASSWORD,VAT,CARGO,DEPARTAMENTO,R_ALOJAMIENTO,ROL,PAIS)"
                    . "VALUES (:name, :email, :phone, :username, :password, :vat, :post, :department, :l_provider, :rol, :country);");
            $stmt->execute($params);

            
            $location;
            
            if($pdo->commit()) {
                $user = [
                'usuario' => $params[':username'],
                'email' => $params[':email'],
                'password' => $params[':password']
                ];
            
                $_SESSION['user'] = $user;
            
                $location = "Location:index.php?registered";
            } else {
                $location = "Location: register.php?error";
            }

            header($location);
            
            
        } catch(Exception $e){
            $pdo->rollBack();
            header("Location: register.php?error");
        }
    
    }
}
