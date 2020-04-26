<div class="title">
    <div class="row">
        <div class="col title-left">
            <h3><?=$title?></h3>
        </div>
        <div class="col title-right">
            <div>
                <button  type="button" class="btn btn-success" data-toggle="modal" onclick="loadAjaxDefault('list')">Danh sách <?=$title?></button>
            </div>
        </div>
    </div>
    <hr />
</div>
<div class="content">
    <form autocomplete="off" method="post" data-url="admin/vocabulary/index/add" action="javascript:void(0)" onsubmit="postAjax(this)">
        <input type="hidden" class="form-control" name="id" value="<?=$id?>">
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Vocabulary</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="e_name" placeholder="Vocabulary" value="<?=$e_name?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tiếng Viết</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="v_name" placeholder="Tiếng Việt" value="<?=$v_name?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Spell</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="spell" placeholder="Spell" value="<?=$spell?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Category</label>
            <div class="col-sm-4">
                <select id="select-category" class="custom-select custom-select-lg mb-3" name="category[]" multiple="multiple" style="width : 100%">
                    <?php foreach($categorys as $k=>$cate){ ?>
                        <option value="<?=$cate['id']?>" <?php if(in_array($cate['id'],$current_categorys)) echo 'selected="selected"' ?>><?=$cate['e_name']?></option>
                    <?php } ?>
                </select>            
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Type</label>
            <div class="col-sm-4">
                <select  class="custom-select custom-select-lg mb-3" name="type">
                    <?php foreach(["n","v","adj","adv","other"] as $it){?>
                        <option value="<?=$it?>" <?php if($it == $type) echo "selected='selected'"; ?>><?=$it?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-4">
                <button class="btn btn-success" type="submit">Save Vocabulary</button>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function() {
        // let test = [{
        //     id : 0,
        //     text : 'Other',
        //     selected : true
        // }]
        let s2 = $('#select-category').select2({
            placeholder: "Chọn thể loại",
            tags: true,
            width : "100%",
            // selected : test
        });
        <?php if(!empty($current_categorys)){ ?>

            // var vals = [<?php foreach($current_categorys as $it){ echo "'Other',"; } ?>];

            // vals.forEach(function(e){
            // if(!s2.find('option:contains(' + e + ')').length) 
            //     s2.append($('<option>').text(e));
            // });
            // console.log(vals)
            // s2.val(vals).trigger("change"); 
        <?php } ?>

    });
</script>