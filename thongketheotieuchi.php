<?php require_once('header.php');
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$tieuchuan = new TieuChuan();$tieuchuan_list = $tieuchuan->get_all_list();
$id_tieuchuan = isset($_GET['id_tieuchuan']) ? $_GET['id_tieuchuan'] : '';
$minhchung = new MinhChung();$loaivanban = new LoaiVanBan();
if($id_tieuchuan){
	$query = array('id_tieuchuan' => new MongoId($id_tieuchuan));
	$minhchung_list = $minhchung->get_list_condition($query);
}
?>
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<h1 class="page-header"><i class="fa fa-book"></i> THỐNG KÊ THEO TIÊU CHUẨN - TIÊU CHÍ</h1>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
        	<div class="panel-body">
        		<div class="form-group">
        			<div class="col-md-12">
        			<form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="GET" class="form-horizontal" name="thongkeform" id="thongkeform">
                        <select name="id_tieuchuan" id="id_tieuchuan" class="form-control select2" style="width:100%;">
                        	<option value="">Chọn Tiêu chuẩn - Tiêu chí</option>
                        	<?php
	                        if($tieuchuan_list){
	                            $list = iterator_to_array($tieuchuan_list);
	                            showCategories($list, '', '', array($id_tieuchuan));
	                        }
	                        ?>
                        </select>
                    </form>
                    </div>
        		</div>
        	</div>
        </div>
    </div>
</div>

<?php if(isset($minhchung_list) && $minhchung_list): ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
        	<div class="panel-body">
        		<table id="data-table" class="table table-striped table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên</th>
                            <th>Ngày ký</th>
                            <th>Người ký</th>
                            <th>Ngày nhập</th>
                            <th>Tiêu chuẩn</th>
                            <th>Loại văn bản</th>
                            <th>Người nhập</th>
                            <th class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($minhchung_list){
                        $i = 1;
                        foreach ($minhchung_list as $mc) {
                            $tieuchuan->id = $mc['id_tieuchuan']; $tc = $tieuchuan->get_one();
                            $vb = $loaivanban->get_vanban($mc['id_loaivanban']);
                            $users->id = $mc['id_user']; $u = $users->get_one();
                            echo '<tr>
                                <td>'.$i.'</td>
                                <td>'.$mc['ten'].'</td>
                                <td>'.($mc['ngayky'] ? date("d/m/Y", $mc['ngayky']->sec) : '').'</td>
                                <td>'.$mc['nguoiky'].'</td>
                                <td>'.date("d/m/Y", $mc['date_post']->sec).'</td>
                                <td>'.$tc['ten'].'</td>
                                <td>'.$vb.'</td>
                                <td>'.$u['person'].'</td>
                                <td class="text-center">
                                <a href="get.minhchung.html?id='.$mc['_id'].'&act=xem#modal-xemminhchung" class="xemminhchung" data-toggle="modal""><i class="fa fa-eye"></i></a>                              
                                </td>
                            </tr>';$i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
        	</div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-xemminhchung">
<form action="post.minhchung.html" method="POST" class="form-horizontal" data-parsley-validate="true" name="minhchungform" id="minhchungform">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-info"></i> THÔNG TIN MINH CHỨNG</h4>
            </div>
            <div class="modal-body" id="thongtinminhchung">
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-sm btn-primary" data-dismiss="modal">Đóng</a>
            </div>
        </div>
    </div>
</form>
</div>
<?php endif;?>
<div style="clear:both;"></div>
<?php require_once('footer.php'); ?>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="assets/js/table-manage-default.demo.min.js"></script><!-- begin page-header -->
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function() {
    	$(".select2").select2();
    	$(".xemminhchung").click(function(){
            var _link = $(this).attr("href");
            $.get(_link, function(data){
                $("#thongtinminhchung").html(data);
            });
        });
    	$("#id_tieuchuan").change(function(){
    		$("#thongkeform").submit();
    	});
        App.init();TableManageDefault.init();
    });
</script>