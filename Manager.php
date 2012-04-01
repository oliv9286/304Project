<html>
<head>
<link rel="stylesheet" type="text/css" href="template.css"/>
</head>

<body>
<img src='background.png'/>
<div class="pos">

<a href="index.php">Back</a>
<br>
<br>
<br>

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

    function printSalesResult($result) { //prints results from a select statement
	  echo "<br>Got data from Employee table<br>";
	  echo "<table>";
	  echo "<tr><th>Employee Name</th><th>Item Name</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["ENAME"] . "</td><td>" . $row["PNAME"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    }
	
	 function printItemResult($result) { //prints results from a select statement
	  echo "<br>Got data from Item table<br>";
	  echo "<table>";
	  echo "<tr><th>Serial_Number</th><th>PName</th><th>Price</th><th>Quantity</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["PNAME"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printAllPaymentResult($result) { //prints results from a select statement
	  echo "<br>Got data from Payment_Record table<br>";
	  echo "<table>";
	  echo "<tr><th>Sale_Number</th><th>Method_Payment</th><th>Total_Cost</th><th>PDate</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SALE_NUMBER"] . "</td><td>" . $row["METHOD_PAYMENT"] . "</td><td>" . $row["TOTAL_COST"] . "</td><td>" . $row["PDATE"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printAllSalesResult($result) { //prints results from a select statement
	  echo "<br>Got data from Sells table<br>";
	  echo "<table>";
	  echo "<tr><th>Employee_ID</th><th>Serial_Number</th><th>Number_Copies</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["EMPLOYEE_ID"] . "</td><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["NUMBER_COPIES"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printAllClerksResult($result) { //prints results from a select statement
	  echo "<br>Got data from Clerk table<br>";
	  echo "<table>";
	  echo "<tr><th>Employee_ID</th><th>EName</th><th>EPhone</th><th>EAddress</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["EMPLOYEE_ID"] . "</td><td>" . $row["ENAME"] . "</td><td>" . $row["EPHONE"] . "</td><td>" . $row["EADDRESS"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printAllAccountsResult($result) { //prints results from a select statement
	  echo "<br>Got data from Account table<br>";
	  echo "<table>";
	  echo "<tr><th>Account_ID</th><th>Points</th><th>AName</th><th>AAddress</th><th>APhone</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["ACCOUNT_ID"] . "</td><td>" . $row["POINTS"] . "</td><td>" . $row["ANAME"] . "</td><td>" . $row["AADDRESS"] . "</td><td>" . $row["APHONE"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
		
	
	function printGameResult($result) { //prints results from a select statement
	  echo "<br>Got data from Game table<br>";
	  echo "<table>";
	  echo "<tr><th>Serial_Number</th><th>PName</th><th>Price</th><th>Quantity</th><th>Genre</th><th>Platform</th><th>Publisher</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["PNAME"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PUBLISHER"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printUsedGameResult($result) { //prints results from a select statement
	  echo "<br>Got data from Game table<br>";
	  echo "<table>";
	  echo "<tr><th>Serial_Number</th><th>PName</th><th>Price</th><th>Quantity</th><th>Genre</th><th>Discount</th><th>Platform</th><th>Publisher</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["PNAME"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["DISCOUNT"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PUBLISHER"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printHardwareResult($result) { //prints results from a select statement
	  echo "<br>Got data from Hardware table<br>";
	  echo "<table>";
	  echo "<tr><th>Serial_Number</th><th>Type</th><th>Company</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["SERIAL_NUMBER"] . "</td><td>" . $row["TYPE"] . "</td><td>" . $row["COMPANY"] . "</td><td>"; //or just use "echo $row[0]" 
		}
	  echo "</table>";
    }
	
	function printBoughtResult($result) { //prints results from a select statement
	  echo "<br>Got data from Account table<br>";
	  echo "<table>";
	  echo "<tr><th>Account Owner's Name</th><th>Item Name</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["ANAME"] . "</td><td>" . $row["PNAME"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    }

	function printHiresResult($result) { //prints results from a select statement
	  echo "<br>Got data from Hires table<br>";
	  echo "<table>";
	  echo "<tr><th>Manager ID</th><th>Manager name</th><th>Employee ID</th></tr>";

	  while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["MANAGER_ID"] . "</td><td>" . $row["ENAME"] . "</td><td>" . $row["EMPLOYEE_ID"] . "</td><td>"; //or just use "echo $row[0]" 
	  }
	  echo "</table>";
    }	
	
	function printInsertResult($result) { //prints results from a select statement
	  echo "<br> Your Item is inserted <br>";

	  
    }
	
	function printstockResult($result) { //prints results from a select statement
	  echo "<br> The stock is changed <br>";
    }
	
		function printModifyResult($result) { //prints results from a select statement
	  echo "<br> The item is modified <br>";
    }
	
?>

<form method="post" action="Manager.php?employeesales" id="sales">
View Sales made by 
   <input type="text" name="clerk" value="Employee name"/>
   <input type="submit" name="salessubmit" value="Go!"/>
</form>

<form method="post" action="Manager.php?accounttransact" id ="acctran">
View purchase history of 
	<input type="text" name="customer"  value="Account ID"/>
	<input type="submit" name="accTranSubmit" value="Go!"/>
</form>



<form method="post" action="Manager.php?inserthardware" id ="insert">
Add New Hardware: <br>
<input type="text" name="serial_number" value="Serial Number"/>
<input type="text" name="PName" value="Name"/><br>
<input type="text" name="Price" value="Price"/>
<input type="text" name="Quantity" value="Quantity"/><br>
<input type="text" name="Company" value="Publisher/Company"/>

<select name="hardwareType">
<option value="Accessory">Accessory</option>
<option value="Handheld">Handheld</option>
<option value="Console">Console</option>
</select>
<input type="submit" name="insertSubmit" value="insert"/>
</form>

<form method="post" action="Manager.php?insertgame" id ="insert">
Add New Game: <br>
<input type="text" name="serial_number" value="Serial Number"/>
<input type="text" name="PName" value="Name"/><br>
<input type="text" name="Price" value="Price"/>
<input type="text" name="Quantity" value="Quantity"/><br>
<input type="text" name="Company" value="Publisher/Company"/>

<select name="genreType">
<option value="RPG">RPG</option>
<option value="PLATFORMER">PLATFORMER</option>
<option value="HORROR">HORROR</option>
<option value="ACTION">ACTION</option>
<option value="FPS">FPS</option>
<option value="RACING">RACING</option>
<option value="SHOOTER">SHOOTER</option>
<option value="FIGHTING">FIGHTING</option>
</select>

<select name="platformType">
<option value="PS3">PS3</option>
<option value="PC">PC</option>
<option value="XBox">XBOX 360</option>
<option value="Wii">WII</option>
<option value="Vita">VITA</option>
<option value="3DS">3DS</option>
</select>

<input type="submit" name="insertGameSubmit" value="insert"/>
</form>

<form method="post" action="Manager.php?insertusedgame" id ="insert">
Add Used Game: <br>
<input type="text" name="serial_number" value="Serial Number"/>
<input type="text" name="PName" value="Name"/><br>
<input type="text" name="Price" value="Price"/>
<input type="text" name="Discount" value="Discount"/>
<input type="text" name="Quantity" value="Quantity"/><br>
<input type="text" name="Company" value="Publisher/Company"/>

<select name="genreType">
<option value="RPG">RPG</option>
<option value="PLATFORMER">PLATFORMER</option>
<option value="HORROR">HORROR</option>
<option value="ACTION">ACTION</option>
<option value="FPS">FPS</option>
<option value="RACING">RACING</option>
<option value="SHOOTER">SHOOTER</option>
<option value="FIGHTING">FIGHTING</option>
</select>

<select name="platformType">
<option value="PS3">PS3</option>
<option value="PC">PC</option>
<option value="XBox">XBOX 360</option>
<option value="Wii">WII</option>
<option value="Vita">VITA</option>
<option value="3DS">3DS</option>
</select>

<input type="submit" name="insertUsedGameSubmit" value="insert"/>
</form>



<form method="post" action="Manager.php?changestock" id ="change">
Change Stock: <br>
<input type="text" name="Serial" value="Serial Number"/> 
<input type="text" name="Quantity" value="Quantity"/>
<input type="submit" name="stockSubmit" value="Submit"/>
</form>


<form method="post" action="Manager.php?modifyitem" id ="modify">
Modify Item:<br>
<input type="text" name="Serial" value="Serial Number" /><br>
<input type="text" name="PName" value="New_Name"/>
<input type="text" name="Price" value="New_Price"/>
<input type="submit" name="modifySubmit" value="Submit"/>
</form>

<form method="post" action="Manager.php?deleteitem" id ="modify">
Delete Item:<br>
<input type="text" name="delsnum" value="Serial Number" /><br>
<input type="submit" name="deleteSubmit" value="Submit"/>
</form>
<table>
<tr>
<td>
<form method="post" action="Manager.php?allpayment" id ="allp">
All Payments --
<input type="submit" name="allPaymentSubmit" value="Find!"/>
</form>
</td>
<td>
<form method="post" action="Manager.php?allsales" id ="allp">
All Sales --
<input type="submit" name="allSalesSubmit" value="Find!"/>
</form>
</td>
<td>
<form method="post" action="Manager.php?allaccounts" id ="allp">
All Accounts --
<input type="submit" name="allAccountsSubmit" value="Find!"/>
</form>
</td>
<td>
<form method="post" action="Manager.php?allclerks" id ="allp">
All Clerks --
<input type="submit" name="allClerksSubmit" value="Find!"/>
</form>
</td>
</tr>
</table>

<form method="post" action="Manager.php?allhires" id ="allp">
All Hires --
<input type="submit" name="allHiresSubmit" value="Find!"/>
</form>
</td>
</tr>
</table>

<table>
<tr><td>
<form method="post" action="Manager.php?viewallgames" id="allgames">
<input type="submit" name="AllGamesSubmit" value="All Games"/>
</form>
</td><td>
<form method="post" action="Manager.php?viewnewgames" id="newgames">
<input type="submit" name="NewGameSubmit" value="New Games"/>
</form>
</td><td>
<form method="post" action="Manager.php?viewusedgames" id="usedgames">
<input type="submit" name="UsedGameSubmit" value="Used Games"/>
</form>
</td><td>
<form method="post" action="Manager.php?viewhardware" id="hardware">
<input type="submit" name="HardwareSubmit" value="Hardware"/>
</form>
</td></tr>
</table>


<?php
 if($db_conn) {
      if(isset($_POST['salessubmit'])) {
	    if(isset($_GET['employeesales'])) {
	      if(preg_match("/^[A-Z  | a-z]+$/", $_POST['clerk'])){
		    $name=$_POST['clerk'];
		    echo "<br>".$clerk."<br>";
		    $sql = "select e.EName, i.PName from Employee e, Sells s, Item i where e.Employee_ID = s.Employee_ID and s.Serial_Number = i.Serial_Number and e.EName ='".$name."'";
		    $result = executePlainSQL($sql);
			printSalesResult($result);
		    
		  }
		 else {
			echo "<p><br><font color='FF0000'>Input Incorrect! Employee Name Must Be Letters</font><br><p>";
			}
	    }
	  }
	  else if(isset($_POST['accTranSubmit'])) {
	    if(isset($_GET['accounttransact'])) {
	       if(preg_match("/^[0-9]+$/", $_POST['customer'])){
		    $name=$_POST['customer'];
		    echo "<br>".$customer."<br>";
		  
		    $sql = "select A.AName, I.PName from Account A, Makes M, Stores_Purchased S, Item I where A.Account_ID = M.Account_ID AND M.Sale_Number = S.Sale_Number AND S.Serial_Number = I.Serial_Number and A.Account_ID='".$name."'";
		    $result = executePlainSQL($sql);
			printBoughtResult($result);
		    
		  }
		   else {
			echo "<p><br><font color='FF0000'>Input Incorrect! AccountID Must Be Numbers </font><br><p>";
			}
	    }
	  }
	  else if(isset($_POST['insertSubmit'])) {
	    if(isset($_GET['inserthardware'])) {
		
			 if(preg_match("/^[0-9]+$/", $_POST['serial_number']))
			 {
				if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['PName']))
				{
					if(preg_match("/^[0-9]+$/", $_POST['Price']))
					{
						if(preg_match("/^[0-9]+$/", $_POST['Quantity']))
						{
							if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['Company']))
							{	
								 $sNum=$_POST['serial_number'];
									$pName=$_POST['PName'];
									$pr=$_POST['Price'];
									$quan=$_POST['Quantity'];
									$comp=$_POST['Company'];
									$hType=$_POST['hardwareType'];

									echo "<br>".$serial_number."<br>";
									echo "<br>".$PName."<br>";
									echo "<br>".$Price."<br>";
									echo "<br>".$Quantity."<br>";
									echo "<br>".$Company."<br>";
									echo "<br>".$hardwareType."<br>";
	
			
								$sql = "INSERT INTO Item VALUES (".$sNum.", '".$pName."', ".$pr.", ".$quan.")";
								$parsed = OCIParse($db_conn, $sql);
								$sql2 =	"INSERT INTO Hardware values(".$sNum.", '".$hType."', '".$comp."')";
								$parsed2 = OCIParse($db_conn, $sql2);
								$r=OCIExecute($parsed, OCI_DEFAULT); 
								$r2=OCIExecute($parsed2, OCI_DEFAULT); 
			
								OCICommit($db_conn); 
								$sql4 = "select * from Hardware i";
								$result4 = executePlainSQL($sql4);
			
								printInsertResult($r3);
								printHardwareResult($result4);
							}
							
							else {
							echo "<p><br><font color='FF0000'>Input Incorrect! Company Name Must Be Letters</font><br><p>";
							}
						}
						
						else {
						echo "<p><br><font color='FF0000'>Input Incorrect! Quantity Must Be Numbers</font><br><p>";
						}
					}
					
					else {
					echo "<p><br><font color='FF0000'>Input Incorrect! Price Must Be Numbers	</font><br><p>";
					}
				}
				else {
				echo "<p><br><font color='FF0000'>Input Incorrect! Name Must Be Letters Or Numbers</font><br><p>";
				}
			 }
			else {
			echo "<p><br><font color='FF0000'>Input Incorrect!	Serial Number Must Be Numbers</font><br><p>";
			}
				
		
		   
		
		    
		  //}
	    }
	    else {
			echo "<p><br><font color='FF0000'>Insert Item Failed</font><br><p>";
		}
	  }
	  
	  	  else if(isset($_POST['insertGameSubmit'])) {
	    if(isset($_GET['insertgame'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		
		if(preg_match("/^[0-9]+$/", $_POST['serial_number']))
			 {
				if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['PName']))
				{
					if(preg_match("/^[0-9]+$/", $_POST['Price']))
					{
						if(preg_match("/^[0-9]+$/", $_POST['Quantity']))
						{
							if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['Company']))
							{	
							
								$sNum=$_POST['serial_number'];
								$pName=$_POST['PName'];
								$pr=$_POST['Price'];
								$quan=$_POST['Quantity'];
								$comp=$_POST['Company'];
								$gType=$_POST['genreType'];
								$pType=$_POST['platformType'];
								//$newU=$_POST['newUsed'];


								echo "<br>".$serial_number."<br>";
								echo "<br>".$PName."<br>";
								echo "<br>".$Price."<br>";
								echo "<br>".$Quantity."<br>";
								echo "<br>".$Company."<br>";
								echo "<br>".$genreType."<br>";
								echo "<br>".$platformType."<br>";
								//echo "<br>".$newUsed."<br>";
			
								$sql = "INSERT INTO Item VALUES (".$sNum.", '".$pName."', ".$pr.", ".$quan.")";
								$parsed = OCIParse($db_conn, $sql);
								$r=OCIExecute($parsed, OCI_DEFAULT); 
			
								//echo "<br>".$temp."<br>";
								$sql2 =	"INSERT INTO Game values(".$sNum.", '".$gType."', '".$temp."', '".$pType."', '".$comp."')";
								$parsed2 = OCIParse($db_conn, $sql2);
								$r2=OCIExecute($parsed2, OCI_DEFAULT);	
			
					
									$sql3 = "INSERT INTO new_game VALUES (".$sNum.")";
									$parsed3 = OCIParse($db_conn, $sql3);
									$r3=OCIExecute($parsed3, OCI_DEFAULT);

									//$sql3 = "INSERT INTO used_game VALUES (".$sNum.", ".$pr.")";
									//$parsed3 = OCIParse($db_conn, $sql3);
									//$r3=OCIExecute($parsed3, OCI_DEFAULT);

			
								OCICommit($db_conn); 
			
								$sql4 = "select i.Serial_Number, i.PName, i.Price, i.Quantity, g.Genre, g.Platform, g.Publisher from Item i, Game g where i.Serial_Number = g.Serial_Number";
								$result4 = executePlainSQL($sql4);
			
								//printInsertResult($r3);
								printGameResult($result4);
							
							
							}
							 else {
							echo "<p><br><font color='FF0000'>Incorrect Input! Company Name Must Be Letters and/or Numbers</font><br><p>";
							}
						}
						 else {
						echo "<p><br><font color='FF0000'>Incorrect Input! Quantity Must Be Numbers</font><br><p>";
						}
					}
					 else {
					echo "<p><br><font color='FF0000'>Incorrect Input! Price Must Be Numbers</font><br><p>";
					}
				}
				 else {
				echo "<p><br><font color='FF0000'>Incorrect Input! Name Must Be Letters Or Numbers</font><br><p>";
				}
			}
			else {
			echo "<p><br><font color='FF0000'>Incorrect Input! Serial Number Must Be Numbers</font><br><p>";
			}			
		
		
		
		

			//echo "<br>".$r2."<br>";
			
			
			
		
		    
		  //}
	    }
	    else {
			echo "<p><br><font color='FF0000'>Insertitem failed</font><br><p>";
		}
	  }
	  
	  else if(isset($_POST['insertUsedGameSubmit'])) {
	    if(isset($_GET['insertusedgame'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		
		if(preg_match("/^[0-9]+$/", $_POST['serial_number']))
			 {
				if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['PName']))
				{
					if(preg_match("/^[0-9]+$/", $_POST['Price']))
					{
						if(preg_match("/^[0-9]+$/", $_POST['Discount']))
						{
						if(preg_match("/^[0-9]+$/", $_POST['Quantity']))
						{
							if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['Company']))
							{	
							
								$sNum=$_POST['serial_number'];
								$pName=$_POST['PName'];
								$pr=$_POST['Price'];
								$dis=$_POST['Discount'];
								$quan=$_POST['Quantity'];
								$comp=$_POST['Company'];
								$gType=$_POST['genreType'];
								$pType=$_POST['platformType'];
								//$newU=$_POST['newUsed'];


								echo "<br>".$serial_number."<br>";
								echo "<br>".$PName."<br>";
								echo "<br>".$Price."<br>";
								echo "<br>".$Discount."<br>";
								echo "<br>".$Quantity."<br>";
								echo "<br>".$Company."<br>";
								echo "<br>".$genreType."<br>";
								echo "<br>".$platformType."<br>";
								//echo "<br>".$newUsed."<br>";
			
								$sql = "INSERT INTO Item VALUES (".$sNum.", '".$pName."', ".$pr.", ".$quan.")";
								$parsed = OCIParse($db_conn, $sql);
								$r=OCIExecute($parsed, OCI_DEFAULT); 
			
								//echo "<br>".$temp."<br>";
								$sql2 =	"INSERT INTO Game values(".$sNum.", '".$gType."', '".$temp."', '".$pType."', '".$comp."')";
								$parsed2 = OCIParse($db_conn, $sql2);
								$r2=OCIExecute($parsed2, OCI_DEFAULT);	
			
					
									//$sql3 = "INSERT INTO new_game VALUES (".$sNum.")";
									//$parsed3 = OCIParse($db_conn, $sql3);
									//$r3=OCIExecute($parsed3, OCI_DEFAULT);

									$sql3 = "INSERT INTO used_game VALUES (".$sNum.", ".$dis.")";
									$parsed3 = OCIParse($db_conn, $sql3);
									$r3=OCIExecute($parsed3, OCI_DEFAULT);

			
								OCICommit($db_conn); 
			
								$sql4 = "select i.Serial_Number, i.PName, i.Price, i.Quantity, g.Genre, u.Discount, g.Platform, g.Publisher from Item i, Game g, Used_Game u where i.Serial_Number = g.Serial_Number AND i.Serial_Number = u.Serial_Number";
								$result4 = executePlainSQL($sql4);
			
								//printInsertResult($r3);
								printUsedGameResult($result4);
							
							
							}
							 else {
							echo "<p><br><font color='FF0000'>Incorrect Input! Company Name Must Be Letters and/or Numbers</font><br><p>";
							}
						}
						 else {
						echo "<p><br><font color='FF0000'>Incorrect Input! Quantity Must Be Numbers</font><br><p>";
						}
						}
						else {
							echo "<p><br><font color='FF0000'>Incorrect Input! Discount Must Be Numbers</font><br><p>";
							}
					}
					 else {
					echo "<p><br><font color='FF0000'>Incorrect Input! Price Must Be Numbers</font><br><p>";
					}
				}
				 else {
				echo "<p><br><font color='FF0000'>Incorrect Input! Name Must Be Letters Or Numbers</font><br><p>";
				}
			}
			else {
			echo "<p><br><font color='FF0000'>Incorrect Input! Serial Number Must Be Numbers</font><br><p>";
			}			
		
		
		
		

			//echo "<br>".$r2."<br>";
			
			
			
		
		    
		  //}
	    }
	    else {
			echo "<p><br><font color='FF0000'>Insertitem failed</font><br><p>";
		}
	  }
	  
	
	  
	  
	  
	  
	  else if(isset($_POST['stockSubmit'])) {
	    if(isset($_GET['changestock'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['Serial']))
		  {
			if(preg_match("/^[0-9]+$/", $_POST['Quantity']))
			{
				$sNum=$_POST['Serial'];
				$quan=$_POST['Quantity'];
				//echo "<br>".$sNum."<br>";
				//echo "<br>".$quan."<br>";
		  
				$sql = "update Item set Quantity ='".$quan."' where Serial_Number ='".$sNum."'";
				$parsed = OCIParse($db_conn, $sql);
				$r=OCIExecute($parsed, OCI_DEFAULT); 
				OCICommit($db_conn); 
			
				$sql4 = "select * from Item i where i.Serial_Number = '".$sNum."'";
				$result4 = executePlainSQL($sql4);
				//printStockResult($r);
				printItemResult($result4);
		    
		    }
			else {
				echo "<p><br><font color='FF0000'>Incorrect Input! Quantity Must Be Numbers</font><br><p>";
			}
		 }
		 else {
			echo "<p><br><font color='FF0000'>Incorrect Input! Serial Number Must Be Numbers</font><br><p>";
		}
		 
	    }
	  }
	  
	  	  else if(isset($_POST['modifySubmit'])) {
	    if(isset($_GET['modifyitem'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['Serial']))
		  {
		  
			$sNum=$_POST['Serial'];
			$pname=$_POST['PName'];
			$price=$_POST['Price'];
			//echo "<br>".$sNum."<br>";
			//echo "<br>".$quan."<br>";
			
			if (!(strcmp($pname, "New_Name") == 0)) {
				if(preg_match("/^[0-9a-zA-Z\s]+$/", $_POST['PName']))
				{
					$sql = "update Item set PName ='".$pname."' where Serial_Number ='".$sNum."'";
					$parsed = OCIParse($db_conn, $sql);
					$r=OCIExecute($parsed, OCI_DEFAULT); 
				}
				else {
					echo "<p><br><font color='FF0000'>Incorrect Input! Name Must Be Letters Or Numbers</font><br><p>";
				}
			}
				
			if (!(strcmp($price, "New_Price") == 0)) {	
				if(preg_match("/^[0-9]+$/", $_POST['Price']))
				{
					$sql2 = "update Item set Price ='".$price."' where Serial_Number ='".$sNum."'";
					$parsed2 = OCIParse($db_conn, $sql2);
					$r2=OCIExecute($parsed2, OCI_DEFAULT); 
				}
				
				else {
					echo "<p><br><font color='FF0000'>Incorrect Input! Price Must Be Numbers</font><br><p>";
				}
		    }
					OCICommit($db_conn); 
					//printModifyResult($r2);
					$sql4 = "select * from Item i where i.Serial_Number = '".$sNum."'";
					$result4 = executePlainSQL($sql4);
					printItemResult($result4);

		 }
		 else {
			echo "<p><br><font color='FF0000'>Incorrect Input! Serial Number Must Be Numbers</font><br><p>";
		}
	    }
	  }
	  
	  else if(isset($_POST['deleteSubmit'])) {
	    if(isset($_GET['deleteitem'])) {
	      if(preg_match("/^[0-9]+$/", $_POST['delsnum'])){
			$del=$_POST['delsnum'];
			$sqld = "delete Item where Serial_Number = ".$del." ";
		    $parsedd = OCIParse($db_conn, $sqld);
		    $resultd=OCIExecute($parsedd, OCI_DEFAULT);
		    OCICommit($db_conn);
		    
		    $sqlpd = "select * from Item i";	    
		    $result = executePlainSQL($sqlpd);
			printItemResult($result);
		    
		  }
		  else {
			echo "<p><br><font color='FF0000'>Incorrect Input! Serial Number Must Be Numbers</font><br><p>";
		}
	    }
	  }
	  
	  	else if(isset($_POST['allPaymentSubmit'])) {
	    if(isset($_GET['allpayment'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		  
		    $sql = "select * from Payment_Record";
		    $result = executePlainSQL($sql);
			printAllPaymentResult($result);
		    
		  //}
	    }
	  }
	  
	 else if(isset($_POST['allSalesSubmit'])) {
	    if(isset($_GET['allsales'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		  
		    $sql = "select * from sells";
		    $result = executePlainSQL($sql);
			printAllSalesResult($result);
		    
		  //}
	    }
	  }
	  
	  else if(isset($_POST['allAccountsSubmit'])) {
	    if(isset($_GET['allaccounts'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		  
		    $sql = "select * from Account";
		    $result = executePlainSQL($sql);
			printAllAccountsResult($result);
		    
		  //}
	    }
	  }
	  
	  else if(isset($_POST['allClerksSubmit'])) {
	    if(isset($_GET['allclerks'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		  
		    $sql = "select e.Employee_ID, e.EName, e.EPhone, e.EAddress from Employee e, Clerk c where c.Employee_ID = e.Employee_ID";
		    $result = executePlainSQL($sql);
			printAllClerksResult($result);
		    
		  //}
	    }
	  }
	  
	  else if(isset($_POST['allHiresSubmit'])) {
	    if(isset($_GET['allhires'])) {
	    //  if(preg_match("/[A-Z  | a-z]+/", $_POST['clerk'])){
		  
		    $sql = "select h.Manager_ID, e.EName, h.Employee_ID from Employee e, Hires h where h.Manager_ID = e.Employee_ID";
		    $result = executePlainSQL($sql);
			printHiresResult($result);
		    
		  //}
	    }
	  }	  
	  
	        else if(isset($_POST['AllGamesSubmit'])) {
			if(isset($_GET['viewallgames'])) {
				$sql = "select i.pname, g.genre, g.platform, i.price, i.quantity from Game g, Item i where g.serial_number=i.serial_number";
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
		if(isset($_GET['viewnewgames'])) {
			$sql = "select i.pname, g.genre, g.platform, i.price, i.quantity from New_Game n, Game g, Item i where n.serial_number=g.serial_number AND n.serial_number = i.serial_number";
			$result = executePlainSQL($sql);
			echo "<br>New Games</br>";
			echo "<table>";
			echo "<tr><th>Game</th><th>Genre</th><th>Platform</th><th>Price</th><th>Quantity</th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td></tr>"; //or just use "echo $row[0]"
			}
			echo "</table>";
		}
	}
	
	      else if(isset($_POST['UsedGameSubmit'])) {
			if(isset($_GET['viewusedgames'])) {
			$sql = "select i.pname, g.genre, g.platform, i.price, i.quantity, u.discount from Used_Game u, Game g, Item i where u.serial_number=g.serial_number AND u.serial_number = i.serial_number";
			$result = executePlainSQL($sql);
			echo "<br>Used Games</br>";
			echo "<table>";
			echo "<tr><th>Game</th><th>Genre</th><th>Platform</th><th>Price</th><th>Quantity</th><th>Discount</th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["GENRE"] . "</td><td>" . $row["PLATFORM"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td><td>" . $row["DISCOUNT"] . "</td></tr>"; //or just use "echo $row[0]"
			}
			echo "</table>";
		}
	}
	
	      else if(isset($_POST['HardwareSubmit'])) {
			if(isset($_GET['viewhardware'])) {
			$sql = "select i.pname, h.type, i.price, i.quantity from Hardware h, Item i where i.serial_number=h.serial_number";
			$result = executePlainSQL($sql);
			echo "<br>Hardware and Accessories</br>";
			echo "<table>";
			echo "<tr><th>Hardware</th><th>Type</th><th>Price</th><th>Quantity</th></tr>";
			while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
				echo "<tr><td>" . $row["PNAME"] . "</td><td>" . $row["TYPE"] . "</td><td>" . $row["PRICE"] . "</td><td>" . $row["QUANTITY"] . "</td></tr>"; //or just use "echo $row[0]"
			}
			echo "</table>";
		}
	} 

	  
	  
	  
	  else {
	  }
	}
	

?>


</div

</html>