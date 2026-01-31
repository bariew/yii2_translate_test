<?php
/**
 * Translator class file
 */

namespace common\modules\project\models;

use Yii;

/**
 * This is the model class for table "{{%project_translator}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $availability
 *
 * @property ProjectToTranslator[] $projectToTranslators
 * @property Project[] $projects
 */
class Translator extends \yii\db\ActiveRecord
{
    const AVAILABILITY_NONE = 0;
    const AVAILABILITY_WORKING_DAYS = 1;
    const AVAILABILITY_HOLIDAYS = 2;

    public $projectIds;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%project_translator}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'availability'], 'default', 'value' => null],
            [['availability'], 'in', 'range' => array_keys(static::availabilityList())],
            [['name'], 'string', 'max' => 255],
            [['projects'], 'safe']
        ];
    }

    /**
     * @inheritDoc
     */
    public function extraFields()
    {
        return ['projects',];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('project', 'ID'),
            'name' => Yii::t('project', 'Name'),
            'availability' => Yii::t('project', 'Availability'),
        ];
    }

    /**
     * @return array
     */
    public static function availabilityList()
    {
        return [
            static::AVAILABILITY_NONE => Yii::t('project', 'Busy'),
            static::AVAILABILITY_WORKING_DAYS => Yii::t('project', 'Working Days'),
            static::AVAILABILITY_HOLIDAYS => Yii::t('project', 'Holidays'),
        ];
    }

    /**
     * @inheritDoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        if (is_array($this->projectIds)) {
            ProjectToTranslator::deleteAll(['AND', ['translator_id' => $this->id], ['NOT IN', 'project_id', $this->projectIds]]);
            foreach ($this->projectIds as $id) {
                ProjectToTranslator::create($id, $this->id)->save();
            };
        }
        parent::afterSave($insert, $changedAttributes);
    }


    // RELATIONS

    /**
     * Gets query for [[ProjectToTranslators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::class, ['id' => 'project_id'])->alias('projects')->via('projectToTranslators');
    }

    /**
     * Saving post for further process
     * @param $v
     */
    public function setProjects($v)
    {
        $this->projectIds = array_map(function ($w) { return $w['id'] ?? $w; }, array_filter((array) $v));
    }

    /**
     * Gets query for [[ProjectToTranslators]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProjectToTranslators()
    {
        return $this->hasMany(ProjectToTranslator::class, ['translator_id' => 'id'])->alias('projectToTranslators');
    }

}
