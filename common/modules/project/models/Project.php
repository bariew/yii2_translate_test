<?php
/**
 * Project class file
 */
 
namespace common\modules\project\models;

use Yii;

/**
 * This is the model class for table "{{%project}}".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $created_at
 *
 * @property Translator[] $translators
 * @property ProjectToTranslator[] $projectToTranslators
 */
class Project extends \yii\db\ActiveRecord
{
    public $translatorIds;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description'], 'default', 'value' => null],
            [['description'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['translators'], 'safe']
        ];
    }

    /**
     * @inheritDoc
     */
    public function extraFields()
    {
        return ['translators',];
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->translatorIds)) {
            ProjectToTranslator::deleteAll(['AND', ['project_id' => $this->id], ['NOT IN', 'translator_id', $this->translatorIds]]);
            foreach ($this->translatorIds as $translatorId) {
                ProjectToTranslator::create($this->id, $translatorId)->save();
            };
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('project', 'ID'),
            'title' => Yii::t('project', 'Title'),
            'description' => Yii::t('project', 'Description'),
            'created_at' => Yii::t('project', 'Created At'),
        ];
    }

    // RELATIONS

    /**
     * Gets query for [[Translators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTranslators()
    {
        return $this->translatorIds ?? $this->hasMany(Translator::class, ['id' => 'translator_id'])->via('projectToTranslators')->alias('translators');
    }

    /**
     * Saving post for further process
     * @param $v
     */
    public function setTranslators($v)
    {
        $this->translatorIds = array_map(function ($w) { return $w['id'] ?? $w; }, array_filter((array) $v));
    }

    /**
     * Gets query for [[ProjectToTranslators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectToTranslators()
    {
        return $this->hasMany(ProjectToTranslator::class, ['project_id' => 'id'])->alias('projectToTranslators');
    }

}
