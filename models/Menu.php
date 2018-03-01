<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "menu".
 *
 * @property integer $menu_id
 * @property string $menu_label
 * @property string $menu_link
 * @property string $menu_active
 * @property string $menu_layout
 * @property integer $owner_id
 * @property string $menu_params
 * @property integer $menu_order
 * @property integer $parent
 * @property integer $status
 */
class Menu extends \yii\db\ActiveRecord
{
        const STATUS_NOUSE = 1;
        const STATUS_USE = 0;
        
        /**
         * @inheritdoc
         */
        public static function tableName()
        {
                return 'menu';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
                return [
                        [['menu_label', 'menu_link', 'menu_active', 'owner_id'], 'required'],
                        [['owner_id', 'menu_order', 'parent', 'status'], 'integer'],
                        [['menu_label', 'menu_link', 'menu_active', 'menu_params'], 'string', 'max' => 255],
                        [['menu_layout'], 'string', 'max' => 30],
                ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
                return [
                        'menu_id' => Yii::t('app', 'Menu ID'),
                        'menu_label' => Yii::t('app', 'Menu Label'),
                        'menu_link' => Yii::t('app', 'Menu Link'),
                        'menu_active' => Yii::t('app', 'Menu Active'),
                        'menu_layout' => Yii::t('app', 'Menu Layout'),
                        'owner_id' => Yii::t('app', 'Owner ID'),
                        'menu_params' => Yii::t('app', 'Menu Params'),
                        'menu_order' => Yii::t('app', 'Menu Order'),
                        'parent' => Yii::t('app', 'Parent'),
                        'status' => Yii::t('app', 'Status'),
                ];
        }
        
        /**
         * Get menu items by layout and parent.
         * @param string $layout
         * @param integer $parent
         * @return array
         */
        public function getMenuItems($layout = 'main', $parent = 0)
        {
                $ret = [];
                $query = self::find();
                $query->andFilterWhere([
                        'menu_layout' => $layout,
                        'status' => self::STATUS_USE,
                        'parent' => $parent,
                ]);
                $query->orderBy(['menu_order' => SORT_ASC, 'parent' => SORT_ASC]);
                return $query->asArray()->all();
        }
        
        /**
        * 
        * @return array
        */
        public static function findMenus()
        {
                $query = new ActiveQuery(self::className());
                $ret[] = [
                        'menu_id' => 0,
                        'menu_label' => Yii::t('app', 'No Parent')
                ];
                $ret += $query->select([
                            'menu_id',
                            'menu_label' 
                        ])
                        ->where(['status' => 0])
                        ->orderBy(['menu_order'=>SORT_ASC])
                        ->asArray()
                        ->all();
                return $ret;
        }

        /**
         * Get states
         * @return string
         */
        public function getState()
        {
                return ( $this->status == self::STATUS_USE ) ? Yii::t('app' , 'STATUS USE') : Yii::t('app' , 'STATUS NOUSE');        
        }
    
        /**
         * Get states
         * @return array
         */
        public function getStates()
        {
                return [
                        [
                                'key' => self::STATUS_USE,
                                'value' => Yii::t('app' , 'STATUS USE')
                        ],
                        [
                                'key' => self::STATUS_NOUSE,
                                'value' => Yii::t('app' , 'STATUS NOUSE')
                        ]
                ];        
        }         
              
        /*
         * Before save
         * @param string $insert
         * @return boolean
         */
        public function beforeSave($insert)
        {
                if ( parent::beforeSave($insert) ) {
                        $this->menu_active = serialize( explode( ',', $this->menu_active ) );
                        return true;
                }
                return false;
        }
        
        /**
         * Get menu active
         * @return string
         */
        public function unserializeMenuActive()
        {
                if ($this->menu_active)
                        return implode(',', unserialize( $this->menu_active ) );
                return '';
        }
        
        /**
         * Unserialized menu active attribute and set it to model menu active attribute.
         */
        public function setUnserializedMenuActive()
        {
                $this->menu_active = implode(',', unserialize( $this->menu_active ) );
        }
}