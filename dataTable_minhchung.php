<?php
require_once('header_none.php');
$start = isset($_GET['start']) ? $_GET['start'] : 0;
$length = isset($_GET['length']) ? $_GET['length'] : 0;
$draw = isset($_GET['draw']) ? $_GET['draw'] : 1;
$keysearch = isset($_GET['search']['value']) ? $_GET['search']['value'] : '';
$condition = array('$or' => array(array('kyhieu' => new MongoRegex('/' . $keysearch . '/i')), array('ten' => new MongoRegex('/' . $keysearch . '/i')), array('sovanban' => new MongoRegex('/' .$keysearch. '/i'))));
$minhchung = new MinhChung();
$minhchung_list = $minhchung->get_list_to_position_condition($condition, $start, $length);
$recordsTotal = $minhchung->count_all();
$recordsFiltered = $minhchung->get_totalFilter($condition);
$arr_minhchung = array();
if(isset($minhchung_list) && $minhchung_list){
	$i= $start+1;
	foreach ($minhchung_list as $mc) {
		if(!file_exists('uploads/'.$mc['dinhkem'][0]['aliasname'])){
      $filesize = '';//filesize('uploads/'.$mc['dinhkem'][0]['aliasname']);
			$class = 'style="color:#ff0000;font-weight:bold;vertical-align: middle;"';
    } else {
      $class='style="vertical-align: middle;"';
      $filesize = filesize('uploads/'.$mc['dinhkem'][0]['aliasname']);
      $filesize = round($filesize/1048576,2) . ' MB';
    }
		array_push($arr_minhchung, array(
				$i,'<div '.$class.'>' . $mc['kyhieu'] . '</div>',
				$mc['maminhchung'].' '.$mc['ten'],
				$mc['sovanban'],
				$mc['noiphathanh'],
				$mc['maminhchungtrung'],
        $filesize,
				'<a href="get.minhchung.html?id='.$mc['_id'].'&act=copy#modal-minhchung" class="copyminhchung" data-toggle="modal"><i class="fa fa-copy"></i></a>
                <a href="get.minhchung.html?id='.$mc['_id'].'&act=xem#modal-xemminhchung" class="xemminhchung" data-toggle="modal""><i class="fa fa-eye"></i></a>
                <a href="get.minhchung.html?id='.$mc['_id'].'&act=edit#modal-minhchung" class="suaminhchung" data-toggle="modal"><i class="fa fa-edit"></i></a>
                <a href="#modal-xoaminhchung" name="'.$mc['_id'].'" data-toggle="modal" onclick="return false;" class="xoaminhchung"><i class="fa fa-trash"></i></a>
                <a href="uploads/'.$mc['dinhkem'][0]['aliasname'].'" target="_blank"><i class="fa fa-download"></i></a>'));
		$i++;
	}
}
echo json_encode(
  array('draw' => $draw,
        'recordsTotal' => $recordsTotal,
        'recordsFiltered' => $recordsFiltered,
        'data' => $arr_minhchung
    ));
?>



