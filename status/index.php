<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="libs/img/favicon.ico">
    <base href="http://localhost:1100/project/echo360/game/status/">

    <title>Freebie Game | </title>

    <!-- Bootstrap core CSS -->
    <link href="libs/css/bootstrap.min.css" rel="stylesheet">
    <link href="libs/css/style.css" rel="stylesheet">

    <!-- Bootstrap Validation -->
    <link href="libs/css/bootstrapValidator.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="libs/css/dashboard.css" rel="stylesheet">
<!--    <link href="libs/css/dataTables.bootstrap.css" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="libs/css/datepicker.css">-->

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="libs/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="libs/js/ie-emulation-modes-warning.js"></script>

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="libs/js/ie10-viewport-bug-workaround.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="libs/js/html5shiv.min.js"></script>
    <script src="libs/js/respond.min.js"></script>
    <![endif]-->

    <!-- Placed at the end of the document so the pages load faster -->
    <script src="libs/js/jquery-2.1.1.min.js"></script>
    <script src="libs/js/bootstrap.min.js"></script>
<!--    <script src="libs/js/bootstrap-datepicker.js"></script>-->
    <script src="libs/js/bootstrap-modal.js"></script>
<!--    <script src="libs/js/docs.min.js"></script>-->
<!--    <script src="libs/js/jquery.dataTables.min.js"></script>-->
<!--    <script src="libs/js/dataTables.bootstrap.js"></script>-->
<!--    <script src="libs/js/highcharts.js"></script>-->
<!--    <script src="libs/js/modules/exporting.js"></script>-->
    <!--    <script src="libs/js/bootstrap-datetimepicker.min.js"></script>-->
    <script src="libs/js/bootstrapValidator.js"></script>
    <script src="libs/js/wow.min.js"></script>
<!--    <script src="libs/js/post.js"></script>-->
</head>

<body class="signin-bg">




<section class="container absolute-center wow fadeInDown" style="" data-wow-delay="2.0s">
    <div class="row">
        <div class="col-md-6 absolute-center section-frame" style="padding: 20px;">
            <form id="frmStatus" name="frmStatus" class="" method="post">
                <div class="form-group">
                    <label for="">กรุณากรอกชื่อคุณ ค่ะ.</label>
                    <input type="text" class="form-control" id="userName" name="userName" value="freebie"/>
                </div>
            </form>
            <div class="form-group">
                <button id="frmStatusSubmit" name="frmStatusSubmit" class="btn btn-success col-md-12">ทำไรกัน</button>
            </div>

            <div class="clearfix"></div>
            <div id="resultReloading" class="alpha omega" style="font-family: 'rte_mehuaregular'; font-size: 60px; width: 484px; height: auto;"></div>
        </div>


    </div>
</section>

<!-- Bootstrap core JavaScript
================================================== -->
<!--<script src="./libs/js/data_table_sorting.js"></script>-->

<script type="text/javascript">

    $(document).ready(function() {
        $('#frmStatusSubmit').click(function(){
//        alert('frmStatusSubmit');
        var url = 'functions.php';
        var frm = $("#frmStatus");
        var data = frm.serializeArray(); //alert(data);
        $.ajax({
            type: "post"
            , url: url
            , data: data
            , dataType: "html"
            , success: function(data){ $('#resultReloading').html(data); /*alert('success.');*/ }
            , error: function(data){ /*$('.resultReloading').html(data); alert('error.');*/ }
//            , complete: function(){ alert('complete.'); /*$('.resultReloading').html(data); $('#loading-image').modal('hide'); $('.modal-backdrop').hide();*/ }
        });
        });
    });

</script>
</body>
</html>