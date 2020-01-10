<?php

 //setting headers
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Headers: access");
 header("Access-Control-Allow-Methods: POST");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-Width");


 //icluding the database and creating an object of the database class.
 require 'database.php';
 $db_connection = new Database();

 //we use the database refference $db_connection to access dbConnection() function
 $conn = $db_connection->dbConnection();

 //GETTING FORM DATA REQUEST
 $data = json_decode(file_get_contents("php://input"));

 //creating a message array and setting it to empty.
 $msg['message']='';

 //checking if we've received data from the request
 if (isset($data->title) && isset($data->body) && isset($data->author)) {

   //first check if the data is not empty
   if (!empty($data->title) && !empty($data->body) &&!empty($data->author)) {

          //perform the insert statement
          $insert_query = "INSERT INTO posts (title,body,author) VALUES(:title,:body,:author)";

          $insert_stmt = $conn->prepare($insert_query);

          //data binding

          $insert_stmt->bindValue(':title', htmlspecialchars(strip_tags($data->title)),PDO::PARAM_STR);
          $insert_stmt->bindValue(':body', htmlspecialchars(strip_tags($data->body)),PDO::PARAM_STR);
          $insert_stmt->bindValue(':author', htmlspecialchars(strip_tags($data->author)),PDO::PARAM_STR);
          //give a success message if it was successfuly added
          if($insert_stmt->execute()){
            $msg['message'] = 'Data Inserted Successfully';
        }else{
            $msg['message'] = 'Data not Inserted';
        }
   }else {
     $msg['message']='oops! no fields found, empty!!';
   }
 }else {
   $msg['message'] = 'please fill all the fields | title ,body ,author';
 }

  //echo the data in a json fomart
  echo json_encode($msg);
 ?>
