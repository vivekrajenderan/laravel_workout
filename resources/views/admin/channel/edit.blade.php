<link href="<?php echo base_url(); ?>assets/select2/select2.min.css" rel="stylesheet">
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>CHANNEL LIST</h3>
            </div>

            <div class="title_right">
                <div class="pull-right">
                    <a href="<?php echo base_url() . 'admin/category/channel_list'; ?>" class="btn btn-default" >Channel List</a>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Channel <small>List</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                            </li>                      
                            <li><a class="close-link"><i class="fa fa-close"></i></a>
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <br />
                        <div class="row">
                            <div class="col-md-6 col-xs-12 col-sm-6 col-sm-offset-3 col-md-offset-3 col-xs-offset-0">
                                <div class="alert alert-danger" style="display:none;">
                                    <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>

                                </div>
                            </div>
                        </div>
                        <form  class="form-horizontal form-label-left" method="post" autocomplete="off" id="category-form" action="<?php echo base_url() . 'admin/category/ajax_edit_channel'; ?>">
                            <input type="hidden" name="pk_ch_id" id="pk_ch_id" value="<?php echo $pk_ch_id; ?>">
                            <div class="form-group elVal">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Select Category</label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <select class="select2_single form-control" tabindex="-1" name="pk_cat_id" id="pk_cat_id">
                                        <option></option>                                        
                                        <?php foreach ($category_lists as $key => $cate_list) { ?>
                                            <option value="<?php echo $cate_list['pk_cat_id']; ?>" <?php
                                            if ($get_channel_list[0]['fk_cat_id'] == $cate_list['pk_cat_id']) {
                                                echo "selected";
                                            }
                                            ?>><?php echo $cate_list['cate_name']; ?></option>
                                                <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group elVal">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Channel Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="channel_name" name="channel_name" class="form-control col-md-7 col-xs-12" maxlength="30" minlength="3" value="<?php echo $get_channel_list[0]['channel_name']; ?>">
                                </div>
                            </div>    
                            <div class="form-group elVal">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Channel Number <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="channel_no" name="channel_no" class="form-control col-md-7 col-xs-12" maxlength="30" minlength="3" value="<?php echo $get_channel_list[0]['channel_no']; ?>">
                                </div>
                            </div>                             
                            <div class="form-group elVal">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Channel URL <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="channel_url" name="channel_url" class="form-control col-md-7 col-xs-12" maxlength="150" minlength="3" value="<?php echo $get_channel_list[0]['channel_url']; ?>">
                                </div>
                            </div> 



                            <div class="row"> 
                                <div class="form-group elVal">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Channel Logo <span class="required">*</span>
                                    </label>

                                    <div class="col-md-6 col-sm-6 col-xs-12">  

                                        <?php
                                        $display = "";                                        
                                        if ($get_channel_list[0]['channel_logo'] != '' && isset($get_channel_list[0]['channel_logo'])) {
                                            $display = "none";
                                            if (file_exists("./upload/channel/".$get_channel_list[0]['channel_logo'])) {
                                                $image_name = $get_channel_list[0]['channel_logo'];
                                            } else {
                                                $image_name = "no_image.png";
                                            }
                                            ?>
                                            <div class="control-group file-select-main" id='channel_image'> 

                                                <img class="img-thumbnail" src="<?php echo base_url() . 'upload/channel/' . $image_name; ?>" alt="" width="100" height="100"/></a>
                                                &nbsp;&nbsp;<a href="javascript:void(0);" onclick="RemoveImage();" class="btn btn-dark" title="Delete Logo">Remove</a>

                                            </div>   
                                        <?php } ?>


                                        <!-- image-preview-filename input [CUT FROM HERE]-->
                                        <div class="input-group image-preview" id="channel_image_content" style="padding-left: 5px;display:<?php echo $display; ?>;">
                                            <input type="text" class="form-control image-preview-filename" disabled="disabled">
                                            <span class="input-group-btn">
                                                <!-- image-preview-clear button -->
                                                <button type="button" class="btn btn-default image-preview-clear" style="display:none;">
                                                    <span class="fa fa-remove"></span> Clear
                                                </button>
                                                <!-- image-preview-input -->
                                                <div class="btn btn-default image-preview-input">
                                                    <span class="fa fa-folder-open"></span>
                                                    <span class="image-preview-input-title">Browse</span>
                                                    <input type="file" name="channel_logo" id="channel_logo" accept="image/png, image/jpeg, image/gif" name="input-file-preview"/> <!-- rename it -->
                                                </div>
                                            </span>
                                        </div>                                       
                                        <!-- /input-group image-preview [TO HERE]--> 
                                    </div>
                                </div>
                            </div>

                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="<?php echo base_url(); ?>admin/category/channel_list" class="btn btn-primary">Cancel</a>                                    
                                    <button type="submit" class="btn btn-success">Submit</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /page content -->

<script src="<?php echo base_url(); ?>/assets/lib/jquery.validate.js"></script>
<script>
function RemoveImage()
{
    $("#channel_image").hide();
    $("#channel_image_content").show();
}
$(document).ready(function () {

    $("#category-form").validate({
        highlight: function (element) {
            $(element).closest('.elVal').addClass("form-field text-error");
        },
        unhighlight: function (element) {
            $(element).closest('.elVal').removeClass("form-field text-error");
        }, errorElement: 'span',
        rules: {
            pk_cat_id: {
                required: true
            },
            channel_name: {
                required: true,
                minlength: 3,
                maxlength: 30,
                Exist_Channel: true
            },
            channel_no: {
                required: true,
                minlength: 3,
                maxlength: 40,
            },
            channel_url: {
                required: true,
                minlength: 3,
                maxlength: 150,
                url: true
            },
            channel_logo: {
                required: true,
                imagefilecheck: true
            }

        },
        messages: {
            pk_cat_id: {
                required: "Please Choose Category Name"
            },
            channel_name: {
                required: "Please enter Channel name"
            },
            channel_no: {
                required: "Please enter Channel Number"
            },
            channel_url: {
                required: "Please enter Channel URL"
            },
            channel_logo: {
                required: "Please choose Channel Logo"
            }
        },
        errorPlacement: function (error, element) {
            error.appendTo(element.closest(".elVal"));
        },
        submitHandler: function (form) {
            var formData = new FormData($('#category-form')[0]);
            formData.append('channel_logo', $('input[type=file]')[0].files[0]);
            var $form = $("#category-form");
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
                    window.location = "<?php echo base_url(); ?>admin/category/channel_list";
                }
                else
                {
                    $('.alert-danger').show();
                    $('.alert-danger').html(response.msg);
                    setTimeout(function () {
                        $('.alert-danger').hide('slow');
                    }, 4000);
                }
            });
            return false; // required to block normal submit since you used ajax
        }
    });

    $.validator.addMethod("Exist_Channel", function (value, element) {

        var pk_ch_id = $("#pk_ch_id").val();
        var fk_cat_id = $("#pk_cat_id").val();
        var checkCategory = check_exist_category(value, pk_ch_id, fk_cat_id);
        if (checkCategory == "1")
        {
            return false;
        }
        return true;

    }, "Category Already Exists!");

    $.validator.addMethod("imagefilecheck", function (value, element) {
        var fileExtension = ['jpeg', 'jpg', 'png', 'gif', 'bmp'];
        if ($.inArray(value.split('.').pop().toLowerCase(), fileExtension) == -1) {
            return false;
        }
        else
        {
            return true;
        }
    }, "Please choose format type .jpg, .jpeg, .png, .gif, .bmp");

    $.validator.addMethod("Alphaspace", function (value, element) {
        return this.optional(element) || /^[a-z ]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");

    $.validator.addMethod("Alphanumeric", function (value, element) {
        return this.optional(element) || /^[a-z0-9]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes.");

    $.validator.addMethod("nowhitespace", function (value, element) {
        return this.optional(element) || /^\S+$/i.test(value);
    }, "Space are not allowed");

});

function check_exist_category(channel_name, pk_ch_id, fk_cat_id) {
    var isSuccess = 0;
    $.ajax({
        type: "POST",
        url: "<?php echo base_url(); ?>admin/category/exist_channel_check",
        data: "channel_name=" + channel_name + "&pk_ch_id=" + pk_ch_id + "&fk_cat_id=" + fk_cat_id,
        async: false,
        success:
                function (msg) {
                    isSuccess = msg === "1" ? 1 : 0
                }
    });
    return isSuccess;
}
</script>
<script src="<?php echo base_url(); ?>assets/select2/select2.full.min.js"></script>


<script>
$(document).ready(function () {
    $(".select2_single").select2({
        placeholder: "Select a Category",
        allowClear: true
    });
});
$(document).on('click', '#close-preview', function () {
    $('.image-preview').popover('hide');
    // Hover befor close the preview
    $('.image-preview').hover(
            function () {
                $('.image-preview').popover('show');
            },
            function () {
                $('.image-preview').popover('hide');
            }
    );
});

$(function () {
    // Create the close button
    var closebtn = $('<button/>', {
        type: "button",
        text: 'x',
        id: 'close-preview',
        style: 'font-size: initial;',
    });
    closebtn.attr("class", "close pull-right");
    // Set the popover default content
    $('.image-preview').popover({
        trigger: 'manual',
        html: true,
        title: "<strong>Preview</strong>" + $(closebtn)[0].outerHTML,
        content: "There's no image",
        placement: 'bottom'
    });
    // Clear event
    $('.image-preview-clear').click(function () {
        $('.image-preview').attr("data-content", "").popover('hide');
        $('.image-preview-filename').val("");
        $('.image-preview-clear').hide();
        $('.image-preview-input input:file').val("");
        $(".image-preview-input-title").text("Browse");
    });
    // Create the preview image
    $(".image-preview-input input:file").change(function () {
        var img = $('<img/>', {
            id: 'dynamic',
            width: 250,
            height: 200
        });
        var file = this.files[0];
        var reader = new FileReader();
        // Set preview image into the popover data-content
        reader.onload = function (e) {
            $(".image-preview-input-title").text("Change");
            $(".image-preview-clear").show();
            $(".image-preview-filename").val(file.name);
            img.attr('src', e.target.result);
            $(".image-preview").attr("data-content", $(img)[0].outerHTML).popover("show");
        }
        reader.readAsDataURL(file);
    });
});
</script>