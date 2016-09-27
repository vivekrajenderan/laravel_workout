<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>EDIT CATEGORY</h3>
            </div>

            <div class="title_right">
                <div class="pull-right">
                    <a href="<?php echo base_url() . 'admin/category/'; ?>" class="btn btn-default" >Category List</a>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit <small>Category</small></h2>
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
                        <form  class="form-horizontal form-label-left" method="post" autocomplete="off" id="category-form" action="<?php echo base_url() . 'admin/category/ajax_edit'; ?>">
                            <input type="hidden" name="pk_cat_id" id="pk_cat_id" value="<?php echo $pk_cat_id;?>">
                            <div class="form-group elVal">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name <span class="required">*</span>
                                </label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="cate_name" name="cate_name" class="form-control col-md-7 col-xs-12" maxlength="30" minlength="3" value="<?php echo $get_category_list[0]['cate_name'];?>">
                                </div>
                            </div>                            
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                    <a href="<?php echo base_url(); ?>admin/category" class="btn btn-primary">Cancel</a>                                    
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
    $(document).ready(function () {

        $("#category-form").validate({
            highlight: function (element) {
                $(element).closest('.elVal').addClass("form-field text-error");
            },
            unhighlight: function (element) {
                $(element).closest('.elVal').removeClass("form-field text-error");
            }, errorElement: 'span',
            rules: {
                cate_name: {
                    required: true,
                    minlength: 3,
                    maxlength: 30,
                    Exist_Category: true
                }
            },
            messages: {
                cate_name: {
                    required: "Please enter Category name"

                }
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.closest(".elVal"));
            },
            submitHandler: function (form) {
                var $form = $("#category-form");
                $.ajax({
                    type: $form.attr('method'),
                    url: $form.attr('action'),
                    data: $form.serialize(),
                    dataType: 'json'
                }).done(function (response) {

                    if (response.status == "1")
                    {
                        window.location = "<?php echo base_url(); ?>admin/category/";
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

        $.validator.addMethod("Exist_Category", function (value, element) {

            var pk_cat_id = $("#pk_cat_id").val();
            var checkCategory = check_exist_category(value, pk_cat_id);
            if (checkCategory == "1")
            {
                return false;
            }
            return true;

        }, "Category Already Exists!");

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

    function check_exist_category(cate_name, pk_cat_id) {
        var isSuccess = 0;
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>admin/category/exist_category_check",
            data: "cate_name=" + cate_name + "&pk_cat_id=" + pk_cat_id,
            async: false,
            success:
                    function (msg) {
                        isSuccess = msg === "1" ? 1 : 0
                    }
        });
        return isSuccess;
    }
</script>