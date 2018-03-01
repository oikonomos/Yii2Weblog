<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "post".
 *
 * @property string $po_id
 * @property integer $author_id
 * @property string $parent
 * @property string $password
 * @property string $writer
 * @property string $title
 * @property string $content
 * @property string $excerpt
 * @property string $email
 * @property string $homepage
 * @property string $created_at
 * @property string $updated_at
 * @property integer $term_taxonomy_id
 * @property integer $status
 * @property string $tags
 * @property string $post_type
 * @property integer $group_id
 * @property integer $level
 * @property integer $sequence
 * @property integer $hit_count
 * @property string $comment_status
 * @property integer $comment_count
 *
 * @property Comment[] $comments
 * @property User $author
 * @property Postmeta[] $postmetas
 */
class Post extends \yii\db\ActiveRecord
{
        public $name;
        public $taxonomy;
        public $termname;
        public $term_id;
        public $attachment;
        public $attachments;

        const STATUS_DELETED = 0;
        const STATUS_PUBLISHED = 10;

        /**
         * @inheritdoc
         */
        public static function tableName()
        {
                return 'post';
        }

        /**
         * @inheritdoc
         */
        public function rules()
        {
            return [
                [['author_id', 'parent', 'term_taxonomy_id', 'status', 'group_id', 'level', 'sequence', 'hit_count', 'comment_count'], 'integer'],
                [['title'], 'required'],
                [['content', 'excerpt', 'tags'], 'string'],
                [['created_at', 'updated_at'], 'safe'],
                [['password'], 'string', 'max' => 64],
                [['writer'], 'string', 'max' => 100],
                [['title', 'email', 'homepage'], 'string', 'max' => 255],
                [['post_type'], 'string', 'max' => 30],
                [['comment_status'], 'string', 'max' => 10],
                [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['author_id' => 'id']],
            ];
        }

        /**
         * @inheritdoc
         */
        public function attributeLabels()
        {
            return [
                'po_id' => Yii::t('app', 'Post ID'),
                'author_id' => Yii::t('app', 'Author ID'),
                'parent' => Yii::t('app', 'Parent'),
                'password' => Yii::t('app', 'Password'),
                'writer' => Yii::t('app', 'Writer'),
                'title' => Yii::t('app', 'Title'),
                'content' => Yii::t('app', 'Content'),
                'excerpt' => Yii::t('app', 'Excerpt'),
                'email' => Yii::t('app', 'Email'),
                'homepage' => Yii::t('app', 'Homepage'),
                'created_at' => Yii::t('app', 'Created At'),
                'updated_at' => Yii::t('app', 'Updated At'),
                'term_taxonomy_id' => Yii::t('app', 'Term Taxonomy ID'),
                'termname' => Yii::t('app', 'Category'),
                'status' => Yii::t('app', 'Status'),
                'tags' => Yii::t('app', 'Tags'),
                'post_type' => Yii::t('app', 'Post Type'),
                'group_id' => Yii::t('app', 'Group ID'),
                'level' => Yii::t('app', 'Level'),
                'sequence' => Yii::t('app', 'Sequence'),
                'hit_count' => Yii::t('app', 'Hit Count'),
                'comment_status' => Yii::t('app', 'Comment Status'),
                'comment_count' => Yii::t('app', 'Comment Count'),
                'attachments' => Yii::t('app', 'Attachments'),
            ];
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getComments()
        {
            return $this->hasMany(Comment::className(), ['post_id' => 'po_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getAuthor()
        {
            return $this->hasOne(User::className(), ['id' => 'author_id']);
        }

        /**
         * @return \yii\db\ActiveQuery
         */
        public function getPostmetas()
        {
            return $this->hasMany(Postmeta::className(), ['post_id' => 'po_id']);
        }

        /**
        * @return \yii\db\ActiveQuery
        */
        public function getTerm()
        {
            return $this->hasOne(Term::ClassName(), ['term_id' => 'term_id'])->viaTable(TermTaxonomy::tableName(), ['term_taxonomy_id'=>'term_taxonomy_id']);
        }

        /**
         * @inheritdoc
         * @return PostQuery the active query used by this AR class.
         */
        public static function find()
        {
            return new PostQuery(get_called_class());
        }

        /**
         * Check this post created by user
         * @param integer 
         * @return boolean
        */
        public function createdBy($user)
        {
           return ($this->author_id == $user) ? true : false;
        }

        /*
         * Before save
         * @param string $insert
         * @return boolean
         */
        public function beforeSave($insert)
        {
            if ( parent::beforeSave($insert) )
            {
                if ( $this->isNewRecord )
                {
                    $this->created_at = date("Y-m-d H:i:s");
                }
                else
                {
                    $this->updated_at = date("Y-m-d H:i:s");
                }
                return true;
            }
            return false;
        }

        /*
         * Before delete
         * @return boolean
         */
        public function afterDelete()
        {
                if ($this->term_taxonomy_id) {
                        $model = \app\models\TermTaxonomy::findOne($this->term_taxonomy_id);
                        $model->count--;
                        $model->save();
                }
        }
    
        /** 
         * retrieve the prevous article ID and return it.
         * @param array params search key and search text
         * @return integer ID 
         */
        public function retrievePrevousPostId($params)
        {
                if (is_array($params) && isset($params['sfld'])) {
                        if (in_array($params['sfld'], ['hit_count']))
                            $sql = sprintf("select po_id from post where %s = %s && group_id >= %s && sequence < %s order by group_id desc, sequence asc limit 1", $params['sfld'], $params['stx'], $this->group_id, $this->sequence); 
                        else
                            $sql = sprintf("select po_id from post where %s like '%%s%' && group_id >= %s && sequence < %s order by group_id desc, sequence asc limit 1", $params['sfld'], $params['stx'], $this->group_id, $this->sequence);
                }
                else {
                        $sql = sprintf("select po_id from post where group_id >= %s && sequence < %s order by group_id desc, sequence asc limit 1", $this->group_id, $this->sequence);
                }
                $command = Yii::$app->db->createCommand($sql);
                $row = $command->query();
                return (is_array($row)) ? $row['po_id']: null;
        }

        /** 
         * retrieve the next article ID and return it.
         * @param array search key and search text
         * @return integer ID 
         */
        public function retrieveNextPostId($params)
        {
                if (is_array($params) && isset($params['sfld'])) {
                        if (in_array($params['sfld'], ['hit_count']))
                            $sql = sprintf("select po_id from post where %s = %s && group_id >= %s && sequence > %s orderby order by group_id desc, sequence asc limit 1", $params['sfld'], $params['stx'], $this->group_id, $this->sequence); 
                        else
                            $sql = sprintf("select po_id from post where %s like '%%s%' && group_id >= %s && sequence > %s orderby order by group_id desc, sequence asc limit 1", $params['sfld'], $params['stx'], $this->group_id, $this->sequence);
                }
                else {
                        $sql = sprintf("select po_id from post where group_id >= %s && sequence > %s order by group_id asc, sequence desc limit 1", $this->group_id, $this->sequence);
                }

                $command = Yii::$app->db->createCommand($sql);
                $row = $command->query();
                return (is_array($row)) ? $row['po_id']: null; 
        }

        /**
         * Get states
         * @return array
         */
        public function getStates()
        {
            return [
                [
                    'key' => self::STATUS_DELETED,
                    'value' => "STATUS_DELETED"
                ],
                [
                    'key' => self::STATUS_PUBLISHED,
                    'value' => "STATUS_PUBLISHED"
                ]
            ];        
        }

        /**
        * @return void
        */
        public function setPostmetas()
        {
            $metas = $this->getPostmetas()->all();

            foreach ($metas as $model) {
                    $this->{$model->meta_key} = $model->meta_value;
            }
        }

        /**
        * @return void
        */
        public function savePostmetas($metas)
        {
            foreach($metas as $key => $value) {
                $model = Postmeta::find()->where(['post_id'=>$this->po_id, 'meta_key'=>$key])->one();
                if ($model === null) {
                    $model = new Postmeta();
                    $model->meta_key = $key;
                    $model->post_id = $this->po_id;
                }

                $model->meta_value = $value;

                $model->save();
            }
        }

        /**
         * 
         * @param string $attachments
         * @return string
         */
        public function transformAttachmentToTags( $attachments )
        {
                $attaches = unserialize( $attachments );
                $ret = "";
                foreach ( $attaches as $attach )
                {
                        $mediaInfo = explode( "|",  $attach );
                        $media = Media::findOne( $mediaInfo[0] );
                        if ($media->file_type == 'image')
                                $ret .= '<a href="' . $media->file_url . '" title="' . $media->caption . '">'
                                        . '<img src="' . $media->file_url . '" width="100%" alt="' . $media->display_filename . '" style="padding:2px;"  /></a>';
                        else
                                $ret .= '<a href="' . $media->file_url . '">'
                                        . '<img src="' . $media->thumb_url . '" width="' . $media->thumb_width . '" height="' . $media->thumb_height 
                                        . '" alt="' . $media->display_filename . '" style="padding:2px;"  /></a>';
                }

                return $ret;
        } 

        /**
         * 
         * @param string $attachments
         * @return string
         */
        public function getFirstAttachment ( $attachments )
        {
                $attaches = unserialize( $attachments );
                $ret = "";
                $cnt = count($attaches);

                if ( $cnt > 0 && $attaches[0] ) {
                        $mediaInfo = explode( "|",  $attaches[0] );
                        $media = Media::findOne( $mediaInfo[0] );
                        $ret = $media;
                }

                return $ret;
        } 

        /**
         * 
         * @param string $attachments
         * @return string
         */
        public function getAttachment ( $attachments, $depIndex = 0 )
        {
                $attaches = unserialize( $attachments );
                $ret = "";
                $cnt = count($attaches);
                
                if ( $cnt > $depIndex && $attaches[$depIndex] ) {
                        $mediaInfo = explode( "|",  $attaches[$depIndex] );
                        $media = Media::findOne( $mediaInfo[$depIndex] );
                        $ret = $media;
                }

                return $ret;
        } 

        /**
         * 
         * @param string $attachments
         * @return string
         */
        public function getAttachmentsToTags ( $attachments )
        {
                $attaches = unserialize( $attachments );
                $ret = "";
                if (empty($attaches)) {
                        return $ret;
                }
                
                foreach ( $attaches as $attach )
                {
                        $mediaInfo = explode( "|",  $attach );
                        $media = Media::findOne( $mediaInfo[0] );
                        if ($media->file_type == 'image')
                                $ret .= '<a href="' . $media->file_url . '" rel="prettyPhoto[gallery]" title="' . $media->caption . '">'
                                         . '<img src="'.$media->thumb_url.'" alt="'.$media->display_filename.'" />' . '</a></br />';
                        else
                                $ret .= '<a href="' . $media->file_url . '" title="' . $media->caption . '">'
                                        . $media->display_filename . '</a></br />';
                }

                return $ret;
        } 

        /**
         * 
         * @param string $attachments
         * @return mixed
         */
        public function getAttachmentFirstThumb( $attachments )
        {            
                $attaches = unserialize( $attachments );
                $ret = "";
                $mediaInfo = explode( "|",  $attaches[ 0 ] );
                $media = Media::findOne( $mediaInfo[0] );
                $thumb = preg_replace('/'.$media->thumb_width.'x'.$media->thumb_height.'/', '250x250', $media->thumb_url);

                if ( $media !== null )
                        return array( 'imgUrl'=>$media->file_url, 'thumb'=>$thumb, 'filename'=>$media->caption );
                else 
                        return null;
        } 

        /**
         * Display attribute attachment into attached files format 
         */
        public function transformedAttachedFileFormat(  )
        {
                $attachments = unserialize( $this->attachment );
                foreach( $attachments as $attachment ) {
                        $fileInfo = explode( "|", $attachment );
                        echo "<li><span class=\"af-item\">"
                                . $fileInfo[1] 
                                . "</span><img class=\"afi-delete\" src=\"/images/common/delete.png\" /><input type=\"hidden\" name=\"attachment[]\" value=\"" 
                                . $attachment 
                                . "\" /></li>";
                }
        }

        /**
        * @return void
        */
        public function getGalleryThumb()
        {
                $postmeta = \app\models\Postmeta::findOne(['post_id' => $this->po_id, 'meta_key' => 'attachment']);
                
                if ( is_object($postmeta) ) {
                        return $this->getAttachmentFirstThumb( $postmeta->meta_value );
                }
                
                return null;
        }
}
