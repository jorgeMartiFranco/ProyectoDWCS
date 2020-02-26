<?php
function checkUser($username, $password) {
    $params = parse_ini_file("db.ini");
    $pdo = new PDO("mysql:host=$params[host];dbname=$params[dbname];charset=$params[charset]","$params[username]");
    $stmt = $pdo->prepare('SELECT usuario, email, `password` FROM socios WHERE lower(usuario)=:username OR lower(email)=:username');
    $stmt->execute([':username' => strtolower($username)]);
    

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if($user !== FALSE) {
        if(password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return FALSE;
}