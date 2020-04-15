<!DOCTYPE html>
<html lang="vi">
<head>
    <?php $this->load->view('head'); ?>
</head>
<body>
    <?php $this->load->view('header'); ?>
    <section class="body-section">
        <div class="row">
            <div class="col">
                <input class="form-control" value="test" />
                <div class="test"></div>
            </div>
        </div>
    </section>
</body>
</html>
<?php $this->load->view('script'); ?>
<script>
    $(document).ready(function(){
        let input = $(".col").find('input');
        let html = `<p></p>`
        $(".test").html(html);
        $(".test").find('p').html(input)
    })
</script>