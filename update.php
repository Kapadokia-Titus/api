<?php

  // setting headers
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: PUT");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-headers: Content-Type, Access-Control-Allow-Headers, Authorization , X-Requested-Width");


  //including the database and creating an object
  require 'database.php';
  $database_con = new Database();
  $conn = $database_con->dbConnection();

  //get data form request
  $data = json_decode(file_get_contents("php://input"));

  // checking if the id to be updated exists
  if (isset($data->id)) {

    //setting message to null sirst
    $msg['message'] = '';
    $post_id = $data->id;

    //get post by id from database
    $get_post = "SELECT * FROM posts  WHERE id=:post_id";
    $get_stmt = $conn->prepare($get_post);
      $get_stmt->bindValue(':post_id', $post_id,PDO::PARAM_INT);
    $get_stmt->execute();

    //check whether there is any post in your database
    if ($get_stmt->rowCount()>0) {

      //fetch post from database
        $row = $get_stmt->fetch(PDO::FETCH_ASSOC);

        //check if new update is available then  set it otherwise set old data
        $post_title = isset($data->title)? $data->title: $row['title'];
        $post_body = isset($data->body)? $data->body :$row['body'];
        $post_author = isset($data->author)? $data->author :$row['author'];


        //update query
        $update_query = "UPDATE posts  SET title = :title, body=:body, author=:author WHERE id=:id";

        $update_stmt = $conn->prepare($update_query);

        //data binding and remove special characters and remove tags
        $update_stmt->bindValue(':title', htmlspecialchars(strip_tags($post_title)), PDO::PARAM_STR);
        $update_stmt->bindValue(':body', htmlspecialchars(strip_tags($post_body)), PDO::PARAM_STR);
        $update_stmt->bindValue(':author', htmlspecialchars(strip_tags($post_author)), PDO::PARAM_STR);
        $update_stmt->bindValue(':id', $post_id, PDO::PARAM_INT);

        if ($update_stmt->execute()) {
            $msg['message'] = 'Data updated Successfully';
          }else {
            $msg['message'] = 'Data not Updated';
          }
    }else {
      $msg['message'] = "Invalid Id";
    }

    echo json_encode($msg);
  }
 ?>
