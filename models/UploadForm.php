<?php

namespace app\models;

use yii\base\Model;
use yii\web\UploadedFile;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', //'extensions' => 'xlsx,xls',
                'mimeTypes'  => [
                    'application/vnd.ms-office',
                    'application/msexcel',
                    'application/x-msexcel',
                    'application/x-ms-excel',
                    'application/x-excel',
                    'application/x-dos_ms_excel',
                    'application/xls',
                    'application/x-xls',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
                    ],
                'wrongMimeType'=> \Yii::t('app','Only excel files are allowed.'),
                'checkExtensionByMimeType' => false,
                'skipOnEmpty' => false],
        ];
    }
    
    public function attributeLabels() {
        return [
            'file' => 'Fichier'
        ];
    }
    
      public function upload() {
         if ($this->file && ($this->validate() || $this->file->type=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet')) {
             //If you're using the "basic" template folder uploads should be created under web
            $this->file->saveAs('uploads/' . $this->file->baseName . '.' .
               $this->file->extension);
            return true;
         } else {
            return false;
         }
      }
      
      public function getFullPath() {
          $fullPath = 'uploads/'.$this->file->baseName.'.'.$this->file->extension;
          if (file_exists($fullPath)){
              return $fullPath;
          }
          return '';
      }
}