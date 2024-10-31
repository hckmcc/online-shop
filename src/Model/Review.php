<?php

namespace Model;

class Review extends Model
{
    private int $id;
    private string $userName;
    private int $productId;
    private int $rating;
    private string $text;
    public static function addReview(int $userId, int $productId, int $rating, string $reviewText): void
    {
        $stmt = self::getPDO()->prepare("INSERT INTO reviews (user_id, product_id, rating, review_text) VALUES (:user_id, :product_id, :rating, :review_text)");
        $stmt->execute(['user_id' => $userId, 'product_id' => $productId, 'rating' => $rating, 'review_text' => $reviewText]);
    }
    public static function getReviews(int $productId): ?array
    {
        $stmt = self::getPDO()->prepare("SELECT r.id, u.name, r.product_id, r.rating, r.review_text FROM reviews r JOIN users u ON r.user_id=u.id WHERE product_id = :product_id ORDER BY r.id DESC");
        $stmt->execute(['product_id' => $productId]);
        $stmt = $stmt->fetchAll();
        if(empty($stmt)){
            return null;
        }
        foreach ($stmt as $review) {
            $reviewObj = new self();
            $reviewObj->setProperties($review);
            $reviews[]=$reviewObj;
        }
        return $reviews;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function getText(): string
    {
        return $this->text;
    }
    public function setProperties(array $review): void
    {
        $this->id = $review['id'];
        $this->userName = $review['name'];
        $this->productId = $review['product_id'];
        $this->rating = $review['rating'];
        $this->text = $review['review_text'];
    }
}