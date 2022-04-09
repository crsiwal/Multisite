<?php
defined('BASEPATH') or exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: Common.php
 *  Path: application/helpers/Common.php
 *  Description: This helper add multiple common functions for use.
 *
 * Function Added:
 *
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              --------------
 *  Rahul Siwal         26/01/2020              Created
 *
 */

function get_boolean_input($input_key) {
	$ci = &get_instance();
	return (filter_var($ci->input->post($input_key, true), FILTER_VALIDATE_BOOLEAN) === true) ? true : false;
}

function get_boolean($input_value) {
	return (filter_var($input_value, FILTER_VALIDATE_BOOLEAN) === true) ? true : false;
}

function get_input_method() {
	$ci = &get_instance();
	return strtoupper($ci->input->server('REQUEST_METHOD'));
}

function add_widget($widgetName, $widgetData = []) {
	$ci = &get_instance();
	$ci->load->view('widgets/' . $widgetName, $widgetData);
}

function add_block($blockName, $blockData = [], $access = "public", $return = false) {
	if ($access != false && access($access)) {
		$ci = &get_instance();
		return $ci->load->view('blocks/' . $blockName, $blockData, $return);
	}
}

function add_element($elementName, $elementData = []) {
	$ci = &get_instance();
	$ci->load->view('elements/' . $elementName, $elementData);
}

function get_time() {
	return date("Y-m-d H:i:s");
}

function get_date($format = "Y-m-d") {
	$timeFormat = in_array($format, ["Y-m-d", "Y/m/d"]) ? $format : "Y-m-d";
	return date($timeFormat);
}

function access($accessName = "") {
	if ($accessName == "public") {
		return true;
	} else {
		$ci = &get_instance();
		return $ci->user->is_accessable($accessName);
	}
}

function get_page_name() {
	$ci = &get_instance();
	return $ci->sessions->get_page();
}

function addmenu($permision, $name, $url = "#", $icon = "", $class = "") {
	if (access($permision)) {
?>
		<li class="">
			<div class="navitem-container">
				<a class="<?= $class; ?>" href="<?= url($url, true); ?>">
					<div class="image-container">
						<span class="fa <?= $icon; ?>" aria-hidden="true"></span>
					</div>
					<span class="text-capitalize"><?= $name; ?></span>
				</a>
			</div>
		</li>
	<?php
	}
}

function addgroup($permision, $name, $icon = "", $submenu = []) {
	if (access($permision) && is_array($submenu)) {
	?>
		<li>
			<div class="navitem-container">
				<a href="#<?= "link" . $permision; ?>" data-toggle="collapse" aria-expanded="false" class="attribution-link">
					<div class="text-image-container">
						<div class="image-container">
							<span class="fa <?= $icon; ?>" aria-hidden="true"></span>
						</div>
						<span class="text-capitalize"><?= $name; ?></span>
					</div>
					<i class="fa fa-caret-down text-white ml-auto"></i>
				</a>
			</div>
			<ul class="collapse list-unstyled" id="<?= "link" . $permision; ?>">
				<?php
				foreach ($submenu as $menu) {
					addSubmenu($menu[0], $menu[1], $menu[2]);
				}
				?>
			</ul>
		</li>
		<?php
	}
}

function addSubmenu($permision, $name, $url = "#", $class = "") {
	if (access($permision)) {
		echo '<li><a href="' . url($url, true) . '" class="' . $class . '">' . $name . '</a></li>';
	}
}

function add_setup_blocks($blocks = []) {
	if (is_array($blocks)) {
		foreach ($blocks as $block) {
			if (isset($block["access"]) && access($block["access"])) {
		?>
				<div class="col col-6 col-md-3 gutter-right gutter-tablet-right">
					<div class="common-settings-grid-card card-shadow-2">
						<p class=""><?= $block["name"]; ?></p>
						<p id="<?= $block["id"]; ?>"> </p>
						<p class="">
							<a href="<?php url($block["url"]); ?>"><?= $block["link"]; ?></a>
						</p>
					</div>
				</div>
<?php
			}
		}
	}
}

function tooltipList($listArray) {
	$message = "";
	if (is_array($listArray)) {
		foreach ($listArray as $name => $list) {
			switch ($name) {
				case "title":
					$message .= '<div class="ttle">' . $list . '</div>';
					break;
				case "description":
					$message .= '<div class="tlst"><span class="tplv">' . $list . '</span></div>';
					break;
				default:
					$message .= '<div class="tlst"><span class="tpln">' . $name . '</span>: <span class="tplv">' . $list . '</span></div>';
					break;
			}
		}
	}
	tooltip($message);
}

function tooltip($message = "") {
	echo '<span class="infotip pointer" data-toggle="tooltip" data-placement="bottom" title="' . htmlentities($message) . '"></span>';
}

function ellipse($string = "", $length = 12) {
	return (strlen($string) > $length) ? substr($string, 0, strrpos($string, ' ', ($length - strlen($string)))) . '...' : $string;
}

function isJson($string) {
	json_decode($string);
	return (json_last_error() == JSON_ERROR_NONE);
}

/**
 *
 * @param type $length
 * @param type $method
 * @author Rahul Siwal <rsiwal@yahoo.com>
 * @return type
 */
function unique_key($length = 8, $method = "shuffle") {
	if ($method == "shuffle") {
		$string = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		return substr(str_shuffle($string), 0, $length);
	} elseif ($method == "microtime") {
		return base_convert(microtime(false), 10, 36);
	} else {
		return bin2hex(openssl_random_pseudo_bytes(($length / 2)));
	}
}

function get_integer($string) {
	return (int) $string;
}

function get_number_select($min = 0, $max = 99999, $step = 1, $label = "Please Select") {
	$key = $value = range($min, $max, $step);
	array_unshift($value, $label);
	array_unshift($key, 0);
	$array = array_combine($key, $value);
	return preg_filter('/$/', ' Pixel', $array);
}

function breadcrumb($list = [], $return = false) {
	$text = '<p class="font-12 text-capitalize text-darkgray-2">';
	$text .= '<span class=""><a href="' . url("", true) . '">Home</a></span> / ';
	if (is_array($list)) {
		$length = count($list);
		$loop = 0;
		foreach ($list as $name => $link) {
			$link = url($link, true);
			if (++$loop == $length) {
				$text .= '<span class="text-blue">' . $name;
			} else {
				$text .= '<span class=""><a href="' . $link . '">' . $name . '</a><span> / ';
			}
		}
	}
	$text .= '</p>';
	if ($return) {
		return $text;
	} else {
		echo $text;
	}
}

function video_platform($name = "", $value = "", $access = "", $checked = false) {
	if (!empty($name) && access($access)) {
		echo '<div class="form-check form-check-inline"><input class="form-check-input" type="radio" name="platform" id="vdtp_' . $value . '" value="' . $value . '" ' . (($checked) ? 'checked="checked"' : '') . '><label class="form-check-label pointer" for="vdtp_' . $value . '">' . $name . '</label></div>';
	}
}

function set_input_error() {
	$ci = &get_instance();
	$error = $ci->form->error_array();
	$ci->sessions->set_error(reset($error));
}

function set_error($error = "") {
	$ci = &get_instance();
	$ci->sessions->set_error($error);
}

function get_error() {
	$ci = &get_instance();
	return $ci->sessions->get_error();
}

function set_msg($message = "") {
	$ci = &get_instance();
	$ci->sessions->set_msg($message);
}

function get_msg() {
	$ci = &get_instance();
	return $ci->sessions->get_msg();
}

function get_hashtag($content = "") {
	$hashtags = [];
	$clean_one = strip_tags($content);
	$clean_two = html_entity_decode($clean_one);
	$clean_final = strip_tags($clean_two);
	preg_match_all("/#(\\w+)/", $clean_final, $hashtags);
	return (isset($hashtags[1]) && is_array($hashtags[1])) ? array_unique($hashtags[1]) : [];
}

/**
 *
 * @param type $condition
 * @param type $values
 * @return type
 */
function where($condition = [], $values = []) {
	$where = [];
	if (is_array($condition)) {
		foreach ($condition as $key) {
			switch ($key) {
				case 'user_id':
					$where['user_id'] = (isset($values[$key]) ? $values[$key] : get_logged_in_user_id());
					break;
				case 'blog_id':
					$where['blog_id'] = (isset($values[$key]) ? $values[$key] : get_active_blog_id());
					break;
				default:
					$where[$key] = (isset($values[$key]) ? $values[$key] : "");
			}
		}
	}
	return $where;
}
