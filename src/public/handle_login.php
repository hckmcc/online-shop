<?php
$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');

$userService = new UserService($pdo, $_POST['email'], $_POST['psw']);
if ($user_id = $userService->login()) {
    echo 'Logged it as user id: '.$user_id;
    $userData = $userService->getUser();
    // do stuff
} else {
    echo 'Invalid login';
}
?>