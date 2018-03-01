<?php
/**
 * ConfigForm
 */
namespace app\models;

use yii\base\Model;
use Yii;

/**
 * This is the model class for table "ConfigForm".
 *
 * @property string $option_id
 * @property string $name
 * @property string $value
 */
class ConfigForm extends Model
{    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // stx and sfld are both required
            [['stx'], 'required'],
            [['sfld', 'isOr'], 'string'],
            [['stx'], 'string', 'min' => 2, 'max'=>100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'option_id' => Yii::t('app', 'Option ID'),
            'name' => Yii::t('app', 'Option Name'),
            'value' => Yii::t('app', 'Option Value'),
        ];
    }
}
