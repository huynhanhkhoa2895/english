<div class="title">
    <div class="row">
        <div class="col title-left">
            <h3><?=$title?></h3>
        </div>
        <div class="col title-right">
            <div>
                <?php if($href == 'pharse' || $href == 'vocabulary'){ ?>
                    <button  type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Thêm <?=$title?> bằng file Excel</button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Chọn file Excel thêm từ vựng</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="javascript:void(0)" class="form" enctype="multipart/form-data" method="post" id="formExcel" onsubmit="uploadExcel(this)">
                                        <input style="display: block" type="file" name="fileExcel">
                                        <button class="btn btn-primary" type="submit">Upload file</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <?php if($href != 'result'){ ?>
                    <?php if($href == 'exercise'){ ?>
                        <button  type="button" class="btn btn-success" data-toggle="modal" onclick="openSelectType()">Thêm <?=$title?></button>
                    <?php }else{ ?>
                        <button  type="button" class="btn btn-success" data-toggle="modal" onclick="loadAjaxDefault('add')">Thêm <?=$title?></button>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
    <hr />
</div>
<div class="content">
    <table id="table-simple-<?=$href?>" class="table table-striped table-bordered">
        <thead>
        <tr>
            <?php foreach($header as $head){ ?>
                <th><?=$head?></th>
            <?php } ?>
        </tr>
        </thead>
    </table>
    <script type="text/javascript">        
        $(document).ready(function(){
            $('#table-simple-<?=$href?>').dataTable( {
                processing: true,
                "serverSide": true,
                "ajax": {
                    "type": "GET",
                    'url': url+'admin/table/index',
                    'data' : {href : '<?=$href?>'},
                },
                columns: [
                    <?php foreach($header as $k=>$head){ ?>
                        { data: "<?=$k?>" },
                    <?php } ?>
                ],
            });
        });
    </script>
</div>
<?php if($href == 'exercise'){ ?>
<div class="modal" id="ContentSelectExerciseType" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Chọn loại bài tập</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4 label">Chọn loại bài tập</div>
                    <div class="col-8">
                        <select id="selectTypeExercise" class="form-control">
                            <option value="vocabulary">Bài tập từ vựng</option>
                            <option value="communication">Bài tập giao tiếp</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="loadAjaxDefault('add','',{exercise_type : true})">Tiếp tục</button>
            </div>
        </div>
    </div>
</div>
<script>
    function openSelectType(){
        $('#ContentSelectExerciseType').modal('show')
    }
</script>
<?php } ?>