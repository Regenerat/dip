<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $groupInfo app\models\Orders */
/* @var $booksInGroup app\models\Books[] */

echo '<p><strong>Group ID:</strong> ' . Html::encode($groupInfo->group_id) . '</p>';
echo '<p><strong>Date:</strong> ' . Html::encode($groupInfo->date) . '</p>';
echo '<p><strong>User ID:</strong> ' . Html::encode($groupInfo->user_id) . '</p>';

echo '<h3>Books in Group:</h3>';
echo '<ul>';
foreach ($booksInGroup as $book) {
    echo '<li>' . Html::encode($book->title) . '</li>';
    // Дополнительная информация о книге, которую вы хотите отобразить
}
echo '</ul>';
