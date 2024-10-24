<?php
namespace Model;
class User extends Model
{
    private int $id;
    private string $name;
    private string $email;
    private string $password;

    public static function getUserById(int $id): ?User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE id= :id');
        $stmt->execute(['id' => $id]);
        $stmt = $stmt->fetch();
        if(empty($stmt)){
            return null;
        }
        $userObj = new self();
        $userObj->setProperties($stmt);
        return $userObj;
    }
    public static function getUserByEmail(string $email): ?User
    {
        $stmt = self::getPDO()->prepare('SELECT * FROM users WHERE email= :email');
        $stmt->execute(['email' => $email]);
        $stmt = $stmt->fetch();
        if(empty($stmt)){
            return null;
        }
        $userObj = new self();
        $userObj->setProperties($stmt);
        return $userObj;
    }

    public static function addUserToDB(string $name, string $email, string $password): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute(['name' => $name, 'email' => $email, 'password' => $password]);
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
    private function setProperties(array $stmt): void
    {
        $this->id = $stmt['id'];
        $this->name = $stmt['name'];
        $this->email = $stmt['email'];
        $this->password = $stmt['password'];
    }
}