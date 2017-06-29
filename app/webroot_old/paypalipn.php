<?php
$servername = "localhost";
$username = "s1077983_dbuser";
$password = "boho!@#4";

$dbnane="s1077983_boho";
$myconn = mysql_connect($servername, $username, $password) or die("Could not connect");
mysql_select_db($dbnane,$myconn);
//session_start();
//print_r($dff);
$urlredirect = "http://$_SERVER[HTTP_HOST]/";




		if(!empty($_POST['txn_id'])){

			$payment_date = date('Y-m-d H:i:s');
			$payment_status = 'Y';
			$transaction_id = $_POST['txn_id'];

			$order_id = $_POST['custom'];
		    $updatesql="Update orders Set payment_date='".$payment_date."',payment_status='Y',transaction_id='".$transaction_id."' where id='".$order_id."'";
		    $updatesqlquery=mysql_query($updatesql);
		    $flag=mysql_affected_rows($myconn);

			if($flag){


				$order_id = $_POST['custom'];
				$transaction_id = $_POST['txn_id'];
				$amount = $_POST['mc_gross'];
				$status = 'Y';


				$insertsql="Insert into transactions(`order_id`,`transaction_id`,`amount`,`status`) Values('".$order_id."','".$transaction_id."','".$amount."','".$status."')";
				$insertquery=mysql_query($insertsql);
			    $last_insert_id=mysql_insert_id();


				if($last_insert_id){
				//$redirecturl=$urlredirect.'Orders/pay/'.$last_insert_id;
				//   header('Location: '.$redirecturl);

				} else {
			//	   $redirecturl=$urlredirect.'Orders/pay';
			//	    header('Location: '.$redirecturl);

				}


			}

		} else {
	//		 $redirecturl=$urlredirect.'Orders/Paypalipnerror';
	///	     header('Location: '.$redirecturl);
		}



























?>