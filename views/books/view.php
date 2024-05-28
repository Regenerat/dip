<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Books $model */

$this->title = $model->title;

$view = Url::to(['books/view']);

// Регистрируем все CSS и JS файлы
// Регистрируем все CSS и JS файлы

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js', ['position' => \yii\web\View::POS_END]);

// Регистрация JS кода для обработки кликов по кнопкам "Купить"
$this->registerJs(<<<JS
$(document).on('click', '.page__buy__btn', function() {
    var bookId = $(this).data('id');
    $.ajax({
        url: "../cart/update?id=" + bookId,
        type: "post",
        success: function(data) {
            console.log("Ответ сервера: " + data);
            if (data === "success") {
                $('#successModal').modal('show');
            } else if (data === "already_exists") {
                $('#existsModal').modal('show');
            } else if (data === "Пожалуйста, войдите, чтобы добавить книгу в корзину") {
                alert(data);
                window.location.href = "site/login";
            } 
            else {
                $('#errorModal').modal('show');
            }
        },
        error: function(xhr, status, error) {
            console.error("Ошибка AJAX-запроса: " + status + ", " + error);
            $('#errorModal').modal('show');
        }
    });
    return false;
});
JS
, \yii\web\View::POS_READY);
?>
<div class="books-view">
    <div class="container">
        <p class="page__title"><?= Html::encode($model->title) ?></p>
        <p class="page__author"><?= Html::encode($model->author->fName . ' ' . $model->author->mName) ?></p>

        <div class="row mt-5">
            <div class="col-lg-3">
                <div class="page__info">
                    <?= Html::img('../../' . $model->image, [
                        'alt' => $model->title, 
                        'class' => 'page__img',
                        'style' => 'cursor: pointer;'
                    ]) ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="page__info-annotation">
                    <p class="page__annotation">
                        Аннотация
                    </p>
                    <p class="page__description">
                        <?php
                            $text = str_replace('\n', "\n", $model->description);
                        ?>
                        <?= nl2br(Html::encode($text)) ?>
                    </p>
                    <a href="#description" class="btn btn-primary btn__mb">Полное описание</a>
                    <div class="page__feature">
                        <p class="page__feature__title">Издательство</p>
                        <p class="page__feature__name"><?= Html::encode($model->publisher->name) ?></p>
                    </div>
                    <div class="page__feature">
                        <p class="page__feature__title">Год, тираж</p>
                        <p class="page__feature__name"><?= Html::encode($model->publicationYear) ?></p>
                    </div>
                    
                </div>
                
            </div>
            <div class="col-lg-3">
                <div class="page__buy">
                    <p><?= Html::encode($model->price) ?><small>₽</small></p>
                    <div class="page__buy__quantity">
                        <?php
                            if($model->stockQuantity > 0) {    
                                echo Html::img('../web/images/check_mark.svg', [
                                    'class' => 'page__img',
                                    'style' => 'cursor: pointer;'
                                ]);
                                echo '<p class="page__buy__quantity__check">В наличии</p>';
                            }
                            else{
                                echo Html::img('../web/images/cross.svg', [
                                    'class' => 'page__img',
                                    'style' => 'cursor: pointer;'
                                ]);
                                echo '<p class="page__buy__quantity__check">Нет в наличии</p>';
                            }
                        ?>
                    </div>
                    <div class="page__buy__buy-btn">
                    <?= Html::a('Купить', '#', [
                        'class' => 'btn page__buy__btn',
                        'data-id' => $model->id,
                    ]) ?>
                    </div>
                </div>
                <div class="page__buy">
                    <p class="buy__order">КАК ПОЛУЧИТЬ ЗАКАЗ</p>
                    <div class="p">А ни как</div>
                </>
            </div>
        
        </div>

        <p class="description__title">Описание</p>

        <div id="description">
            <p class="description">
                <?php
                    $text = str_replace('\n', "\n", $model->description);
                ?>
                <?= nl2br(Html::encode($text)) ?>
            </p>
        </div>
    
    
        
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade modal-no-backdrop" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel">Успех</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Книга успешно добавлена в корзину.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Already Exists Modal -->
<div class="modal fade modal-no-backdrop" id="existsModal" tabindex="-1" aria-labelledby="existsModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="existsModalLabel">Внимание</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Книга уже в корзине.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<!-- Error Modal -->
<div class="modal fade modal-no-backdrop" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="errorModalLabel">Ошибка</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Произошла ошибка при добавлении книги в корзину.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
