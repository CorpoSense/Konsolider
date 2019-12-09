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
            [['file'], 'file', /*'extensions' => 'xlsx' ,*/ 'skipOnEmpty' => false],
        ];
    }
    
    public function attributeLabels() {
        return [
            'file' => 'Fichier'
        ];
    }
    
      public function upload() {
         if ($this->validate()) {
            $this->file->saveAs('../uploads/' . $this->file->baseName . '.' .
               $this->file->extension);
            return true;
         } else {
            return false;
         }
      }
      
      public function getFullPath() {
          $fullPath = '../uploads/'.$this->file->baseName.'.'.$this->file->extension;
          if (file_exists($fullPath)){
              return $fullPath;
          }
          return '';
      }
}