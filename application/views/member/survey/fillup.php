<?php
/***************************************************************************************************
 * Copyright (c) 2020. by Codepeople India
 * This project is developed and maintained by Codepeople India.
 * Nobody is permitted to modify the source or any part of the project without permission.
 * Project Developer: Bidush Sarkar
 * Developed for: Codepeople India
 **************************************************************************************************/
?>
<div class="row">
    <div class="col-sm-2"></div>
    <div class="col-sm-8">
        <h3><?php echo $data->survey_name ?></h3>
        <?php echo form_open('survey/submit/' . $data->id) ?>
        <table class="table" style="max-width: 600px; background-color: #fff; border-bottom: 0 none;
	box-shadow: 0 1px 5px rgba(0, 0, 0, 0.46);">
            <tr>
                <td>
                    <?php
                    $data = unserialize($data->question_answers);
                    foreach ($data as $e => $v) {
                        echo '<div class="col-sm-12"><h4 class="alert alert-warning">' . $e . '</h4>';
                        echo '<strong>Your Answer: </strong><br/>';
                        if (trim($v) == ""):
                            echo '<input required type="text" class="form-control" name="' . $e . '">';
                        else:
                            foreach (explode(',', $v) as $ans):
                                echo '<input required type="radio" value="' . $ans . '" name="' . $e . '">' . $ans . '<br/>';
                            endforeach;
                        endif;
                        echo '</div>';
                    }
                    ?>

                </td>
            </tr>
        </table>
        <div class="row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-danger pull-right">Submit & Earn</button>
            </div>
        </div>
        <br/>
        <?php form_close() ?>
    </div>
    <div class="col-sm-2"></div>
</div>