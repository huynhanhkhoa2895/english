<!DOCTYPE html>
<html lang="vi">
<head>
    <?php $this->load->view('head'); ?>
</head>
<body data-exercise="<?=$exercise?>">
    <?php $this->load->view('header'); ?>
    <section class="container body-section">
        <h3>Bài <?=$name?></h3>
        <hr/>
        <?php if($type=="vocabulary"){ ?>
            <div class="test-container">
                <?php foreach($test as $key=>$t){ ?>                
                    <div data-stt="<?=$key?>" data-id="<?=$t['id']?>" data-last="<?=count($test)-1?>" data-e="<?=$t['e_name']?>" data-v="<?=$t['v_name']?>" data-type="<?php if(!empty($t['type'])) echo $t['type'];?>" data-class="<?php if(!empty($t['type'])) echo 'vocabulary'; else echo 'pharse' ?>" class="row test-content <?php if($key == 0) echo "active"; ?>">
                        <div class="col-2">
                            <h4>Câu <?=$key+1?></h4>
                        </div>
                        <div class="col-4">
                            <h4>
                                <?php if(empty($isListen)){ ?>
                                    <?=$t['v_name']?> <?php if(!empty($t['type'])) echo '('.$t['type'].')';?>
                                <?php }else{ ?>
                                    <?=$this->myfunction->speakEnglish($t['e_name'])?>
                                <?php } ?>
                            </h4>
                        </div>
                        <div class="col-4">
                            <p><input data-id="<?=$t['id']?>" autocomplete="off" name="input-<?=$t['id']?>-<?php if(!empty($t['type'])) echo 'vocabulary'; else echo 'pharse' ?>" id="input-vocabulary-<?=$t['id']?>" class="input-vocabulary form-control"></p>
                            <p><button id="btn-vocabulary-<?=$t['id']?>" onclick="nextExercise(this)" type="button" class="btn btn-primary">Tiếp tục</button></p>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="test-result">
                <div style="" class="result"></div>
            </div>
        <?php }else{ ?>
            <div class="test-container">
                <?php foreach($test as $key=>$t){ ?>                
                    <div data-stt="<?=$key?>" data-id="<?=$t['id']?>" data-last="<?=count($test)-1?>" data-e="<?=$t['e_name']?>" data-v="<?=$t['v_name']?>" data-type="<?php if(!empty($t['type'])) echo $t['type'];?>" data-class="<?php if(!empty($t['type'])) echo 'vocabulary'; else echo 'pharse' ?>" class="row test-content <?php if($key == 0) echo "active"; ?>">
                        <div class="col-2">
                            <h4>Câu <?=$key+1?></h4>
                        </div>
                        <div class="col-4">
                            <h4>
                                <span class=""><?=$t['v_name']?> <?php if(!empty($t['type'])) echo '('.$t['type'].')';?></span>
                                <?=$this->myfunction->speakEnglish($t['e_name'])?>                                    
                            </h4>
                        </div>
                        <div class="col-4">
                            <div>
                                <textarea data-id="<?=$t['id']?>" autocomplete="off" id="input-vocabulary-<?=$t['id']?>" class="input-vocabulary form-control">
                                </textarea>
                            </div>
                            <div><button id="btn-vocabulary-<?=$t['id']?>" onclick="nextExercise(this)" type="button" class="btn btn-primary">Tiếp tục</button></div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        <div class="test-button row">
            <div class="col-4">
                <?php if(!empty($lession)){ ?>
                    <a href="<?=base_url("lession-detail/".$lession)?>" class="btn btn-success">Quay về DS bài học</a>
                <?php } ?>
            </div>
            <div class="col-4">
                <a href="<?=base_url("exercise")?>" class="btn btn-danger">Quay về DS bài tập</a>
            </div>
            <div class="col-4">
                <a href="<?=base_url("exercise-detail/".$exercise)?>" class="btn btn-warning">Làm lại</a>
            </div>
        </div>
    </section>
</body>
</html>
<?php $this->load->view('script'); ?>
<script type="text/javascript">
    let result = {'true' : 0,'false' : 0};
    $(document).ready(function(){
        $(".span-speak-english").first().click();
        $(document).on("keyup",".input-vocabulary",function(e){
            let id = $(this).data("id");
            if(e.keyCode == 13){
                console.log("đã bấm");
                $("#btn-vocabulary-"+id).click();
            }
        })
    })
    function nextExercise(it){
        $('.test-content').removeClass("active");
        let answer = $(it).parents('.test-content').find('input').val();
        let content = $(it).parents('.test-content')
        let last = $(content).data('last');
        let stt = $(content).data('stt');
        let e = $(content).data('e');
        $("input").focus()
        if(e == answer){
            $(content).find('input').addClass('is-valid'); 
            result['true']++;
        }
        else{
            $(content).find('input').addClass('is-invalid');
            let val = $(content).find('input').val();
            $(content).find('input').val(val+` (${e})`)
            result['false']++ ;     
        }   
        if(stt != last){
            stt += 1;
            if($(".span-speak-english").length != 0){
                $(`.test-content[data-stt=${stt}]`).find(".span-speak-english").click();
            }
            let input = $(`.test-content[data-stt=${stt}]`).find("input")[0];
            console.log(stt);
            $(input).focus()
            $(`.test-content[data-stt=${stt}]`).addClass("active");
        }else{
            let html = 
            `
                <span style="color : red">${result['true']}</span> / <span style="color : green">${last+1}</span>
                <span>(Point: ${Math.round(result['true']/(last+1) *1000) /100})</span>
            `;
            $(`.test-content`).addClass("active");
            $(".test-result .result").html(html);
            $(".test-container button").hide();       
            saveResultTest({'true' : result['true'],'false' : result['false'],point : Math.round(result['true']/(last+1) *1000) /100})
        }
    }
    function saveResultTest(data = {}){        
        let id,table;
        let logs= {};
        logs['true'] = {};
        logs['false'] = {};
        let exercise = $("body").data("exercise");
        $(".test-container input").each(function(k,e){            
            id = $(e).parents(".test-content").data("id");
            table = $(e).parents(".test-content").data("class");
            logs[id] = {};
            logs[id]['class'] = table;
            if($(e).hasClass('is-valid')){
                logs[id]['result'] = true;
            }else{
                logs[id]['result'] = false;
            }
        })
        $.post(url+"home/saveLog",{logs : logs,exercise : exercise,data : data},function(kq){
            
        })
    }
</script>