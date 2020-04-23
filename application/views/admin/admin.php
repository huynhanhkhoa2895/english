<!DOCTYPE html>
<html lang="vi">
<head>
    <?php $this->load->view('admin/head'); ?>
</head>
<body>
<section class="admin-body-section">
    <div class="body-left">
        <ul>
            <li data-href="vocabulary" data-toggle="tooltip" title="Từ vựng" data-placement="right">
                <a  href="javascript:void(0)">
                    <i class="fas fa-language fa-2x"></i>
                </a>
            </li>
            <li data-href="pharse" data-toggle="tooltip" title="Cụm từ" data-placement="right">
                <a  href="javascript:void(0)">
                    <i class="fas fa-radiation fa-2x"></i>
                </a>
            </li>
            <li data-href="category" data-toggle="tooltip" title="Chủ đề" data-placement="right">
                <a  class="" href="javascript:void(0)">
                    <i class="fas fa-layer-group fa-2x"></i>
                </a>
            </li>
            <li data-href="lession" data-toggle="tooltip" title="Bài học" data-placement="right">
                <a  class="" href="javascript:void(0)">
                    <i class="fas fa-address-book fa-2x"></i>
                </a>
            </li>
            <li data-href="exercise" data-toggle="tooltip" title="Bài tập" data-placement="right">
                <a  href="javascript:void(0)">
                    <i class="fab fa-amilia fa-2x"></i>
                </a>
            </li>
            <li data-href="read" data-toggle="tooltip" title="Bài Đọc" data-placement="right">
                <a  href="javascript:void(0)">
                    <i class="fas fa-book fa-2x"></i>
                </a>
            </li>
            <li data-href="communication" data-toggle="tooltip" title="Giao Tiếp" data-placement="right">
                <a  href="javascript:void(0)">
                    <i class="fas fa-church fa-2x"></i>
                </a>
            </li>
            <li data-href="result" data-toggle="tooltip" title="Kết quả" data-placement="right">
                <a  href="javascript:void(0)">
                    <i class="fas fa-thumbs-up fa-2x"></i>
                </a>
            </li>
            <li data-toggle="tooltip" title="Trang chủ" data-placement="right">
                <a  href="<?=base_url()?>">
                    <i class="fas fa-sign-out-alt fa-2x"></i>
                </a>
            </li>            
            <!-- <li data-href="category" data-toggle="tooltip" title="Test" data-placement="right">
                <a  class="" href="javascript:void(0)">
                    <i class="fab fa-adn fa-2x"></i>
                </a>
            </li> -->
        </ul>
    </div>
    <div class="body-right">
        <div id="loading">
            <i class="fas fa-spinner fa-spin fa-4x"></i>
        </div>
        <div class="section-content"></div>
    </div>
</section>
</body>
</html>
<?php $this->load->view('admin/script'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        <?php 
            if(empty($href)) echo "let first_href;";
            else echo "let first_href = `$href`;";
        ?>
        let action = '<?=$action?>';
        let id = '<?php if(!empty($id)) echo $id?>';
        if(first_href == "" || first_href == null ) {
            $('.body-left li a').first().click();
        }
        else {
            $(`.body-left li[data-href='${first_href}']`).addClass('active');
            loadAjax(action,first_href,id)
        }
    });
</script>