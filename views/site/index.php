<?php

use yii\bootstrap5\Html;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';
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
</div>
