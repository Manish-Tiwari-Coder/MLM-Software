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
    <?php echo form_open() ?>
    <input name="id" value="<?php echo $result->id ?>" type="hidden">
    <div class="col-sm-6">
        <label>Earning Name</label>
        <select class="form-control" name="income_name">
            <option selected><?php echo $result->income_name ?></option>
            <option>Level Income</option>
            <option>Matching Income</option>
            <option>Direct Income</option>
            <option>Other Income</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Level No</label>
        <select class="form-control" name="level_no">
            <option selected><?php echo $result->level_no ?></option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
            <option>10</option>
            <option>11</option>
            <option>12</option>
            <option>13</option>
            <option>14</option>
            <option>15</option>
            <option>16</option>
            <option>17</option>
            <option>18</option>
            <option>19</option>
            <option>20</option>
        </select>
    </div>
    <div class="col-sm-6">
        <label>Total Member</label>
        <input type="text" class="form-control" value="<?php echo set_value('total_member', $result->total_member) ?>"
               name="total_member">
    </div>
    <div class="col-sm-6">
        <label>Earning Amount</label>
        <input type="text" class="form-control" value="<?php echo set_value('amount', $result->amount) ?>"
               name="amount">
    </div>
    <div class="col-sm-6">
        <label>Achieve Duration <br/> </label>
        <input type="text" class="form-control"
               value="<?php echo set_value('income_duration', $result->income_duration) ?>"
               name="income_duration"><span style="font-size: 11px">( Within how many days he/she should achieve this  ? 0 for no duration )</span>
    </div>
    <div class="col-sm-6"><br/>
        <input type="submit" class="btn btn-success" value="Save" onclick="this.value='Saving..'">
    </div>
    <?php echo form_close() ?>
</div>