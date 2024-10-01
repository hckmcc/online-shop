<?php
$errors = [];

//validate email
if (isset($_POST["email"])){
    $email = $_POST["email"];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email!';
    };
}else{
    $errors['email'] = 'Enter email';
};

//validate password
if (isset($_POST["psw"])) {
    $password = $_POST["psw"];
}else{
    $errors['psw'] = 'Enter password';
};
if (empty($errors)) {
    $pdo= new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->execute(['email' => $email]);
    $result=$stmt->fetch(PDO::FETCH_LAZY);
    if (password_verify($password, $result['password'])) {
        print_r($result);
        print_r("Success");
    }else{
        $errors['wrong_psw'] = 'Incorrect email or password!';
        require_once './get_login.php';
    }
}else{
    require_once './get_login.php';
};