<?php
//fetch.php;
include_once '../core/init.php';
$store = new Store();
if(isset($_POST["view"]))
{
 include("connect.php");
 if($_POST["view"] != '')
 {
  $update_query = "UPDATE comments SET status=1 WHERE status=0";
  mysqli_query($connect, $update_query);
 }
 $query = "SELECT * FROM comments ORDER BY id DESC";
 $result = mysqli_query($connect, $query);
 $output = '';
 
 if(mysqli_num_rows($result) > 0)
 {
  while($row = mysqli_fetch_array($result))
  {
    $sql = "SELECT * FROM users WHERE id = '".$row['user_id']."'";
    $results = mysqli_query($connect, $sql);
    while ($rows = mysqli_fetch_object($results)) {    
   $output .= '
   <li>
    <a href="'.$row["url"].'">
    <b>'.$rows->first_name.':</b>
     <small><em>'.$row["comment"].'</em></small><br>
     <small><em>'.$store->time_elapsed($row["time_elapsed"]).'</em></small>
    </a>
   </li>
   <li class="divider"></li>
   ';
    }
  }
 }
 else
 {
  $output .= '<li><a href="#" class="text-bold text-italic">No Notification Found</a></li>';
 }
 
 $query_1 = "SELECT * FROM comments WHERE status=0";
 $result_1 = mysqli_query($connect, $query_1);
 $count = mysqli_num_rows($result_1);
 $data = array(
  'notification'   => $output,
  'unseen_notification' => $count
 );
 echo json_encode($data);
}
?>