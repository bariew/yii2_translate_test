<?php
/**
 * TranslatorController class file
 */


namespace frontend\modules\project\controllers;

use common\modules\project\models\Translator;
use frontend\modules\project\models\TranslatorSearch;
use yii\rest\ActiveController;

/**
 * Class TranslatorController
 * @package frontend\modules\project\controllers
 */
class TranslatorController extends ActiveController
{
    public $modelClass = Translator::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge([
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

    /**
     * @inheritDoc
     */
    public function actions()
    {
        return array_merge_recursive(parent::actions(), [
            'index' => [
                'dataFilter' => [
                    'class' => 'yii\data\ActiveDataFilter',
                    'searchModel' => TranslatorSearch::class,
                ],
            ]
        ]);
    }

    /**
     * Translators Available for current project
     * @param $project_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public function actionList($project_id)
    {
        /**
         * SELECT `t`.* FROM `project_translator` `t`
         *      LEFT JOIN `project_to_translator` `projectToTranslators ON `t`.`id` = `projectToTranslators`.`translator_id`
         *      LEFT JOIN `project` `projects` ON `projectToTranslators`.`project_id` = `projects`.`id`
         *      WHERE ((`projects`.`id`='1') OR (projects.id IS NULL)) AND (`availability` != 0)
         *      GROUP BY `t`.`id`
         *      ORDER BY `t`.`availability`, `t`.`name`
         */
        return TranslatorSearch::find()->alias('t')->joinWith('projects')->groupBy('t.id')
            ->orderBy(['t.availability' => SORT_ASC, 't.name' => SORT_ASC])
            ->andWhere(['OR', ['projects.id' => $project_id], 'projects.id IS NULL'])
            ->andWhere(['!=', 'availability', Translator::AVAILABILITY_NONE])
            ->all();
    }

    /**
     * @return array
     */
    public function actionAvailabilityList()
    {
        return TranslatorSearch::availabilityList();
    }
}