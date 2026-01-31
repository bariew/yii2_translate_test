<?php
/**
 * ProjectToTranslator class file
 */

namespace common\modules\project\models;

use Yii;

/**
 * This is the model class for table "{{%project_to_translator}}".
 *
 * @property int $id
 * @property int|null $project_id
 * @property int|null $translator_id
 *
 * @property Project $project
 * @property Translator $translator
 */
class ProjectToTranslator extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_to_translator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'translator_id'], 'default', 'value' => null],
            [['project_id', 'translator_id'], 'integer'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::class, 'targetAttribute' => ['project_id' => 'id']],
            [['translator_id'], 'exist', 'skipOnError' => true, 'targetClass' => Translator::class, 'targetAttribute' => ['translator_id' => 'id']],
            [['project_id', 'translator_id'], 'unique', 'targetAttribute' => ['project_id', 'translator_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('project', 'ID'),
            'project_id' => Yii::t('project', 'Project ID'),
            'translator_id' => Yii::t('project', 'Translator ID'),
        ];
    }

    /**
     * @param $project_id
     * @param $translator_id
     * @return static
     */
    public static function create($project_id, $translator_id)
    {
        $model = new static();
        $model->load(['project_id' => $project_id, 'translator_id' => $translator_id], '');
        return $model;
    }

    /**
     * Gets query for [[Project]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::class, ['id' => 'project_id']);
    }

    /**
     * Gets query for [[Translator]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslator()
    {
        return $this->hasOne(Translator::class, ['id' => 'translator_id']);
    }

}
