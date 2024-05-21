<?php

use app\models\Status;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

$newBooks = \app\models\Books::find()
    ->where(['status_id' => Status::NEW_STATUS])
    ->all();

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
?>
<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide1.png" alt="1" class="d-block w100">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide2.png" alt="2" class="d-block w100">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-3">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide3.png" alt="1" class="d-block w100">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide3.png" alt="2" class="d-block w100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="new__books">
        <div class="container">
            <p class="new__books__title">Новинки</p>
            <div class="row">
                <?php foreach ($newBooks as $book): ?>
                    <div class="book_item">
                        <div class="thumbnail">
                            <?= Html::img('../../' . $book->image, ['alt' => $book->title, 'class' => 'img-responsive']) ?>
                            <div class="caption">
                                <p class="book__title"><?= Html::encode($book->title) ?></p>
                                <p class="book__author"><?= Html::encode($book->author->mName. ' ' . mb_substr($book->author->fName, 0, 1). '.' . mb_substr($book->author->lName, 0, 1).'.') ?></p>
                                <div class=" buy__block">
                                    <span class="book__price"><?= Html::encode($book->price) ?><small>₽</small></span>
                                    
                                    <?= Html::a('Купить', '#', [
                                        'class' => 'btn buy__btn',
                                        'data-id' => $book->id,
                                        'onclick' => '
                                            $.ajax({
                                                url: "' . Url::to(['cart/update', 'id' => $book->id]) . '",
                                                type: "post",
                                                success: function(data) {
                                                    console.log("Ответ сервера: " + data);
                                                    if (data === "success") {
                                                        alert("Книга успешно добавлена в корзину");
                                                    } else if (data === "already_exists") {
                                                        alert("Книга уже в корзине");
                                                    } else if (data === "Пожалуйста, войдите, чтобы добавить книгу в корзину") {
                                                        alert(data);
                                                        window.location.href = "' . Url::to(['site/login']) . '"; // Перенаправление на страницу входа
                                                    } else {
                                                        alert("Произошла ошибка при добавлении книги в корзину");
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error("Ошибка AJAX-запроса: " + status + ", " + error);
                                                    alert("Произошла ошибка при добавлении книги в корзину");
                                                }
                                            });
                                            return false;
                                    ']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
</div>

