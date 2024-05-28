<?php

use app\models\Cart;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var app\models\CartSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$newBooks = Cart::find()
    ->where(['user_id' => Yii::$app->user->identity->id])
    ->all();

$sum = 0;
$count = 0;
foreach($newBooks as $book){
    $sum += $book->book->price * $book->count;
    $count += $book->count;
}

// Регистрируем все CSS и JS файлы

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js', ['position' => \yii\web\View::POS_END]);

// Регистрируем JavaScript для обработки удаления записи через AJAX
$deleteUrl = Url::to(['cart/delete']);
$updateUrl = Url::to(['cart/count-update']);

$script = <<< JS
$(document).ready(function() {
    $('.increase-btn').click(function() {
        var id = $(this).data('id');
        updateCount(id, 'increase');
    });

    $('.decrease-btn').click(function() {
        var id = $(this).data('id');
        var currentCount = parseInt($('#item-count-' + id).text());
        if (currentCount > 1) {
            updateCount(id, 'decrease');
        } else {
            showModal('Количество товара не может быть меньше 1');
        }
    });

    $('.delete-btn').click(function() {
        var id = $(this).data('id');
        console.log('ID элемента для удаления:', id); // Добавляем отладочный вывод
        deleteItem(id);
    });

    function deleteItem(id) {
        console.log('Отправка запроса на удаление элемента с id:', id); // Отладочный вывод
        $.ajax({
            url: '$deleteUrl',
            type: 'POST', // Используем метод POST
            data: {
                id: id
            },
            success: function(data) {
                console.log('Ответ от сервера:', data); // Отладочный вывод
                if (data.success) {
                    location.reload();
                } else {
                    showModal(data.error);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showModal('Ошибка при удалении элемента');
                console.error('AJAX Error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }

    function updateCount(id, action) {
        $.ajax({
            url: '$updateUrl',
            type: 'POST',
            data: {
                id: id,
                action: action,
                _csrf: yii.getCsrfToken()
            },
            success: function(data) {
                if (data.error) {
                    showModal(data.error);
                } else {
                    $('#item-count-' + id).text(data.count);
                    $('#cart-count').text('В корзине ' + data.totalCount + ' ' + data.countLabel);
                    $('#cart-sum').text(data.totalSum + '₽');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showModal('Ошибка при обновлении количества');
                console.error('AJAX Error: ' + textStatus + ': ' + errorThrown);
            }
        });
    }

    function showModal(message) {
        $('#cartModalBody').text(message);
        $('#cartModal').modal('show');
    }
});
JS;

$this->registerJs($script);
?>

<div class="cart-index">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
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
                                <button class="decrease-btn cart__button" data-id="<?= $book->id ?>">
                                    <img src="<?= Url::to('@web/images/count/minus.png') ?>" alt="Decrease">
                                </button>
                                <span id="item-count-<?= $book->id ?>"><?= $book->count ?></span>
                                <button class="increase-btn cart__button" data-id="<?= $book->id ?>">
                                    <img src="<?= Url::to('@web/images/count/plus.png') ?>" alt="Increase">
                                </button>
                            </div>
                            <div class="cart__delete">
                                <p class="cart__info__price"><?= Html::encode($book->book->price) ?><small>₽</small></p>
                                <div class="del">
                                    <button class="delete-btn" data-id="<?= $book->id ?>">
                                        <img src="<?= Url::to('@web/images/count/delete.png') ?>" alt="Delete">
                                    </button>
                                    <button class="delete-btn del__text" data-id="<?= $book->id ?>">
                                        Удалить
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart__order__info">
                    <p class="cart__count" id="cart-count">
                        <?= Html::encode("В корзине " . $count) ?>
                        <?php
                            $cnt = "";
                            if($count == 1){
                                $cnt = "товар";
                            }
                            elseif($count >= 2 && $count <=4){
                                $cnt = "товара";
                            }
                            else{
                                $cnt = "товаров";
                            }
                        ?>
                        <?= Html::encode(" " . $cnt) ?>
                    </p>
                    <div class="cart__price__block">
                        <p class="cart__itog">Итого</p>
                        <p class="cart__sum" id="cart-sum"><?= Html::encode($sum) ?><small>₽</small></p>
                    </div>
                    <div class="cart__order_do">
                    <?= Html::a('Оформить заказ', ['orders/create'], ['class' => 'btn btn-primary order__btn']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cartModalLabel">Информация</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cartModalBody">
                <!-- Здесь будет отображаться сообщение -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>