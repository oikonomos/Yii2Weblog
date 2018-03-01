<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "media".
 *
 * @property string $media_id
 * @property integer $owner_id
 * @property string $display_filename
 * @property string $filename
 * @property string $caption
 * @property string $file_size
 * @property string $file_type
 * @property string $file_mime_type
 * @property string $file_url
 * @property string $file_path
 * @property string $thumb_url
 * @property string $thumb_path
 * @property integer $thumb_width
 * @property integer $thumb_height
 * @property string $created_at
 * @property string $updated_at
 * @property string $description
 *
 * @property User $owner
 */
class Media extends \yii\db\ActiveRecord
{
        public $upfile;
        public $name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'media';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['owner_id', 'file_size', 'thumb_width', 'thumb_height'], 'integer'],
            [['upfile'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['description', 'name'], 'string'],
            //[['upfile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
            [['display_filename', 'filename', 'caption', 'file_url', 'file_path', 'thumb_url', 'thumb_path'], 'string', 'max' => 255],
            [['file_type', 'file_mime_type'], 'string', 'max' => 100],
            [['owner_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'media_id' => Yii::t('app', 'Media ID'),
            'owner_id' => Yii::t('app', 'Owner ID'),
            'display_filename' => Yii::t('app', 'Display Filename'),
            'filename' => Yii::t('app', 'Filename'),
            'name' => Yii::t('app', 'Name'),
            'caption' => Yii::t('app', 'Caption'),
            'file_size' => Yii::t('app', 'File Size'),
            'file_type' => Yii::t('app', 'File Type'),
            'file_mime_type' => Yii::t('app', 'File Mime Type'),
            'file_url' => Yii::t('app', 'File Url'),
            'file_path' => Yii::t('app', 'File Path'),
            'thumb_url' => Yii::t('app', 'Thumb'),
            'thumb_path' => Yii::t('app', 'Thumb Path'),
            'thumb_width' => Yii::t('app', 'Thumb Width'),
            'thumb_height' => Yii::t('app', 'Thumb Height'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'description' => Yii::t('app', 'Description'),
            'upfile' => Yii::t('app', 'Upfile'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOwner()
    {
        return $this->hasOne(User::className(), ['id' => 'owner_id']);
    }

    /**
     * @inheritdoc
     * @return MediaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaQuery(get_called_class());
    }

    /**
     * Check this mdia created by user
    * @return boolean
    */
    public function createdBy($user)
    {
       return ($this->owner_id == $user) ? true : false;
    }

        /*
         * Before delete
         * @return boolean
         */
        public function afterDelete()
        {
                if ($this->media_id) {
                        $fnArr = explode('.', $this->filename);
                        $fnwithoutExt = implode('.', array_slice($fnArr, 0, -1));
                        $file = $this->file_path . '/' . $this->filename;
                        @unlink($file);
                        if ($fnwithoutExt && $handler = opendir($this->thumb_path)) {
                                while(false !== ($file = readdir($handler))) { 
                                        if ($file != "." && $file != "..") {
                                                if (preg_match('/'.$fnwithoutExt.'/', $file)) {
                                                        $thumb = $this->thumb_path . DIRECTORY_SEPARATOR . $file;
                                                        @unlink($thumb);
                                                }
                                        }
                                }
                        }
                }
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
    
    /**
     * Do file upload process.
     * @param type $name Description
     * @return type Description
     */
    public function upload($where = 'uploads/media', $scenario = null)
    {
        if ( !$scenario ) {              
            $year = date('Y');
            $month = date('m');
            $uploadedDir = Yii::getAlias('@app/web/') . $where;
            $destPath = $uploadedDir . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month;
            $source = $where . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month;
        }
        else {
            $uploadedDir = Yii::getAlias('@app/web/') . $where;
            $destPath = $this->file_path;
            $source = str_replace(Yii::getAlias('@app/web/'), '', $this->file_path);
            $directories = explode('/', $source);
            $year = $directories[2];
            $month = $directories[3];
        }
        
        $UploadedYearPath = $uploadedDir . DIRECTORY_SEPARATOR . $year;
        $UploadedMonthPath = $uploadedDir . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month;
        
        $fname = time() . '_' . str_replace(' ', '_', $this->upfile->name);
        $this->filename = $fname;
        $this->display_filename = $this->upfile->name;
        $this->filename = $fname;
        $this->file_type = $this->checkFiletype($this->upfile->extension);                    
        $this->file_mime_type = $this->upfile->type;
        $this->file_size = $this->upfile->size;
        $fimenameWithoutExt = substr($this->upfile->name, 0, (-1)*((strlen($this->upfile->extension)+1)));
        if ( !$this->caption )
            $this->caption = $fimenameWithoutExt;
        $this->file_url = Yii::$app->params['defaultUrl'] . DIRECTORY_SEPARATOR . $source . DIRECTORY_SEPARATOR . $fname;
        $this->file_path = Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . $source;
        $this->owner_id = \Yii::$app->user->id;

        if ( !is_dir($UploadedYearPath) ) {
            FileHelper::createDirectory($UploadedYearPath);
            chmod($UploadedYearPath, 0707);
        }
        if ( !is_dir($UploadedMonthPath) ) {
            FileHelper::createDirectory($UploadedMonthPath);
            chmod($UploadedMonthPath, 0707);
        }

        $fileToSave = $destPath . DIRECTORY_SEPARATOR . $fname;
        $filepathToSave = $destPath . DIRECTORY_SEPARATOR;

        if ( $this->upfile->saveAs($fileToSave) ) {
            chmod($fileToSave, 0707);
            
            if (is_file($fileToSave) && $this->file_type == 'image') {
                $thumb = $this->createThumb($this->filename, $source, 100, 100);
                $this->thumb_url = $thumb['thumb_url'];
                $this->thumb_path =  $thumb['thumb_path'];
                $this->thumb_width = $thumb['thumb_width'];
                $this->thumb_height = $thumb['thumb_height'];
                $thumb2 = $this->createThumb($this->filename, $source, 250, 250);
            }
            else {
                $this->thumb_url = $this->getThumbnailByFileType($this->file_type);
                $this->thumb_width = 100;
                $this->thumb_height = 100;
            }
            return TRUE;
        }
        
        return FALSE;
    }

    /**
     * Retrieve the file type from the extension of the file uploaded.
     * @param string $ext extension of the file uploaded.
     * @return string
    */
    public function checkFiletype($ext)
    {
        $extToType = array(
             'image'       => array( 'jpg', 'jpeg', 'jpe',  'gif',  'png',  'bmp',   'tif',  'tiff', 'ico' ),
             'audio'       => array( 'aac', 'ac3',  'aif',  'aiff', 'm3a',  'm4a',   'm4b',  'mka',  'mp1',  'mp2',  'mp3', 'ogg', 'oga', 'ram', 'wav', 'wma' ),
             'video'       => array( '3g2',  '3gp', '3gpp', 'asf', 'avi',  'divx', 'dv',   'flv',  'm4v',   'mkv',  'mov',  'mp4',  'mpeg', 'mpg', 'mpv', 'ogm', 'ogv', 'qt',  'rm', 'vob', 'wmv' ),
             'document'    => array( 'doc', 'docx', 'docm', 'dotm', 'odt',  'pages', 'pdf',  'xps',  'oxps', 'rtf',  'wp', 'wpd', 'psd', 'xcf', 'hwp', 'hwt' ),
             'spreadsheet' => array( 'numbers', 'ods',  'xls',  'xlsx', 'xlsm',  'xlsb' ),
             'interactive' => array( 'swf', 'key',  'ppt',  'pptx', 'pptm', 'pps',   'ppsx', 'ppsm', 'sldx', 'sldm', 'odp' ),
             'text'        => array( 'asc', 'csv',  'tsv',  'txt' ),
             'archive'     => array( 'bz2', 'cab',  'dmg',  'gz',   'rar',  'sea',   'sit',  'sqx',  'tar',  'tgz',  'zip', '7z' ),
             'code'        => array( 'css', 'htm',  'html', 'php',  'js' ),
        );

        foreach ($extToType as $key => $value) {
            if(in_array($ext, $value))
                return $key;
        }

        return "none";
    }

    /**
    * Retrieve the file type from the extension of the file uploaded.
    * @return string $filetype the file type retrieved by file extension.  
    */
    public function getThumbnailByFileType( $filetype )
    {
        switch ( $filetype ) {
        case "document":
            return Yii::$app->params['imgUrl'] . "/images/media/document.png";
        case "spreadsheet":
            return Yii::$app->params['imgUrl'] . "/images/media/spreadsheet.png";
        case "interactive":
            return Yii::$app->params['imgUrl'] . "/images/media/interactive.png";
        case "text":
            return Yii::$app->params['imgUrl'] . "/images/media/text.png";
        case "audio":
            return Yii::$app->params['imgUrl'] . "/images/media/audio.png";
        case "video":
            return Yii::$app->params['imgUrl'] . "/images/media/video.png";
        case "archive":
            return Yii::$app->params['imgUrl'] . "/images/media/archive.png";
        case "code":
            return Yii::$app->params['imgUrl'] . "/images/media/code.png";
        default :
            return Yii::$app->params['imgUrl'] . "/images/media/default.png";                
       }
    }
    
        /**
         * Create thumbnail image
         * @param string $filename
         * @param string $path
         * @param integer $dimX
         * @param integer $dimY
         * @return array
         */
        public function createThumb( $filename, $path, $dimX=100, $dimY=100 )
        {             
                $file = Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . $filename;
                $thumbPath = Yii::getAlias('@app/web') . DIRECTORY_SEPARATOR . $path . DIRECTORY_SEPARATOR . "thumbs";
                $splitFilename = explode('.', $filename);
                $size = count($splitFilename);
                $splitFilename[$size - 1] = "_" . $dimX . "x" . $dimY . '.' . $splitFilename[$size - 1];
                $newFilename = implode('', $splitFilename);
                $thumbFile = $thumbPath . DIRECTORY_SEPARATOR . $newFilename;
                $thumb_url = Yii::$app->params['defaultUrl'] . DIRECTORY_SEPARATOR . $path . "/thumbs/" . $newFilename;
                if( !is_dir( $thumbPath ) ) {
                        FileHelper::createDirectory( $thumbPath );
                        chmod( $thumbPath, 0707 );
                }

                \yii\imagine\Image::thumbnail($file, $dimX, $dimY)->save($thumbFile, ['quility'=>100]);
                chmod($thumbFile, 0707);

                return array( 'thumb_url'=>$thumb_url, 'thumb_path'=>$thumbPath, 'thumb_width'=>$dimX, 'thumb_height'=>$dimY );
        }

    /**
     * Get Link for the PrettyPhoto.
     * @return string
     */
    public function getPrettyPhotoTag()
    {
        $ret = "";
        if ($this->file_type == 'image')
            $ret .= '<a href="' . $this->file_url . '" rel="prettyPhoto" title="' . $this->caption . '">'
                . '<img src="' . $this->thumb_url . '" width="' . $this->thumb_width . '" height="' . $this->thumb_height 
                . '" alt="' . $this->display_filename . '" style="padding:2px;"  /></a>';
        else
            $ret .= '<a href="' . $this->file_url . '">'
                . '<img src="' . $this->thumb_url . '" width="' . $this->thumb_width . '" height="' . $this->thumb_height 
                . '" alt="' . $this->display_filename . '" style="padding:2px;"  /></a>';

        return $ret;
    } 
}
