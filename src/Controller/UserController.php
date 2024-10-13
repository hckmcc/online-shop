<?php
require_once '../Model/UsersModel.php';
class UserService
{
    public function login(string $email, string $password): void
    {
        $errors = $this->loginValidation($email, $password);

        if (empty($errors)){
            $user_model = new UsersModel();
            $user = $user_model->getUserByEmail($email);
            if (!empty($user) and password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                header('Location: /catalog');
                exit;
            }else{
                $errors['wrong_psw'] = 'Incorrect email or password!';
            }
        }
        require_once '../View/get_login.php';
    }

    public function getLoginPage(): void
    {
        require_once '../View/get_login.php';
    }
    public function register(string $name, string $email, string $password, string $passwordRep): void
    {
        $errors = $this->registerValidation($name, $email, $password, $passwordRep);
        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $user_model = new UsersModel();
            $user_model->addUserToDB($name, $email, $hash);
            header('Location: /login');
            exit;
        }
        require_once '../View/get_registration.php';
    }
    public function getRegistrationPage(): void
    {
        require_once '../View/get_registration.php';
    }
    private function loginValidation(string $email, string $password): array
    {
        $errors = [];
        if (empty($email)) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }
        if (empty($password)) {
            $errors['psw'] = 'Enter password';
        }
        return $errors;
    }
    private function registerValidation(string $name, string $email, string $password, string $passwordRep):array
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($name)>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }
        $user_model = new UsersModel();
        if (empty($email)) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }elseif($user_model->getUserByEmail($email)){
            $errors['email'] = 'Email already exists!';
        }
        if (empty($password)) {
            $errors['psw'] = 'Enter password';
        }elseif(!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*\d)\S*$/", $password)){
            $errors['psw'] = 'Incorrect password';
        }
        if ($password !== $passwordRep) {
            $errors['psw_rpt'] = 'Passwords don\'t match!';
        }
        return $errors;
    }
}