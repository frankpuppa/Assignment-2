<?php 

require_once('../../include/connect.php');
$mysqli = mysqlConnect();

/*
$mysqli = new mysqli('localhost', 'root', '', 'FootWearShop'); //Connect and select 'FootWearShop' database
if($mysqli->connect_error)
{
	die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}
*/
	
	$name = $mysqli->escape_string($_POST['shoe_name']);
	$size = $mysqli->escape_string($_POST['size']);
	$color = $mysqli->escape_string($_POST['color']);
	$price = $mysqli->escape_string($_POST['price']);
	$supplier_id = $mysqli->escape_string($_POST['supplier_id']);
	$Url = "img/" . $_FILES["file"]["name"];
	$urlInsert = $mysqli->escape_string($Url);
	
	$sql1 = "INSERT INTO `Shoe_supplier` (`shoe_id`, `supplier_id`) VALUES (LAST_INSERT_ID(), '$supplier_id');";
	$sql2 = "INSERT INTO `Shoe` (`shoe_name`, `size`, `color`, `quantity`, `price`, `image_url`) VALUES ('$name ', '$size', '$color', '0', '$price', '$urlInsert');";
	
	$result2 = $mysqli->query($sql2);
	$result1 = $mysqli->query($sql1);
	
	header ('Location: index.php');
echo '<pre>';
if (move_uploaded_file($_FILES["file"]["tmp_name"], $Url)) {
    echo "File is valid, and was successfully uploaded.\n";
} else {
    echo "Possible file upload attack!\n";
}

echo 'Here is some more debugging info:';
print_r($_FILES);

print "</pre>";

      
	

?>