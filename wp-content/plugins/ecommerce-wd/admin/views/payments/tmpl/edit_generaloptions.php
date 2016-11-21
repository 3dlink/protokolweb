<?php
 
defined('ABSPATH') || die('Access Denied');

$row = $this->row;
$class_name = $row->class_name;
$row_cc_fields = $row->cc_fields;
$cc_fields = $class_name ::$cc_fields ;

?>
<table class="adminlist table">
	<tbody>
		<?php foreach ($cc_fields as $key => $field):
			$checked = isset($row_cc_fields->$key) ? $row_cc_fields->$key : '0';
			if ($field == 1) {
				$list = __('This field is required', 'wde');
      }
			else {
				$array = array((object)array('value' => 0, 'text' => __('Hide', 'wde')),(object) array('value'=>1, 'text' => __('Show', 'wde')),(object) array('value'=>2, 'text' => __('Show and require', 'wde')));
        $list = WDFHTML::wd_radio_list($key, $array, 'value', 'text', $checked);
      }
      ?>
			<tr>
				<td class="col_key">
					<label for="<?php echo $key; ?>">
						<?php _e($key, 'wde'); ?>:
					</label>
				</td>
				<td class="col_value">
					<?php echo $list ?>
				</td>
			</tr>
		<?php endforeach;?>
	</tbody>
</table>