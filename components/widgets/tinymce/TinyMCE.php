<?php
/**
 * Classname : TinyMCE
 * This widget is for tinyMCE 
 * @author 석상범
 */

namespace app\components\widgets\tinymce;

use yii\base\Widget; 

class TinyMCE extends Widget
{
    public $width = "100%";
    public $height = "500";
    public $id = "content";
    public $baseUrl = "";
    public $clientOptions = [];

    public function init() {
        parent::init();
        $this->publishAssets();        
    }
    
    public function run() {
        
        $this->getView() -> registerJs( "
tinymce.init({
	selector: '#" . $this->id . "',
	height: " . $this->height .  ",
	theme: 'modern',
	language: 'ko_KR',
	plugins: [
		'advlist autolink lists link image charmap print preview hr anchor pagebreak',
		'searchreplace wordcount visualblocks visualchars code fullscreen',
		'insertdatetime media nonbreaking save table contextmenu directionality',
		'emoticons template paste textcolor colorpicker textpattern imagetools'
	],
	toolbar1: 'insertfile undo redo | styleselect | fontsizeselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link custom_image',
	toolbar2: 'print preview media | forecolor backcolor emoticons',
                fontsize_formats: '8pt 10pt 12pt 14pt 18pt 24pt 36pt',
	image_advtab: true,
	templates: [
		{ title: 'Test template 1', content: 'Test 1' },
		{ title: 'Test template 2', content: 'Test 2' }
	],
	content_css: [
		'//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
		'//www.tinymce.com/css/codepen.min.css'
	],
	setup: function(editor) {
			editor.addButton('custom_image', {
			    title: '이미지삽입',
			    icon: 'image',
			    onclick: function() {
				window.open('" . $this->baseUrl . "/upload.php', 'tinymcePop', 'width=400, height=300');
			    }
			});
		}
 });
            ", \yii\web\View::POS_BEGIN);
    }
    
    public function publishAssets() {
        $assets = dirname( __FILE__ ) . '/assets';
        $baseUrl = $this->getView()->getAssetManager()->publish( $assets );
        $this->baseUrl = $baseUrl[1];
        //print_r($baseUrl);
        if ( is_dir( $assets ) ) {
            $this->getView() -> registerJsFile( $baseUrl[1] . '/js/tinymce.min.js', [
                'position'=> \yii\web\View::POS_HEAD
            ]);
        }    
    }
}
