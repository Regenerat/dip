<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;1,300&display=swap" rel="stylesheet">
    <?php $this->head() ?>
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<main id="main" class="flex-shrink-0" role="main">
    <div class="container">
        <div class="header_inner">
            <a href='/' class="logo">
                <?= Html::img('@web/images/logo.png', ['alt' => 'Логотип', 'class' => 'logo__img']) ?>
            </a>
            <nav class="menu">
                <ul class="menu__list">
                    <li class="menu__item">
                        <a href="/books" class="menu__link">Книги</a>
                    </li>
                    <li class="menu__item">
                        <a href="#" class="menu__link">Печатная продукция</a>
                    </li>
                    <li class="menu__item">
                        <a href="#" class="menu__link">Упаковочные материалы</a>
                    </li>
                    <!-- <li class="menu__item">
                        <a href="#" class="menu__link">что-то</a>
                    </li> -->
                </ul>
            </nav>
            <ul class="user__actions">
                <li class="user__actions__item">
                    <a href='/cart/' class="user__actions__link">
                        <?= Html::img('@web/images/cart.svg', ['class' => 'nav__icons', 'alt' => 'Корзина']) ?>
                    </a>
                </li>
                <li class="user__actions__item">
                    <a href="/site/login/" class="user__actions__link">
                        <?= Html::img('@web/images/user.svg', ['class' => 'nav__icons','alt' => 'Пользователь']) ?>
                    </a>
                </li>
            </ul>   
        </div> 
    </div>
    <?= $content ?>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; My Company <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
