<?php

/**
 * Created by PhpStorm.
 * User: hust
 * Date: 15.02.2017
 * Time: 0:33
 */
class Audiosession extends Storable
{
    public $id;
    public $uri = "";
    public $description = "";
    public $full_description = "";
    public $duration = "";
    public $img1 = "";
    public $img2 = "";
    public $img3 = "";
    public $img4 = "";
    public $caption = "";
    public $created = null;
    public $published = 0;
    public $blocked = 0;
    public $blockstart = null;
    public $blockend = null;


/*    function __construct($uri, $desc, $image, $caption){
        $result = insert('audiosessions', array('url' => $uri, 'desc' => $desc, 'img' => $image, 'caption' => $caption));
        return $result;
    }*/

    static function getAll(){
        return parent::getAll(__CLASS__);
    }

    static function getById($id){
        return parent::getById(__CLASS__, $id);
    }


    static function tableName(){
        return "audiosessions";
    }

    static function getPublished(){
        $audiosessions = Database::getDB()->get('audiosessions', "published=1 and blocked=0");

        foreach($audiosessions as &$audiosession){
            $audiosession = new Audiosession($audiosession);
        }
        return $audiosessions;
    }


    public function getForm(){

        $options = array(
            'id'       => array('type' => 'text', 'required'  => false,  'value' => $this->id),
            'caption'       => array('type' => 'text', 'required'  => true,  'value' => $this->caption),
            'uri'           => array('type' => 'text',  'required'  => true,   'value' => $this->uri),
            'img1'           => array('type' => 'text',  'required'  => true,   'value' => $this->img1),
            'img2'           => array('type' => 'text',  'required'  => false,   'value' => $this->img2),
            'img3'           => array('type' => 'text',  'required'  => false,   'value' => $this->img3),
            'img4'           => array('type' => 'text',  'required'  => false,   'value' => $this->img4),
            'description'   => array('type' => 'text',  'required'  => true,   'value' => $this->description),
            'full_description'   => array('type' => 'text',  'required'  => true,   'value' => $this->full_description),
            'duration'    => array('type' => 'text',  'required'  => false,  'value' => $this->duration),
            'published'    => array('type' => 'checkbox',  'required'  => false,  'value' => $this->published)
        );

        $form = new Form($options);
        return $form;

    }


    public function delete($id){
        $result = Database::getDB()->remove("audiosessions", $id);
        return $result;
    }

    public function save(){

        $data = array(
            "uri" => "'".$this->uri."'",
            "description" => "'".$this->description."'",
            "full_description" => "'".$this->full_description."'",
            "duration" => "'".$this->duration."'",
            "img1" => "'".$this->img1."'",
            "img2" => "'".$this->img2."'",
            "img3" => "'".$this->img3."'",
            "img4" => "'".$this->img4."'",
            "caption" => "'".$this->caption."'",
            "published" => $this->published,
            "blocked" => $this->blocked,
            "blockstart" => "'".$this->blockstart."'",
            "blockend" => "'".$this->blockend."'",
        );

        if($this->id){
            return Database::getDB()->setArray("audiosessions", $data, "id=".$this->id );
        } else {
            return Database::getDB()->insertArray("audiosessions", $data);
        }
    }


    public static function getAudiosessionsFromIDString($str){
        $query = "SELECT * FROM audiosessions WHERE id IN($str)";
        return Database::getDB()->getQuery($query);
    }

    function getFullDescription($id)
    {
        $query = "SELECT * FROM audiosessions WHERE id = $id";

        $result = Database::getDB()->getQuery($query);
        return $result;
    }


    function getFullDescripntion($id)
    {
        $query = "SELECT * FROM audiosessions WHERE id = $id";

        $result = Database::getDB()->getQuery($query);
        return $result;
    }
}