<div id="content">
    <div class="reg_form">
        <div class="form_title">Sign Up</div>
        <form method="post" enctype="multipart/form-data" action="<?= base_url('/User/registration')?>">
            <p>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?= set_value('first_name'); ?>" />
                <div class="error_filds">
                    <?= form_error('first_name'); ?>
                </div>
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?= set_value('last_name'); ?>" />
                <div class="error_filds">
                    <?= form_error('last_name'); ?>
                </div>
            </p>
            <p>
                <label for="email">Your Email:</label>
                <input type="text" id="email" name="email" value="<?= set_value('email'); ?>" />
                <div class="error_filds">
                    <?= form_error('email'); ?>
                </div>
            </p>
            <p>
                <label for="image">Your Avatar</label>
                <input type="file" class="btn btn-default" id="image" name="image" value="<?= set_value('image'); ?>" />
                <img id="img_prew" src=""/>
                <div class="error_filds">
                    <?= form_error('image'); ?>
                </div>
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?= set_value('password'); ?>" />
                <div class="error_filds">
                <?= form_error('password'); ?>
                </div>
            </p>
            <p>
                <label for="con_password">Confirm Password:</label>
                <input type="password" id="con_password" name="con_password" value="<?= set_value('con_password'); ?>" />
                <div class="error_filds">
                    <?= form_error('con_password'); ?>
                </div>
            </p>
            <p>
                <input type="submit" class="btn btn-success" value="Submit" />
            </p>
        </form>
    </div>
</div>

<script>
$('#image').change(function(e){
        var files = e.target.files;
        $('#img_prew').attr({
            src:URL.createObjectURL(files[0])
        }).css({
            width:'180px',
            height:'150px',
            marginTop:'10px'
        });
    }
);
</script>