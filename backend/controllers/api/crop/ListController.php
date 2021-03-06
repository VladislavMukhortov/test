<?php
declare(strict_types=1);

namespace app\controllers\api\crop;

use Yii;
use yii\rest\Controller;
use yii\helpers\ArrayHelper;
use yii\filters\Cors;
use yii\filters\VerbFilter;
use yii\web\Response;

use app\models\Crops;

/**
 * API
 */
class ListController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors() : array
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    'Origin' => Yii::$app->params['cors.origin'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600
                ],
            ],

            'verbFilter' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['GET', 'POST', 'OPTIONS']
                ]
            ]
        ]);
    }



    /**
     * {@inheritdoc}
     */
    public function beforeAction($action) : bool
    {
        Yii::$app->user->enableSession = false;
        return parent::beforeAction($action);
    }



    /**
     * @inheritdoc
     */
    public function actions() : array
    {
        return [
            'options' => [
                'class' => 'yii\rest\OptionsAction'
            ],
        ];
    }



    /**
     * @return [type] [description]
     */
    public function actionIndex() : Response
    {
        return $this->asJson();
    }



    /**
     * Список культур для доски объявлений
     * @return string
     */
    public function actionMarket() : Response
    {
        $crops = Crops::find()->allArray();

        for ($i = 0, $arr = count($crops); $i < $arr; $i++) {
            $crops[$i]['name'] = Yii::t('app', 'crops.' . $crops[$i]['name']);
        }

        return $this->asJson($crops);
    }

    /**
     * Подробная информация о культуре
     * @return string
     */

    public function actionInfo() : Response
    {   
        $get = Yii::$app->request->get();
        $id = $get['id'];
        $info = Crops::find()
            ->select('name, description, image')
            ->where(["id" => $id])
            ->one();

        $info['name'] = Yii::t('app', 'crops.' . $info['name']);

        return $this->asJson($info);
    }



}
