<?php
/**
 * Search widget for yii2
 * @Class name Search
 * @author Sangbom, Suhk
 * @version 0.1
 */

namespace app\components\widgets\search;

use yii\base\Widget;

class Search extends Widget
{
        public $view = 'search';
        public $method= 'get';
        public $id = "searchform";
        public $inputId = "gstx2";
        public $buttonId = "btn-search2";
        public $assetName = "app\assets\Yii2WeblogAppAsset";
        public $gstx = "";
        public $total = 0;


        public function init() {
                parent::init();
                $this->publishAssets();        
        }

        public function run() {
                echo $this -> render( $this->view, [
                        'method' => $this->method,
                        'id' => $this->id,
                        'gstx' => $this->gstx,
                        'inputId' => $this->inputId,
                        'buttonId' => $this->buttonId,
                        'total' => $this->total,
                        'htmlOptions' => compact( 'htmlOptions' )
                ] );
        }

        public function publishAssets() {
                $assets = dirname( __FILE__ ) . '/assets';
                $baseUrl = $this->getView()->getAssetManager()->publish( $assets );
                if ( is_dir( $assets ) ) {
                        $this->getView() -> registerCssFile( $baseUrl[1] . '/css/search.css', [
                                'depends'=>[
                                        $this->assetName
                                ]
                        ]);
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/search.js', [
                                'position'=> \yii\web\View::POS_END,
                                'depends'=>[
                                        'yii\web\YiiAsset',
                                        'yii\bootstrap\BootstrapAsset',
                                ]
                        ]);
                }    
        }
}
