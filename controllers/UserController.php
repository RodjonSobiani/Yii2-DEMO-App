<?php

namespace app\controllers;

use app\models\user;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for user model.
 */
class UserController extends Controller
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
                'access' => [
                    'class' => AccessControl::class,
                    'only' => ['index', 'create', 'admin', 'update', 'view', 'user'],
                    'rules' => [
                        [
                            'allow' => true,
                            'actions' => ['create'],
                            'roles' => ['?'],
                        ],
                        [
                            'allow' => true,
                            'actions' => ['index', 'update', 'admin', 'activate', 'deactivate', 'view', 'user', 'makeadmin', 'makeuser'],
                            'roles' => ['@'],
                            'matchCallback' => function($rule, $action) {
                                return Yii::$app->user->identity->isAdmin();
                            }
                        ],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => user::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdmin()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => user::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single user model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->where(['id_user' => $id])->orderBy('date DESC')
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new user();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/site/login']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = user::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionActivate($id)
    {
        $this->findModel($id)->activate();
        return $this->redirect(['/user']);
    }

    public function actionDeactivate($id)
    {
        $this->findModel($id)->deactivate();
        return $this->redirect(['/user']);
    }

    public function actionMakeadmin($id)
    {
        $this->findModel($id)->makeAdmin();
        return $this->redirect(['/user']);
    }

    public function actionMakeuser($id)
    {
        $this->findModel($id)->makeUser();
        return $this->redirect(['/user']);
    }
}
