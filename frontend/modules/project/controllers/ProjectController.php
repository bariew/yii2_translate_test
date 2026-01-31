<?php
/**
 * ProjectController class file
 */


namespace frontend\modules\project\controllers;


use common\modules\project\models\Project;
use yii\rest\ActiveController;

/**
 * Class ProjectController
 * @package frontend\modules\project\controllers
 */
class ProjectController extends ActiveController
{
    public $modelClass = Project::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge([
            // For cross-domain AJAX request
            'corsFilter'  => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    'Origin' => ['http://localhost:5173'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['Content-Type', 'Authorization', 'X-Requested-With'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                ],
            ],
        ], parent::behaviors());
    }

}