<?php

use yii\helpers\Html;
use app\models\Places;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Orders $model */

$places = Places::find()->select(['id', 'place'])->all();

?>
<div class="orders-create">
    <div class="container">
        <p class="order__title">Оформление заказа</p>
        <div class="order">
            <div class="order__details">
                <p class="order__details__title">Способ получения</p>
                <p class="order__details__place order__details__title">В пункте выдачи</p>
                <?php $form = ActiveForm::begin(['action' => ['orders/create']]); ?>

                <?= $form->field($model, 'places_id')->dropDownList(
                    ArrayHelper::map($places, 'id', 'place'), 
                    ['prompt'=>'Выберите пункт выдачи'] 
                ) ?>

                <?= $form->field($model, 'date')->textInput(['type' => 'date']) ?>

                <div class="form-group">
                    <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
                </div>
                
                <?php ActiveForm::end(); ?>
                
            </div>
        </div>
    </div>
</div>
