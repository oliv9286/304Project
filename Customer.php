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
View all payment record of this account 
	<input type="text" name="payment" value="Account ID"/>
	<input type="submit" name="paid" value="Go!"/>
</form>
  
<form method="post" action="Customer.php?name" >
View all purchase history of this account 
	<input type="text" name="customer" value="Account ID"/>
	<input type="submit" name="submit" value="Go!"/>
</form>


<form method="post" action="Customer.php?name" >
View points for this account 
	<input type="text" name="account" value="Account ID"/>
	<input type="submit" name="search" value="Go!"/>
</form>


<form method="post" action="Customer.php?name" >
View returns for this account 
	<input type="text" name="return" value="Account ID"/>
	<input type="submit" name="find" value="Go!"/>
</form>

<form method="post" action="Customer.php?name" >
Buy an item using this account 
	<input type="text" name="buyer" value="Account ID"/>
	<input type="text" name="item" value="Serial Number"/>
	
	<select name="paymethod">
	<option value="Credit Card">Credit Card</option>
	<option value="Debit Card">Debit Card</option>
	<option value="Points">Points</option>
	</select>
	
	<input type="submit" name="buy" value="Buy!"/>
</form>
    
<form method="post" action="Customer.php?name" >
Return an item using this account 
	<input type="text" name="returner" value="Account ID"/>
	<input type="text" name="ritem" value="Serial Number"/>
	<input type="submit" name="returned" value="Return!"/>
</form>

</br>
<table>
<tr><td>
<form method="post" action="Customer.php?allitems" id="allitems">
<input type="submit" name="AllItemsSubmit" value="All Items"/>
</form>
</td><td>
<form method="post" action="Customer.php?allgames" id="allgames">
<input type="submit" name="AllGamesSubmit" value="All Games"/>
</form>
</td><td>
<form method="post" action="Customer.php?newgames" id="newgames">
<input type="submit" name="NewGameSubmit" value="New Games"/>
</form>
</td><td>
<form method="post" action="Customer.php?usedgames" id="usedgames">
<input type="submit" name="UsedGameSubmit" value="Used Games"/>
</form>
</td><td>
<form method="post" action="Customer.php?hardware" id="hardware">
<input type="submit" name="HardwareSubmit" value="Hardware"/>
</form>
</td></tr>
</table>



<?php
	
	
    if($db_conn) {
      if(isset($_POST['returned'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['returner'])){
		      if (preg_match("/^[0-9]+$/", $_POST['ritem'])){
			      
		    $returner=$_POST['returner'];
		    $ritem = $_POST['ritem'];
		    $rdate = date("d-M-Y"); //today's date
		    echo "<br>".$returner."<br>";
		  
		    $sqlreturn = "insert into returns values (".$returner.", ".$ritem.", '".$rdate."')";
		    $parsedret = OCIParse($db_conn, $sqlreturn);
		    $resultret=OCIExecute($parsedret, OCI_DEFAULT); 
		    
		    OCICommit($db_conn);
		    
		    $preturn = "select * from returns where account_id = ".$returner."";
		    $resultreturn = executePlainSQL($preturn);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Returns:<br>";
	  echo "<table>";
	  echo "<tr><th>Account ID</th><th>Serial Number</th><th>Return Date</th></tr>";

	  while ($row = OCI_Fetch_Array($resultreturn, OCI_BOTH)) {
		echo "<tr><td>" . $row["ACCOUNT_ID"] . "</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["RETURN_DATE"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	    } else
	    echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	  }
	}
}

   ?>
   

 <?php
	
	
    if($db_conn) {
      if(isset($_POST['buy'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['buyer'])){
		      if (preg_match("/^[0-9]+$/", $_POST['item'])){
		      if (preg_match("/^[a-zA-Z\s]+$/", $_POST['paymethod'])){
			      
		    $buyer=$_POST['buyer'];
		    $item=$_POST['item'];
		    $paymethod=$_POST['paymethod'];
		    
		    echo "<br>".$buyer."<br>";	

		    $sqlmax = "select max(sale_number) from payment_record";
    		$resultmax = executePlainSQL($sqlmax);
    		$rowmax = OCI_Fetch_Array($resultmax, OCI_BOTH);
    		$salesb = $rowmax["MAX(SALE_NUMBER)"];
    		$sales = $salesb + 1; //new sale number
    		  
    		$quan = "select quantity from item where serial_number = ".$item."";
    		$resultquan = executePlainSQL($quan);
    		$rowquan = OCI_Fetch_Array($resultquan, OCI_BOTH);
    		$quandecb = $rowquan["QUANTITY"];
    		$quandec = $quandecb - 1; //new item quantity
    		 
    		$dec = "update item set quantity ='".$quandec."' where serial_number =".$item."";
		    $parseddec = OCIParse($db_conn, $dec);
		    $resultdec=OCIExecute($parseddec, OCI_DEFAULT); 
		     
		    $price = "select price from item where serial_number = ".$item."";
		    $resultprice = executePlainSQL($price);
    		$rowprice = OCI_Fetch_Array($resultprice, OCI_BOTH);
    		$total = $rowprice["PRICE"]; // total price
    		 
    		$today =  date("d-M-Y"); //today's date
			
    		$prinsert = "insert into Payment_Record values (".$sales.", '".$paymethod."', ".$total.", '".$today."')";
		    $parsedpr = OCIParse($db_conn, $prinsert);
		    $resultpr=OCIExecute($parsedpr, OCI_DEFAULT);
		    
		    $minsert = "insert into makes values (".$buyer.", ".$sales.")";
		    $parsedm = OCIParse($db_conn, $minsert);
		    $resultm=OCIExecute($parsedm, OCI_DEFAULT);
		    
		    $spinsert = "insert into stores_purchased values (".$sales.", ".$item.")";
		    $parsedsp = OCIParse($db_conn, $spinsert);
		    $resultsp=OCIExecute($parsedsp, OCI_DEFAULT);
		    
		        		
    		if ( strcmp ( $paymethod , "Points" ) == 0){
			$oldpoints = "select points from account where account_id = ".$buyer."";
    		$resultpoints = executePlainSQL($oldpoints);
    		$rowpoints = OCI_Fetch_Array($resultpoints, OCI_BOTH);
    		$pointsdecb = $rowpoints["POINTS"];
    		$pointsdec = $pointsdecb - $total; //new points
    		
    		if ($pointsdec < 0)
    		echo "<br><font color='FF0000'>Not enough points!  Choose another payment method.</font><br>";
    		else {
    		$pdec = "update account set points =".$pointsdec." where account_id = ".$buyer."";
		    $parsedpdec = OCIParse($db_conn, $pdec);
		    $resultpdec=OCIExecute($parsedpdec, OCI_DEFAULT); 
	    		}
			}
			
		    OCICommit($db_conn);
		    
		    $sqlbuy = "select m.account_id, m.sale_number, s.serial_number from makes m, stores_purchased s where m.account_id =".$buyer." AND m.sale_number = s.sale_number";	    
		    $resultbuy = executePlainSQL($sqlbuy);
		    
			    //prints results from a select statement
	  echo "<br>Got data from tables Makes and Payment Record:<br>";
	  echo "<table>";
	  echo "<tr><th>Account ID</th><th>Sale Number</th><th>Serial Number</th></tr>";

	  while ($row = OCI_Fetch_Array($resultbuy, OCI_BOTH)) {
		echo "<tr><td>" . $row["ACCOUNT_ID"] . "</td><td>" . $row["SALE_NUMBER"] . "</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input letters only.</font><br>";
	    } else
	    echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	  } else
	  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}
}
}

   ?>
   
   
<?php
	
	
    if($db_conn) {
      if(isset($_POST['modify'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['AccountID'])){
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
		    echo "<br><font color='FF0000'>Input not of correct type!  Please input letters only.</font><br>";
	    }
	    	if (!(strcmp($address, "New Address") == 0)) {
		    	 if(preg_match("/[A-Z  | a-z | 0-9]+/", $_POST['AAddress'])){
		    $sql2 = "update account set aaddress ='".$address."' where account_id ='".$account."'";
		    $parsed2 = OCIParse($db_conn, $sql2);
		    $result2=OCIExecute($parsed2, OCI_DEFAULT);
		    } else
		    echo "<br><font color='FF0000'>Input not of correct type!  Please input letters and numbers only.</font><br>";
	    }	    
	    	if (!(strcmp($phone, "New Phone Number") == 0)){
		    	 if(preg_match("/^[0-9]+$/", $_POST['APhone'])){
		    $sql3 = "update account set aphone ='".$phone."' where account_id ='".$account."'";
		    $parsed3 = OCIParse($db_conn, $sql3);
		    $result3=OCIExecute($parsed3, OCI_DEFAULT);
		    } else
		    echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
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
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID and value(s) to modify.</p>";
	}

  ?>
  

 <?php
	
	
    if($db_conn) {
      if(isset($_POST['paid'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['payment'])){
		    $payment=$_POST['payment'];
		    echo "<br>".$payment."<br>";
		  
		    $sqlpay = "select p.sale_number, p.method_payment, p.total_cost, p.pdate from payment_record p, makes m where p.sale_number = m.sale_number AND m.account_id = ".$payment."";
		    $resultpay = executePlainSQL($sqlpay);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Payment_Record:<br>";
	  echo "<table>";
	  echo "<tr><th>Sale Number</th><th>Method of Payment</th><th>Total Cost</th><th>Payment Date</th></tr>";

	  while ($row = OCI_Fetch_Array($resultpay, OCI_BOTH)) {
		echo "<tr><td>" . $row["SALE_NUMBER"] . "</td><td>" . $row["METHOD_PAYMENT"] . "</td><td>" . $row["TOTAL_COST"] . "</td><td>" . $row["PDATE"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}

   ?>
  
    
<?php
	
	
    if($db_conn) {
      if(isset($_POST['submit'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['customer'])){
		    $purchase=$_POST['customer'];
		    echo "<br>".$purchase."<br>";
		  
		    $sql = "select S.Sale_Number, I.Serial_Number, I.PName from Account A, Makes M, Stores_Purchased S, Item I where A.Account_ID = M.Account_ID AND A.Account_ID = ".$purchase." AND M.Sale_Number = S.Sale_Number AND S.Serial_Number = I.Serial_Number";
		    $result = executePlainSQL($sql);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Stores Purchased and Item:<br>";
	  echo "<table>";
	  echo "<tr><th>Sale Number</th><th>Serial Number</th><th>Product Name</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SALE_NUMBER"] . "</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["PNAME"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
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
	      if(preg_match("/^[0-9]+$/", $_POST['account'])){
		    $accountp=$_POST['account'];
		    echo "<br>".$accountp."<br>";
		  
		    $sqlp = "select a.points from Account a where a.Account_ID =  ".$accountp."";
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
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}

  ?>
  
  <?php
	
	
    if($db_conn) {
      if(isset($_POST['find'])) {
	    if(isset($_GET['name'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['return'])){
		    $accountr=$_POST['return'];
		    echo "<br>".$accountr."<br>";
		  
		    $sqlr = "select I.pname, R.return_date from Returns R, Item I where R.Account_ID =  ".$accountr." AND I.Serial_Number = R.Serial_Number";
		    $resultp = executePlainSQL($sqlr);
		    
			    //prints results from a select statement
	  echo "<br>Got data from table Returns:<br>";
	  echo "<table>";
	  echo "<tr><th>Product Name</th><th>Return Date</th></tr>";

	  while ($row = OCI_Fetch_Array($resultp, OCI_BOTH)) {
		echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["RETURN_DATE"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    
		    
		  } else
		  echo "<br><font color='FF0000'>Input not of correct type!  Please input numbers only.</font><br>";
	    }
	  }
	}
	else {
	  echo "<p>Please enter an account ID.</p>";
	}

  ?>
  
<?php
	
	 if($db_conn) {
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

      else if(isset($_POST['AllGamesSubmit'])) {
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

      else if(isset($_POST['NewGameSubmit'])) {
if(isset($_GET['newgames'])) {
$sql = "select i.pname, g.genre, g.platform, i.price from New_Game n, Game g, Item i where n.serial_number=g.serial_number AND n.serial_number = i.serial_number";
$result = executePlainSQL($sql);
echo "<br>New Games</br>";
echo "<table>";
echo "<tr><th>Game</th><th>Genre</th><th>Platform</th><th>Price</th></tr>";
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PRICE"] . "</td></tr>"; //or just use "echo $row[0]"
}
echo "</table>";
}
}

      else if(isset($_POST['UsedGameSubmit'])) {
if(isset($_GET['usedgames'])) {
$sql = "select i.pname, g.genre, g.platform, i.price, u.discount from Used_Game u, Game g, Item i where u.serial_number=g.serial_number AND u.serial_number = i.serial_number";
$result = executePlainSQL($sql);
echo "<br>Used Games</br>";
echo "<table>";
echo "<tr><th>Game</th><th>Genre</th><th>Platform</th><th>Price</th><th>Discount</th></tr>";
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["DISCOUNT"] . "</td></tr>"; //or just use "echo $row[0]"
}
echo "</table>";
}
}

      else if(isset($_POST['HardwareSubmit'])) {
if(isset($_GET['hardware'])) {
$sql = "select i.pname, h.type, i.price from Hardware h, Item i where i.serial_number=h.serial_number";
$result = executePlainSQL($sql);
echo "<br>Hardware and Accessories</br>";
echo "<table>";
echo "<tr><th>Game</th><th>Type</th><th>Price</th></tr>";
while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["TYPE"] . "</td><td>" . $row["PRICE"] . "</td></tr>"; //or just use "echo $row[0]"
}
echo "</table>";
}
}

}




  ?>
  
</br></br></br></br></br>


</div>

</body>
</html>