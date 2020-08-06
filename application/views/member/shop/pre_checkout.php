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
    <?php if ($this->cart->contents()) { ?><?php echo form_open('cart/update'); ?>
        <div class="row table-responsive">
            <table class="table table-bordered">

                <tr>
                    <th>QTY</th>
                    <th>Item Description</th>
                    <th style="text-align:right">Item Price</th>
                    <th style="text-align:right">Sub-Total</th>
                </tr>

                <?php $i = 1; ?>

                <?php foreach ($this->cart->contents() as $items): ?>

                    <?php echo form_hidden('rowid[]', $items['rowid']); ?>

                    <tr>
                        <td><?php echo form_input(array('name'      => 'qty[]]',
                                                        'value'     => $items['qty'],
                                                        'maxlength' => '3',
                                                        'size'      => '5',
                                                  )); ?></td>
                        <td>
                            <?php echo $items['name']; ?>

                            <?php if ($this->cart->has_options($items['rowid']) == TRUE) : ?>

                                <p>
                                    <?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>

                                        <strong><?php echo $option_name; ?>:</strong> <?php echo $option_value; ?><br/>

                                    <?php endforeach; ?>
                                </p>

                            <?php endif; ?>

                        </td>
                        <td style="text-align:right"><?php echo config_item('currency') . $this->cart->format_number($items['price']); ?></td>
                        <td style="text-align:right"><?php echo config_item('currency') . $this->cart->format_number($items['subtotal']); ?></td>
                    </tr>

                    <?php $i++; ?>

                <?php endforeach; ?>

                <tr>
                    <td colspan="2"></td>
                    <td class="right"><strong>Total</strong></td>
                    <td class="right"><?php echo config_item('currency') . $this->cart->format_number($this->cart->total()); ?></td>
                </tr>

            </table>

            <p><?php echo form_submit('', 'Update your Cart'); ?></p>
            <a href="<?php echo site_url('cart/checkout') ?>" class="btn btn-success">Checkout &rarr;</a>
            <a href="<?php echo site_url('cart/new-purchase') ?>" class="btn btn-danger">Buy More Items &rarr;</a>
        </div>
        <?php echo form_close();
    }
    else {
        echo '<h3 align="center">:( You have no item in your cart</h3>';
    } ?>
</div>
