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
 * @property string $publisher
 * @property string $publicationYear
 * @property float $price
 * @property int $stockQuantity
 * @property int $status_id
 *
 * @property Authors $author
 * @property OrderDetails[] $orderDetails
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
            [['image', 'title', 'author_id', 'publisher', 'publicationYear', 'price', 'stockQuantity', 'status_id'], 'required'],
            [['author_id', 'stockQuantity', 'status_id'], 'integer'],
            [['publicationYear'], 'safe'],
            [['price'], 'number'],
            [['image', 'title', 'publisher'], 'string', 'max' => 255],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['status_id'], 'exist', 'skipOnError' => true, 'targetClass' => Status::class, 'targetAttribute' => ['status_id' => 'id']],
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
            'publisher' => 'Publisher',
            'publicationYear' => 'Publication Year',
            'price' => 'Price',
            'stockQuantity' => 'Stock Quantity',
            'status_id' => 'Status ID',
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
     * Gets query for [[OrderDetails]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrderDetails()
    {
        return $this->hasMany(OrderDetails::class, ['book_id' => 'id']);
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
