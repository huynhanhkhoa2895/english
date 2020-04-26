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
    <div class="row lession-content">
        <div class="col-md lession-result">
            <div class="table-result">
                <div class="row button-result">
                    <div class="col">
                        <button type="button" class="btn btn-success" onclick="add('<?=$table?>')">Submit</button>
                    </div>
                    <div class="col" style="text-align : center">
                        <button type="button" data-toggle="modal"  data-target="#randomModal" class="btn btn-warning">Random</button>
                        <div class="modal fade" id="randomModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <input id="numberRandom" type="number"/>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" onclick="random()">Save changes</button>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="text-align : right">
                        <button type="button" onclick="reset('lession')" class="btn btn-danger pull-right">Reset</button>
                    </div>
                </div>
                <div class="row name-lession">
                    <div class="col-11">
                        <input value="<?=$name?>" class="form-control" id="name-lession" placeholder="Tên bài học" />
                    </div>
                    <div class="col-1">
                        <span class="count-vocabulary-in"></span>
                    </div>
                </div>
                <div class="row content-table-result">
                    <table id="content-table-result" class="table table-bordered table-success">
                        <?php if(!empty($id)){ ?>
                            <?php foreach($data as $it){ ?>
                                <tr data-id="<?=$it['id']?>" data-class="<?php if(!empty($it['type'])) echo "vocabulary"; else echo "pharse"?>">
                                    <td><?=$it['e_name']?> <?=$it['type']?></td>
                                    <td><?=$it['v_name']?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md lession-vocabulary">
            <div class="search-vocabulary">
                <div class="row">
                    <div class="col-1">
                        <div class="arrow-push-all-vocabulary" onclick="pushAllVocabularyInto()">
                            <i class="fas fa-arrow-circle-left fa-2x"></i>
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-search"></i></span>
                            </div>
                            <input id="search-vocabulary-input" type="text" class="form-control" placeholder="Vocabulary or Pharse" aria-label="Vocabulary or Pharse" aria-describedby="basic-addon1" onkeyup="onFilter(this,'vocabulary')">
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="check-disable-date">
                            <label class="custom-control-label" for="check-disable-date">Sử dụng ngày</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <input class="form-control" id="daterange-input" type="text" name="daterange" disabled/>                 
                    </div>
                </div>
            </div>
            <div class="filter-vocabulary">
                <div class="row">
                    <div class="col">
                        <select id="select-category" class="form-control" onchange="onFilter(this,'category')">
                            <option value="">-- Mời chọn thể loại</option>
                            <?php foreach($categorys as $category){ ?>
                                <option value="<?=$category['id']?>"><?=$category['e_name']?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col">
                        <select id="select-type" class="form-control" onchange="onFilter(this,'type')">
                            <option value="">-- Mời chọn loại từ</option>
                            <option value="n">n</option>
                            <option value="v">v</option>
                            <option value="adj">adj</option>
                            <option value="adv">adv</option>
                        </select>
                    </div>
                    <div class="col">
                        <select id="select-class" class="form-control" onchange="onFilter(this,'class')">
                            <option value="">-- Mời chọn dạng từ</option>
                            <option value="vocabulary">Vocabulary</option>
                            <option value="pharse">Pharse</option>
                        </select>
                    </div>
                    <div class="col">
                        <select id="select-sort" class="form-control" onchange="onFilter(this,'sort')">
                            <option value="asc">Từ cũ tới mới</option>
                            <option value="desc">Từ mới tới cũ</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-vocabulary" data-date="" data-sort="" data-vocabulary="" data-class="" data-type="" data-category="">

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">   
    list_vocabulary = [];
    list_vocabulary.splice(); 
    id_lession = '<?=$id?>';
    var start = moment().subtract(29, 'days');
    var end = moment();
    var exercise_type = "<?=$exercise_type?>";
    <?php if(!empty($id)){ ?>        
        <?php foreach($data as $it){ ?>
            list_vocabulary.push({id : <?=$it['id']?>,class : '<?php if(!empty($it['type'])) echo "vocabulary"; else echo "pharse"?>'});
        <?php } ?>   
    <?php } ?>     
    $(document).ready(function(){
        let startDate = moment().startOf('hour').format('YYYY-MM-DD')
        let endDate = moment().startOf('hour').format('YYYY-MM-DD')
        $(".count-vocabulary-in").html(list_vocabulary.length);
        $(".table-vocabulary,.content-table-result").slimScroll({
            height : 'calc(100% - 100px)'
        });
        loadTableVocabularyIn({},exercise_type);        
        $(document).on("click",".row-vocabulary",function(event){
            let data = {};        
            data = $(this).data();
            let check = true;
            list_vocabulary.forEach((e)=>{
                if(e.id == data.id && e.class == data.class){
                    $.toast({ 
                        heading: 'Warning',
                        icon: 'warning',
                        text : 'Từ này đã có trong danh sách', 
                        position : 'top-right'      
                    })
                    check = false;
                    return false;
                }
            })
            console.log(check)
            if(!check) return false;
            list_vocabulary.push({id : data.id,class : data.class})
            let html =
            `
                <tr data-id="${data.id}" data-class="${data.class}">
                    <td>${data.e} ${data.type}</td>
                    <td>${data.v}</td>
                </tr>
            `;
            $(".count-vocabulary-in").html(list_vocabulary.length);
            $("#content-table-result").append(html);
            event.stopImmediatePropagation();
            event.stopPropagation()
            event.preventDefault()
        })  
        $(document).on("click","#content-table-result tr",function(){
            let tr = $(this)[0];
            let id = $(tr).data('id');
            let classs = $(tr).data('class');
            list_vocabulary.forEach((e,k)=>{
                if(e.id == id && e.class == classs){
                    list_vocabulary.splice(k,1);
                    $(tr).remove();
                    $(".count-vocabulary-in").html(list_vocabulary.length);
                    return false;
                }            
            })
        }) 
        $('#daterange-input').daterangepicker({
            opens: 'left',
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour'),
            locale: {
                format: 'DD/MM/YYYY'
            }
        }, function(start, end, label) {            
            $(".table-vocabulary").data('date',start.format('YYYY-MM-DD')+'_'+end.format('YYYY-MM-DD'));
            startDate = start.format('YYYY-MM-DD');
            endDate = end.format('YYYY-MM-DD');
            loadTableVocabularyIn({},exercise_type);
        });
        $("#check-disable-date").on("click",function(){
            let it = $(this)[0];
            if(!$(it).prop('checked')){
                $("#daterange-input").prop("disabled",true)
                $(".table-vocabulary").data('date','');
            }else{
                $("#daterange-input").prop("disabled",false)
                $(".table-vocabulary").data('date',startDate+'_'+endDate);
            }
            loadTableVocabularyIn({},exercise_type);
        })
    })
    function loadTableVocabularyIn(data = {},exercise_type = "vocabulary"){  
        data['vocabulary'] = $(".table-vocabulary").data('vocabulary');
        data['class'] = $(".table-vocabulary").data('class');
        data['type'] = $(".table-vocabulary").data('type');
        data['category'] = $(".table-vocabulary").data('category');
        data['sort'] = $(".table-vocabulary").data('sort');
        data['date'] = $(".table-vocabulary").data('date');
        $('.table-vocabulary').load(url+'admin/ajax/lession/loadtable',{filter : data,exercise_type : exercise_type})
    }    
    function add(table = "exercise"){
        let arr = [];
        if($("#name-lession").val() == null || $("#name-lession").val() == '' || list_vocabulary.length == 0){
            $.toast({ 
                heading: 'Warning',
                icon: 'warning',
                text : 'Chưa đầy đủ thông tin', 
                position : 'top-right'      
            })
            return false;
        }   
        $.post(url+`admin/lession/index/add`,{data : list_vocabulary,name : $("#name-lession").val(),id : id_lession,table : table,exercise_type : exercise_type},function(kq){
            reset("lession");
            let res = $.parseJSON(kq);
            if(res.err == 0){
                if(res.action == "edit"){
                    window.location.href = url+"admin/lession";
                    return false;
                }
                $.toast({ 
                    heading: 'Success',
                    icon: 'Success',
                    text : 'Thêm thành công', 
                    position : 'top-right'      
                })
            }else{
                $.toast({ 
                    heading: 'Error',
                    icon: 'Error',
                    text : 'Có lỗi xảy ra', 
                    position : 'top-right'      
                })
            }
        })   
    }
    function random(){
        list_vocabulary = [];
        let number = $("#numberRandom").val();
        if(number == '' || number == 0){
            return false;
        }
        $.get(url+'admin/lession/index/random',{count : number},function(kq){
            let res = $.parseJSON(kq);
            let html = '';
            res.forEach((data)=>{
                list_vocabulary.push({id : data.id,class : data.class})
                html +=
                `
                    <tr>
                        <td>${data.e_name} ${(data.type != null)?"("+data.type+")":""}</td>
                        <td>${data.v_name}</td>
                    </tr>
                `;
            })
            $(".count-vocabulary-in").html(list_vocabulary.length);
            $("#content-table-result").html(html)
        })
    }
    function onFilter(it,type){
        let val = $(it).val();
        $(".table-vocabulary").data(type,val);
        loadTableVocabularyIn();
    }
    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    function pushAllVocabularyInto(){
        list_vocabulary = [];
        list_vocabulary.splice();
        let data = {};
        let html = '';
        $(".table-vocabulary tr").each(function(){
            
            data = {
                id : $(this).data("id"),
                class : $(this).data("class"),
                e_name : $(this).data("e"),
                v_name : $(this).data("v"),
                type : $(this).data("type"),
            }
            list_vocabulary.push({id : data.id,class : data.class})
            html +=
            `
                <tr>
                    <td>${data.e_name} ${(data.type != null)?"("+data.type+")":""}</td>
                    <td>${data.v_name}</td>
                </tr>
            `;
        })
        $(".count-vocabulary-in").html(list_vocabulary.length);
        $("#content-table-result").html(html);
    }
</script>