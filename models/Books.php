<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $image
 * @property string $title
 * @property int $author_id
 * @property int $publisher_id
 * @property string $publicationYear
 * @property float $price
 * @property int $stockQuantity
 * @property int $status_id
 * @property int $genre_id
 * @property string $description
 *
 * @property Authors $author
 * @property Cart[] $carts
 * @property Genre $genre
 * @property Orders[] $orders
 * @property Publisher $publisher
 * @property Status $status
 */
class Books extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'books';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['image', 'title', 'author_id', 'publisher_id', 'publicationYear', 'price', 'stockQuantity', 'status_id', 'genre_id', 'description'], 'required'],
            [['author_id', 'publisher_id', 'stockQuantity', 'status_id', 'genre_id'], 'integer'],
            [['price'], 'number'],
            [['description'], 'string'],
            [['image', 'title', 'publicationYear'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
            [['genre_id'], 'exist', 'skipOnError' => true, 'targetClass' => Genre::class, 'targetAttribute' => ['genre_id' => 'id']],
            [['publisher_id'], 'exist', 'skipOnError' => true, 'targetClass' => Publisher::class, 'targetAttribute' => ['publisher_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Image',
            'title' => 'Title',
            'author_id' => 'Author ID',
            'publisher_id' => 'Publisher ID',
            'publicationYear' => 'Publication Year',
            'price' => 'Price',
            'stockQuantity' => 'Stock Quantity',
            'status_id' => 'Status ID',
            'genre_id' => 'Genre ID',
            'description' => 'Description',
        ];
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Genre]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGenre()
    {
        return $this->hasOne(Genre::class, ['id' => 'genre_id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Orders::class, ['book_id' => 'id']);
    }

    /**
     * Gets query for [[Publisher]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPublisher()
    {
        return $this->hasOne(Publisher::class, ['id' => 'publisher_id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::class, ['id' => 'status_id']);
    }
}
