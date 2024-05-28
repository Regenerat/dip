<?php

use app\models\Cart;
use app\models\Books;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$newBooks = Cart::find()
    ->where(['user_id' => Yii::$app->user->identity->id])
    ->all();
?>

<div class="cart-index">
    <div class="container">
        <div class="row">
            <div class="col-lg-9">
                <div class="cart__order">
                    <?php foreach ($newBooks as $book): ?>
                        <div class="cart">
                            <div class="cart__image">
                                <?= Html::a(Html::img('../../' . $book->book->image, [
                                    'alt' => $book->book->title, 
                                    'class' => 'img-responsive',
                                    'style' => 'cursor: pointer;'
                                ]), ['books/view', 'id' => $book->book->id]) ?>
                            </div>
                            <div class="cart__info">
                                <p class="cart__title"><?= Html::encode($book->book->title) ?></p>
                                <p class="cart__author"><?= Html::encode($book->book->author->fName) ?><?= Html::encode($book->book->author->mName) ?></p>
                            </div>
                            <div class="cart__price">
                                <?= Html::encode($book->book->price) ?><small>₽</small>
                            </div>
                            
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="cart__order__info">
                    <p class="cart__count"><?= Html::encode(count($newBooks)) ?> товара</p>
                </div>
            </div>
        </div>
        
        
    </div>

</div>
