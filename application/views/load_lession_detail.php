<!DOCTYPE html>
<html lang="vi">
<head>
    <?php $this->load->view('head'); ?>
</head>
<body data-lession="<?=$lession?>">
    <?php $this->load->view('header'); ?>
    <section class="container body-section">
        <h3>Bài <?=$name?></h3>
        <hr/>
        <div class="row test-container">
            <div class="col">
                <table class="table table-bordered table-lession-vocabulary">
                    <thead>
                        <tr>
                            <th style="cursor : pointer" data-show="1" onclick="toggleHide(this,'e')">Hide</th>
                            <th style="cursor : pointer" data-show="1" onclick="toggleHide(this,'v')">Hide</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($lessions as $key=>$t){ ?>                
                            <tr>
                                <td class="col-e-name">
                                    <?=$t['e_name']?> <?php if(!empty($t['type'])) echo '('.$t['type'].')';?>
                                    <?=$this->myfunction->speakEnglish($t['e_name'])?>
                                </td>
                                <td class="col-v-name">
                                    <div class="row">
                                        <div class="col-6">
                                            <?=$t['v_name']?>
                                        </div>
                                        <div class="col-6">
                                            <input class="form-control" />
                                        </div>
                                    </diV>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row test-container">
            <div class="col">
                <table class="table table-bordered table-warning">
                    <thead>
                        <tr>
                            <th>Bài tập</th>
                            <th>Số câu</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($test as $key=>$t){ ?>                
                            <tr>
                                <td>
                                    <a href="<?=base_url("exercise-detail/".$t['id'])?>"><?=$t['name']?></a>
                                </td>
                                <td><?=$t['count']?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</body>
</html>
<?php $this->load->view('script'); ?>
<script type="text/javascript">
    function toggleHide(it,col){
        let show = $(it).data("show");
        if(show == 1){
            $(it).html("Show");
            $(it).data("show",0);
            $(`.col-${col}-name`).css("background","#212529");
            $(".table-lession-vocabulary").addClass("active");
        }else{
            $(it).html("Hide");
            $(it).data("show",1);
            $(`.col-${col}-name`).css("background","#fff");
            $(".table-lession-vocabulary").removeClass("active");
        }
    }
    $(document).on("click",".col-e-name",function(){
        if($(".table-lession-vocabulary").hasClass("active")){
            $(this).find(".span-speak-english").click()
        }
    })
</script>