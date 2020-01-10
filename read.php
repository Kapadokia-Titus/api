<?php

  //inserting headers
  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-Headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header("Content-Type: application/json; charset=UTF-8");

  //including database and creating its object
  require 'database.php';
  $db_conn = new Database();
  $conn =$db_conn->dbConnection();

  //check the ID parameter or not
  if (isset($_GET['id'])) {

      //if has an id parameter
        $post_id = filter_var($_GET['id'], FILTER_VALIDATE_INT, [
            'options'=>[
              'default'=> 'all_posts',
               'min_range'=>1]
        ]);
  }else {
    $post_id = 'all_posts';
  }

  //make an SQL query;;
  //if it gets post id, it will show posts by id otherwise it sows all posts.

  $sql = is_numeric($post_id)?"SELECT * FROM posts WHERE id='$post_id'": "SELECT * FROM posts";
  $stmt = $conn->prepare($sql);
  $stmt->execute();


  //checking whether there is an post in our database
  if ($stmt->rowCount()>0) {

      //creating a post array
      $post_array=[];


      while ($row  = $stmt->fetch(PDO::FETCH_ASSOC)) {

          $post_data = [
              'id'=>$row['id'],
              'title'=>$row['title'],
              'body'=> html_entity_decode($row['body']),
              'author'=>$row['author']
          ];

          //we push the post data to the post array
          array_push($post_array, $post_data);

      }
      //show post or posts in a json fomart
      echo json_encode($post_array);
  }else {
    //this displays if there is no records in the database
    echo json_encode(['message'=>'no records found']);
  }
 ?>
