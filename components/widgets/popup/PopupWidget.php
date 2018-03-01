<?php
/**
 * PopupWidget widget for yii2
 * @Class name PopupWidget
 * @author Sangbom, Suhk
 * @version 0.1
 */

namespace app\components\widgets\popup;

use yii\base\Widget;
use app\models\Popup;

class PopupWidget extends Widget
{
        public $view = 'popup';
        public $assetName = "app\assets\Yii2WeblogAppAsset";
        public $id = "";


        public function init() {
                parent::init();                
                $this->publishAssets();        
        }

        public function run() {
                $ymdhis = date("Y-m-d H:i:s");
                $popups = Popup::find()->where("start_date <= '{$ymdhis}' && end_date >= '{$ymdhis}'")->orderBy(['created_at' => SORT_DESC])->limit(1)->all();
                $cookies = \Yii::$app->getRequest()->getCookies();
                
                foreach ($popups as $popup) {
                        if ( $cookies->getValue('popupid') !== md5($popup->popup_id) ) {
                                echo $this -> render( $this->view, [
                                        'width' => $popup->width,
                                        'height' => $popup->height,
                                        'dim_x' => $popup->dim_x,
                                        'dim_y' => $popup->dim_y,
                                        'po_center' => $popup->po_center,
                                        'popupid' => $popup->popup_id,
                                        'id' => $this->id,
                                        'content' => $popup->content,
                                        'htmlOptions' => compact( 'htmlOptions' )
                                ] );
                        }
                }
        }

        public function publishAssets() {
                $assets = dirname( __FILE__ ) . '/assets';
                $baseUrl = $this->getView()->getAssetManager()->publish( $assets );

                if ( is_dir( $assets ) ) {
                        $this->getView() -> registerCssFile( $baseUrl[1] . '/css/popup.css', [
                                'depends'=>[
                                        $this->assetName
                                ]
                        ] );
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/popup.js', [
                                'position'=> \yii\web\View::POS_END,
                                'depends'=>[
                                    'yii\web\YiiAsset',
                                    'yii\bootstrap\BootstrapAsset',
                                ]
                        ]);
                }    
        }
}
