<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Контактная информация';

$this->registerCssFile("@web/css/contact-info.css", ['depends' => [\yii\web\YiiAsset::class]]);
?>

<div class="site-contact-info">
    <div class="container">
    <p>
        Мы всегда рады помочь вам и ответить на все ваши вопросы. Пожалуйста, используйте контактную информацию ниже, чтобы связаться с нами.
    </p>

    <h2>Наши контакты</h2>
    <div class="contact-info">
        <p><strong>Email:</strong> info@rebook.com</p>
        <p><strong>Телефон:</strong> +1 (234) 567-890</p>
        <p><strong>Адрес:</strong> 1234 Книжная улица, Библиотечный город, 56789</p>
    </div>

    <h2>Связаться с нами</h2>
    <p>Вы также можете отправить нам сообщение, используя форму ниже:</p>

    <form>
        <div class="form-group">
            <label for="name">Ваше имя:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="email">Ваш Email:</label>
            <input type="email" id="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="message">Ваше сообщение:</label>
            <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Отправить</button>
        </div>
    </form>
    </div>
</div>
