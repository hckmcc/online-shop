<?php
require_once '../Model/projectPDO.php';
class User
{
    private PDO $pdo;
    public function __construct(){
        $pdo= new projectPDO();
        $this->pdo = $pdo->returnPDO();
    }
    public function getUserByEmail(string $email): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE email= :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function addUserToDB(string $name, string $email, string $password): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
}