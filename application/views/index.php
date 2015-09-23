<div id="content">
    <h2>Welcome Back, <?php echo $this->session->userdata('first_name'); ?>!</h2>
    <p>This section represents the area that only logged in members can access.</p>
    <h4><?php echo anchor('/User/logout', 'Logout'); ?></h4>
</div>