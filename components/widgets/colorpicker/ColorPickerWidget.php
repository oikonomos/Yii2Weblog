<?php
/**
 * PopupWidget widget for yii2
 * @Class name PopupWidget
 * @author Sangbom, Suhk
 * @version 0.1
 */

namespace app\components\widgets\colorpicker;

use yii\widgets\InputWidget;

class ColorPickerWidget extends InputWidget
{
        public $view = 'colorpicker';
        public $id = "";


        public function init() {
                parent::init();                
                $this->publishAssets();        
        }

        public function run() {               
                echo $this -> render( $this->view, [] );
        }

        public function publishAssets() {
                $assets = dirname( __FILE__ ) . '/assets';
                $baseUrl = $this->getView()->getAssetManager()->publish( $assets );

                if ( is_dir( $assets ) ) {
                        $this->getView() -> registerCssFile( $baseUrl[1] . '/css/colorpicker.css' );
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/colorpicker.js', [
                                'position'=> \yii\web\View::POS_END,
                                'depends'=>[
                                    'yii\web\YiiAsset',
                                    'yii\bootstrap\BootstrapAsset',
                                ]
                        ]);
                }    
        }
}
