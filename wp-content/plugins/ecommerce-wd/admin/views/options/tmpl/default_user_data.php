<?php

defined('ABSPATH') || die('Access Denied');


$lists = $this->lists;
$list_user_data_field = $lists['user_data_field'];

$options = $this->options;
$initial_values = $options['initial_values'];

$user_data_fields = $this->user_data_fields;
?>

<table class="adminlist table">
    <tbody>
    <?php
    foreach ($user_data_fields as $user_data_field) {
        ?>
        <tr>
            <td class="col_key">
                <label for="<?php echo $user_data_field->name; ?>">
                    <?php echo $user_data_field->label; ?>:
                </label>
            </td>

            <td class="col_value">
                <?php echo WDFHTML::wd_radio_list($user_data_field->name, $list_user_data_field, 'value', 'text', $initial_values[$user_data_field->name]); ?>
            </td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>

<!-- ctrls -->
<table class="adminlist table">
    <tbody>
    <tr>
        <td class="btns_container">
            <?php
            echo WDFHTML::jfbutton(__('Reset', 'wde'), '', '', 'onclick="onBtnResetClick(event, this, \'user_data\');"');
            echo WDFHTML::jfbutton(__('Load default values', 'wde'), '', '', 'onclick="onBtnLoadDefaultValuesClick(event, this, \'user_data\');"');
            ?>
        </td>
    </tr>
    </tbody>
</table>