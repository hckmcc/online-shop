<?php
namespace Controller;
use Model\User;
use Request\LoginRequest;
use Request\RegisterRequest;
use Service\Auth\AuthServiceInterface;

require_once '../Model/User.php';
class UserController
{
    private AuthServiceInterface $authService;

    public function __construct(array $properties)
    {
        $this->authService = $properties['AuthService'];
    }
    public function login(LoginRequest $request): void
    {
        $errors = $request->validation();

        if (empty($errors)){
            if($this->authService->login($request->getEmail(), $request->getPassword())){
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
        $errors = $request->validation();
        if (empty($errors)) {
            $hash = password_hash($request->getPassword(), PASSWORD_DEFAULT);
            User::addUserToDB($request->getName(), $request->getEmail(), $hash);
            header('Location: /login');
            exit;
        }
        require_once '../View/get_registration.php';
    }
    public function logout(): void
    {
        $this->authService->logout();
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