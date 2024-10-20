<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegisterRequest;

require_once '../Model/User.php';
class UserController
{
    private User $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function login(LoginRequest $request): void
    {
        $errors = $request->validation();

        if (empty($errors)){
            $user = $this->userModel->getUserByEmail($request->getEmail());
            if (!is_null($user) and password_verify($request->getPassword(), $user->getPassword())) {
                session_start();
                $_SESSION['user_id'] = $user->getId();
                header('Location: /catalog');
                exit;
            }else{
                $errors['wrong_psw'] = 'Incorrect email or password!';
            }
        }
        require_once '../View/get_login.php';
    }
    public function register(RegisterRequest $request): void
    {
        $errors = $request->validation($this->userModel);
        if (empty($errors)) {
            $hash = password_hash($request->getPassword(), PASSWORD_DEFAULT);
            $this->userModel->addUserToDB($request->getName(), $request->getEmail(), $hash);
            header('Location: /login');
            exit;
        }
        require_once '../View/get_registration.php';
    }
    public function logout(): void
    {
        session_start();
        if(isset($_SESSION['user_id'])){
            unset($_SESSION['user_id']);
        }
        header('Location: /login');
    }
    public function getLoginPage(): void
    {
        require_once '../View/get_login.php';
    }
    public function getRegistrationPage(): void
    {
        require_once '../View/get_registration.php';
    }
}