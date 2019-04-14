<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 23.04.2017
 * Time: 2:47
 */
class FileUploader
{
    public $uploadKey;
    public $tempFile;
    public $tmp_name;
    public $originalName;
    public $destFileName = '';
    public $path;
    public $type;
    public $size;
    public $uniqe = true;

    public $mime;

    function __construct($uploadKey, $destPath, $name = null,  $mimeTypes = null, $uniqeName = null)
    {
        $this->uploadKey = $uploadKey;

        if($name) $this->destFileName = $name;

        $this->path = $destPath;

        if($mimeTypes && is_array($mimeTypes))
            $this->mime = $mimeTypes;

        if(!$uniqeName) $this->uniqe = false;

    }

    public function load()
    {
        if( empty($_FILES["{$this->uploadKey}"]) ) return 0;

        if($_FILES["{$this->uploadKey}"]['error'] !== 0)
            throw new Exception("Ошибка загрузки файла");

        $file = $_FILES["{$this->uploadKey}"];

        $this->originalName = basename($file['name']);

        if($this->destFileName == '') $this->destFileName = $this->originalName;

        $this->type = $file['type'];
        $this->size = $file['size'];
        $this->tmp_name = $file['tmp_name'];

        $this->tempFile = $file;

        if ($this->mime && !in_array($this->type, $this->mime))
            throw new Exception("недопустимый MIME тип");

        return true;
    }

    public function save()
    {
        $dest_path = $this->path . $this->destFileName;

        if ($this->uniqe){
            if (file_exists($dest_path)) {
                $i = 1;
                do {
                    $dest_path = $this->path . "(copy$i)" . $this->destFileName;
                    $i++;
                } while (file_exists($dest_path));
            }
        } else {

            if(file_exists($dest_path)) unlink($dest_path);

        }

        move_uploaded_file($this->tmp_name, $dest_path);

    }


    public function getURL()
    {
        $dest_path = $this->path . $this->destFileName;
        $uploadimage_url = str_replace(PATH_MEDIA.DS, "", $dest_path );
        $uploadimage_url = str_replace("\\", "/", $uploadimage_url);
        return $uploadimage_url;
    }

}