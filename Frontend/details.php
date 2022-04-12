<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

<!-- JS, Popper.js, and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body style="background-color:cyan;">
    <center><img src="cesa.jpg" width="170"height="170">
    <h1 class="card text-center">Welcome to I2IT's Computer Engineering Students Association!</h1>
    <br><br>
    </center>
     
      <div class="panel">
          <div class="title"><h5>Notifications regarding activities you can do in this lockdown period:</h5></div>
          <ul class="notification-bar">
              <li class="unread">
                  <i class="ion-checkmark"></i>
                  <a href="https://www.coursera.org/">
                  <p>Register for courses from Coursera</p>
              </li>
              <li class="unread">
                  <i class="ion-checkmark"></i>
                  <a href="https://www.udemy.com/course/">
                  <p>Register for courses from Udemy</p>
              </li>
              <li>
                  <i class="ion-paper-airplane"></i>
                  <a href="https://doppa2020.devopsppalliance.org/">
                  <p>DevOps Conference </p>
              </li>
              <li>
                  <i class="ion-plus"></i>
                  <a href="https://docs.google.com/forms/d/e/1FAIpQLSfBraNkQ6bYW3FqCNimzkLDT0bzRS6dFSy_hHptKLwYBca3nQ/viewform">
                  <p>Register for a webinar Cloud computing</p>
              </li>
          </ul>
      </div>
</a> 
    <br>
    <div class="card">
        <br>
        <form method="post">
        Your Name:
        <input type="text" name="names" required="required"><br>
        Your Class:
        <input type="text" name="classes" required="required"><br>
        Comment any message:
        <input type="text" name="msg" required="required">
        <br>
        <input class="btn btn-warning" type="submit" name="submit_btn"  value="register" >
    </form>
<br>
    </div><br>
    <br>
    <h3>Messages from Students</h3>

  <?php
    $conn=mysqli_connect('localhost','root','','cesa');
    if($conn)
    {
        // echo "sucessful connection";
    }
    else
        echo "oh noooooo";
    $sql = "SELECT * FROM msg_info";
        $result = mysqli_query ($conn, $sql); 
        while ($row = mysqli_fetch_array ($result)){
    ?>
    <div class="panel">
          <ul class="notification-bar">
              <li>
                  <i class="ion-plus"></i>
                  <b><?php echo $row ['names']; ?>, <?php echo $row ['classes']; ?>  </b>
                  <p><?php echo $row ['msg']; ?> </p>
              </li>

          </ul>
    </div>
       <?php
        }
        ?>
        </p>
 <div class="panel">
          <ul class="notification-bar">
              <li class="unread">
                  <i class="ion-checkmark"></i>
                  <b>Shrushti Jagtap,TE COMP</b>
                  <p>Just completed a course - 'AWS cloud' from Udemy</p>
              </li>
              <li class="unread">
                  <i class="ion-checkmark"></i>
                  <b>Rahul Jain,BE COMP</b>
                  <p>Started a course - 'Machine Learning' from Coursera</p>
              </li>
              <li>
                  <i class="ion-paper-airplane"></i>
                   <b>Roshni Kapoor,SE COMP</b>
                  <p>Just completed a course - 'Linux essentials' from CiscoNA</p>
              </li>
              <li>
                  <i class="ion-plus"></i>
                  <b>Sharvari Gadiwan,TE COMP</b>
                  <p>Just completed a course - 'Python' from Udemy</p>
              </li>
          </ul>
      </div>
   <center>
    <div class="card text-center">
        <h4>Core Team</h4>
        <p>1. HOD : Dr.Sashikala Mishra</p>
        <p>2. Faculty Co-ordinator : Prof.Prashant Gadakh</p>
        <p>3. Student Chair : Rakshitha Shettigar</p>
        <p>4. Vice Chair : Shrushti Jagtap, Akshay Biradar</p>
    </div><br>
    <h4>Thank You for visiting this page</h4>

   </center>
   <?php
$conn=mysqli_connect('localhost','root','','cesa');
if($conn)
{
    // echo "sucessful connection";
}
else
    echo "oh noooooo";
 if(isset($_POST['submit_btn'])) 
 {
    $names=$_POST['names'];
    $classes=$_POST['classes'];
    $msg=$_POST['msg'];
$query="INSERT INTO `msg_info`( `names`, `classes`, `msg`)
 VALUES ('$names' ,'$classes','$msg')";
 $result=mysqli_query($conn,$query);
 if($result)
 {
     echo "<script>alert('Successfully recieved the message');</script>";
 } 
 } 
?>
</body>

</html>