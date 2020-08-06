<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/

$top_id = $this->uri->segment('3') ? $this->uri->segment('3') : $this->session->user_id;

?>
<div class="col-sm-5">
    <table class="table">
        <tr>
            <td style="font-size: 12px" width="33.33%">
                <img src="<?php echo base_url('uploads/site_img/green.png') ?>"><br/>
                Green User
            </td>
            <td style="font-size: 12px" width="33.33%">
                <img src="<?php echo base_url('uploads/site_img/red.png') ?>"><br/>
                Red User
            </td>
            <td style="font-size: 12px" width="33.33%">
                <img src="<?php echo base_url('uploads/site_img/new.png') ?>"><br/>
                No User
            </td>
        </tr>
    </table>
</div>
<div class="col-sm-5">
    <form method="post" action="<?php echo site_url('tree/my_tree') ?>">
        <label>Enter User Id</label>
        <input type="text" name="top_id" class="form-control">
        <button class="btn btn-xs btn-danger" type="submit">Search</button>
    </form>
</div>
<hr/></div>
<div class="row">
    <?php if (config_item('leg') == "1") { ?>
        <div class="hr_divider" style="text-align: center">


            <div class="table-responsive" style="overflow-x: auto; text-align: left">
                <table align="center" class="table" style="max-width: 500px">
                    <tr>
                        <td colspan="3" class="alert alert-warning"> <?php $U = $this->plan_model->create_tree($top_id);
                            echo $U['data'] ?></td>
                    </tr>
                    <?php

                    $this->db->select('id, name, total_a, mypv, topup, total_a_pv, my_img')->where('sponsor', $top_id);
                    $data = $this->db->get('member')->result();

                    foreach ($data as $e) {
                        if ($e->topup == "0.00") {
                            $color = 'red';
                        } else {
                            $color = 'green';
                        }

                        $myimg = $e->my_img ? base_url('uploads/' . $e->my_img) : base_url('uploads/site_img/' . $color . '.png');
                        echo '
<tr>
                        <td></td>
                        <td></td>
                        <td style="border-left: 4px dashed #006aeb;"><span style="color: #006aeb"></span>
                      <span style="text-align: center"><a href="' . site_url('tree/my_tree/' . $e->id) . '" style="text-decoration: none; color: ' . $color . '; margin: 5px" data-toggle="popover" data-trigger="hover" data-html="true" data-placement="top" title="<div align=\'left\'><strong>' . config_item('ID_EXT') . $e->id . '</strong><hr/>Total Downline:' . ($e->total_a) . '<br/>Total BV: ' . ($e->total_a_pv) . '<br/> My Business: ' . $e->mypv . '</div>"><img class="img-circle" style="max-height: 70px" src="' . $myimg . '"><br/>' . $e->name . '<br/>(' . config_item('ID_EXT') . $e->id . ')</a></span> 
</td>
                    </tr>';
                    }
                    ?>

                </table>
            </div>




        </div>
    <?php } ?>
    <?php if (config_item('leg') == "2") { ?>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td colspan="8" align="center"><?php $U = $this->plan_model->create_tree($top_id);
                            echo $U['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_bg.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"
                            align="center"><?php $A = $this->plan_model->create_tree($U['A'], $U['id'], 'A');
                            echo $A['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                        <td colspan="4"
                            align="center"><?php $B = $this->plan_model->create_tree($U['B'], $U['id'], 'B');
                            echo $B['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2"
                            align="center"><?php $A_1 = $this->plan_model->create_tree($A['A'], $A['id'], 'A');
                            echo $A_1['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                          class="img-responsive">
                        </td>
                        <td colspan="2"
                            align="center"><?php $A_2 = $this->plan_model->create_tree($A['B'], $A['id'], 'B');
                            echo $A_2['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                          class="img-responsive">
                        </td>
                        <td colspan="2"
                            align="center"><?php $B_1 = $this->plan_model->create_tree($B['A'], $B['id'], 'A');
                            echo $B_1['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                          class="img-responsive">
                        </td>
                        <td colspan="2"
                            align="center"><?php $B_2 = $this->plan_model->create_tree($B['B'], $B['id'], 'B');
                            echo $B_2['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                          class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td align="left"><?php $A1_1 = $this->plan_model->create_tree($A_1['A'], $A_1['id'], 'A');
                            echo $A1_1['data'] ?></td>
                        <td align="right"><?php $A1_2 = $this->plan_model->create_tree($A_1['B'], $A_1['id'], 'B');
                            echo $A1_2['data'] ?></td>
                        <td align="left"><?php $A2_1 = $this->plan_model->create_tree($A_2['A'], $A_2['id'], 'A');
                            echo $A2_1['data'] ?></td>
                        <td align="right"><?php $A2_2 = $this->plan_model->create_tree($A_2['B'], $A_2['id'], 'B');
                            echo $A2_2['data'] ?></td>
                        <td align="left"><?php $B1_1 = $this->plan_model->create_tree($B_1['A'], $B_1['id'], 'A');
                            echo $B1_1['data'] ?></td>
                        <td align="right"><?php $B1_2 = $this->plan_model->create_tree($B_1['B'], $B_1['id'], 'B');
                            echo $B1_2['data'] ?></td>
                        <td align="left"><?php $B2_1 = $this->plan_model->create_tree($B_2['A'], $B_2['id'], 'A');
                            echo $B2_1['data'] ?></td>
                        <td align="right"><?php $B2_2 = $this->plan_model->create_tree($B_2['B'], $B_2['id'], 'B');
                            echo $B2_2['data'] ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if (config_item('leg') == "3") { ?>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td colspan="9" align="center"><?php $U = $this->plan_model->create_tree($top_id);
                            echo $U['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_bg.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3"
                            align="center"><?php $A = $this->plan_model->create_tree($U['A'], $U['id'], 'A');
                            echo $A['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                        <td colspan="3"
                            align="center"><?php $B = $this->plan_model->create_tree($U['B'], $U['id'], 'B');
                            echo $B['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                        <td colspan="3"
                            align="center"><?php $C = $this->plan_model->create_tree($U['C'], $U['id'], 'C');
                            echo $C['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"
                            align="left"><?php $A_1 = $this->plan_model->create_tree($A['A'], $A['id'], 'A');
                            echo $A_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $A_2 = $this->plan_model->create_tree($A['B'], $A['id'], 'B');
                            echo $A_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $A_3 = $this->plan_model->create_tree($A['C'], $A['id'], 'C');
                            echo $A_3['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="left"><?php $B_1 = $this->plan_model->create_tree($B['A'], $B['id'], 'A');
                            echo $B_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $B_2 = $this->plan_model->create_tree($B['B'], $B['id'], 'B');
                            echo $B_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $B_3 = $this->plan_model->create_tree($B['C'], $B['id'], 'C');
                            echo $B_3['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="left"><?php $C_1 = $this->plan_model->create_tree($C['A'], $C['id'], 'A');
                            echo $C_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $C_2 = $this->plan_model->create_tree($C['B'], $C['id'], 'B');
                            echo $C_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $C_3 = $this->plan_model->create_tree($C['C'], $C['id'], 'C');
                            echo $C_3['data'] ?><br/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if (config_item('leg') == "4") { ?>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td colspan="16" align="center"><?php $U = $this->plan_model->create_tree($top_id);
                            echo $U['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_bg.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"
                            align="center"><?php $A = $this->plan_model->create_tree($U['A'], $U['id'], 'A');
                            echo $A['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                        <td colspan="4"
                            align="center"><?php $B = $this->plan_model->create_tree($U['B'], $U['id'], 'B');
                            echo $B['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                        <td colspan="4"
                            align="center"><?php $C = $this->plan_model->create_tree($U['C'], $U['id'], 'C');
                            echo $C['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                        <td colspan="4"
                            align="center"><?php $D = $this->plan_model->create_tree($U['D'], $U['id'], 'D');
                            echo $D['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_sm.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="1"
                            align="left"><?php $A_1 = $this->plan_model->create_tree($A['A'], $A['id'], 'A');
                            echo $A_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $A_2 = $this->plan_model->create_tree($A['B'], $A['id'], 'B');
                            echo $A_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $A_3 = $this->plan_model->create_tree($A['C'], $A['id'], 'C');
                            echo $A_3['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $A_4 = $this->plan_model->create_tree($A['D'], $A['id'], 'D');
                            echo $A_4['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="left"><?php $B_1 = $this->plan_model->create_tree($B['A'], $B['id'], 'A');
                            echo $B_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $B_2 = $this->plan_model->create_tree($B['B'], $B['id'], 'B');
                            echo $B_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $B_3 = $this->plan_model->create_tree($B['C'], $B['id'], 'C');
                            echo $B_3['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $B_4 = $this->plan_model->create_tree($B['D'], $B['id'], 'D');
                            echo $B_4['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="left"><?php $C_1 = $this->plan_model->create_tree($C['A'], $C['id'], 'A');
                            echo $C_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $C_2 = $this->plan_model->create_tree($C['B'], $C['id'], 'B');
                            echo $C_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $C_3 = $this->plan_model->create_tree($C['C'], $C['id'], 'C');
                            echo $C_3['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $C_4 = $this->plan_model->create_tree($C['D'], $C['id'], 'D');
                            echo $C_4['data'] ?><br/>
                        </td>

                        <td colspan="1"
                            align="left"><?php $D_1 = $this->plan_model->create_tree($D['A'], $D['id'], 'A');
                            echo $D_1['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $D_2 = $this->plan_model->create_tree($D['B'], $D['id'], 'B');
                            echo $D_2['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="center"><?php $D_3 = $this->plan_model->create_tree($D['C'], $D['id'], 'C');
                            echo $D_3['data'] ?><br/>
                        </td>
                        <td colspan="1"
                            align="right"><?php $D_4 = $this->plan_model->create_tree($D['D'], $D['id'], 'D');
                            echo $D_4['data'] ?><br/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>
    <?php if (config_item('leg') == "5") { ?>
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <td colspan="20" align="center"><?php $U = $this->plan_model->create_tree($top_id);
                            echo $U['data'] ?><br/><img src="<?php echo base_url('uploads/site_img/line_bg.gif') ?>"
                                                        class="img-responsive">
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4"
                            align="center"><?php $A = $this->plan_model->create_tree($U['A'], $U['id'], 'A');
                            echo $A['data'] ?><br/>
                        </td>
                        <td colspan="4"
                            align="center"><?php $B = $this->plan_model->create_tree($U['B'], $U['id'], 'B');
                            echo $B['data'] ?><br/>
                        </td>
                        <td colspan="4"
                            align="center"><?php $C = $this->plan_model->create_tree($U['C'], $U['id'], 'C');
                            echo $C['data'] ?><br/>
                        </td>
                        <td colspan="4"
                            align="center"><?php $D = $this->plan_model->create_tree($U['D'], $U['id'], 'D');
                            echo $D['data'] ?><br/>
                        </td>
                        <td colspan="4"
                            align="center"><?php $E = $this->plan_model->create_tree($U['E'], $U['id'], 'E');
                            echo $E['data'] ?><br/>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    <?php } ?>


