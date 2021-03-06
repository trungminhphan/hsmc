<?php
class TieuChuan {
    const COLLECTION = 'tieuchuan';
    private $_mongo;
    private $_collection;

    public $id = '';
    public $ma = '';
    public $ten = '';
    public $id_parent = '';
    public $mota = '';
    public $orders = 0;

    public function __construct(){
        $this->_mongo = DBConnect::init();
        $this->_collection = $this->_mongo->getCollection(TieuChuan::COLLECTION);
    }

    public function get_all_list(){
        return $this->_collection->find()->sort(array('orders'=>1));
    }

    public function get_list_condition($condition){
        return $this->_collection->find($condition)->sort(array('orders'=>1));
    }

    public function get_one(){
        $query = array('_id' => new MongoId($this->id));
        return $this->_collection->findOne($query);
    }

    public function get_id_by_ma(){
        $query = array('ma' => trim($this->ma));
        $field = array('_id' => true);
        $result = $this->_collection->findOne($query, $field);
        if(isset($result['_id'])) return $result['_id'];
        else return false;
    }

    public function insert(){
        $query = array(
            'ma' => $this->ma,
            'ten' => $this->ten,
            'id_parent' => $this->id_parent ? new MongoId($this->id_parent) : '',
            'mota' => $this->mota,
            'orders' => intval($this->orders)
        );
        return $this->_collection->insert($query);
    }

    public function edit(){
        $query = array('$set' => array(
            'ma' => $this->ma,
            'ten' => $this->ten,
            'id_parent' => $this->id_parent ? new MongoId($this->id_parent) : '',
            'mota' => $this->mota,
            'orders' => intval($this->orders)));
        $condition = array('_id' => new MongoId($this->id));
        return $this->_collection->update($condition, $query);
    }

    public function delete(){
        $query = array('_id' => new MongoId($this->id));
        return $this->_collection->remove($query);
    }

    public function check_dmdonvi($id_parent){
        $query = array('id_parent' => $id_parent ? new MongoId($id_parent) : '');
        $field = array('_id' => true);
        $result = $this->_collection->findOne($query, $field);
        if(isset($result['_id']) && $result['_id']) return true;
        else return false;
    }

    public function check_dmtieuchuan($id_tieuchuan){
        $query = array('id_parent' => new MongoId($id_tieuchuan));
        $field = array('_id' => true);
        $result = $this->_collection->findOne($query, $field);
        if(isset($result['_id']) && $result['_id']) return true;
        else return false;
    }

}
?>