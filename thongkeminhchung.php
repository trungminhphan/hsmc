<?php
require_once('header.php');
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$minhchung = new MinhChung();$tieuchuan = new TieuChuan();
$minhchung_list = $minhchung->get_all_list();
$tieuchuan_list = $tieuchuan->get_all_list();
$tk_tieuchuan = $tieuchuan->get_list_condition(array('id_parent' => ''));
$tk_tieuchi = $tieuchuan->get_list_condition(array('id_parent' => array('$ne' => '')));
$minhchung_list = $minhchung->get_all_list();
$minhchungtrung = $minhchung->get_list_condition(array('maminhchungtrung' => array('$ne' => '')));
$tk_nhomminhhchung = $minhchung->thongkenhom();
$count_danhap = 0;
if($minhchung_list){
	foreach($minhchung_list as $mc){
		if(file_exists('uploads/' . $mc['dinhkem'][0]['aliasname'])){
			$count_danhap++;
		}
	}
}
?>
<link href="assets/plugins/jquery-file-upload/blueimp-gallery/blueimp-gallery.min.css" rel="stylesheet" />
<link href="assets/plugins/jquery-file-upload/css/jquery.fileupload.css" rel="stylesheet" />
<link href="assets/plugins/jquery-file-upload/css/jquery.fileupload-ui.css" rel="stylesheet" />
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />
<link href="assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.css" rel="stylesheet" />
<h1 class="page-header"><i class="fa fa-book"></i> THỐNG KÊ MINH CHỨNG</h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-body">
            	<table id="data-table" class="table table-striped table-bordered table-hovered" style="font-size:12px;">
            	<tbody>
            		<tr>
            			<td>Tiêu chuẩn</td>
            			<td><?php echo $tk_tieuchuan->count(); ?></td>
            		</tr>
            		<tr>
            			<td>Tiêu chí</td>
            			<td><?php echo $tk_tieuchi->count(); ?></td>
            		</tr>
            		<tr>
            			<td>Nhóm minh chứng</td>
            			<td><?php echo count($tk_nhomminhhchung); ?></td>
            		</tr>
            		<tr>
            			<td>Tổng số minh chứng con trong nhóm minh chứng</td>
            			<td><?php echo format_number($minhchung_list->count()); ?></td>
            		</tr>
            		<tr>
            			<td>Minh chứng con trùng</td>
            			<td><?php echo format_number($minhchungtrung->count()); ?></td>
            		</tr>
            		<tr>
            			<td>Minh chứng con</td>
            			<td><?php echo format_number($minhchung_list->count() - $minhchungtrung->count()); ?></td>
            		</tr>
            		<tr>
            			<td>Đã nhập liệu minh chứng con</td>
            			<td><?php echo format_number($count_danhap); ?></td>
            		</tr>
            		<tr>
            			<td>Minh chứng con chưa nhập</td>
            			<td><?php echo format_number($minhchung_list->count() - ($minhchungtrung->count() + $count_danhap)); ?></td>
            		</tr>
            		<tr>
            			<td>Đạt</td>
            			<td><?php echo format_number(round(($count_danhap/($minhchung_list->count() - $minhchungtrung->count())*100),2)); ?> %</td>
            		</tr>
            	</tbody>
            	</table>
            </div>
        </div>
    </div>
</div>
<div style="clear:both;"></div>
<?php require_once('footer.php'); ?>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/js/apps.min.js"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>