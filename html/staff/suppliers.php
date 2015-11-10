<?php
//Check access rights for this page.
session_start();
if($_SESSION['role'] < 3)
{
	//Send the user back to the main page
	header("Location: /staff");
	die();
}
require_once('../../include/suppliers.php');
$title = "Suppliers";

include('../../include/wrapperstart.php');
?>
<script src="js/jquery.js" type="text/javascript"></script>
<script src="js/jquery.maskedinput.js" type="text/javascript"></script>
<div class="container"></div>
<h3>Search Supplier</h3>

<form class="pull-right" action="/staff/suppliers.php" method="POST">
	<input type="submit" name="addsupplier" value="Add Supplier">
</form>

<form action="/staff/suppliers.php" method="POST">
             
             <select name="searchby">
				 <option value="byname">by Name</option>
				 <option value="byshoe">by Shoe Name</option>
             </select>
				<input type="text" name="fname">
                <input type="submit" name="srcsupplier" value="Submit">
</form >


<p>Allow admins and managers to view, edit and add supplier information.</p>


</div>
<?php
if(isset($_POST['fname'])){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
		
		$suppliers = new Supplier($mysqli);
	
	//~ error_log($_REQUEST['searchby']);
	//~ error_log("TEST FNAME " . $_REQUEST['fname']);
	$searchby= $_REQUEST['searchby'];
	if($searchby=="byname"){
		$result=$suppliers->getSupplierbyName($_REQUEST['fname']);
	}else if($searchby=="byshoe"){
		$result=$suppliers->getSupplierbyShoe($_REQUEST['fname']);	
	}
	
		//$result=$suppliers->getSuppliers($_POST['fname']);	
		if($result->num_rows != 0){
			?>
			  <br/>
			  <div class="container">
              <div class="panel panel-default">
              <!-- Default panel contents -->
              <div class="panel-heading">Customer Results</div>
              <table class="table">
                        <tr>
                            <td>#</td>
                            <td>Supplier Name</td>
                            <td>Phone Number</td>
                            <td>Email</td>
                            <td>Address</td>
                            <td>Edit</td>
                            <td>Delete</td>                     
                        </tr>
<?php
		$i=1;
		while ($row = $result->fetch_assoc()) {?>		
			<tr>
				<td><?php echo "$i";?></td>
				<td><?php echo $row["supplier_name"];?> </td>
				<td><?php echo $row["phonenumber"];?></td>
				<td><?php echo $row['email'];?></td>
				<!--Get Address of Supplier-->
				<td><?php
				echo $row["first_line"] . "<br/>";
				echo $row["second_line"]."<br/>";
				echo $row["city"]. "<br/>";
				echo $row["postcode"]. "<br/>";
				echo $row["country"];
				?></td>
				<td>
				<!--form code Use User_info id to delete from tables-->
				<form action="/staff/suppliers.php" method="POST">
					<input type="hidden" name="name" value="<?php echo $row["supplier_name"];?>">
					<input type="submit" name="edit" value="Edit">
				</form>
				</td>
				<td>
				<form action="/staff/suppliers.php" method="POST">
					<input type="hidden" name="addressid" value="<?php echo $row["address_id"];?>">
					<input type="hidden" name="id" value="<?php echo $row['id'];?>">
					<input type="submit" name="delete" value="Delete">
				</form>
				</td>
			</tr>
	
			<?php $i++;
        //printf ("%s %s %s\n", $row["gender"], $row["nationality"], $row["last_name"]);
		
    }?>
    </table>
    </div>
    </div>
<?php
		
		
	}

}else if($_POST['addsupplier']){ ?>
		<br/>
		<div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-7 col-xs-offset-2" style="background-color: #ededed;">
	<h3>Add Supplier Information</h3>
     <form action="/staff/suppliers.php" method="POST">
             <div class="form-group">
                    <label for="first_name"> Supplier Name: </label>  
                    <input type="text" name="supplier_name" style="width:250px;" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="last_name"> Phone Number: </label>  
                    <input id="phonenumber" type="text" name="phonenumber" style="width:250px;" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="nationality"> Email: </label>  
                    <input type="text" name="email" class="form-control" style="width:250px;" required>
                </div>
				<h3>Address:</h3>
                <div class="form-group">
                    <label for="first_line"> First line: </label>  
                    <input  name="first_line" type="text" style="width:250px;"class="form-control" required>
                </div>   
                <div class="form-group">
                    <label for="second_line"> Second line: </label>  
                    <input name='second_line' type="text" style="width:250px;" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label for="postcode"> Postcode: </label>  
                    <input id="postcode"  name='postcode' type="text" size="6" style="width:100px;" class="form-control" required>
                </div>
                 <div class="form-group">
                    <label for="city"> City: </label>  
                    <input  name='city' type="text" size="25" style="width:250px;" class="form-control" required>
                </div>
				 <div class="form-group">
                    <label for="country"> Country: </label>  
                    <input name='country' type="text" size="25" style="width:250px;" class="form-control" required>
                </div>
                <button type="submit" name="submitsupplier" value="Edit Values" class="btn btn-default">Add Supplier</button>
            </form>
</div>

<?php 
}else if(isset($_POST['submitsupplier'])){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	
	//error_log($_REQUEST['supplier_name']. " " .$_REQUEST['phonenumber']. " " .$_REQUEST['email']. " " .$_REQUEST['first_line']. " " .$_REQUEST['second_line']. " " .$_REQUEST['postcode']. " " .$_REQUEST['city']. " " .$_REQUEST['country']);
	$result=$suppliers->addSupplier($_REQUEST['supplier_name'],$_REQUEST['phonenumber'],$_REQUEST['email'],$_REQUEST['first_line'],$_REQUEST['second_line'],$_REQUEST['postcode'],$_REQUEST['city'],$_REQUEST['country']);
	if($result->affected_rows() == 0){
	echo "Error Supplier cannot be inserted";
	die();
	}
}else if(isset($_POST['edit'])){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/

	$suppliers = new Supplier($mysqli);
	$result=$suppliers->getSupplierbyName($_REQUEST['name']);
	if($result->num_rows != 0){ 
		$row = $result->fetch_assoc();?>
		<br/>
		<div class="col-md-8 col-md-offset-2">
			<div class="container center-block" style="background-color: #ededed;">
				
					
				<div style="display:block; float:left; padding:30px;">
					<h3> Supplier Address</h3>
				<br/>
				<form action="/staff/suppliers.php" method="POST">
				 <div class="form-group">
                    <label for="first_line"> First Line: </label>  
                    <input type="text" name="first_line" style="width:250px;" class="form-control" value="<?php echo $row["first_line"];?>" required>
                </div>
                <div class="form-group">
                    <label for="second_line"> Second Line: </label>  
                    <input type="text" name="second_line" style="width:250px;" class="form-control" value="<?php echo $row["second_line"];?>" required>
                </div>
                <div class="form-group">
                    <label for="postcode"> Postcode: </label>  
                    <input id="postcode"  name='postcode'  type="text" size="6" style="width:100px;" class="form-control" value="<?php echo $row["postcode"]; ?>" required>
                </div>
                 <div class="form-group">
                    <label for="city"> City: </label>  
                    <input  name='city' type="text" size="25" style="width:250px;" class="form-control" value="<?php echo $row["city"]; ?>" required>
                </div>
				 <div class="form-group">
                    <label for="country"> Country: </label>  
                    <input name='country' type="text" size="25" style="width:250px;" class="form-control" value="<?php echo $row["country"]; ?>" required>
                </div>
                <button type="submit" name="editaddress" class="btn btn-default">Edit Supplier Address</button>
					<input type="hidden" name="addressid" value="<?php echo $row['address_id'];?>">
				</form>
				</div>
					
					<div style="display:block; float:left; padding:30px;">
						<h3>Supplier Details</h3>
					<br/>
			 <form action="/staff/suppliers.php" method="POST">
				 <div class="form-group">
                    <label for="supplier_name"> Supplier Name: </label>  
                    <input type="text" name="supplier_name" style="width:250px;" class="form-control" value="<?php echo $row["supplier_name"];?>" required>
                </div>
                <div class="form-group">
                    <label for="phonenumber"> Phone Number: </label>  
                    <input type="text" name="phonenumber" style="width:250px;" class="form-control" value="<?php echo $row["phonenumber"];?>" required>
                </div>
                <div class="form-group">
                    <label for="email"> Email: </label>  
                    <input type="text" name="email" style="width:250px;" class="form-control" value="<?php echo $row["email"];?>" required>
                </div>
					<input type="hidden" name="id" value="<?php echo $row['id'];?>">
                <button type="submit" name="editsupplier" class="btn btn-default">Edit Supplier</button>
				</form>
				</div>
				
				</div>
		</div>
	<?php } 
}else if(isset($_POST['editaddress'])){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	error_log(" ID" . $_REQUEST['addressid']. " " .$_REQUEST['first_line'].$_REQUEST['second_line'].$_REQUEST['city'].$_REQUEST['postcode'].$_REQUEST['country']);
	$result=$suppliers->updateSupplierAddress($_REQUEST['addressid'],$_REQUEST['first_line'],$_REQUEST['second_line'],$_REQUEST['city'],$_REQUEST['postcode'],$_REQUEST['country']);
	if($result->affected_rows() == 0){
		echo "No Address has been updated!";
		die();
	}
	


}else if(isset($_POST['editsupplier'])){
	/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	//~ //error_log("Supplier " . $_REQUEST['id']. " " . $_REQUEST['addressid']);
	$result=$suppliers->updateSupplier($_REQUEST['id'], $_REQUEST['supplier_name'], $_REQUEST['phonenumber'], $_REQUEST['email']);
	if($result->affected_rows() == 0){
		echo "No Supplier has been updated!";
		die();
	}
}else if(isset($_POST['delete'])){

/*******DEBUUG ***/
	ini_set("log_errors", 1);
	ini_set("error_log", "/tmp/php-error.log");
	/****** END DEBUG*****/
	$suppliers = new Supplier($mysqli);
	$result=$suppliers->deleteSupplier($_REQUEST['id'], $_REQUEST['addressid']);
	if($result == 0){
		echo "No Supplier has been deleted!";
		die();
	}
}
?>
<script>
jQuery(function($)
{
	$("#postcode").mask("*** ***",{placeholder:"___ ___"});
	$("#phonenumber").mask("(999) 999-9999");
});
</script>
<?php
include('../../include/wrapperend.php');
?>
