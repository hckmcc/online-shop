<?php

$errors = [];

//validate name
if (isset($_POST["name"])){
    $name = $_POST["name"];
    if (strlen($name)>50){
        $errors['name'] = 'Name must contain less than 50 symbols';
    }
}else{
    $errors['name'] = 'Enter name';
};

//validate email
if (isset($_POST["email"])){
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Incorrect email!';
    };
}else{
    $errors['email'] = 'Enter email';
};

//validate password
if (isset($_POST["psw"])) {
    $password = $_POST["psw"];
    $pwd_validation = preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password);
    if (!$pwd_validation) {
        $errors['psw'] = 'Incorrect password';
    };
    $passwordRep = $_POST["rpt_psw"];
    if ($password !== $passwordRep) {
        $errors['psw_rpt'] = 'Passwords don\'t match!';
    };
}else{
    $errors['psw'] = 'Enter password';
};

if (empty($errors)) {
    $hash = password_hash($password, PASSWORD_DEFAULT);

    $pdo= new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
    $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(['email' => $email]);
    print_r($stmt->fetchAll());
}else{
    require_once './get_registration.php';
    };