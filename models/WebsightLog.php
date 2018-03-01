<?php

namespace app\models;

use Yii;

use app\models\WebsightLogOs;
use app\models\WebsightLogIp;
use app\models\WebsightLogBrowser;
use app\models\WebsightLogReferer;
use app\models\WebsightLogSearchengin;
use app\models\WebsightLogPage;
use app\models\WebsightLogKeyword;
use app\models\WebsightLogDomain;
use app\models\WebsightLogCounter;

/**
 * This is the model class for table "websight_log".
 *
 * @property integer $idx
 * @property string $user_id
 * @property integer $browser
 * @property integer $domain
 * @property integer $referer
 * @property integer $ip
 * @property integer $searchengin
 * @property integer $keyword
 * @property integer $os
 * @property integer $page
 * @property string $created_at
 */
class WebsightLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'websight_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'browser', 'domain', 'referer', 'ip', 'searchengin', 'keyword', 'os', 'page'], 'integer'],
            [['browser', 'domain', 'referer', 'ip', 'searchengin', 'keyword', 'os', 'page'], 'required'],
            [['created_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'idx' => Yii::t('app', 'Idx'),
            'user_id' => Yii::t('app', 'User ID'),
            'browser' => Yii::t('app', 'Browser'),
            'domain' => Yii::t('app', 'Domain'),
            'referer' => Yii::t('app', 'Referer'),
            'ip' => Yii::t('app', 'Ip'),
            'searchengin' => Yii::t('app', 'Searchengin'),
            'keyword' => Yii::t('app', 'Keyword'),
            'os' => Yii::t('app', 'Os'),
            'page' => Yii::t('app', 'Page'),
            'created_at' => Yii::t('app', 'Created At'),
        ];
    }
   public function getOSversion($os,$array)
   {
           for($i=0;$i<(sizeof($array) - 1);$i++){
                   $j=$i+1;
                   if ( $array[$i]  && $array[$j] )
                   {
                            if(preg_match("/$os/",$array[$i]) && preg_match("/^[0-9]{1,2}([\.]{1}[0-9]{1,2})*[a-z]{0,1}$/",$array[$j])){
                                    $os_version=$array[$j];
                            }	
                   }
           }
           return $os_version;
   }


   // browser정보
   public function getBRversion($br,$array)
   {
           $br_version = null;
           for($i=0;$i<(sizeof($array) - 1);$i++){
                   $j=$i+1;
                   if ( $array[$i]  && $array[$j] )
                   {
                            if(preg_match("/$br/",$array[$i]) && preg_match("/^[0-9]{1,2}([\.]{1}[0-9]{1,2})*[a-z]{0,1}$/",$array[$j])){
                                    $br_version=$array[$j];
                            }	
                   }
           }
           return $br_version;
   }

   // os+browser체크
   public function getUserAgent()
   {
           $temp = null;
           $os_name = "unknown";
           $os_version = null;
           $br_name = "unknown";
           $br_version = null;

           if ( isset( $_SERVER["HTTP_USER_AGENT"] ) )
           {
                    $strAgent=$_SERVER["HTTP_USER_AGENT"];
                    $strAgent=preg_replace("/([ 0-9\.])*%/i","",$strAgent);
                    $strAgent=trim(preg_replace("/-|_|=|\+|;/i"," ",$strAgent));

                    $arrAgent=explode(" ",$strAgent);

                    if(preg_match("/([a-z])+\//",$arrAgent[0])){
                            $br_version_temp=explode("/",$arrAgent[0]);
                    }
                    $br_version_temp=$br_version_temp[1];

                    if(preg_match("/Win|Window/i",$strAgent)){
                    $os_name="Windows";

                            if(preg_match("/s 3\.1|n3\.1/",$strAgent)){
                                    $os_version="3.1";
                            }

                            if(preg_match("/s 95|n95/",$strAgent)){
                                    $os_version="95";
                            }

                            if(preg_match("/s 98|n98/",$strAgent)){
                                    $os_version="98";
                            }	

                            if(preg_match("/s NT|nNT/",$strAgent)){
                                    $os_version="NT";
                            }

                            if(preg_match("/s NT|nNT/",$strAgent) && preg_match("/T 5\.0| 2000/i",$strAgent)){
                                    $os_version="2000";
                            }

                            if(preg_match("/s NT|nNT/",$strAgent) && preg_match("/T 5\.1| XP/i",$strAgent)){
                                    $os_version="XP";
                            }

                            if(preg_match("/s CE|nCE/",$strAgent)){
                                    $os_version="CE";
                            }

                            if(preg_match("/s 9x|n 9x/",$strAgent) || preg_match("/me/i",$strAgent)){
                                    $os_version="Me";
                            }
                    }

                    elseif(preg_match("/Mac PowerPC|PPC/i",$temp)){
                            $os_name="Mac PowerPC";
                            $os_version = $this->getOSversion("Mac powerPC",$arrAgent);
                    }

                    elseif(preg_match("/Mac/i",$temp)){
                            $os_name="Macintosh";
                            $os_version = $this->getOSversion("Mac",$arrAgent);
                    }

                    elseif(preg_match("/Linux/i",$temp)){
                            $os_name="Linux";
                            $os_version = $this->getOSversion("Linux",$arrAgent);
                    } 

                    elseif(preg_match("/IRIX/i",$temp)){
                            $os_name="IRIX";
                            $os_version = $this->getOSversion("IRIX",$arrAgent);
                    }

                    elseif(preg_match("/sunOS/i",$temp)){
                            $os_name="sunOS";
                            $os_version = $this->getOSversion("sunOS",$arrAgent);
                    }

                    elseif(preg_match("/phone/i",$temp)){
                            $os_name="CellPhone";
                            $os_version = $this->getOSversion("phone",$arrAgent);
                    }

                    else{
                            $os_name="unknown";
                            $os_version="";
                    }


                    if(preg_match("/MSN/i",$strAgent)){
                            $br_name="MSN";
                            $br_version=$this->getBRversion("MSN",$arrAgent);
                    }

                    elseif(preg_match("/MSIE/i",$strAgent)){
                            $br_name="MSIE";
                            $br_version=$this->getBRversion("MSIE",$arrAgent);
                    }

                    elseif(preg_match("/(\[){1}[a-z]{1,3}(\]){1}/i",$strAgent) && preg_match("/\]/i",$strAgent)){
                            $br_name="Netscape";
                            $br_version=$br_version_temp;
                    }

                    elseif(preg_match("/opera/i",$strAgent)){
                            $br_name="Opera";
                            $br_version=$this->getBRversion("Opera",$arrAgent);
                            if(!$br_version){
                                    $br_version=$br_version_temp;
                            }
                    }

                    elseif(preg_match("/gec|gecko/i",$strAgent)){
                            $br_name="Gecko";
                            $br_version=$this->getBRversion("Gecko",$arrAgent);
                            if(!$br_version){
                                    $br_version=$br_version_temp;
                            }
                    }

                    elseif(preg_match("/MSMB/i",$strAgent)){
                            $br_name="MSMB";
                    }

                    else{
                            $br_name="unknown";
                    }
           }

           return array($os_name . $os_version, $br_name . $br_version);
   }

   // 레퍼러에서 도메인 정보 가져오기
   public function getRefererDomain()
   {
            if ( isset( $_SERVER["HTTP_REFERER"] ) )
            {
                    $arr = explode("/",$_SERVER["HTTP_REFERER"]);
                    return strtolower($arr[2]);
            }

            return null;
   }

   // 쿼리스트링에서 검색엔진과 검색엔진 키워드 알아내기
   public function getSearchKeyword($str_domain)
   {
           $engin = null;
           $keyword = null;
           $query = null;
           //$str="http://search.cyworld.com/search/all.html?qn=&s=&f=&bd=&bw=&tq=&z=A&q=%B3%B2%B1%D4%B8%AE&premiumText=&s=";
           //$str_domain = "search.cyworld.com";

           //검색엔진별 쿼리 키워드
           if(preg_match("/.naver.com$/i",$str_domain)){
                           $engin = "naver.com";
                           $query = "query";
           }else if(preg_match("/.daum.net$/i",$str_domain)){
                           $engin = "daum.net";
                           $query = "q";
           }else if(preg_match("/.cyworld.com$/i",$str_domain)){
                           $engin = "cyworld.com";
                           $query = "q";
           }else if(preg_match("/.yahoo.com$/i",$str_domain)){
                           $engin = "yahoo.com";
                           $query = "p";
           }else if(preg_match("/.nate.com$/i",$str_domain)){
                           $engin = "nate.com";
                           $query = "q";
           }else if(preg_match("/.paran.com$/i",$str_domain)){
                           $engin = "paran.com";
                           $query = "Query";
           }

           //검색엔진 추가시 위의 주석과 함께 테스트 해본다~
           //if($str){
           //	$arr = explode("&",$str);
           if( isset( $_SERVER["QUERY_STRING"] ) ){
                   $arr = explode("&",$_SERVER["QUERY_STRING"]);
                   for($i=0;$i<count($arr);$i++){
                           $arr2 = explode("=",$arr[$i]);
                           if($query && $arr2[0]==$query){
                                   $keyword = $arr2[1];
                           }
                   }
           }

           if ( !$engin ) {
               $engin = 'unknown';
           }
           if ( !$keyword ) {
               $keyword = 'none';
           }

           return array($engin, $keyword);
   }

   /*
    * 웹로그 출력 양식에 맞게 웹로그 포맷으로 변경한 후, 그 데이터를 데이터베이스에 저장한다.
    */
   public function insertLogs()
   {               
        $webSightLog = new WebsightLog();               
        $weblog = array();

        if (Yii::$app->user->id) 
            $webSightLog->user_id = Yii::$app->user->id;
        else
            $webSightLog->user_id = 0;

        $arrAgent = $this->getUserAgent();
        $weblog['os'] = $arrAgent[0];
        $weblog['browser'] = $arrAgent[1];
        if ( isset( $_SERVER["HTTP_REFERER"] ) && $_SERVER["HTTP_REFERER"] )
                 $weblog['referer'] = urldecode($_SERVER["HTTP_REFERER"]);
        else
                $weblog['referer']  = "none";

        $weblog['domain'] = $this->getRefererDomain();
        if ( !$weblog['domain'] )
        {
                $weblog['domain']  = "none";
                $weblog['engin'] = 'direct';
                $weblog['keyword']  = 'none';
        }
        else
        {
                 $arrQuery = $this->getSearchKeyword($weblog['domain']);
                 $weblog['engin'] = $arrQuery[0];
                 $weblog['keyword'] = urldecode($arrQuery[1]);                       
        }
        //print_r($weblog);
        if ( isset( $_SERVER["REMOTE_ADDR"] ) )
                 $weblog['ip'] = $_SERVER["REMOTE_ADDR"];
        else
                 $weblog['ip'] = 'none';
        if ( isset( $_SERVER["REQUEST_URI"] ) && $_SERVER["REQUEST_URI"] )
                 $weblog['page'] = $_SERVER["REQUEST_URI"];
        else
                 $weblog['page'] = 'none';
        
        // Begin transaction
        $transaction = Yii::$app->db->beginTransaction();
        
        try {

                //os 정보 입력
                $model = WebsightLogOs::find()->where(['os'=>$weblog['os']])->one();
                if ($model !== null )
                {
                         $model->hit++;
                         $model->save();
                }
                else
                {
                        $model = new WebsightLogOs();
                        $model->os = $weblog['os'];
                        $model->hit = 1;
                        $model->save();
                }               
                $webSightLog->os = $model->idx;

                //browser 정보 입력
                $model = WebsightLogBrowser::find()->where(['browser'=>$weblog['browser']])->one();
                if ($model !== null )
                {
                         $model->hit++;
                         $model->save();
                }
                else
                {
                        $model = new WebsightLogBrowser();
                        $model->browser = $weblog['browser'];
                        $model->hit = 1;
                        $model->save();
                }             
                $webSightLog->browser = $model->idx;

                //referer 정보 입력
                $model = WebsightLogReferer::find()->where(['referer'=>$weblog['referer']])->one();
                if ($model !== null )
                {
                         $model->hit++;
                         $model->save();
                }
                else
                {
                        $model = new WebsightLogReferer();
                        $model->referer = $weblog['referer'];
                        $model->hit = 1;
                        $model->save();
                }             
                $webSightLog->referer = $model->idx;

                //domain 정보 입력
                $model = WebsightLogDomain::find()->where(['domain'=>$weblog['domain']])->one();
                if ($model !== null )
                {
                         $model->hit++;
                         $model->save();
                }
                else
                {
                        $model = new WebsightLogDomain();
                        $model->domain = $weblog['domain'];
                        $model->hit = 1;
                        $model->save();
                }             
                $webSightLog->domain = $model->idx;

                 //ip 정보 입력
                $model = WebsightLogIp::find()->where(['ip'=>$weblog['ip']])->one();
                if ($model !== null )
                {
                         $model->hit++;
                         $model->save();
                }
                else
                {
                        $model = new WebsightLogIp();
                        $model->ip = $weblog['ip'];
                        $model->hit = 1;
                        $model->save();
                }             
                $webSightLog->ip = $model->idx;

                 //page 정보 입력
                $model = WebsightLogPage::find()->where(['page'=>$weblog['page']])->one();
                if ($model !== null )
                {
                         $model->hit++;
                         $model->save();
                }
                else
                {
                        $model = new WebsightLogPage();
                        $model->page = $weblog['page'];
                        $model->hit = 1;
                        $model->save();
                }             
                $webSightLog->page = $model->idx;

                 //searchengin 정보 입력
                 $model = WebsightLogSearchengin::find()->where(['searchengin'=>$weblog['engin']])->one();
                 if ($model !== null )
                 {
                          $model->hit++;
                          $model->save();
                 }
                 else
                 {
                         $model = new WebsightLogSearchengin();
                         $model->searchengin = $weblog['engin'];
                         $model->hit = 1;
                         $model->save();
                 }             
                 $webSightLog->searchengin = $model->idx;


                 //keyword 정보 입력
                 $model = WebsightLogKeyword::find()->where(['keyword'=>$weblog['keyword']])->one();
                 if ($model !== null )
                 {
                          $model->hit++;
                          $model->save();
                 }
                 else
                 {
                         $model = new WebsightLogKeyword();
                         $model->keyword = $weblog['keyword'];
                         $model->hit = 1;
                         $model->save();
                 }   
                 $webSightLog->keyword = $model->idx;

                $webSightLog->save();

                 //날짜설정
                 $yyyy = date('Y');
                 $mm = date('m');
                 $dd = date('d');
                 $week = date('w');
                 $hh = date('G');

                 //count 정보 입력
                $model = WebsightLogCounter::find()->where(['yyyy' => $yyyy, 'mm' => $mm, 'dd' => $dd])->one();
                 if ($model !== null )
                 {
                          $hit = $model->getAttribute( "h".$hh );
                          $model->setAttribute( "h".$hh, $hit + 1 );
                          $model->hit++; 
                          $model->save();
                 }
                 else
                 {
                         $model = new WebsightLogCounter();
                         $model->yyyy = $yyyy;
                         $model->mm = $mm;
                         $model->dd = $dd;
                         $model->week = $week;
                         $model->setAttribute( "h".$hh, 1 );                        
                         $model->hit = 1;
                         $model->save();
                 }
                 
                // Rollback
                $transaction->commit();
        }
        catch (yii\console\Exception $ex) {
                // Rollback
                $transaction->rollback();
                echo $ex->getMessage(); 
        }
    }
}
