<?php

namespace app\controllers;

use app\models\Cart;
use app\models\CartSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Yii;
use yii\web\BadRequestHttpException;

/**
 * CartController implements the CRUD actions for Cart model.
 */
class CartController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Cart models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new CartSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Cart model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Cart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Cart();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Cart model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        if (Yii::$app->request->isPost) {
            $userId = Yii::$app->user->id;

            if ($userId === null) {
                return 'Пожалуйста, войдите, чтобы добавить книгу в корзину';
            }

            // Логирование для отладки
            Yii::info("actionUpdate вызван с id: $id, userId: $userId", __METHOD__);

            // Проверка существования записи
            $cartItem = Cart::findOne(['user_id' => $userId, 'book_id' => $id]);

            if (!$cartItem) {
                // Создаем новую запись, если ее нет
                $cartItem = new Cart();
                $cartItem->user_id = $userId;
                $cartItem->book_id = $id;

                // Отладка: выводим содержимое модели перед сохранением
                VarDumper::dump($cartItem);
                Yii::info("Содержимое модели Cart перед сохранением: " . VarDumper::dumpAsString($cartItem), __METHOD__);

                if ($cartItem->save()) {
                    Yii::info("Запись добавлена в корзину: user_id=$userId, book_id=$id", __METHOD__);
                    return 'success';
                } else {
                    Yii::error("Ошибка сохранения записи: " . print_r($cartItem->errors, true), __METHOD__);
                    return 'error';
                }
            } else {
                return 'already_exists';
            }
        }

        throw new BadRequestHttpException('Неверный запрос');
    }

    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Cart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Cart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Cart::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
