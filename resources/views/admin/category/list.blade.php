<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>CATEGORY LIST</h3>
            </div>

            <div class="title_right">
                <div class="pull-right">
                    <a href="<?php echo base_url() . 'admin/category/add'; ?>" class="btn btn-default" >Add Category</a>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Category <small>List</small></h2>
                        <ul class="nav navbar-right panel_toolbox">
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
                        <?php if ($this->session->flashdata('ErrorMessages') != '') { ?>
                            <div class="alert alert-error">
                                <button data-dismiss="alert" class="close" type="button">&times;</button>
                                <?php echo $this->session->flashdata('ErrorMessages'); ?>
                            </div><!--alert-->
                            <?php
                        }

                        if ($this->session->flashdata('SucMessage') != '') {
                            ?>
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close" type="button">&times;</button>
                                <?php echo $this->session->flashdata('SucMessage'); ?>
                            </div><!--alert-->
                        <?php } ?>                          
                        <table id="datatable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.No</th>
                                    <th>Category Name</th>
                                    <th>Created date</th>  
                                    <th>Action</th>     
                                </tr>
                            </thead>


                            <tbody>
                                <?php foreach ($category_lists as $key => $list) { ?>
                                    <tr>
                                        <td><?php echo $key + 1; ?></td>
                                        <td><?php echo $list['cate_name']; ?></td>                                       
                                        <td><?php echo date("Y-m-d", strtotime($list['created_on'])); ?></td>
                                        <td >   <a href="<?php echo base_url(); ?>admin/category/edit/<?php echo md5($list['pk_cat_id']); ?>" title="edit"><i class="fa fa-edit"></i></a> 
                                            &nbsp;&nbsp;&nbsp;<a title="delete" href="<?php echo base_url(); ?>admin/category/delete/<?php echo md5($list['pk_cat_id']); ?>" onClick="return confirm('Do u really want to delete Category?');" > <i class="fa fa-trash"></i></a>
                                            &nbsp;&nbsp;&nbsp;
                                            <input type="checkbox" class="switch" <?php
                                                   if ($list['standing'] == "1") {
                                                       echo "checked";
                                                   }
                                                   ?> data-id="<?php echo $key; ?>" data-name="<?php echo md5($list['pk_cat_id']); ?>"/>

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
<script src="<?php echo base_url(); ?>assets/js/bootstrap-switch.js"></script>  
<script>
    $(document).ready(function () {
        $("input.switch").bootstrapSwitch();
        $('.switch').on('switchChange.bootstrapSwitch', function (event, state) {
            var standing = 0;
            if (state == true)
            {
                standing = 1;
            }
            var pk_cat_id = $(this).attr('data-name');

            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>admin/category/change_category_active",
                data: "standing=" + standing + "&pk_cat_id=" + pk_cat_id,
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