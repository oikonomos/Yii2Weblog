<?php

namespace app\components\widgets\taxonomy;

use yii\base\Widget; 

class Taxonomy extends Widget
{
    public $baseUrl = "";
    public $url = "";
    public $csrfToken = "";
    public $IDSet= "";
    public $optionText = '';
    public $fieldID = "parent";
    
    public function init()
    {
        parent::init();
        $this->publishAssets();        
    }
    
    public function run()
    {
        $this->getView()->registerJs(sprintf("
var tn = new Taxonomy({
categoryContainerID:'category',
fieldID:'%s',
parentIDs:'%s',
optionText:'%s',
url:'%s',
csrfToken:'%s'});", $this->fieldID, $this->IDSet, $this->optionText, $this->url, $this->csrfToken));
    }
    
    public function publishAssets()
    {        
        $assets = dirname( __FILE__ ) . '/assets';
        $baseUrl = $this->getView()->getAssetManager()->publish( $assets );
        $this->baseUrl = $baseUrl[1];
        
        if ( is_dir( $assets ) ) {
            $this->getView() -> registerCssFile( $baseUrl[1] . '/css/taxonomy.css', [
                'position'=> \yii\web\View::POS_END,
                'depends'=>[                    
                    'yii\web\YiiAsset',
                    'yii\bootstrap\BootstrapAsset',
                    'yii\bootstrap\BootstrapPluginAsset',
                ]
            ]);
            $this->getView() -> registerJsFile( $baseUrl[1] . '/js/taxonomy.min.js', [
                'position'=> \yii\web\View::POS_END,
                'depends'=>[                    
                    'yii\web\YiiAsset',
                    'yii\bootstrap\BootstrapAsset',
                    'yii\bootstrap\BootstrapPluginAsset',
                ]
            ]);
        }
    }
}
