$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
})
$(document).on('click','.body-left li[data-href]',function () {
    let href = $(this).data('href');
    $(".body-left ul li").removeClass('active');
    $(this).addClass('active');
    loadAjax('list',href)
})
function loadAjax(action,href,id="") {
    $("#loading").show();
    $.ajax({
        method : 'get',
        type : 'get',
        url : url+'admin/ajax/'+href,
        data : {action : action,id : id},
        success : function (kq) {
            $('.body-right .section-content').html(kq);
            rewrite_url = url+"admin/"+href+"?action="+action;
            if(id != "") rewrite_url += `&id=${id}`;
            console.log(id)
            window.history.pushState(null, null,rewrite_url);
        }
    }).done(function () {
        $("#loading").hide();
    });
}
function loadAjaxDefault(action,id="",option = {}) {
    let done = true;
    let newOption = {};
    href = $('.body-left li.active').data('href')
    if(option.exercise_type){
        $('#ContentSelectExerciseType').on('shown.bs.modal', function (e) {
            $("#ContentSelectExerciseType").modal('hide');
        })
        newOption = {exercise_type : $("#selectTypeExercise").val()}
    }
    if(done){
        $("#loading").show();
        let data = {action : action,id : id,...newOption};
        console.log(data)
        $.ajax({
            method : 'get',
            type : 'get',
            url : url+'admin/ajax/'+href,
            data : data,
            success : function (kq) {
                $('#ContentSelectExerciseType').modal('hide')
                $('.body-right .section-content').html(kq);
                rewrite_url = url+"admin/"+href+"?action="+action;
                if(id != "") rewrite_url += `&id=${id}`;
                if(newOption.exercise_type != null && newOption.exercise_type != "") rewrite_url += `&exercise_type=${newOption.exercise_type}`;
                window.history.pushState(null, null,rewrite_url);
            }
        }).done(function () {
            $("#loading").hide();
        });
    }

}
function uploadExcel(it) {
    let formData = new FormData($(it)[0]);
    $.ajax({
        url: url+'admin/vocabulary/index/postExcel',
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (kq) {
            let res = $.parseJSON(kq);
            if(res.err == 0){
                $.toast({ 
                    heading: 'Success',
                    icon: 'success',
                    text : res.msg, 
                    position : 'top-right'      
                })
                loadAjax('list',$('.body-left li.active').data('href'))
                $("#exampleModal").find('.close').click();
                $(".modal-backdrop").remove();
            }else{
                $.toast({ 
                    heading: 'Fail',
                    icon: 'error',
                    text : res.msg, 
                    position : 'top-right'      
                })
            }
        }
    });
}
function postAjax(it){
    let formData = new FormData($(it)[0]);
    let href = $(it).data('url')
    $.ajax({
        url: url+href,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (kq) {
            let res = $.parseJSON(kq);
            if(res.err == 0){
                $.toast({ 
                    heading: 'Success',
                    icon: 'success',
                    text : res.msg, 
                    position : 'top-right'      
                })
                loadAjax('list',$('.body-left li.active').data('href'))
                $("#exampleModal").find('.close').click();
                $(".modal-backdrop").remove();
                console.log(res);
                if(res.redirect != null && res.redirect != ""){
                    window.location.href = url+res.redirect;
                }
            }else{
                $.toast({ 
                    heading: 'Fail',
                    icon: 'error',
                    text : res.msg, 
                    position : 'top-right'      
                })
            }
        }
    })
}
function confirmDelete(it){
    let href = $(it).data('href');
    if (confirm("Are you sure delete?")) {
        $.get(href,{},function(){
            loadAjaxDefault('list')
        })
        
    }
    return false;
}


function reset(type="exercise"){
    list_vocabulary = [];
    $("#content-table-result").html('');
    $("#name-"+type).val('');
    $(".count-vocabulary-in").html(list_vocabulary.length);
}
function speakEnglish(it){
    let audio = $(it).find("audio");
    audio[0].play();
}
function lessionChangeInResult(){
    
}