<?php

namespace app\models;

use Yii;
use yii\db\Query;
use app\models\Color;

/**
 * This is the model class for table "term_taxonomy".
 *
 * @property integer $term_taxonomy_id
 * @property integer $term_id
 * @property string $taxonomy
 * @property integer $parent
 * @property string $family_id
 * @property integer $level
 * @property integer $sequence
 * @property integer $count
 * @property string $color
 * @property string $color2
 * @property string $font
 * @property string $write_level
 * @property string $update_level
 * @property string $view_level
 * @property string $list_level
 * @property string $replay_level
 */
class TermTaxonomy extends \yii\db\ActiveRecord
{
    public $name;
    public $slug;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'term_taxonomy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['taxonomy', 'family_id'], 'required'],
            [['term_id', 'parent', 'family_id', 'level', 'sequence', 'count'], 'integer'],
            [['taxonomy'], 'string', 'max' => 32],
            [['color', 'color2'], 'string', 'max' => 60],
            [['write_level', 'update_level', 'view_level', 'list_level', 'reply_level'], 'string', 'max' => 64],
            [['font'], 'string', 'max' => 50],
            [
                ['term_id', 'taxonomy'], 'unique',
                'targetAttribute' => ['term_id', 'taxonomy'],
                'message' => Yii::t('app', 'The combination of Term ID and Taxonomy has already been taken.')
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'term_taxonomy_id' => Yii::t('app', 'Term Taxonomy ID'),
            'term_id' => Yii::t('app', 'Term ID'),
            'taxonomy' => Yii::t('app', 'Taxonomy'),
            'name' => Yii::t('app', 'name'),
            'slug' => Yii::t('app', 'Slug'),
            'parent' => Yii::t('app', 'Parent'),
            'family_id' => Yii::t('app', 'Family ID'),
            'level' => Yii::t('app', 'Level'),
            'sequence' => Yii::t('app', 'Sequence'),
            'count' => Yii::t('app', 'Count'),
            'color' => Yii::t('app', 'Color'),
            'color2' => Yii::t('app', 'Color2'),
            'font' => Yii::t('app', 'Font'),
            'write_level' => Yii::t('app', 'Write Level'),
            'update_level' => Yii::t('app', 'Update Level'),
            'view_level' => Yii::t('app', 'View Level'),
            'list_level' => Yii::t('app', 'List Level'),
            'reply_level' => Yii::t('app', 'Reply Level'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['term_taxonomy_id' => 'term_taxonomy_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTerm()
    {
        return $this->hasOne(Term::className(), ['term_id' => 'term_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTermTaxonomies()
    {
        return $this->hasMany(TermTaxonomy::className(), ['parent' => 'term_taxonomy_id']);
    }
    
    /**
     * @param integer $parent
     * @param integer $max
     * @return array TermTaxonomy ids that retrieved.
     */
   public static function findAllParents($parent = 0, $max = 4)
   {
        $parents = array();
        $parents[] = $parent;
        if ($parent)
        {
            $currentParent = $parent;
            $cnt = 0;
            while ($currentParent)
            {
                if ($cnt > $max -1) break;
                $model = self::findOne($currentParent);
                $parents[] = $model->parent;
                $currentParent = $model->parent;
                $cnt++;
            }
        }
        
        $reversed_array = array_reverse($parents);
        if (count($reversed_array) < 2)
            return $reversed_array;
        else
            return array_slice($reversed_array, 1);
   }
    
    /**
     * If First variable is true, 
     * @param integer $parent
     * @param integer $first
     * @return array TermTaxonomy ids that retrieved. 
     */
    public static function findSiblings($parent = 0, $first = false)
    {
        $query = new Query;
        $query->select('term_taxonomy.term_taxonomy_id, b.name')
                 ->from('term_taxonomy')
                 ->leftJoin('term b', 'term_taxonomy.term_id=b.term_id');
        
        $query->andFilterWhere([
            'term_taxonomy.parent' => $parent
        ]);
        $query->andFilterCompare('term_taxonomy.term_taxonomy_id', 0, '<>');
         
        $rows = $query->all();
        $resultSet = array();
        if (!$parent)
            $resultSet[] = [0=>Yii::t('app','Taxonomy')];
        for ($i=0, $l=count($rows); $i<$l; $i++)
        {
            $resultSet[] = [$rows[$i]['term_taxonomy_id'] => $rows[$i]['name']];
        }
        return $resultSet;
    }
        
        /**
         * Set name and alias of the Term Model..
        */
        public function setNameNSlug()
        {
                $termModel = Term::findOne($this->term_id);
                $this->name = $termModel->name;
                $this->slug = $termModel->slug;
        }
        
        /**
         * Retrieve all the descendants.
         * @param integer $tt_id term taxonomy id.
         * @return mixed term taxonomy ids.
         */
        public static function findAllChildren( $term_taxonomy_id = null ) {
                if ( empty($term_taxonomy_id) ) return null;
                
                $query = new Query;
                $query->select('term_taxonomy_id')
                         ->from('term_taxonomy');

                $query->andFilterWhere([
                    'parent' => $term_taxonomy_id
                ]);
                
                return $query->all();                               
        }
        
        /**
         * Retrieve all the descendants.
         * @param integer $tt_id term taxonomy id.
         * @return array term taxonomy ids.
         */
        public static function getTermTaxonomyDescendants( $term_taxonomy_id = null ) {
                if ( empty($term_taxonomy_id) ) return []; 
                
                $tids = [$term_taxonomy_id];
                $rows = self::findAllChildren($term_taxonomy_id);
                foreach ( $rows as $row ) {
                        array_push( $tids, $row['term_taxonomy_id'] );
                        $rows2 = self::findAllChildren( $row['term_taxonomy_id'] );
                        foreach ( $rows2 as $row2 ) {
                                array_push( $tids, $row2['term_taxonomy_id'] );
                        }
                }
                return $tids;
        }
    
        /**
         * @param string $color color name
         * @return mixed if it is, it is \yii\db\ActiveQuery
         */
        public function getColor( $color )
        {
                if ( $color ) {
                        $model = Color::findOne(['name'=>$color]);

                        return $model;
                }
                else 
                        return null;
        }

        /**
         * @param string $color color name
         * @return mixed
         */
        public function getColorSample( $color )
        {
                if ( $color ) {
                        $model = Color::findOne(['name'=>$color]);

                        if ( $model !== null )
                                return '<span style="display: inline-block; width: 50px; height: 20px; ' . $model->style . ';">&nbsp;</span>&nbsp;<label>' . $model->name . '</label>';
                        else
                                return $color;
                }
                else 
                        return null;
        }
        
        /**
         * Check whether visitor has the authority to write, update, view, list or reply.
         * @param $role user role.
         * @mode $mode write, update, view, list or reply.
         * @return boolean check result.
         */
        public function checkAuthority($role, $mode) {
                if ( empty($role) || empty($mode) ) {
                        return false;
                }
                
                if ( $this->{$mode.'_level'} == $role ) {
                        
                }
        }
}
