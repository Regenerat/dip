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
use yii\web\Response;

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

        // Проверяем, существует ли запись в корзине для данного пользователя и книги
        $cartItem = Cart::findOne(['user_id' => $userId, 'book_id' => $id]);

        if (!$cartItem) {
            // Создаем новую запись в корзине
            $cartItem = new Cart();
            $cartItem->user_id = $userId;
            $cartItem->book_id = $id;
            $cartItem->count = 1;

            if ($cartItem->save()) {
                // Возвращаем сообщение об успешном добавлении книги в корзину
                return 'success';
            } else {
                // Если сохранение не удалось, возвращаем сообщение об ошибке
                return 'error';
            }
        } else {
            // Если запись уже существует, возвращаем сообщение о том, что книга уже в корзине
            return 'already_exists';
        }
    }

    // Если запрос не является POST-запросом, выдаем ошибку о неверном запросе
    throw new BadRequestHttpException('Неверный запрос');
}

public function actionCountUpdate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            $id = Yii::$app->request->post('id');
            $action = Yii::$app->request->post('action');

            if (!$id || !$action) {
                throw new \Exception('Invalid parameters');
            }

            $model = Cart::findOne($id);

            if (!$model) {
                throw new \Exception('Model not found');
            }

            if ($action == 'increase') {
                $model->count += 1;
            } elseif ($action == 'decrease') {
                if ($model->count > 1) {
                    $model->count -= 1;
                } else {
                    throw new \Exception('Cannot decrease quantity below 1');
                }
            }

            if (!$model->save()) {
                throw new \Exception('Failed to save model');
            }

            // Обновление общей суммы и количества товаров
            $userId = Yii::$app->user->identity->id;
            $cartItems = Cart::find()->where(['user_id' => $userId])->all();
            $totalCount = 0;
            $totalSum = 0;

            foreach ($cartItems as $item) {
                $totalCount += $item->count;
                $totalSum += $item->count * $item->book->price;
            }

            // Определение правильного окончания для слова "товар"
            $cnt = "товаров";
            if ($totalCount == 1) {
                $cnt = "товар";
            } elseif ($totalCount >= 2 && $totalCount <= 4) {
                $cnt = "товара";
            }

            return [
                'count' => $model->count,
                'totalCount' => $totalCount,
                'totalSum' => $totalSum,
                'countLabel' => $cnt
            ];
        } catch (\Exception $e) {
            Yii::error($e->getMessage(), __METHOD__);
            return [
                'error' => $e->getMessage()
            ];
        }
    }


    /**
     * Deletes an existing Cart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
    
        Yii::debug('Получен запрос на удаление элемента с id: ' . $id);
    
        if (!$id) {
            Yii::debug('Параметр id отсутствует или пуст');
            return ['success' => false, 'error' => 'Параметр id отсутствует или пуст'];
        }
    
        $model = $this->findModel($id); // Найдем модель по переданному $id
        if ($model !== null) {
            Yii::debug('Найдена модель для удаления');
            $model->delete(); // Удаляем найденную модель
            return ['success' => true];
        } else {
            Yii::debug('Не удалось найти модель для удаления');
            return ['success' => false, 'error' => 'Не удалось найти запись для удаления.'];
        }
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
