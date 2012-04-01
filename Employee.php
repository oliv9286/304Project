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



<form method="post" action="Employee.php?name">

Modify This Employee Info:<br>

<input type="text" name="EmployeeID" value="EmployeeID" /><br>

<input type="text" name="EName" value="New Name"/>

<input type="text" name="EPhone" value="New Phone Number"/>

<input type="text" name="EAddress" value="New Address"/>

<input type="submit" name="modify" value="Modify"/>

</form>
 
<form method="post" action="Employee.php?name">
Create New Account:<br>
<input type="text" name="CEmployeeID" value="Creator's Employee ID"/><br>
<input type="text" name="AccountID" value="AccountID"/>
<input type="text" name="AName" value="Name"/>
<input type="text" name="AAddress" value="Address"/>
<input type="text" name="APhone" value = "Phone Number"/>

<input type="submit" name="add" value="Add">
</form>

<form method="post" action="Employee.php?name">
Delete returns for this account 
<input type="text" name="delete" value="Account ID">
<input type="submit" name ="deleter" value="Delete">
</form>





<form method ="post" action="Employee.php?name">

Find the receipt that has more than 1 item on it, and has the highest total cost out of all the receipts.
<input type="submit" name="search"  value="Go!"/>

</form>




<form method="post" action="Employee.php?name">

Find the sum of all purchases from store <input type="submit" name="go" value="Go!"/>

</form>


<form method="post" action="Employee.php?name">
Add
<input type="text" name="addpoints" value="Points">
points to Account ID
<input type="text" name="AccountAddPoints" value="AccountID">
<input type="submit" name="SubmitAddPoint" value="Add">
</form>

<?php
	if($db_conn){
		if(isset($_POST['SubmitAddPoint'])){
			if(isset($_GET['name'])){
			
			$points = $_POST['addpoints'];
			$account_ap = $_POST['AccountAddPoints'];
			
			
			if(!=(strcmp($points, "Points"))==0){
				if(preg_match("/[0-9]+/", $_POST['Points'])){
					
					$curr_point = "select A.Points
									from Account A
									where A.Account_ID = ".$account_ap."";
					
					$currpoint_result = executePlainSQL($curr_point);
					
					while ($row = OCI_Fetch_Array($cus_result,OCI_BOTH)){
					$new_points = .$row['POINTS']. + $currpoint_result;
					}
					
					//$new_points = $currpoint_result + $points;
					
					$set_point = "update Account 
								  set Points = ".$new_points.";
								  where Account_ID = ".$account_ap."";
					
					$parse_ap = OCIParse($db_conn, $set_point);
					$execute_ap = OCIExecute($parse_ap, OCI_DEFAULT);
					OCICommit($db_conn);
					
					$show_points = "select *
									from Account
									where Account_ID = ".$account_ap."";
					$show_result = executePlainSQL($show_points);
					
				}else
				echo "<br><font color='ff0000'>Input Type Incorrect! Points must be Integers</font><br>";
			}else echo "<br><font color='ff0000'>Please Enter Points</font><br>";
			}
			}
			}
?>


<form method="post" action="Employee.php?name">
Find the customers who have returned all consoles:
<input type="submit" name="find" value="Find">
</form>
<br>
<table>
<tr><td>
<form method="post" action="Employee.php?allitems" id="allitems">
<input type="submit" name="AllItemsSubmit" value="All Items"/>
</form>
</td><td>
<form method="post" action="Employee.php?allgames" id="allgames">
<input type="submit" name="AllGamesSubmit" value="All Games"/>
</form>
</td><td>
<form method="post" action="Employee.php?name">

<input type="submit" name="new_game" value="New Games">
</form>
</td><td>
<form method="post" action="Employee.php?name">

<input type="submit" name="usedgame" value="Used Games">

</form>
</td><td>
<form method="post" action="Employee.php?name">
<input type="submit" name="hardware" value="Hardwares" >
</form>
</td></tr>
</table>




<?php
		if($db_conn){
		if(isset($_POST['find'])){
			if(isset($_GET['name'])){
			$cus = "select A.Account_ID, A.AName
					from account A
					where a.account_id in ( select r.account_id
											from returns r
											group by r.account_id
											having count(distinct(r.serial_number)) >= (select count(*)
																from hardware
																where type ='Console'))";
				   
			$cus_result = executePlainSQL($cus);
			
			 echo "<br>All Customers: <br>";    
    		 echo "<table>";
			 echo "<tr><th>AccountID</th><th>Name</th></tr>";
			 while ($row = OCI_Fetch_Array($cus_result,OCI_BOTH)) {
			 echo "<tr><td>". $row["ACCOUNT_ID"] . "</td><td>".$row["ANAME"]."</td><tr>";
	  	}
	  		 echo "</table>";
	  		 
	  }
	}
}
	
?>

<?php
	if($db_conn){
		if(isset($_POST['AllGamesSubmit'])) {
	    if(isset($_GET['allgames'])) {
			$sql = "select i.pname, g.genre, g.platform, i.price, i.Quantity from Game g, Item i where g.serial_number=i.serial_number";
			$result = executePlainSQL($sql);
			echo "<br>All Games</br>";
			echo "<table>";
			echo "<tr><th>Game</th><th>Genre</th><th>Platform</th><th>Price</th><th>Quantity</th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td></tr>"; //or just use "echo $row[0]" 
			}
			echo "</table>";	
		}
	  }	
}
?>

<?php
	if($db_conn){
	   if(isset($_POST['AllItemsSubmit'])) {
	    if(isset($_GET['allitems'])) {
			$sql = "select * from item";
			$result = executePlainSQL($sql);
			echo "<br>All Items</br>";
			echo "<table>";
			echo "<tr><th>Serial#</th><th>Product Name</th><th>Price</th><th>Quantity</th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<tr><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["PNAME"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td></tr>"; //or just use "echo $row[0]" 
			}
			echo "</table>";		
		
		
		}
	  }
}
?>
<?php
	if($db_conn){
		if(isset($_POST['hardware'])){
			if(isset($_GET['name'])){
			$hw = "select I.PName, I.Price, I.Serial_Number
				   From Item I, Hardware H
				   where I.Serial_Number = H.Serial_Number";
				   
			$hw_result = executePlainSQL($hw);
			
			 echo "<br>All Hardwares: <br>";    
    		 echo "<table>";
			 echo "<tr><th>Name</th><th>Price</th><th>Serial Number</th></tr>";
			 while ($row = OCI_Fetch_Array($hw_result,OCI_BOTH)) {
			 echo "<tr><td>". $row["PNAME"] . "</td><td>".$row["PRICE"]."</td><td>" . $row["SERIAL_NUMBER"] . "</td><tr>";
	  	}
	  		 echo "</table>";
	  		 
	  }
	}
}
?>

<?php
	if($db_conn){
		if(isset($_POST['usedgame'])){
			if(isset($_GET['name'])){
			$og = "select I.PName, I.Price, G.Serial_Number, G.Genre, G.Platform, G.Publisher
					from Item I, Game G
					where G.Serial_Number=I.Serial_Number AND G.is_used=1";
				   
			$og_result = executePlainSQL($og);
			
			 echo "<br>All Used Games: <br>";    
    		 echo "<table>";
			 echo "<tr><th>Name</th><th>Price</th><th>Serial Number</th><th>Genre</th><th>Platform</th><th>Publisher</th></tr>";
			 while ($row = OCI_Fetch_Array($og_result,OCI_BOTH)) {
			 echo "<tr><td>". $row["PNAME"] . "</td><td>".$row["PRICE"]."</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row['GENRE']."</td><td>" .$row['PLATFORM']."</td><td>" .$row['PUBLISHER']."</td><tr>";
	  	}
	  		 echo "</table>";
				   
			
			} 
			
		}
		
	}
?>
<?php
	if($db_conn){
		if(isset($_POST['new_game'])){
			if(isset($_GET['name'])){
			$ng = "select I.PName, I.Price, G.Serial_Number, G.Genre, G.Platform, G.Publisher
					from Item I, Game G
					where G.Serial_Number=I.Serial_Number AND G.is_used=0";
				   
			$ng_result = executePlainSQL($ng);
			
			 echo "<br>All New Games: <br>";    
    		 echo "<table>";
			 echo "<tr><th>Name</th><th>Price</th><th>Serial Number</th><th>Genre</th><th>Platform</th><th>Publisher</th></tr>";
			 while ($row = OCI_Fetch_Array($ng_result,OCI_BOTH)) {
			 echo "<tr><td>". $row["PNAME"] . "</td><td>".$row["PRICE"]."</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row['GENRE']."</td><td>" .$row['PLATFORM']."</td><td>" .$row['PUBLISHER']."</td><tr>";
	  	}
	  		 echo "</table>";
				   
			
			}
			
		}
		
	}
?>

 <?php
 
    if($db_conn) {
    	if(isset($_POST['modify'])){
    		if(isset($_GET['name'])){
    		if(preg_match("/[0-9]+/",$_POST['EmployeeID'])){
    		
    			$eid=$_POST['EmployeeID'];
    			$ename=$_POST['EName'];
    			$ephone=$_POST['EPhone'];
    			$eaddress=$_POST['EAddress'];
    			
    			echo "<br> Modify ID:" .$eid. "<br>";
    			
    			if(!(strcmp($ename, "New Name")==0)){
    			if(preg_match("/^[a-zA-Z\s]+$/",$_POST['EName'])){
    			
    			$ud_name = "UPDATE Employee
    						SET EName = '".$ename."'
    						WHERE Employee_ID = '".$eid."'";
    			$parse_name = OCIParse($db_conn, $ud_name);
    			$result_name = OCIExecute($parse_name, OCI_DEFAULT);
    			} 
    			else
    			echo "<br><font color='FF0000'>Input Type Incorrect! Name Must Be Letters</font><br>";
    			}
    			
    		if(!(strcmp($ephone, "New Phone")==0)){
    		
    		if(	preg_match("/[0-9]+/",$_POST['EPhone'])){
    			
    			$ud_phone = "UPDATE Employee
    						 SET EPhone = '".$ephone."'
    						 WHERE Employee_ID = '".$eid."'";
    			$parse_phone = OCIParse($db_conn, $ud_phone);
    			$result_phone = OCIExecute($parse_phone, OCI_DEFAULT);
    			}
    			else 
    			echo "<br><font color='FF0000'>Input Type Incorrect! Phone Must Be Numbers</font><br>";
    		} 
    		
    		if(!(strcmp($eaddress, "New Address")==0)){
    			if(preg_match("/^[0-9a-zA-Z\s,.]+$/", $_POST['EAddress'])){
    			$ud_address = "UPDATE Employee
    						   SET EAddress = '".$eaddress."'
    						   WHERE Employee_ID = '".$eid."'";
    			$parse_add = OCIParse($db_conn, $ud_address);
    			$restult_add = OCIExecute($parse_add, OCI_DEFAULT);
    		} else
    			echo "<br><font color='FF0000'>Input Type Incorrect! Address Must Be Numbers and Letters</font><br>";
    		}
    		
    		
    		
    		
    		OCICommit($db_conn);
    		$new_info = "SELECT *
    					 FROM Employee
    					 WHERE Employee_ID = '".$eid."'";
    		$result_info = executePlainSQL($new_info);
    		
    	//prints modified employee info
	  echo "<br>Modified Employee Info:<br>";
	  echo "<table>";
	  echo "<tr><th>Employee ID</th><th>Name</th><th>Phone Number</th><th>Address</th></tr>";

	  while ($row = OCI_Fetch_Array($result_info, OCI_BOTH)) {
		echo "<tr><td>" . $row["EMPLOYEE_ID"] . "</td><td>" . $row["ENAME"] . "</td><td>" . $row["EPHONE"] . "</td><td>" . $row["EADDRESS"] . "</td></tr>";
	  }
	  echo "</table>";
    
    }
    	else	echo  "<br><br><font color='ff0000'>Please Enter Employee ID</font><br>";	
	 }  

} 
}
  
?> 

<?php

	    if($db_conn) {
        if(isset($_POST['search'])) {
            if(isset($_GET['name'])){
	
	    $drop_nos = "DROP VIEW NOS";
	    $parse_drop = OCIParse($db_conn, $drop_nos);
	    $result_drop = OCIExecute($parse_drop, OCI_DEFAULT);            

	    $most_expensive = "Create View NOS (Sale_Number, purchase_total) AS
				select s.Sale_Number, sum(i.Price) AS purchase_total
				from Stores_Purchased s, Item i
				where s.Serial_Number = i.Serial_Number
				group by s.sale_number		
				having count(s.Serial_Number) > 1";
		$parse_me = OCIParse($db_conn, $most_expensive);
		$result_me = OCIExecute($parse_me, OCI_DEFAULT);
		OCICommit($db_conn);
	    $most_expensive2 ="	select m.Account_ID, a.aname, m.sale_number,n.purchase_total
				from NOS n, makes m, account a
				where n.Sale_Number = m.Sale_Number and a.account_ID = m.account_ID and n.purchase_total = (select max(purchase_total) from nos)";	
		
	    $result_me2 = executePlainSQL($most_expensive2);
	
	echo "<br>Retrieved Data: <br>";
	echo "<table>";
	echo "<tr><th>Account ID</th><th>Name</th><th>Sale Number</th><th>Purchase Total</th></tr>";
	while ($row = OCI_Fetch_Array($result_me2,OCI_BOTH)) {
		echo "<tr><td>" . $row["ACCOUNT_ID"] ."</td><td>".$row["ANAME"]."</td><td>".$row["SALE_NUMBER"]. "</td><td>" . $row["PURCHASE_TOTAL"] . "</td></tr>";
	  }
	  echo "</table>";
		
	    
}
}
}

?>

 
<?php
	if($db_conn){
		if(isset($_POST['go'])) {
            if(isset($_GET['name'])){
            $sum = "SELECT sum(Total_Cost)
            		FROM Payment_Record";
            $result_sum = executePlainSQL($sum);
    echo "<br>Retrieved Data: <br>";    
    echo "<table>";
	echo "<tr><th>Sum of All Purchase:</th></tr>";
	while ($row = OCI_Fetch_Array($result_sum,OCI_BOTH)) {
		echo "<tr><td>" . $row["SUM(TOTAL_COST)"] . "</td></tr>";
	  }
	  echo "</table>";
	}
	}
	}
?>

<?php
	    if($db_conn) {
    	if(isset($_POST['add'])){
    		if(isset($_GET['name'])){
    		if(preg_match("/^[0-9]+$/",$_POST['CEmployeeID']) AND preg_match("/^[0-9]+$/",$_POST['AccountID'])){
    		
    			$cid=$_POST['CEmployeeID'];
    			$aid=$_POST['AccountID'];
    			$aname=$_POST['AName'];
    			$aphone=$_POST['APhone'];
    			$aaddress=$_POST['AAddress'];
    			
    			echo "<br> AccountID: ".$aid." added by EmployeeID: ".$cid. "<br>";
    			
    			if(!(strcmp($aname, "Name")==0)){
    			if(preg_match("/^[a-zA-Z\s]+$/",$_POST['AName'])){
    				if(preg_match("/^[0-9]+$/", $_POST['APhone'])){
    					if(preg_match("/^[0-9a-zA-Z\s,.]+$/", $_POST['AAddress'])){
    			
    			$ac_name = "insert into account values
							(".$aid.", 0, '".$aname."', '".$aaddress."', ".$aphone.")";
				
				
				
				$parse_add = OCIParse($db_conn, $ac_name);
				$result_add = OCIExecute($parse_add, OCI_DEFAULT);
				
				$creates = "insert into creates values
							(".$cid.", ".$aid.")";
							
				$parse_create = OCIParse($db_conn, $creates);
				$result_creates = OCIExecute($parse_create, OCI_DEFAULT);
				
				if($result_creates){
				OCICommit($db_conn);
				
				$new_acc = "SELECT *
    					 FROM Account
    					 ";
    			$result_acc = executePlainSQL($new_acc);
    		
    	//prints modified employee info
	  			echo "<br>Created New Account:<br>";
	  			echo "<table>";
	  			echo "<tr><th>AccountID</th><th>Points</th><th>Name</th><th>Address</th><th>Phone</th></tr>";

	  			while ($row = OCI_Fetch_Array($result_acc, OCI_BOTH)) {
				echo "<tr><td>" . $row["ACCOUNT_ID"] . "</td><td>" . $row["POINTS"] . "</td><td>" . $row["ANAME"] . "</td><td>" . $row["AADDRESS"] . "</td><td>".$row["APHONE"]."</td></tr>";
	  			}
	  			echo "</table>";
				}
				
				else{
				echo "<br><font color='ff0000'> Account ID Already Exists</font><br>";
				
				}
				
    			
    			}else
    				echo "<br><font color='ff0000'> Input Type Incorrect! Address Must Be Letters and Numbers</font><br>";
    			}else
    				echo "<br><font color='ff0000'>Input Type Incorrect! Phone Must Be Numbers</font><br>";
    			}
    			else
    			echo "<br><font color='FF0000'>Input Type Incorrect! Name Must Be Letters</font><br>";
    			}
    			else
    			echo "<br><font color='FF0000'>Pleae Enter Name for the Account</font><br>";
    			
    		
    			
    			
    
    }
    	else	echo  "<br><br><font color='ff0000'>Please Enter Employee ID and AccountID</font><br>";	
	 }  

} 
}
	
?>


  <?php
	
	
    if($db_conn) {
      if(isset($_POST['deleter'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/[0-9]+/", $_POST['delete'])){
		    $accountd=$_POST['delete'];
		    echo "<br> Delete returns for Account ID: ".$accountd."<br>";
		  
		    $sqld = "delete returns where account_id = ".$accountd." ";
		    $parsedd = OCIParse($db_conn, $sqld);
		    $resultd=OCIExecute($parsedd, OCI_DEFAULT);
		    OCICommit($db_conn);
		    
		    $sqlpd = "select * from returns";	    
		    $resultpd = executePlainSQL($sqlpd);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Returns:<br>";
	  echo "<table>";
	  echo "<tr><th>Account ID</th><th>Serial Number</th><th>Return Date</th></tr>";

	  while ($row = OCI_Fetch_Array($resultpd, OCI_BOTH)) {
		echo "<tr><td>" . $row["ACCOUNT_ID"] . "</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["RETURN_DATE"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "<br><font color='FF0000'>Input Type Incorrect! AccountID Must Be Numbers</font><br>";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}

  ?>

</div>



</body>

</html>

