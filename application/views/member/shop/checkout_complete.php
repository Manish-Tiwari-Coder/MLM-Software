<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<table class="table table-bordered">

    <tr>
        <th>Item Description</th>
        <th>QTY</th>
        <th style="text-align:right">Item Price</th>
        <th style="text-align:right">Sub-Total</th>
    </tr>

    <?php $i = 1; ?>

    <?php foreach ($this->cart->contents() as $items): ?>

        <?php echo form_hidden('rowid[]', $items['rowid']); ?>

        <tr>
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
            <td><?php echo $items['qty']; ?></td>

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
<?php
$this->cart->destroy();
?>
<!--<a href="javascript:;" class="btn btn-xs btn-primary" onclick="print()">Print</a>-->