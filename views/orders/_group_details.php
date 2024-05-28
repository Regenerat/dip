<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $groupInfo app\models\Orders */
/* @var $booksInGroup app\models\Books[] */

echo '<p><strong>Номер закза:</strong> ' . Html::encode($groupInfo->group_id) . '</p>';
echo '<p><strong>Дата  выдачи:</strong> ' . Html::encode($groupInfo->date) . '</p>';

echo '<h3>Заказанные  книги:</h3>';
echo '<ul>';
foreach ($booksInGroup as $book) {
    echo '<li>' . Html::encode($book->title) . '</li>';
    // Дополнительная информация о книге, которую вы хотите отобразить
}
echo '</ul>';
