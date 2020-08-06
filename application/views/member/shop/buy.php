<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="col-sm-12">
    <div class="row">
        <?php
        if (!$product) {
            foreach ($categories as $e) { ?>
                <a href="<?php echo site_url('cart/show_products/' . $e->id) ?>">
                    <div class="col-sm-4 img-thumbnail thumbnail" style="background-color: snow">
                        <h4 align="center" style="color: #e7505b"><?php echo $e->cat_name ?></h4>
                        <hr/>
                        <?php echo $e->description ?>
                    </div>
                </a>
            <?php }
        } ?>
    </div>
</div>
<?php if (isset($product_top)) { ?><?php
    foreach ($product_top as $e) { ?>
        <a href="<?php echo site_url('cart/buy_2/' . $e->id) ?>">
            <div class="col-sm-4">
                <div class="thumbnail">
                    <img src="<?php echo base_url('uploads/' . ($e->image ? $e->image : 'default.jpg')) ?>"
                         style="height: 150px !important;" alt="<?php echo $e->prod_name ?>">
                    <div class="caption">
                        <h3><?php echo $e->prod_name ?></h3>
                        <p><strong>Cost: </strong><?php echo $e->prod_price ?></p>
                        <p><a href="<?php echo site_url('cart/buy_2/' . $e->id) ?>" class="btn btn-primary"
                              role="button">Buy</a></p>
                    </div>
                </div>
            </div>
        </a>
    <?php } ?>

<?php } ?>
<?php
foreach ($product as $e) { ?>
    <a href="<?php echo site_url('cart/buy_2/' . $e->id) ?>">
        <div class="col-sm-4">
            <div class="thumbnail">
                <img src="<?php echo base_url('uploads/' . ($e->image ? $e->image : 'default.jpg')) ?>"
                     style="height: 150px !important;" alt="<?php echo $e->prod_name ?>">
                <div class="caption">
                    <h3><?php echo $e->prod_name ?></h3>
                    <p><strong>Cost: </strong><?php echo $e->prod_price ?></p>
                    <p><a href="<?php echo site_url('cart/buy_2/' . $e->id) ?>" class="btn btn-primary" role="button">Buy</a>
                    </p>
                </div>
            </div>
        </div>
    </a>
<?php } ?>
