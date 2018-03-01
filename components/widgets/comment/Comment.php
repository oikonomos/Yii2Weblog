<?php
/**
 * CommentWidget extentsion for yii2
 * @Class name CommentWidget
 * @author Sangbom, Suhk
 * @version 0.1
 */
namespace app\components\widgets\comment;

use Yii; 
use yii\base\InvalidConfigException; 
use yii\base\Widget; 
use yii\helpers\Json;

class Comment extends Widget
{
        public $formView = 'form';
        public $commentView = 'comment';
        public $listView = 'list';
        public $comments;
        public $postId;
        public $authorId;
        public $formId = "comment-form";
        public $assetName = "app\assets\Yii2WeblogAppAsset";
        public $clientOptions = [];

        public function init() {
                parent::init();
                $this->publishAssets();
        }

        public function run() {
                echo $this -> render( $this->formView );
                echo $this -> render( $this->commentView );

                return $this->render(
                        $this->listView,
                        [
                                'post_id' => $this->postId,
                                'author_id' => $this->authorId,
                                'comments' => $this->comments
                        ]
                );
        }

        public function publishAssets() {
                $assets = dirname( __FILE__ ) . '/assets';
                $baseUrl = $this->getView()->getAssetManager()->publish( $assets );

                if ( is_dir( $assets ) ) {
                        $this->getView() -> registerCssFile( $baseUrl[1] . '/css/comment.css', [ 'depends' => [ $this->assetName ] ] );
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/tmpl.min.js', [
                            'position'=> \yii\web\View::POS_END,
                            'depends'=>[
                                'yii\web\YiiAsset',
                                'yii\bootstrap\BootstrapAsset',
                            ]
                        ]);
                        $this->getView() -> registerJsFile( $baseUrl[1] . '/js/comment.js', [
                            'position'=> \yii\web\View::POS_END,
                            'depends'=>[
                                'yii\web\YiiAsset',
                                'yii\bootstrap\BootstrapAsset',
                            ]
                        ]);
                }    
        }
}
