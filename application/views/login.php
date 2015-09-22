<div id="content">
    <div class="signup_wrap">
        <div class="signin_form">
            <div class="form_title">Sign in</div>
            <div class="form_sub_title">It's free and anyone can join</div>
            <?php echo validation_errors('<p class="error">'); ?>
            <form method="post" enctype="multipart/form-data" action="<?= base_url('/User/login')?>">
                <label for="email">Email:</label>
                <input type="text" id="email" name="email" value="" />
                <label for="password">Password:</label>
                <input type="password" id="pass" name="password" value="" />
                <input type="submit" class="" value="Sign in" />
            </form>
        </div>
    </div>
</div>