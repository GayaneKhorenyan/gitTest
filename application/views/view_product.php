<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <h4><?= $product->prod_name ?></h4>
        </div>
    </div>
    <div class="panel-body">
        <p><?= $product->description ?></p>
        <hr class="prod-hr" />
        <p><?= $product->location ?></p>
        <hr class="prod-hr" />
        <p><?= $product->price ?> <i class="fa fa-usd "></i> </p>
        <hr class="prod-hr" />
        <p><?= $cat_name ?></p>
        <hr class="prod-hr" />
        <p>
            <img src="<?= base_url("./uploads/$product->image")?>" class="prod-img"/>
        </p>
    </div>
</div>