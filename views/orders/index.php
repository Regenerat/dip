<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;

/** @var yii\web\View $this */
/** @var app\models\OrdersSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

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

<div class="orders-index">
    <div class="container">
        <?php
        // Сохраняем уникальные group_id
        $uniqueGroupIds = [];
        foreach ($dataProvider->getModels() as $model) {
            if (!in_array($model->group_id, $uniqueGroupIds)) {
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

<!-- Модальное окно -->
<div class="modal fade" id="group-modal" tabindex="-1" role="dialog" aria-labelledby="groupModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- Здесь будет выводиться подробная информация -->
        </div>
    </div>
</div>
