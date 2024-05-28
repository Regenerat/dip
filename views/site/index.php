<?php

use app\models\Status;
use yii\bootstrap5\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'My Yii Application';

$view = Url::to(['books/view']);

// Регистрируем все CSS и JS файлы

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js', ['position' => \yii\web\View::POS_END]);

// Регистрация JS кода для обработки кликов по кнопкам "Купить"
$this->registerJs(<<<JS
$(document).on('click', '.buy__btn', function() {
    var bookId = $(this).data('id');
    $.ajax({
        url: "cart/update?id=" + bookId,
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

$newBooks = \app\models\Books::find()
    ->where(['status_id' => Status::NEW_STATUS])
    ->all();
?>

<div class="site-index">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide1.png" alt="1" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide2.png" alt="2" class="d-block w-100">
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
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide3.png" alt="1" class="d-block w-100">
                        </div>
                        <div class="carousel-item">
                            <img src="<?= Yii::$app->urlManager->baseUrl ?>/images/home_slider/slide3.png" alt="2" class="d-block w-100">
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
                        <?= Html::a(Html::img('../../' . $book->image, [
                            'alt' => $book->title, 
                            'class' => 'img-responsive',
                            'style' => 'cursor: pointer;'
                        ]), ['books/view', 'id' => $book->id]) ?>
                            <div class="caption">
                                <p class="book__title"><?= Html::encode($book->title) ?></p>
                                <p class="book__author"><?= Html::encode($book->author->mName . ' ' . mb_substr($book->author->fName, 0, 1) . '.' . mb_substr($book->author->lName, 0, 1) . '.') ?></p>
                                <div class="buy__block">
                                    <span class="book__price"><?= Html::encode($book->price) ?><small>₽</small></span>
                                    
                                    <?= Html::a('Купить', '#', [
                                        'class' => 'btn buy__btn ms-4',
                                        'data-id' => $book->id,
                                        ]) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
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