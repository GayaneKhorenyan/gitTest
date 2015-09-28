<div class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#responsive-menu">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href="#" class="navbar-brand">Logotip</a>
        </div>
        <div class="collapse navbar-collapse" id="responsive-menu">
            <ul class="nav navbar-nav">
                <li><a href="#">Link1</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Link2 <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Link21</a></li>
                        <li><a href="#">Link22</a></li>
                        <li><a href="#">Link23</a></li>
                        <li><a href="#">Link24</a></li>
                        <li class="divider"></li>
                        <li><a href="#">Link25</a></li>
                    </ul>
                </li>
                <li><a href="#">Link3</a></li>
                <li><a href="#">Link4</a></li>
            </ul>
            <a href="<?= base_url('/User/logout'); ?>" class=" navbar-form navbar-right">
                <button type="button" class="btn btn-danger ">Logout</button>
            </a>
            <a href="<?= base_url("/User/user_products"); ?>" class=" navbar-form navbar-right">
                <button type="button" class="btn btn-success ">Products</button>
            </a>
            <a href="<?= base_url("/User/site"); ?>" class=" navbar-form navbar-right">
                <button type="button" class="btn btn-info ">Home</button>
            </a>
        </div>
    </div>
</div>