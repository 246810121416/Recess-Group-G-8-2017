
<?php
    // declaring functions in their order of execution
	createdatabase();
	adminlogin();
	//This is a php web interface for the administrator to login into the family  SACCO system and access the reports about the system
	function adminlogin(){
	
		echo "<!DOCTYPE html>";
		echo "<html>";
			echo "<head>";
		
			    echo "<meta charset='UTF-8'>";
				echo "<style type='text/css'>";

						echo "body{";
							echo "margin-left:10%;";
							echo "width:65em;";
							echo "border: .5em solid blue;";
							echo "border-radius: 5px;";
							echo "border-top: 3em solid blue;";
							echo "box-shadow: 4px 4px black;";
						echo "}";
						echo "table{";
							echo "background-color:whitesmoke;";
							echo "border: 0;";
							echo "margin-left:10%;";
							echo "margin-right:10%;";
						echo "}";
						echo "td{";
						echo "	font-size: 1.5em;";
						echo "}";
						
						echo "table tr td{";
							echo "cell-padding:2em;";
							echo "cell-spacing:4em;";
							echo "border-collapse:separate;";
							echo "text-align:left;";
							echo "font-weight:bold;";
						echo "}";
						echo "header{";
							echo " border:3px solid blue;";
							echo " background-color:blue;";
							echo " color:white;";
						echo "}";
				echo "</style>";

			echo "</head>";
			
			echo "<body>";
				echo "<header>";
				echo "<h1 align='center'><strong>FAMILY SACCO</strong></h1>";
				echo "</header>";
				
				echo "<br/><h3 align='center'>LOGIN PAGE</h3>";

					echo "<form action='functions.php?action=adminlogin1' method='POST'>";

						echo "<table border='0'  cellspacing='50' align='CENTER'>";
						echo "<tr><td>ADMINISTRATOR ID</td><td><input type='text' name = 'adid' required ></td></tr>";
						echo "<tr><td>ADMINISTRATOR PASSWORD</td><td><input type='password'  name = 'adpassword' required ></td></tr>";
						echo "</table>";

						echo "<p align = 'center' >";
						echo "<input type='submit' value='Submit' style='width:15%; background-color:lightblue;'>";
						echo "</p>";
					echo "</form>";
			echo "</body>";
		echo "</html>";
	
	}
	
	/*This a function that creates a database "recess" with tables that include member, contribution, loan request, idea, administrator, 
	investment, loan repayment, benefits, contribution check ,regular members*/
	
	function createdatabase(){
		
		//Creating connection to the server.
		@$connect1=mysqli_connect("localhost","root","");
	 
		//Creating database "recess" and checking  if it is created. 
		if(mysqli_query($connect1,"CREATE DATABASE recess")){
			
			//echo "Database created";
		}
		
		else{
			
			//echo "Database not created.<br/>";
		}

		//creates connection to the server.
		@$connect=mysqli_connect("localhost","root","","recess");
		
		//creates table member to the database "recess". 
		$table1=mysqli_query($connect,"CREATE TABLE member
			(
			memberId VARCHAR(25) NOT NULL,
			username VARCHAR(25) NOT NULL,
			password VARCHAR(25) NOT NULL,
			date VARCHAR(10) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			PRIMARY KEY(memberId), 
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table contribution to the database "recess".
		$table2=mysqli_query($connect,"CREATE TABLE contribution
			(
			receiptNo VARCHAR(25) NOT NULL PRIMARY KEY,
			amount VARCHAR(9) NOT NULL,
			date VARCHAR(10) NOT NULL,
			memberId VARCHAR(25) NOT NULL,
			status VARCHAR(10) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table investment to the database "recess"
		$table6=mysql_query("CREATE TABLE investment
			(
			investmentNo VARCHAR(9) NOT NULL,
			name VARCHAR(25) NOT NULL,
			description VARCHAR(200) NOT NULL,
			date_of_investment VARCHAR(10) NOT NULL,
			initial_investment_price VARCHAR(9) NOT NULL,
			profit VARCHAR(9) NOT NULL,
			loss VARCHAR(9) NOT NULL,
			memberId VARCHAR(25) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			PRIMARY KEY(investmentNo),
			FOREIGN KEY(name) REFERENCES idea(name),
			FOREIGN KEY(memberId) REFERENCES member(memberId), 
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table loan request to the database "recess".
		$table3=mysqli_query($connect,"CREATE TABLE loan_request
			(
			loanId int NOT NULL AUTO_INCREMENT,
			amount VARCHAR(15) NOT NULL,
			memberId VARCHAR(25) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			status VARCHAR(10) NOT NULL,
			PRIMARY KEY(loanId), 
			FOREIGN KEY(memberId) REFERENCES member(memberId), 
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table idea to the database "recess".
		$table4=mysqli_query($connect,"CREATE TABLE idea
			(
			name VARCHAR(25) NOT NULL,
			capital VARCHAR(9) NOT NULL,
			description VARCHAR(200) NOT NULL,
			memberId VARCHAR(25) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			status VARCHAR(10) NOT NULL,
			PRIMARY KEY(name), 
			FOREIGN KEY(memberId) REFERENCES member(memberId), 
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table administrator to the database "recess".
		$table5=mysqli_query($connect,"CREATE TABLE administrator
			(
			administratorId VARCHAR(25) NOT NULL PRIMARY KEY,
			password VARCHAR(25) NOT NULL
		)");
		
		//creates table investment to the database "recess".
		$table6=mysqli_query($connect,"CREATE TABLE investment
			(
			investmentNo VARCHAR(9) NOT NULL,
			date_of_investment VARCHAR(10) NOT NULL,
			initial_investment_price VARCHAR(9) NOT NULL,
			profit VARCHAR(9) NOT NULL,
			loss VARCHAR(9) NOT NULL,
			memberId VARCHAR(25) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			PRIMARY KEY(investmentNo), 
			FOREIGN KEY(memberId) REFERENCES member(memberId), 
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table loan_repayment to the database "recess".
		$table7=mysqli_query($connect,"CREATE TABLE loan_repayment
			(
			loanRepaymentId int NOT NULL AUTO_INCREMENT,
			loan_repayment_date VARCHAR(10) NOT NULL,
			credit VARCHAR(9) NOT NULL,
			debit VARCHAR(9) NOT NULL,
			memberId VARCHAR(25) NOT NULL,
			administratorId VARCHAR(25) NOT NULL,
			PRIMARY KEY(loanRepaymentId), 
			FOREIGN KEY(memberId) REFERENCES member(memberId), 
			FOREIGN KEY(administratorId) REFERENCES administrator(administratorId)
		)");
		
		//creates table benefits to the database "recess".
		$table8=mysqli_query($connect,"CREATE TABLE benefits 
			(
			benefitId int NOT NULL AUTO_INCREMENT,
			memberId VARCHAR(25) NOT NULL,
			profit int NOT NULL,
			investmentNo VARCHAR(9) NOT NULL,
			PRIMARY KEY(benefitId),
			FOREIGN KEY(investmentNo) REFERENCES investment(investmentNo)	
		)");
		
		//creates table contributioncheck to the database "recess".
		$table9=mysqli_query($connect,"CREATE TABLE contributioncheck 
			(
			memberId VARCHAR(25) NOT NULL PRIMARY KEY,
			amount int NOT NULL
		)");
	     
		//creates table regularmembers to the database "recess".
		$table10=mysqli_query($connect,"CREATE TABLE regularmembers
			(
			memberId VARCHAR(25) NOT NULL PRIMARY KEY,
			username VARCHAR(25) NOT NULL
			
		)");
	}
	
?>