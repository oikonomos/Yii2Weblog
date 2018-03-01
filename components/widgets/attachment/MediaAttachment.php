<?php
/**
 * MediaAttachment extentsion for yii2
 * @Class name MediaAttachment
 * @author Sangbom, Suhk
 * @version 0.1
 */

namespace app\components\widgets\attachment;

use yii\widgets\InputWidget;

class MediaAttachment extends InputWidget
{
        public $lightboxView = 'lightbox';
        public $listView = 'list';
        public $url;
        public $imgUrl;
        public $width = "0";
        public $height = "0";
        public $id = "btn-attachment";
        public $assetName = "app\assets\Yii2WeblogAppAsset";


        public function init() {
                parent::init();
                $this->publishAssets();        
        }

        public function run() {
                $this->getView() -> registerJs("
window.imgUrl = '". $this->imgUrl ."';
$( '#" . $this->id . "' ).click( function(e){
    e.stopPropagation();
    window.showLightbox();
    window.lightbox( {
        url: '" . $this->url . "',
        width: '" . $this->width . "',
        height: '" . $this->height . "',
        type: 'all',
        mstx: ''
    } );
} );            
", \yii\web\View::POS_END );
                echo $this -> render( $this->listView );
                echo $this -> render( $this->lightboxView, compact( 'htmlOptions' ) );
        }
    
        public function publishAssets() {
                $assets = dirname( __FILE__ ) . '/assets';
                $baseUrl = $this->getView()->getAssetManager()->publish( $assets );
                //print_r($baseUrl);
                if ( is_dir( $assets ) ) {
                        $this->getView() -> registerCssFile( $baseUrl[1] . '/css/jquery.media.attachment.css', [ 'depends' => [ $this->assetName ] ]  );
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/tmpl.min.js', [
                                'position'=> \yii\web\View::POS_END,
                                'depends'=>[
                                        'yii\web\YiiAsset',
                                        'yii\bootstrap\BootstrapAsset',
                                ]
                        ]);
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/jquery.media.attachment_2.0.0.min.js', [
                                'position'=> \yii\web\View::POS_END,
                                'depends'=>[
                                        'yii\web\YiiAsset',
                                        'yii\bootstrap\BootstrapAsset',
                                ]
                        ]);
                }    
        }
}
