<?php
class LoaiVanBan {
    const COLLECTION = 'loaivanban';
    private $_mongo;
    private $_collection;

    public $id = '';
    public $ten = '';
    public $thutu = 0;

    public function __construct(){
        $this->_mongo = DBConnect::init();
        $this->_collection = $this->_mongo->getCollection(LoaiVanBan::COLLECTION);
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

    public function insert(){
        $query = array('ten' => $this->ten, 'thutu' => intval($this->thutu));
        return $this->_collection->insert($query);
    }

    public function edit(){
        $query = array('$set' => array( 'ten' => $this->ten, 'thutu' => intval($this->thutu)));
        $condition = array('_id' => new MongoId($this->id));
        return $this->_collection->update($condition, $query);
    }

    public function delete(){
        $query = array('_id' => new MongoId($this->id));
        return $this->_collection->remove($query);
    }

    public function get_vanban($arr){
        $arr_vanban = array();
        if($arr){
            foreach($arr as $key => $value){
                $this->id = $value; $vb = $this->get_one();
                array_push($arr_vanban, $vb['ten']);
            }
        }
        if($arr_vanban) return implode(", ", $arr_vanban);
        else return '';
    }

}
?>