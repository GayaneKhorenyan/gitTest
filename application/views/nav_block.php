<div class="navbar navbar-default navbar-static-top-top" style="margin-top: 10px" id="navbar_block">
    <div class="collapse navbar-collapse">
        <ul class="nav navbar-nav" id="nav_ul">
            <li><a href="<?= base_url("/User/index"); ?>" >Home</a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Products <b class="caret"></b></a>
                <ul class="dropdown-menu" style="border-radius: 2px" id="nav_sub_ul">
                    <li>
                        <a href="<?= base_url("/Product/user_products"); ?>">My Products</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="<?= base_url("/Product/all_products"); ?>">All Products</a>
                    </li>
                </ul>
            </li>
            <li><a href="<?= base_url("/User/categories"); ?>" >Categories</a></li>
        </ul>
        <div class="navbar-right nav-right-menu" style="margin: 17px 20px 0 0;">
            <a href="<?= base_url("/User/logout"); ?>">Logout
                <i class="fa fa-sign-out "></i>
            </a>
        </div>
        <div class="navbar-right divider-vertical "> </div>
        <div class="navbar-right nav-right-menu" style="margin: 17px 15px 0 0;">
            <a href='#' data-toggle="modal" onclick='javascript:addProducts("<?= base_url('/Product/add_product')?>")' data-target="#product_modal">Add Product
                <i class="fa fa-shopping-cart"></i>
            </a>
        </div>
    </div>
</div>

