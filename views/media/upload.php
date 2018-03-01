<?php

use yii\helpers\Html;
use yii\helpers\Url;
use dosamigos\fileupload\FileUploadUI;


/* @var $this yii\web\View */
/* @var $model app\modelsMedia */

$this->title = Yii::t('app', 'Multiple File Upload');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Media'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="media-upload">

    <h1><?= Html::encode($this->title) ?></h1>

    
<div class="media-form">

    <?= FileUploadUI::widget([
        'model' => $model,
        'attribute' => 'upfile',
        'url' => Url::to(['media/upload']),
        'gallery' => false,
        'fieldOptions' => [
            'accept' => 'image/*'
        ],
        'clientOptions' => [
            'maxFileSize' => 2000000
        ],
        // ...
        'clientEvents' => [
            'fileuploaddone' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
            'fileuploadfail' => 'function(e, data) {
                                    console.log(e);
                                    console.log(data);
                                }',
        ],
    ]); ?>

</div>

</div>
