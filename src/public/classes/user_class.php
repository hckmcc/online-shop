<?php
class UserService
{
    public function login(PDO $pdo,string $email, string $password): bool|array
    {
        if (empty($email)) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }

        if (empty($password)) {
            $errors['psw'] = 'Enter password';
        }

        if (empty($errors)){
            $stmt = $pdo->prepare('SELECT * FROM users WHERE email= :email');
            $stmt->execute(['email'=>$email]);
            $user = $stmt->fetch();
            if (!empty($user) and password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                return true;
            }else{
                $errors['wrong_psw'] = 'Incorrect email or password!';
            }
        }
        return $errors;
    }
    public function register(PDO $pdo, string $name, string $email, string $password, string $passwordRep): bool|array
    {
        if (empty($name)) {
            $errors['name'] = 'Enter name';
        }elseif(strlen($name)>50){
            $errors['name'] = 'Name must contain less than 50 symbols';
        }

        if (empty($email)) {
            $errors['email'] = 'Enter email';
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $errors['email'] = 'Invalid email!';
        }

        if (empty($password)) {
            $errors['psw'] = 'Enter password';
        }elseif(!preg_match("/^\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$/", $password)){
            $errors['psw'] = 'Incorrect password';
        }

        if ($password !== $passwordRep) {
            $errors['psw_rpt'] = 'Passwords don\'t match!';
        };

        if (empty($errors)) {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute(['name' => $name, 'email' => $email, 'password' => $hash]);
            return true;
        }
        return $errors;
    }
}