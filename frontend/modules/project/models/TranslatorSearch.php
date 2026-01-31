<?php
/**
 * Translator class file
 */

namespace frontend\modules\project\models;

/**
 * Class Translator
 * @package frontend\modules\project\models
 */
class TranslatorSearch extends \common\modules\project\models\Translator
{
    /**
     * @inheritDoc
     */
    public function rules()
    {
        return [[$this->attributes(), 'safe']];
    }

}