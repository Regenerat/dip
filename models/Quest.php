<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;
use yii\helpers\VarDumper;

/**
 * This is the model class for table "quest".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string $email
 * @property int $age
 * @property string $sex
 * @property string $number
 * @property string $country
 * @property string $city
 * @property int $size
 */
class Quest extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile
     */
    public $imageFile;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'quest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'email', 'sex', 'number'], 'required', 'message' => 'поле должно быть заполнено!'],
            [['image'], 'file', 'extensions' => 'png, jpg'],
            [['name', 'surname'], 'string', 'min' => 2, 'max' => 25],
            ['size', 'integer', 'min' => 35, 'max' => 100, 'message' => 'размер не может быть меньше 35 или больше 100'],
            ['age', 'integer'],
            ['email', 'email', 'message' => 'почта введена неправильно'],
            [['sex'], 'string'],
            [['number'], 'string', 'min' => 11, 'max' => 11, 'message' => 'телефон должен содержать 11 символов'],
            [['country', 'city'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'email' => 'Email',
            'age' => 'Age',
            'sex' => 'Sex',
            'number' => 'Number',
            'country' => 'Country',
            'city' => 'City',
            'size' => 'Size',
        ];
    }

    public function upload()
    {
            $this->image->saveAs("../uploads/{$this->image->baseName}.{$this->image->extension}");
            return true;
    }
}
