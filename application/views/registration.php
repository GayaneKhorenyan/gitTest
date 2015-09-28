<div class="container">
    <div class="row content">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 content-block">
            <div class="panel-group form-pan-group" >
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h4 class="panel-title">Registration</h4>
                    </div>
                    <div class="panel-body">
                        <form  method="post" enctype="multipart/form-data" action="<?= base_url('/User/registration')?>" role="form" class="">
                            <div class="form-group">
                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?= set_value('first_name'); ?>" placeholder="First Name"/>
                                <div class="error_filds">
                                    <?= form_error('first_name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?= set_value('last_name'); ?>" placeholder="Last Name" />
                                <div class="error_filds">
                                    <?= form_error('last_name'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" id="email" name="email" class="form-control" value="<?= set_value('email'); ?>" placeholder="E-mail"/>
                                <div class="error_filds">
                                    <?= form_error('email'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="file" class="form-control image btn btn-default" id="image" name="image" value="<?= set_value('image'); ?>" />
                                <div class="img-content">
                                    <img class="img_prew" src=""/>
                                </div>

                                <div class="error_filds">
                                    <?= form_error('image'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" id="password" name="password" class="form-control" value="<?= set_value('password'); ?>" placeholder="Password"/>
                                <div class="error_filds">
                                    <?= form_error('password'); ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="password" id="con_password" name="con_password" class="form-control" value="<?= set_value('con_password'); ?>" placeholder="Confirm Password"/>
                                <div class="error_filds">
                                    <?= form_error('con_password'); ?>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success ">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
