<?php
namespace app\models;

use Yii;
use yii\base\Model;
use dosamigos\fileupload\FileUpload;
use app\models\Media;

/**
 * File Upload form
 */
class FileUploadForm extends Model
{
        public $upfile;

        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                        [['upfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
                return [
                        'upfile' => Yii::t('app', 'Upfile'),
                ];       
        }
        
        /**
         * Process upload
         */
        public function upload ()
        {
                
        }
}
