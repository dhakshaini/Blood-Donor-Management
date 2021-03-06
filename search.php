<?php
error_reporting(0);
include('includes/config.php');
$con=new mysqli('localhost','root','','bbdms');
if($con->connect_error){
  die('Connection failed: '.$con->connect_error);
 }

?>


<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Blood Donor Management System | Become A Donar</title>
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/modern-business.css" rel="stylesheet">
    <style>
    .navbar-toggler {
        z-index: 1;
    }
    
    @media (max-width: 576px) {
        nav > .container {
            width: 100%;
        }
    }
    </style>
        <style>
    .errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
    </style>


</head>

<body>

<?php include('includes/header.php');?>

    <!-- Page Content -->
    <div class="container">

        <!-- Page Heading/Breadcrumbs -->
        <h1 class="mt-4 mb-3">Search <small>Donor</small></h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">Home</a>
            </li>
            <li class="breadcrumb-item active">Search  Donor</li>
        </ol>
            <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
        <!-- Content Row -->
        <form name="donar" method="post">
<div class="row">



<div class="col-lg-4 mb-4">
<div class="font-italic">Blood Group<span style="color:red">*</span> </div>
<div><select name="bloodgroup" class="form-control" required>
<?php $sql = "SELECT * from  tblbloodgroup ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->BloodGroup);?>"><?php echo htmlentities($result->BloodGroup);?></option>
<?php }} ?>
</select>
</div>
</div>


<div class="col-lg-4 mb-4">
<div class="font-italic">Location </div>
<div><textarea class="form-control" name="location"></textarea></div>
</div>

</div>

<div class="row">
<div class="col-lg-4 mb-4">
<div><input type="submit" name="submit" class="btn btn-primary" value="submit" style="cursor:pointer"></div>
</div>
</div>
       <!-- /.row -->
</form>   

        <div class="row">
                   <?php 
if(isset($_POST['submit']))
{
$status=1;
$bloodgroup=$_POST['bloodgroup'];
$location=$_POST['location'];
$do=date('Y-m-d');
$from=date('Y-m-d',strtotime("2020-07-09"));
if($bloodgroup=="AB+"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and Address='$location' and lastdonated not between '$from' and '$do'");
}
else if($bloodgroup=="A+"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='A+' or BloodGroup='A-' or BloodGroup='O-' or BloodGroup='O+') and Address='$location' and lastdonated not between '$from' and '$do'");
}else if($bloodgroup=="A-"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='A-' or BloodGroup='O-') and Address='$location' and lastdonated not between '$from' and '$do'");
}else if($bloodgroup=="B+"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='B+' or BloodGroup='B-' or BloodGroup='O-' or BloodGroup='O+') and Address='$location' and lastdonated not between '$from' and '$do'");
}else if($bloodgroup=="B-"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='B-' or BloodGroup='O-') and Address='$location' and lastdonated not between '$from' and '$do'");

}else if($bloodgroup=="O+"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='O-' or BloodGroup='O+') and Address='$location' and lastdonated not between '$from' and '$do'");
}else if($bloodgroup=="O-"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='O-') and Address='$location' and lastdonated not between '$from' and '$do'");
}else if($bloodgroup=="AB-"){
$result = mysqli_query($con,"SELECT * FROM tblblooddonars WHERE status=$status and (BloodGroup='B-' or BloodGroup='A-' or BloodGroup='O-' or BloodGroup='AB-') and Address='$location' and lastdonated not between '$from' and '$do'");

}
$check_user=mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
	 // output data of each row
	 $cnt=1;
if ($check_user > 0) {
 ?>
 <!-- Start Styles. Move the 'style' tags and everything between them to between the 'head' tags -->
<style type="text/css">
.myTable { background-color:#eee;border-collapse:collapse; }
.myTable th { background-color:#000;color:white;width:50%; }
.myTable td, .myTable th { padding:5px;border:1px solid #000; }
</style>
<!-- End Styles -->
<table class="myTable">

       <tr>
	     <th>Name</th>
         <th>Mobile No/Email Id</th>
         <th>Gender</th>
         <th>Age</th>
         <th>Blood Group</th>
         <th>Last Donation</th>
         <th>Address</th>
       </tr>
	     <tr>
  			<td><?php echo $row['FullName']; ?></td>
  			<td><?php echo $row['MobileNumber'];?> / <?php echo $row['EmailId'];?></td>
            <td><?php echo $row['Gender'];?></td>
  			<td><?php echo $row['Age']; ?></td>
  			<td><?php echo $row['BloodGroup']; ?></td>
  			<td><?php echo $row['lastdonated'];?></td>
  			<td><?php echo $row['Address']; ?></td>
  
  		</tr><?php

		while ($row = mysqli_fetch_array($result)) { ?>
		<tr>
			<td><?php echo $row['FullName']; ?></td>
  			<td><?php echo $row['MobileNumber'];?> / <?php echo $row['EmailId'];?></td>
            <td><?php echo $row['Gender'];?></td>
  			<td><?php echo $row['Age']; ?></td>
  			<td><?php echo $row['BloodGroup']; ?></td>
  			<td><?php echo $row['lastdonated'];?></td>
  			<td><?php echo $row['Address']; ?></td>
  
		</tr>
		<?php }
  }
  else
{
echo htmlentities("No Record Found");

}
  ?>
            
<?php }
			
             ?>
        


</div>
</div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/tether/tether.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

</body>

</html>
