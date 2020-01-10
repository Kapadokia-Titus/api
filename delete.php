<?php

 //setting headers
 header("Access-Control-Allow-Origin: *");
 header("Access-Control-Allow-Headers: access");
 header("Access-Control-Allow-Methods: POST");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Allow-Headers: Content-Type ,Access-Control-Allow-Headers, Authorization, X-Requested-Width");

 //including the database and creating its object
 require 'database.php';
 $database_conn = new Database();
 $conn = $database_conn->dbConnection();


 //get data form request
 $data = json_decode(file_get_contents("php://input"));

 //checking if the id is available in the data
 //this is because the data we're to delete has to have a specified id:
 if (isset($data->id)) {

    //initialzing our message as null
    $msg['message']='';

    $post_id = $data->id;

    //get postb id from the database
    $check_post = "SELECT * FROM posts WHERE id=:post_id";
   $check_post_stmt = $conn->prepare($check_post);
   $check_post_stmt->bindValue(':post_id', $post_id,PDO::PARAM_INT);
   //$check_post_stmt->execute();

    //check whether there is any post in our database
     if ($check_post_stmt->rowCount()>0) {

       //delete by id from the database
       $delete_post = "DELETE * FROM posts WHERE id=:post_id";
       $delete_post_stmt = $conn->prepare($delete_post);
       $delete_post_stmt->bindValue(':post_id', $post_id, PDO::PARAM_INT);

       if ($delete_post->execute()) {

          //set success message
          $msg['message']="data deleted successfully";
       }else {
         //error message
         $msg['message']= "problem deleting your data";
       }

     }else {
       $msg['message']= "can't find the record with the specified id";
     }

      //echo message in a json fomart
      echo json_encode($msg);
 }

 ?>
