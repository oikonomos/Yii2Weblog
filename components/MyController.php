<?php

/*
 * MyController
 */
namespace app\components;

use Yii;
use yii\web\Controller;
use app\models\WebsightLog;

class MyController extends Controller
{ 
    public $qtx;
    
    /**
     * Checkl access Authority
     */
    public function filterCheckAuthority($model = null)
    {        
        $auth = Yii::$app->authManager;
        $ci = $this->id;
        $permission = $this->action->id . ucfirst($ci);
        
        // If user'srole is speradmin
        if ('superadmin' == Yii::$app->user->role) {
            return true;
        }
        
        if (!$model) {
            return ( Yii::$app->user->can($permission) ) ? true : false;            
        }
        else {
            return ( Yii::$app->user->can($permission, ['model' => $model]) ) ? true : false;
        }
    }
    
    /**
     * Checkl access Authority
     */
    public function errorHandler()
    {
        if ( Yii::$app->user->isGuest )
            $this->redirect(array('site/login'));
        else
            $this->redirect(array('site/handler','msg'=>'NoAuthority', 'name'=>'Authority'));
    }
    
    /**
     * Before action
     * @param type $action
     * @return boolean
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }
        // Aggregate Visiter activity log.
        $model = new WebsightLog();
        $model->insertLogs();

        return true; // or false to not run the action
    }

    /**
     * This is a function that excerpts a given content.
     */
    public function excerpt($content, $length=255, $endStr="...") {
        $excerpt = strip_tags(html_entity_decode($content));
        $excerpt = preg_replace('/\r\n|\r|\n/', ' ', $excerpt);

        if (strlen($excerpt) > $length) {
            if( !$endStr )
                return mb_substr($excerpt, 0, $length) . '&hellip;';
            else
                return mb_substr($excerpt, 0, $length) . $endStr;
        }

        return $content;
    }

    /**
     * This is a function that emphasizes a given text in a given content.
     */
    public function emphasizeText($content) {
        if(!$content||!$this->qtx) return $content;

        $emphasizedText="<span class='highlightd-word'>".$this->qtx."</span>";
        return str_replace($this->qtx, $emphasizedText, $content);
    }
}
