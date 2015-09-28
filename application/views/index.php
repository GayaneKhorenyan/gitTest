<div class="container-fluid main-body">
    <header>
        <h2>Welcome Back, <?= $this->session->userdata('first_name'); ?>!</h2>
    </header>
    <article>
        <p>This section represents the area that only logged in members can access.</p>
    </article>
    <a href="javascript:addProducts('<?= base_url("User/add_product") ?>')" >
        <button class="btn btn-default btn-block">Add Category</button>
    </a>
    <div class="row">
        <div class="col-md-6 col-md-offset-3 col-xs-8 col-xs-offset-2">
            <div id="add_product"></div>
        </div>
    </div>
</div>