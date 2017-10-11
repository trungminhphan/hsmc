<?php
require_once('header.php');

?>
<h1 class="page-header"><i class="fa fa-book"></i> Minh chứng bổ sung sau ngày 15/06/2017</h1>
<div class="alert alert-danger fade in m-b-15">
  Đang cập nhật, vui lòng quay lại sau!.
</div>

<div style="clear:both;"></div>
<?php require_once('footer.php'); ?>
<!-- ================== BEGIN PAGE LEVEL JS ================== -->
<script src="assets/plugins/gritter/js/jquery.gritter.js"></script>
<script src="assets/plugins/jstree/dist/jstree.min.js"></script>
<script src="assets/js/ui-tree.demo.min.js"></script>
<script src="assets/js/apps.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
<script>
    $(document).ready(function() {
        App.init();TreeView.init();
    });
</script>
