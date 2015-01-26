$(document).ready(function() {

    $('#frmStatus').submit(function(){
//        alert('frmStatusSubmit');
            var url = 'functions.php';
            var frm = $("#frmStatus");
            var data = frm.serializeArray();
            $.ajax({
                type: "POST"
                , url: url
                , data: data
                , dataType: "html"
                , success: function(data){ $('#resultReloading').html(data); alert('success.'); }
                , error: function(data){ /*$('.resultReloading').html(data);*/ alert('error.'); }
                , complete: function(){ alert('complete.'); /*$('.resultReloading').html(data); $('#loading-image').modal('hide'); $('.modal-backdrop').hide();*/ }
            });
    });

});
