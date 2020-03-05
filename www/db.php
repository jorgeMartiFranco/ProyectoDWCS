<?php

function load($user) {

    $params = parse_ini_file("db-$user.ini");
    $pdo = new PDO("mysql:host=$params[host];dbname=$params[dbname];charset=$params[charset]", "$params[username]");
    return $pdo;
}

function checkUser($username, $password) {
    $pdo = load("root");
    $stmt = $pdo->prepare('SELECT usuario, email, `password` FROM socios WHERE lower(usuario)=:username OR lower(email)=:username');
    $stmt->execute([':username' => strtolower($username)]);


    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user !== FALSE) {
        if (password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return FALSE;
}

function getCountries() {
    $pdo = load("root");
    $stmt = $pdo->query("SELECT ID_PAIS as id, nombre  FROM PAISES");
    $countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($countries as $country) {
        echo "<option value='$country[id]'>$country[nombre]</option>";
    }
}


function getInstitutionTypes(){
    $pdo = load("root");
    $stmt = $pdo->query("SELECT ID_TIPO_INSTITUCION, TIPO FROM TIPOS_INSTITUCION;");
    $insTypes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach($insTypes as $type){
        echo "<option value='$type[ID_TIPO_INSTITUCION]]'>$type[TIPO]</option>";
        
    }
    
}



function registerPartnerInstitution(){
    
    $pdo = load("root");
    try {
        $name=$_POST["fName"]+$_POST["lName"];
        $pdo->beginTransaction();
        $stmt = $pdo->prepare("INSERT INTO PARTNER (NOMBRE_COMPLETO,EMAIL,TELEFONO,USUARIO,PASSWORD,VAT,CARGO,DEPARTAMENTO,R_ALOJAMIENTO,PAIS)"
                . "VALUES (?,?,?,?,?,?,?,?,?,?);");
        $stmt = $pdo->exec($name,$_POST[""],$_POST[""],$_POST[""],$_POST[""],$_POST[""],$_POST[""],$_POST[""],$_POST[""],$_POST[""]);
        
        
        header("Location:index.php");
        
    }catch(Exception $e){
        
    }
    
    
}
