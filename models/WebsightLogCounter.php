<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "websight_log_counter".
 *
 * @property integer $idx
 * @property string $yyyy
 * @property string $mm
 * @property string $dd
 * @property integer $h0
 * @property integer $h1
 * @property integer $h2
 * @property integer $h3
 * @property integer $h4
 * @property integer $h5
 * @property integer $h6
 * @property integer $h7
 * @property integer $h8
 * @property integer $h9
 * @property integer $h10
 * @property integer $h11
 * @property integer $h12
 * @property integer $h13
 * @property integer $h14
 * @property integer $h15
 * @property integer $h16
 * @property integer $h17
 * @property integer $h18
 * @property integer $h19
 * @property integer $h20
 * @property integer $h21
 * @property integer $h22
 * @property integer $h23
 * @property string $week
 * @property integer $hit
 */
class WebsightLogCounter extends \yii\db\ActiveRecord
{
        public $gsum;
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
                return 'websight_log_counter';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                        [['yyyy', 'mm', 'dd', 'week'], 'required'],
                        [['h0', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'h7', 'h8', 'h9', 'h10', 'h11', 'h12', 'h13', 'h14', 'h15', 'h16', 'h17', 'h18', 'h19', 'h20', 'h21', 'h22', 'h23', 'hit'], 'integer'],
                        [['yyyy'], 'string', 'max' => 4],
                        [['mm', 'dd'], 'string', 'max' => 2],
                        [['week'], 'string', 'max' => 1],
                        [['yyyy', 'mm', 'dd'], 'unique', 'targetAttribute' => ['yyyy', 'mm', 'dd'], 'message' => 'The combination of Yyyy, Mm and Dd has already been taken.'],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
                return [
                        'idx' => Yii::t('app', 'Idx'),
                        'yyyy' => Yii::t('app', 'Year'),
                        'mm' => Yii::t('app', 'Month'),
                        'dd' => Yii::t('app', 'Day'),
                        'h0' => Yii::t('app', 'H0'),
                        'h1' => Yii::t('app', 'H1'),
                        'h2' => Yii::t('app', 'H2'),
                        'h3' => Yii::t('app', 'H3'),
                        'h4' => Yii::t('app', 'H4'),
                        'h5' => Yii::t('app', 'H5'),
                        'h6' => Yii::t('app', 'H6'),
                        'h7' => Yii::t('app', 'H7'),
                        'h8' => Yii::t('app', 'H8'),
                        'h9' => Yii::t('app', 'H9'),
                        'h10' => Yii::t('app', 'H10'),
                        'h11' => Yii::t('app', 'H11'),
                        'h12' => Yii::t('app', 'H12'),
                        'h13' => Yii::t('app', 'H13'),
                        'h14' => Yii::t('app', 'H14'),
                        'h15' => Yii::t('app', 'H15'),
                        'h16' => Yii::t('app', 'H16'),
                        'h17' => Yii::t('app', 'H17'),
                        'h18' => Yii::t('app', 'H18'),
                        'h19' => Yii::t('app', 'H19'),
                        'h20' => Yii::t('app', 'H20'),
                        'h21' => Yii::t('app', 'H21'),
                        'h22' => Yii::t('app', 'H22'),
                        'h23' => Yii::t('app', 'H23'),
                        'week' => Yii::t('app', 'Week'),
                        'hit' => Yii::t('app', 'Hit'),
                ];
        }
        
        /**
         * Get hourly statistics data set.
         * @param string $yyyy
         * @param string $mm
         * @return array
         */
        public static function getHourlyDataSet($yyyy, $mm, $dd) {
                $data = self::findOne(['yyyy'=>$yyyy, 'mm' => $mm, 'dd' => $dd]);
                //echo $yyyy.','.$mm.','.$dd;
                $ret = [];
                
                for ( $i=0; $i<24; $i++ ) {
                        $ret['labels'][] = $i;
                        $ret['data'][] = $data['h'.$i];
                }
                return $ret;
        }
        
        /**
         * Get Monthly statistics data set.
         * @param string $yyyy
         * @param string $mm
         * @return array
         */
        public static function getDailyDataSet($yyyy, $mm) {
                $dataSet = self::find()->where(['yyyy'=>$yyyy, 'mm'=>$mm])->orderBy(['dd' => SORT_ASC])->limit(31)->all();
                $ret = [];
                foreach ( $dataSet AS $row ) {
                        $ret['labels'][] = (int)$row['dd'];
                        $ret['data'][] = $row['hit'];
                }
                return $ret;
        }
        
        /**
         * Get daily statistics data set.
         * @param string $yyyy
         * @param string $mm
         * @return array
         */
        public static function getMonthlyDataSet($yyyy) {
                $dataSet = self::findBySql("SELECT mm, sum(hit) as gsum FROM websight_log_counter WHERE yyyy='{$yyyy}' GROUP BY mm ORDER BY mm ASC LIMIT 12 ")->all();
                
                $ret = [];
                foreach ( $dataSet AS $row ) {
                        $ret['labels'][] = (int)$row['mm'];
                        $ret['data'][] = $row['gsum'];
                }
                return $ret;
        }
        
        /**
         * Get yearly statistics data set.
         * @param string $yyyy
         * @param string $mm
         * @return array
         */
        public static function getYearlyDataSet() {
                $yyyy = (int)date('Y') - 30;
                $dataSet = self::findBySql("SELECT yyyy, sum(hit) as gsum FROM websight_log_counter WHERE yyyy>='{$yyyy}' GROUP BY yyyy ORDER BY yyyy ASC LIMIT 30 ")->all();                
                $ret = [];
                foreach ( $dataSet AS $row ) {
                        $ret['labels'][] = (int)$row['yyyy'];
                        $ret['data'][] = $row['gsum'];
                }
                //var_dump($ret);exit;
                return $ret;
        }
}
