<html>
<head>
<link rel="stylesheet" type="text/css" href="template.css"/>
</head>
<body>
<img src='background.png'/>
<div class="pos">

<?php
    $success = true;
	$db_conn = OCILogon("ora_y4u7", "a44229102", "ug");
	
	function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}


?>

<a href="index.php">Back</a>
<br>
<br>
<br>

<form method="post" action="Customer.php?name">
Modify This Account Info:<br>
<input type="text" name="AccountID" value="AccountID" /><br>
<input type="text" name="AName" value="New Name"/>
<input type="text" name="AAddress" value="New Address"/>
<input type="text" name="APhone" value="New Phone Number"/>
<input type="submit" name="modify" value="Modify!"/>
</form>


  
<form method="post" action="Customer.php?name" >
View all purchase history of this account 
	<input type="text" name="customer" value="Account ID"/>
	<input type="submit" name="submit" value="Go!"/>
</form>



<form method="post" action="Customer.php?name" >
View points for this account 
	<input type="text" name="account" value="Account ID"/>
	<input type="submit" name="search" value="View!"/>
</form>

<?php
	
	
    if($db_conn) {
      if(isset($_POST['modify'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/[0-9]+/", $_POST['AccountID'])){
		    $account=$_POST['AccountID'];
		    
		    $name = $_POST['AName'];
		    $address = $_POST['AAddress'];
		    $phone = $_POST['APhone'];
		    
		    echo "<br>".$account."<br>";
		  
		    if (!(strcmp($name, "New Name") == 0)) {
			     if(preg_match("/[A-Z  | a-z]+/", $_POST['AName'])){
		    $sql1 = "update account set aname ='".$name."' where account_id ='".$account."'";
		    $parsed1 = OCIParse($db_conn, $sql1);
		    $result1=OCIExecute($parsed1, OCI_DEFAULT);
		    } else
		    echo "Input not of correct type!";
	    }
	    	if (!(strcmp($address, "New Address") == 0)) {
		    	 if(preg_match("/[A-Z  | a-z | 0-9]+/", $_POST['AAddress'])){
		    $sql2 = "update account set aaddress ='".$address."' where account_id ='".$account."'";
		    $parsed2 = OCIParse($db_conn, $sql2);
		    $result2=OCIExecute($parsed2, OCI_DEFAULT);
		    } else
		    echo "Input not of correct type!";
	    }	    
	    	if (!(strcmp($phone, "New Phone Number") == 0)){
		    	 if(preg_match("/[0-9]+/", $_POST['APhone'])){
		    $sql3 = "update account set aphone ='".$phone."' where account_id ='".$account."'";
		    $parsed3 = OCIParse($db_conn, $sql3);
		    $result3=OCIExecute($parsed3, OCI_DEFAULT);
		    } else
		    echo "Input not of correct type!";
	    }
	    	OCICommit($db_conn);
	    	$sql4 = "select * from account where ACCOUNT_ID='".$account."'";	    
		    $result4 = executePlainSQL($sql4);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Account:<br>";
	  echo "<table>";
	  echo "<tr><th>Account ID</th><th>Name</th><th>Address</th><th>Phone Number</th></tr>";

	  while ($row = OCI_Fetch_Array($result4, OCI_BOTH)) {
		echo "<tr><td>" . $row["ACCOUNT_ID"] . "</td><td>" . $row["ANAME"] . "</td><td>" . $row["AADDRESS"] . "</td><td>" . $row["APHONE"] . "</td></tr>";
	  }
	  echo "</table>";
		    
		  } else
		  echo "Input not of correct type!";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID and value(s) to modify.</p>";
	}

  ?>
  
  
<?php
	
	
    if($db_conn) {
      if(isset($_POST['submit'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/[0-9]+/", $_POST['customer'])){
		    $purchase=$_POST['customer'];
		    echo "<br>".$purchase."<br>";
		  
		    $sql = "select I.Serial_Number, I.PName from Account A, Makes M, Stores_Purchased S, Item I where A.Account_ID = M.Account_ID AND A.Account_ID = ".$purchase." AND M.Sale_Number = S.Sale_Number AND S.Serial_Number = I.Serial_Number";
		    $result = executePlainSQL($sql);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Item:<br>";
	  echo "<table>";
	  echo "<tr><th>Serial Number</th><th>Product Name</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["PNAME"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "Input not of correct type!";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}

  ?>
  

  <?php
	
	
    if($db_conn) {
      if(isset($_POST['search'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/[0-9]+/", $_POST['account'])){
		    $accountp=$_POST['account'];
		    echo "<br>".$accountp."<br>";
		  
		    $sqlp = "select a.points from Account a where Account_ID =  ".$accountp."";
		    $resultp = executePlainSQL($sqlp);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Account:<br>";
	  echo "<table>";
	  echo "<tr><th>Points</th></tr>";

	  while ($row = OCI_Fetch_Array($resultp, OCI_BOTH)) {
		echo "<tr><td>" . $row["POINTS"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "Input not of correct type!";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}

  ?>
  
</br></br></br></br></br>


</div>

</body>
</html>