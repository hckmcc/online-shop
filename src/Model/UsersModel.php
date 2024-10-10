<?php
class UsersModel
{
    public function getUserByEmail(string $email): array|false
    {
        $pdo= $this->createPDO();
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email= :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    public function addUserToDB(string $name, string $email, string $password): void
    {
        $pdo= $this->createPDO();
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }

    private function createPDO(): PDO
    {
        return new PDO('pgsql:host=postgres;port=5432;dbname=mydb','user','pass');
    }
}