<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta name="author" content="Exolim"/>
    <meta name="robots" content="noindex, nofollow">
    <title>Management Dashboard | <?php echo config_item('company_name') ?></title>
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all"
          rel="stylesheet"
          type="text/css"/>
    <style type="text/css">
        table, tr { border : 1px solid #ccc }
    </style>
</head>
<body onload="print()">
<p>&nbsp;</p>
<div class="container-fluid">
    <div class="row table-responsive">
        <table class="table table-border" align="center" style="max-width: 800px">
            <tr>
                <td><h4>INVOICE # <?php echo $this->uri->segment(3) ?></h4></td>
                <td align="right"><h4>Date: <?php echo $result->date ?></h4></td>
            </tr>
            <tr>
                <td style="padding-top: 10%"><strong>Bill By:</strong><br/><?php echo nl2br($result->company_address) ?>
                </td>
                <td style="padding-top: 10%"><strong>Bill To:</strong><br/><?php echo $result->userid ?>
                    <br/><?php echo nl2br($result->bill_to_address) ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <table class="table table-striped">
                        <tr>
                            <td>Item Name</td>
                            <td>Price</td>
                            <td>Qty</td>
                            <td align="right">Tax (eg: GST)</td>
                            <td align="right">Total</td>
                        </tr>
                        <?php
                        foreach (unserialize($result->invoice_data) as $data => $val):
                            $tax = unserialize($result->invoice_data_tax);
                            $qty = unserialize($result->invoice_data_qty);
                            $total += (($val * $qty[$data]) + (($val * $qty[$data]) * $tax[$data]) / 100);
                            ?>
                            <tr>
                                <td><?php echo $data ?></td>
                                <td><?php echo config_item('currency') . $val ?></td>
                                <td><?php echo $qty[$data] ?></td>
                                <td align="right"><?php echo config_item('currency') . ($tax[$data] ? $tax[$data] : 0) ?></td>
                                <td align="right"><?php echo config_item('currency') . (($val * $qty[$data]) + (($val * $qty[$data]) * $tax[$data]) / 100) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td align="right" colspan="5"><strong>Total
                                    Payable: </strong> <?php echo config_item('currency') . $total ?></td>
                        </tr>
                        <tr>
                            <td align="right" colspan="5"><strong>Paid
                                    Amount: </strong> <?php echo config_item('currency') . $result->paid_amt ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right" colspan="5"><strong>Due
                                    Balance: </strong> <?php echo config_item('currency') . (number_format($total - $result->paid_amt, 2)) ?>
                            </td>
                        </tr>
                    </table>
                    * This is an electronically generated invoice, hence no further signature is required.
                </td>
            </tr>
        </table>
        <div align="center">
            <?php if (($total - $result->paid_amt) <= 0) {
                echo '<h1 align="center" style="color: green">PAID</h1>';
            } else {
                echo '<h2 align="center" style="color: red">NOT FULLY PAID</h2>';
            } ?>
        </div>
    </div>
</div>
</body>
</html>