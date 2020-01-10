<?php

require 'database.php';

  $sql = "INSERT INTO posts (title,body,author) VALUES ('kapadokia titus', 'dmvndjbvkdlvnjdisscvjisxkcnb,lbvavcjv kldc v dvdn vbjxvnxb hc dc vbcxjvnmvdxs','tunikiwa')";


  if (!$sql) {
    echo "error during posting";
  }
  echo "posted succesfully";

 ?>
