<?php require_once('header.php');
$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
$tieuchuan = new TieuChuan();$tieuchuan_list = $tieuchuan->get_all_list();
$minhchung = new MinhChung();$loaivanban = new LoaiVanBan();



  //$query = array('id_tieuchuan' => array('$in' => $arr_tieuchuan));
  //$minhchung_list = $minhchung->get_list_condition($query);
    $minhchung_list = $minhchung->get_list_b();
    //var_dump($minhchung_list);

?>
<link href="assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
<link href="assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
<!--<link href="assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />-->
<h1 class="page-header"><i class="fa fa-book"></i> MINH CHỨNG CƠ SỞ DỮ LIỆU</h1>
<?php if(isset($minhchung_list) && $minhchung_list): ?>
<div class="alert alert-success fade in m-b-15">
    <p class="text-center"><strong>TỔNG CỘNG <?php echo $minhchung_list->count(); ?> MINH CHỨNG</strong></p>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-primary">
          <div class="panel-body">
            <table id="data-table" class="table table-striped table-bordered table-hovered" style="font-size:12px;">
                    <thead>
                        <tr>
                            <th width="10" style="text-align: center;vertical-align: middle;">STT</th>
                            <th width="40" style="text-align: center;vertical-align: middle;">Mã MC</th>
                            <th style="text-align: center;vertical-align: middle;">Tên</th>
                            <th style="text-align: center;">Số, tài liệu, ngày ban hành</th>
                            <th style="text-align: center;vertical-align: middle;">Nơi ban hành</th>
                            <!--<th>Ngày ký</th>
                            <th>Người ký</th>
                            <th>Ngày nhập</th>
                            <th>Tiêu chuẩn</th>
                            <th>Loại văn bản</th>
                            <th>Người nhập</th>-->
                            <th class="text-center" width="70">MC Trùng</th>
                            <th class="text-center" width="90">Dung lượng</th>
                            <th class="text-center" width="70">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if($minhchung_list){
                        $i = 1;$count_minhchung_co = 0; $count_minhchung_chuaco = 0;
                        foreach ($minhchung_list as $mc) {
                            if(!file_exists('uploads/' . $mc['dinhkem'][0]['aliasname'])){
                                $class = 'style="color:#ff0000;vertical-align: middle;"';
                                $count_minhchung_chuaco++;
                                $filesize = '';
                            } else {
                                $class='vertical-align: middle;';$count_minhchung_co++;
                                $filesize = filesize('uploads/' . $mc['dinhkem'][0]['aliasname']);
                                $filesize = round($filesize/1048576,2) . ' MB';
                            }
                            echo '<tr style="border-top: 3px solid #ccc;">';
                            echo '<td style="vertical-align: middle;" class="text-center">'.$i.'</td>';
                            echo '<td style="vertical-align: middle;" class="text-center"><b>'.$mc['kyhieu'].'</b></td>';
                            echo '<td '.$class.'>'.$mc['ten'].'</td>';
                            echo '<td style="vertical-align: middle;" class="text-center">'.$mc['sovanban'].'</td>';
                            echo '<td style="vertical-align: middle;" class="text-center">'.$mc['noiphathanh'].'</td>';
                            echo '<td style="vertical-align: middle;" class="text-center">'.$mc['maminhchungtrung'].'</td>';
                            echo '<td style="vertical-align: middle;" class="text-center">'.$filesize.'</td>';
                            if($users->get_username() =='dhag' && in_array($mc['dinhkem'][0]['aliasname'], $arr_visible)){
                                echo '<td></td>';
                            } else {
                                echo '<td style="vertical-align: middle;" class="text-center">
                                    <a href="get.minhchung.html?id='.$mc['_id'].'&act=xem#modal-xemminhchung" class="xemminhchung" data-toggle="modal"><i class="fa fa-eye"></i></a>&nbsp;&nbsp;&nbsp;
                                    <a href="download.html?file='.$mc['dinhkem'][0]['aliasname'].'" target="_blank"><i class="fa fa-download"></i></a>
                                </td>';
                            }
                            echo '</tr>';

                            $i++;
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <?php $total = $count_minhchung_co + $count_minhchung_chuaco; ?>
                <h1 class="page-header"><i class="fa fa-book"></i> Tổng cộng: <?php echo $total; ?>&nbsp;&nbsp;&nbsp; Đã có: <?php echo $count_minhchung_co; ?>&nbsp;&nbsp;&nbsp; Chưa có: <?php echo $count_minhchung_chuaco; ?></h1>
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
<?php else: ?>
    <div class="alert alert-danger fade in m-b-15">
        <strong><i class="fa fa-database"></i> Chưa có dữ liệu!</strong>
    </div>
<?php endif;?>
<div style="clear:both;"></div>
<?php require_once('footer.php'); ?>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/select2/dist/js/select2.min.js"></script>
<script src="assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<!--<script src="assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
-->
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
        /*$("#data-table").DataTable({
            responsive:!0,
            "pageLength": 100,
            //dom:"Bfrtip",
            dom: '<"top"Bfrtip<"clear">>rt<"bottom"iflp<"clear">>',
            buttons:[
                {extend:"excel",className:"btn-sm"},
                {extend:"pdf",className:"btn-sm"},
                {extend:"print",className:"btn-sm"}
            ],
        });*/
        App.init();
    });
</script>
