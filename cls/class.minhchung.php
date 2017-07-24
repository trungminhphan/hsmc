<?php
class MinhChung {
    const COLLECTION = 'minhchung';
    private $_mongo;
    private $_collection;
    public $id = '';
    public $orders = 0;
    public $ten = '';
    public $id_tieuchuan = '';
    public $id_loaivanban = ''; //array();
    public $kyhieu = '';
    public $noiphathanh = '';
    public $sovanban = '';
    public $sovanbanden = '';
    public $nguoiky = '';
    public $ngayky = '';
    public $noidung = '';
    public $dinhkem = array(); //array(filename, aliasname, type, size)
    public $date_post = '';
    public $id_user = '';

    public function __construct(){
        $this->_mongo = DBConnect::init();
        $this->_collection = $this->_mongo->getCollection(MinhChung::COLLECTION);
    }

    public function get_all_list(){
        return $this->_collection->find()->sort(array('date_post'=> 1));
    }

    public function get_list_condition($condition){
        return $this->_collection->find($condition)->sort(array('date_post'=>1));
    }

    public function get_list_limit($limit){
        return $this->_collection->find()->sort(array('date_post'=>-1))->limit($limit);
    }

    public function get_one(){
        $query = array('_id' => new MongoId($this->id));
        return $this->_collection->findOne($query);
    }

    public function insert(){
        $query = array(
            'orders' => $this->orders ? intval($this->orders) : 0,
        	'ten' => $this->ten,
        	'id_tieuchuan' => $this->id_tieuchuan ? new Mongoid($this->id_tieuchuan) : '',
        	'id_loaivanban' => $this->id_loaivanban,
        	'kyhieu' => $this->kyhieu,
        	'noiphathanh' => $this->noiphathanh,
        	'sovanban' => $this->sovanban,
        	'sovanbanden' => $this->sovanbanden,
        	'nguoiky' => $this->nguoiky,
        	'ngayky' => $this->ngayky,
        	'noidung' => $this->noidung,
        	'dinhkem' => $this->dinhkem,
        	'date_post' => new MongoDate(),
        	'id_user' => new MongoId($this->id_user)
        );
        return $this->_collection->insert($query);
    }

    public function edit(){
        $query = array('$set' => array(
            'orders' => $this->orders ? intval($this->orders) : 0,
        	'ten' => $this->ten,
        	'id_tieuchuan' => $this->id_tieuchuan ? new Mongoid($this->id_tieuchuan) : '',
        	'id_loaivanban' => $this->id_loaivanban,
        	'kyhieu' => $this->kyhieu,
        	'noiphathanh' => $this->noiphathanh,
        	'sovanban' => $this->sovanban,
        	'sovanbanden' => $this->sovanbanden,
        	'nguoiky' => $this->nguoiky,
        	'ngayky' => $this->ngayky,
        	'noidung' => $this->noidung,
        	'dinhkem' => $this->dinhkem,
        	'date_post' => new MongoDate(),
        	'id_user' => new MongoId($this->id_user)
        ));
        $condition = array('_id' => new MongoId($this->id));
        return $this->_collection->update($condition, $query);
    }

    public function delete(){
        $query = array('_id' => new MongoId($this->id));
        return $this->_collection->remove($query);
    }

    public function check_dinhkem($aliasname){
        $query = array('dinhkem.aliasname' => $aliasname);
        $filed = array('_id' => true);
        $result = $this->_collection->findOne($query, $filed);
        if(isset($result['_id']) && $result['_id']) return true;
        else return false;
    }

    public function thongketieuchi($arr_tieuchuan){
        $condition = array(
            '$match' => array('id_tieuchuan' => array('$in' => $arr_tieuchuan))
        );
        $sort = array(
            '$sort' => array('_id.orders' => 1)
        );
        $query = array(
            '$group' => array(
                '_id' => array('kyhieu' => '$kyhieu', 'orders' => '$orders')
            )
        );
        $result = $this->_collection->aggregate($condition, $query, $sort);
        if($result && isset($result['result'])) return $result['result'];
        return 0;
    }

    public function thongkenhom(){
        $sort = array(
            '$sort' => array('kyhieu' => 1)
        );
        $query = array(
            '$group' => array(
                '_id' => '$kyhieu',
                'count' => array('$sum' => 1)
            )
        );
        $result = $this->_collection->aggregate($query, $sort);
        if($result && isset($result['result'])) return $result['result'];
        return 0;
    }    
}
?>