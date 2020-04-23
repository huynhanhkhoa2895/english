
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
    <form autocomplete="off" method="post" data-url="admin/communication/index/add" action="javascript:void(0)" onsubmit="postAjax(this)">
        <input type="hidden" name="action" value="<?=$action?>" />
        <input type="hidden" name="id" value="<?=$id?>" />
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Communication</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="e_name" placeholder="Câu giao tiếp" value="<?=$e_name?>">
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-4 col-form-label">Tiếng việt</label>
            <div class="col-sm-4">
                <input type="text" class="form-control" name="v_name" placeholder="Câu giao tiếp" value="<?=$v_name?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-4 col-form-label"></label>
            <div class="col-sm-4">
                <button class="btn btn-success" type="submit">Save communication</button>
            </div>
        </div>
    </form>
</div>
