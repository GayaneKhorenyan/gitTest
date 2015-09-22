<div id="content">
    <div class="reg_form">
        <div class="form_title">Sign Up</div>
        <div class="form_sub_title">It's free and anyone can join</div>
        <?php echo validation_errors('<p class="error">'); ?>
        <form method="post" enctype="multipart/form-data" action="<?= base_url('/User/registration')?>">
            <p>
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="<?php echo set_value('first_name'); ?>" />
            </p>
            <p>
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="<?php echo set_value('last_name'); ?>" />
            </p>
            <p>
                <label for="email">Your Email:</label>
                <input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" />
            </p>
            <p>
                <label for="image">Your Avatar</label>
                <input type="file" id="image" name="image" value="<?php echo set_value('image'); ?>" />
            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" />
            </p>
            <p>
                <label for="con_password">Confirm Password:</label>
                <input type="password" id="con_password" name="con_password" value="<?php echo set_value('con_password'); ?>" />
            </p>
            <p>
                <input type="submit" class="greenButton" value="Submit" />
            </p>
        </form>
    </div><!--<div class="reg_form">-->
</div>