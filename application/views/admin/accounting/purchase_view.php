<div class="row table-responsive">
    <table class="table table-border">
        <tr>
            <td><h4>Bill No # <?php echo $result->bill_no ?></h4></td>
            <td align="right"><h4>Date: <?php echo $result->date ?></h4></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><h3><?php echo $result->supplier ?></h3></td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="table table-striped">
                    <tr style="font-weight: 900">
                        <td>Item Name</td>
                        <td>Price</td>
                    </tr>
                    <?php
                    foreach (unserialize($result->purchased_data) as $data => $val):
                        ?>
                        <tr>
                            <td><?php echo $data ?></td>
                            <td><?php echo config_item('currency') . $val ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td align="right" colspan="3"><strong>Total
                                Amount: </strong> <?php echo config_item('currency') . $result->bill_amt ?></td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3"><strong>Paid
                                Amount: </strong> <?php echo config_item('currency') . $result->paid_amt ?>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="3"><strong>Due
                                Balance: </strong> <?php echo config_item('currency') . ($result->bill_amt - $result->paid_amt) ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <a href="javascript:history.back()" class="btn btn-danger btn-xs">&larr; Go Back</a>
    <?php if (trim($result->bill_copy) !== "") { ?>
        <a href="<?php echo base_url('uploads/' . $result->bill_copy) ?>" target="_blank" class="btn btn-primary btn-xs">View
            Bill Copy</a>
    <?php } ?>
</div>