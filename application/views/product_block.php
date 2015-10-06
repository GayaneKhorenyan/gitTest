<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <h4><?= $product->prod_name ?></h4>
        </div>
    </div>
    <div class="panel-body" style="margin: auto 15px;">
        <div class="row">
                <div class="col-md-8 col-md-offset-2 prod_view_block" >
                    <div class="row">
                        <div class="col-md-6">
                            <p style="height: 150px">
                                <img src="<?= base_url("/uploads/$product->image")?>" class="prod-img"/>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <p>
                                    <span>
                                        <label class="prod-field-name">Name: </label> <?= $product->prod_name ?>
                                    </span>
                                </p>
                                <p>
                                    <span>
                                        <label class="prod-field-name">Description:</label> <?= $product->description ?>
                                    </span>
                                </p>
                                <hr class="prod-hr" />
                                <p>
                                    <span>
                                        <label class="prod-field-name">Location:</label> <?= $product->location ?>
                                    </span>
                                </p>
                                <hr class="prod-hr" />
                                <p>
                                    <span>
                                        <label class="prod-field-name">Price:</label> <?= $product->price ?> <i class="fa fa-usd price-shadow"></i>
                                    </span>
                                 </p>
                                <hr class="prod-hr" />
                                <p>
                                    <span>
                                        <label class="prod-field-name">Category:</label> <?= $cat_name ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>