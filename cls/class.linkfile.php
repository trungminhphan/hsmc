<?php
class LinkFile{
  const COLLECTION = 'linkfile';
  private $_mongo;
  private $_collection;

  public $id = '';
  public $filename = '';
  public $file_id = '';
  public $link = '';
  public $date_post = '';

  public function __construct(){
    $this->_mongo = DBConnect::init();
    $this->_collection = $this->_mongo->getCollection(LinkFile::COLLECTION);
  }

  public function get_all_list(){
      return $this->_collection->find()->sort(array('thutu'=>1));
  }

  public function get_list_condition($condition){
      return $this->_collection->find($condition)->sort(array('thutu'=>1));
  }

  public function get_one(){
      $query = array('_id' => new MongoId($this->id));
      return $this->_collection->findOne($query);
  }

  public function get_one_condition($condition){
      return $this->_collection->findOne($condition);
  }

  public function insert(){
    $query = array(
      'filename' => $this->filename,
      'file_id' => $this->file_id,
      'link' => $this->link,
      'date_post' => new MongoDate()
    );
    return $this->_collection->insert($query);
  }

  public function delete(){
    $query = array('_id' => new MongoId($this->id));
    return $this->_collection->remove($query);
  }
}
?>
