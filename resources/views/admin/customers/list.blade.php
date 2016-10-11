
@extends('layouts.templatelayout')
@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>USERS LIST</h3>
            </div>

            <div class="title_right">
                <div class="pull-right">
                    <a href="<?php echo url('/admin/user/add'); ?>" class="btn btn-default" >Add User</a>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Users <small>List</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="javascript:void(0);" data-toggle="modal" data-target="#squarespaceModal" title="Upload"><i class="fa fa-upload"></i></a></li>
                            <li><a href="<?php echo url('/admin/user/excel'); ?>" target="_blank" title="Excel"><i class="fa fa-download"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>                      
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="alert alert-success" id="alert-success"  style="display:none;">    
                        </div>
                        <div class="alert alert-error"  id="alert-error" style="display:none;">
                        </div>                        
                        @if(Session::has('ErrorMessages'))
                        <div class="alert alert-error">
                            <button data-dismiss="alert" class="close" type="button">&times;</button>
                            {{ Session::get('ErrorMessages') }}
                        </div><!--alert-->
                        @endif

                        @if(Session::has('SucMessage'))
                        <div class="alert alert-success">
                            <button data-dismiss="alert" class="close" type="button">&times;</button>
                            {{ Session::get('SucMessage') }}
                        </div><!--alert-->
                        @endif
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Mobile Number</th>
                                    <th>VC Number</th>
                                    <th>Created date</th>  
                                    <th>Action</th>     
                                </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($user_list as $key => $list) { ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $list['fname']; ?></td>
                                        <td><?php echo $list['lname']; ?></td>
                                        <td><?php echo $list['emailid']; ?></td>
                                        <td><?php echo $list['mobileno']; ?></td>
                                        <td><?php echo $list['vc_number']; ?></td>
                                        <td><?php echo date("Y-m-d", strtotime($list['created_on'])); ?></td>
                                        <td >   <a href="<?php echo url('/admin/user/edit'); ?>/<?php echo md5($list['pk_cust_id']); ?>" title="edit"><i class="fa fa-edit"></i></a> 
                                            &nbsp;&nbsp;&nbsp;<a title="delete" href="<?php echo url('/admin/user/delete'); ?>/<?php echo md5($list['pk_cust_id']); ?>" onClick="return confirm('Do u really want to delete User?');" > <i class="fa fa-trash"></i></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="switch" <?php
                                            if ($list['standing'] == "1") {
                                                echo "checked";
                                            }
                                            ?> data-id="<?php echo $key; ?>" data-name="<?php echo md5($list['pk_cust_id']); ?>"/>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->
<!--  Modal Box -->



<!-- line modal -->
<div class="modal fade" id="squarespaceModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="modal-title" id="lineModalLabel">My Modal</h3>
            </div>
            <div class="modal-body">

                <!-- content goes here -->
                <div class="row">
                    <div class="col-md-6 col-xs-12 col-sm-6 col-sm-offset-3 col-md-offset-3 col-xs-offset-0">
                        <div class="alert alert-danger" style="display:none;">
                            <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>

                        </div>
                    </div>
                </div>
                <form id="bulkupload-form" action="<?php echo url('/admin/user/importexcel'); ?>" method="post" enctype="multipart/form-data">           
                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                    <div class="form-group elVal">
                        <label for="exampleInputFile">File input</label>
                        <input type="file" id="bulkuploadfile" name="bulkuploadfile">
                        <p class="help-block">Please upload xls format</p>
                    </div>                   
                    <button type="submit" class="btn btn-default">Submit</button>
                </form>

            </div>
            <div class="modal-footer">
                <div role="group" aria-label="group button">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-default" data-dismiss="modal"  role="button">Close</button>
                    </div>				
                </div>
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/bootstrap-switch.js') }}"></script>  
<script>
$(document).ready(function () {
    $("input.switch").bootstrapSwitch();
    $('.switch').on('switchChange.bootstrapSwitch', function (event, state) {
        var standing = 0;
        if (state == true)
        {
            standing = 1;
        }
        var pk_cust_id = $(this).attr('data-name');

        $.ajax({
            type: "POST",
            url: "<?php echo url('/admin/user/change-users-active'); ?>",
            data: "standing=" + standing + "&pk_cust_id=" + pk_cust_id + "&_token={{ csrf_token() }}",
            dataType: 'json'
        }).done(function (response) {

            if (response.status == 1)
            {
                $('#alert-success').show();
                $('#alert-success').html(response.msg);
                setTimeout(function () {
                    $('#alert-success').hide('slow');
                }, 4000);
            }
            else
            {
                $('#alert-error').show();
                $('#alert-error').html(response.msg);
                setTimeout(function () {
                    $('#alert-error').hide('slow');
                }, 4000);
            }
        });
        return false;

    });
}); 

</script>

<script src="{{ asset('lib/jquery.validate.js') }}"></script>
<script>
$(document).ready(function () {

    $("#bulkupload-form").validate({
        highlight: function (element) {
            $(element).closest('.elVal').addClass("form-field text-error");
        },
        unhighlight: function (element) {
            $(element).closest('.elVal').removeClass("form-field text-error");
        }, errorElement: 'span',
        rules: {
            bulkuploadfile: {
                required: true,
                filecheck: true
            }
        },
        messages: {
            bulkuploadfile: {
                required: "Please upload file"

            }
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.closest(".elVal"));
        },
        submitHandler: function (form) {
            var formData = new FormData($('#bulkupload-form')[0]);
            formData.append('import_file', $('input[type=file]')[0].files[0]);
            var $form = $("#bulkupload-form");
            $.ajax({
                type: $form.attr('method'),
                url: $form.attr('action'),
                data: formData,
                async: false,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json'
            }).done(function (response) {
                if (response.status == "1")
                {
                    window.location = "<?php echo url('/admin/user/'); ?>";
//                   $("#bulkupload-form").trigger( "reset" );
//                   $('#modal').modal('toggle');
//                   $('#alert-success').show();
//                   $('#alert-success').html(response.msg);
//                   setTimeout(function () {
//                    $('#alert-success').hide('slow');
//                   }, 4000);
                }
                else
                {                    
                    $('.alert-danger').show();
                    $('.alert-danger').html(response.msg);
                    setTimeout(function () {
                        $('.alert-danger').hide('slow');
                    }, 4000);
                }
                console.log(response);return false;
                
            });
            return false; // required to block normal submit since you used ajax
        }
    });

    $.validator.addMethod("filecheck", function (value, element) {
        var fileExtension = ['xls','xlsx'];
        if ($.inArray(value.split('.').pop().toLowerCase(), fileExtension) == -1) {
            return false;
        }
        else
        {
            return true;
        }
    }, "Please choose format type .xls, .xlsx");


});

//How to add read more link to copied text using jquery
/*
$(document).ready(function () {
    document.body.oncopy = function () {
        var body_element = document.getElementsByTagName('body')[0];
        var selection;
        selection = window.getSelection();
        var pagelink = "<br />Read more at: <a href='" + document.location.href + "'>" + document.location.href + "</a><br />";
        var copytext = selection + pagelink;
        var newdiv = document.createElement('div');
        body_element.appendChild(newdiv);
        newdiv.innerHTML = copytext;
        selection.selectAllChildren(newdiv);
        window.setTimeout(function () {
            body_element.removeChild(newdiv);
        }, 0);
    };
});
*/
</script>
@stop