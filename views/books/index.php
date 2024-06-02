<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\Genre[] $genres */
/** @var app\models\Authors[] $authors */

$this->title = Yii::t('app', 'Books');
$this->params['breadcrumbs'][] = $this->title;

// Путь к вашему CSS файлу
$cssFile = Yii::$app->request->baseUrl . '/css/books.css';

$view = Url::to(['books/view']);

// Регистрируем все CSS и JS файлы

$this->registerJsFile('https://code.jquery.com/jquery-3.6.0.min.js', ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js', ['position' => \yii\web\View::POS_END]);
$this->registerJsFile('https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/js/bootstrap.bundle.min.js', ['position' => \yii\web\View::POS_END]);

// Регистрация JS кода для обработки кликов по кнопкам "Купить"
$this->registerJs(<<<JS
$(document).on('click', '.book__buy__btn', function() {
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
    
// Регистрируем CSS файл
$this->registerCssFile($cssFile);

?>

<div class="books-index">
    <div class="container">
        <div class="row">
            <!-- Фильтры -->
            <div class="col-md-3">
                <div class="sidebar">
                    <h3>Фильтры</h3>
                    <?php $form = ActiveForm::begin([
                        'method' => 'get',
                        'action' => ['books/index'],
                    ]); ?>

                    <div class="form-group">
                        <label for="genre_id">Жанры</label>
                        <?= Html::dropDownList('genre_id', Yii::$app->request->get('genre_id'), 
                            \yii\helpers\ArrayHelper::map($genres, 'id', 'genre'), 
                            ['class' => 'form-control', 'prompt' => 'Выберите жанр']) ?>
                    </div>

                    <div class="form-group">
                        <label for="author_id">Авторы</label>
                        <?= Html::dropDownList('author_id', Yii::$app->request->get('author_id'), 
                            \yii\helpers\ArrayHelper::map($authors, 'id', function($author) {
                                return $author->fName . ' ' . $author->lName;
                            }), 
                            ['class' => 'form-control', 'prompt' => 'Выберите автора']) ?>
                    </div>

                    <div class="form-group">
                        <label for="min_price">Цена (мин)</label>
                        <?= Html::input('number', 'min_price', Yii::$app->request->get('min_price'), ['class' => 'form-control', 'id' => 'min_price']) ?>
                    </div>

                    <div class="form-group">
                        <label for="max_price">Цена (макс)</label>
                        <?= Html::input('number', 'max_price', Yii::$app->request->get('max_price'), ['class' => 'form-control', 'id' => 'max_price']) ?>
                    </div>

                    <div class="form-group">
                        <label for="year">Год публикации</label>
                        <?= Html::input('number', 'year', Yii::$app->request->get('year'), ['class' => 'form-control', 'id' => 'year']) ?>
                    </div>

                    <div class="form-group">
                        <?= Html::submitButton('Применить', ['class' => 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
            <!-- Каталог книг -->
            <div class="col-md-9">
                <div class="">
                    <p class="new__books__title new__title">Каталог</p>
                    <div class="row">
                        <?php foreach ($dataProvider->getModels() as $book): ?>
                            <div class="col-md-4">
                                <div class="new__book_item">
                                    <div class="thumbnail">
                                        <?= Html::a(Html::img('../../' . $book->image, [
                                            'alt' => $book->title, 
                                            'class' => 'img-responsive',
                                            'style' => 'cursor: pointer;'
                                        ]), ['books/view', 'id' => $book->id]) ?>
                                        <div class="caption">
                                            <p class="book__title"><?= Html::encode($book->title) ?></p>
                                            <p class="book__author"><?= Html::encode($book->author->mName . ' ' . Html::encode($book->author->fName) . ' ' . Html::encode($book->author->lName)) ?></p>
                                            <div class="buy__block">
                                                <span class="book__price"><?= Html::encode($book->price) ?><small>₽</small></span>
                                                <?= Html::a('Купить', '#', [
                                                    'class' => 'book__buy__btn ms-4',
                                                    'data-id' => $book->id,
                                                    ]) ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
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
