<?php
/**
 * SearchForm
 */
namespace app\models;

use yii\base\Model;
use Yii;

class SearchForm extends Model
{
    public $stx = "";
    public $sfld = "";
    public $isOr = "";
    
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // stx and sfld are both required
            [['stx'], 'required'],
            [['sfld', 'isOr'], 'string'],
            [['stx'], 'string', 'min' => 1, 'max'=>100],
        ];
    }
}
