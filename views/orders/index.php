<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var app\models\User $currentUser */

// Получаем текущего пользователя
$currentUser = Yii::$app->user->identity;

// Регистрируем скрипт, который будет обрабатывать клики на group_id
$this->registerJs(new JsExpression("
    $(document).on('click', '.group-link', function(){
        var groupId = $(this).data('group-id');
        $.ajax({
            type: 'POST', // Используем метод POST
            url: '" . Url::to(['orders/group-details']) . "',
            data: {groupId: groupId},
            success: function(response){
                $('#group-modal .modal-content').html(response);
                $('#group-modal').modal('show');
            }
        });
    });
"));
?>

<div class="container">
    <div class="row">
        <div class="col-md-7">
            <div class="orders-index">
                <?php
                // Сохраняем уникальные group_id для текущего пользователя
                $uniqueGroupIds = [];
                foreach ($dataProvider->getModels() as $model) {
                    if ($model->user_id == $currentUser->id && !in_array($model->group_id, $uniqueGroupIds)) {
                        $uniqueGroupIds[] = $model->group_id;
                    }
                }
                ?>
                <?php
                // Выводим уникальные group_id
                foreach ($uniqueGroupIds as $groupId): ?>
                    <div class="group">
                        <?php
                            echo "Заказ №" . Html::a($groupId, '#', ['class' => 'group-link', 'data' => ['group-id' => $groupId]]);
                            echo "<br>";
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="user-info">
                <h4>Информация о пользователе</h4>
                <p><strong>Логин:</strong> <?= Html::encode($currentUser->login) ?></p>
                <p><strong>Email:</strong> <?= Html::encode($currentUser->email) ?></p>
                <p><strong>Телефон:</strong> <?= Html::encode($currentUser->phone) ?></p>
                <?= Html::beginForm(['site/logout'], 'post') ?>
                    <?= Html::submitButton('Выйти', ['class' => 'btn btn-primary btn-block']) ?>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно -->
<div class="modal fade" id="group-modal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Здесь будет выводиться подробная информация -->
        </div>
    </div>
</div>
