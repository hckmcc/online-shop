<?php
require_once '../Model/User.php';
class UserService
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function login(): void
    {
        $errors = $this->loginValidation($_POST);

        if (empty($errors)){
            $user = $this->userModel->getUserByEmail($_POST['email']);
            if (!empty($user) and password_verify($_POST['psw'], $user['password'])) {
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
    public function register(): void
    {
        $errors = $this->registerValidation($_POST);
        if (empty($errors)) {
            $hash = password_hash($_POST['psw'], PASSWORD_DEFAULT);
            $this->userModel->addUserToDB($_POST['name'], $_POST['email'], $hash);
            header('Location: /login');
            exit;
        }
        require_once '../View/get_registration.php';
    }
    public function getLoginPage(): void
    {
        require_once '../View/get_login.php';
    }
    public function getRegistrationPage(): void
    {
        require_once '../View/get_registration.php';
    }
    private function loginValidation(array $postData): array
    {
        $errors = [];
        if (empty($postData['email'])) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }
        if (empty($postData['psw'])) {
            $errors['psw'] = 'Enter password';
        }
        return $errors;
    }
    private function registerValidation(array $postData):array
    {
        $errors = [];
        if (empty($postData['name'])) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($postData['name'])>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }
        if (empty($postData['email'])) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($postData['email'], FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }elseif($this->userModel->getUserByEmail($postData['email'])){
            $errors['email'] = 'Email already exists!';
        }
        if (empty($postData['psw'])) {
            $errors['psw'] = 'Enter password';
        }elseif(!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*\d)\S*$/", $postData['psw'])){
            $errors['psw'] = 'Incorrect password';
        }
        if ($postData['psw'] !== $postData['psw_rpt']) {
            $errors['psw_rpt'] = 'Passwords don\'t match!';
        }
        return $errors;
    }
}