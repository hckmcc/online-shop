<?php
namespace Model;
class User extends Model
{
    public function getUserById(int $id): array|false
    {
        $stmt = $this->pdo->prepare('SELECT * FROM users WHERE id= :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
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