<?php
	require_once("connect.php");
	function random_string($length) {
		$key = '';
		$keys = array_merge(range(0, 9), range('a', 'z'));

		for ($i = 0; $i < $length; $i++) {
		$key .= $keys[array_rand($keys)];
		}

		return $key;
	}

	function get_class_db($class_id) {

		if (!($stmt = $mysqli_piq->prepare("
		select * from class where id = ?
		"))) {
			echo "Prepare failed: (" . $mysqli_piq->errno . ") " . $mysqli_piq->error;
		}

		if (!$stmt->bind_param("i", $class_id)) {
		    echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
		}

		if (!$stmt->execute()) {
		    echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
		}
		$stmt->store_result();
		$result_array = [];

		$stmt->bind_result($name, $description, $image, $price, $user_id, $address, $intersection, $class_id, $request_form);
		$result_array['name'] = $name;
		$result_array['description'] = $description;
		$result_array['image'] = $image;
		$result_array['price'] = $price;
		$result_array['user_id'] = $user_id;
		$result_array['address'] = $address;
		$result_array['intersection'] = $intersection;
		$result_array['class_id'] = $class_id;
		$result_array['request_form'] = $request_form;

		$stmt->fetch();

		$stmt->close();
		return $result_array;
	}
?>
