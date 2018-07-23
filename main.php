<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
    li {
    list-style-type: none;
   }

    li {
      cursor: pointer;
    }

    dt {
      cursor: pointer;
    }

    div{
  cursor: pointer;
}

  </style>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <title>Task</title>
 </head>
 <body>
  <table border="1" rules="cols">
   <caption>Task status</caption>
   <tr>
    <th>TODO</th>
    <th>DOING</th>
    <th>DONE</th>
   </tr>
   <tr><td><ul><?php
   require_once 'connection.php';
   $link = mysqli_connect($host, $user, $password, $database)
       or die("Ошибка " . mysqli_error($link));
   //$count = mysql_num_rows($res);
   $query ="SELECT name FROM todo ORDER BY todo.date desc";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        $res1 = mysqli_query($link,"SELECT id FROM todo WHERE name = '$row[0]'");
        $row1 = mysqli_fetch_row($res1);
        $id = $row1[0];
        $count = 0;
        $res = mysqli_query($link,"SELECT com FROM todo_com WHERE id = '$id'");
        while ($rew = mysqli_fetch_row($res))
        {
          $count++;
        }
        echo "<li>$row[0] "."($count)</li>";
     }
   }
   ?></ul></td>
   <td><ol><?php
   $query ="SELECT name FROM doing ORDER BY doing.date desc";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        $res1 = mysqli_query($link,"SELECT id FROM doing WHERE name = '$row[0]'");
        $row1 = mysqli_fetch_row($res1);
        $id = $row1[0];
        $count = 0;
        $res = mysqli_query($link,"SELECT com FROM doing_com WHERE id = '$id'");
        while ($rew = mysqli_fetch_row($res))
        {
          $count++;
        }
        echo "<li>$row[0] "."($count)</li>";
     }
   }
   ?></ol></td>
   <td><dl><?php
   $query ="SELECT name FROM done ORDER BY done.date desc";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        $res1 = mysqli_query($link,"SELECT id FROM done WHERE name = '$row[0]'");
        $row1 = mysqli_fetch_row($res1);
        $id = $row1[0];
        $count = 0;
        $res = mysqli_query($link,"SELECT com FROM done_com WHERE id = '$id'");
        while ($rew = mysqli_fetch_row($res))
        {
          $count++;
        }
        echo "<li>$row[0] "."($count)</li>";
     }
   }
   ?></dl></td>
 </div>
 </tr>

  </table>

  <button id="opener">Create task</button>
  <form id="dialog"  method="post" action="" >
    <p><input  type="text" placeholder="name" name="name"> </p>
    <p><textarea type="text" name="description" placeholder="description"></textarea></p>
    <p><select  name="select" size="3" >
    <option selected value="todo">TODO</option>
    <option value="doing">DOING</option>
    <option value="done">DONE</option>
    </select>
    <br>
   <input type="submit" value="Отправить" name = " submit" align="center"></p>
  </form>

  <?php
  if(isset($_POST['submit']))
  {
    $table_name = $_POST['select'];
    $name = $_POST['name'];
    $descr = $_POST['description'];
    if ($table_name == 'todo')
    {
      $query = "INSERT INTO todo (name,date) VALUES('$name',NOW())";
      $result = mysqli_query($link,$query);
      $query = "select id from todo where name = '$name'";
      $result = mysqli_query($link,$query);
      $row = mysqli_fetch_row($result);
      $id = $row[0];
      $query = "INSERT INTO todo_com VALUES($id,'$descr')";
      $result = mysqli_query($link,$query);
       header("Location: ".$_SERVER['REQUEST_URI']);
    }
    if ($table_name == 'doing')
    {
      $query = "INSERT INTO doing (name,date) VALUES('$name',NOW())";
      $result = mysqli_query($link,$query);
      $query = "select id from doing where name = '$name'";
      $result = mysqli_query($link,$query);
      $row = mysqli_fetch_row($result);
      $id = $row[0];
      $query = "INSERT INTO doing_com VALUES($id,'$descr')";
      $result = mysqli_query($link,$query);
       header("Location: ".$_SERVER['REQUEST_URI']);
    }
    if ($table_name == 'done')
    {
      $query = "INSERT INTO done (name,date) VALUES('$name',NOW())";
      $result = mysqli_query($link,$query);
      $query = "select id from done where name = '$name'";
      $result = mysqli_query($link,$query);
      $row = mysqli_fetch_row($result);
      $id = $row[0];
      $query = "INSERT INTO done_com VALUES($id,'$descr')";
      $result = mysqli_query($link,$query);
      header("Location: ".$_SERVER['REQUEST_URI']);
    }
    $_POST['select']= 'null';
  }
?>

<form id="dialog1" action="" method="post">
  <p><textarea type="text" name="description1" placeholder="description"></textarea></p>
  <!--<p><select  name="select1" size="3" >
  <option selected value="todo">TODO</option>
  <option value="doing">DOING</option>
  <option value="done">DONE</option>
</select>-->
  <p><?php
    $message = $_GET['message'];
    $a = substr($message,0,strlen($message)-3);
    //echo "$a<br>";
    //echo "todo<br>";
    if($result = mysqli_query($link,"select id from todo where exists (select id from todo where todo.name = '$a')")){
      if ($row = mysqli_fetch_row($result)) {
        //echo "from todo<br>";
        $query = "select id from todo where name = '$a'";
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_row($result);
        $id = $row[0];
        $query = "select com from todo_com where id = '$id'";
        if($result = mysqli_query($link, $query)){
          while ($row = mysqli_fetch_row($result)) {
             echo "$row[0]<br>";
          }
        }
      }
    }

    //echo "doing<br>";
    if($result = mysqli_query($link,"select id from doing where exists (select id from doing where doing.name = '$a')")){
      if ($row = mysqli_fetch_row($result)) {
        //echo "from doing<br>";
        $query = "select id from doing where name = '$a'";
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_row($result);
        $id = $row[0];
        $query = "select com from doing_com where id = '$id'";
        if($result = mysqli_query($link, $query)){
          while ($row = mysqli_fetch_row($result)) {
             echo "$row[0]<br>";
          }
        }
      }
    }

  //  echo "done<br>";
    if($result = mysqli_query($link,"select id from done where exists (select id from done where done.name = '$a')")){
      if ($row = mysqli_fetch_row($result)) {
        //echo "from done<br>";
        $query = "select id from done where name = '$a'";
        $result = mysqli_query($link,$query);
        $row = mysqli_fetch_row($result);
        $id = $row[0];
        $query = "select com from done_com where id = '$id'";
        if($result = mysqli_query($link, $query)){
          while ($row = mysqli_fetch_row($result)) {
             echo "$row[0]<br>";
          }
        }

      }
    }
  ?></p>
  <input type="submit" value="Отправить" name = " submit1" align="center">
</form>

  <?php
    if(isset($_GET['message']))
    {
      $message = $_GET['message'];
      $flag =true;
      $a = substr($message,0,strlen($message)-3);
      if(isset($_POST['submit1']))
      {
        $table_name = $_POST['select1'];
        $descr = $_POST['description1'];
        if($result = mysqli_query($link,"select id from todo where exists (select id from todo where todo.name = '$a')")){
          if ($row = mysqli_fetch_row($result)) {
            $query = "select id from todo where name = '$a'";
            $result = mysqli_query($link,$query);
            $row = mysqli_fetch_row($result);
            $id = $row[0];

            $query = "INSERT INTO todo_com VALUES($id,'$descr')";
            $result = mysqli_query($link,$query);
          }
        }
        if($result = mysqli_query($link,"select id from doing where exists (select id from doing where doing.name = '$a')")){
          if ($row = mysqli_fetch_row($result)) {
            $query = "select id from doing where name = '$a'";
            $result = mysqli_query($link,$query);
            $row = mysqli_fetch_row($result);
            $id = $row[0];
            $query = "INSERT INTO doing_com VALUES($id,'$descr')";
            $result = mysqli_query($link,$query);
          }
        }
        if($result = mysqli_query($link,"select id from done where exists (select id from done where done.name = '$a')")){
          if ($row = mysqli_fetch_row($result)) {
            $query = "select id from done where name = '$a'";
            $result = mysqli_query($link,$query);
            $row = mysqli_fetch_row($result);
            $id = $row[0];
            $query = "INSERT INTO done_com VALUES($id,'$descr')";
            $result = mysqli_query($link,$query);
          }
        }
        $url = 'http://localhost/main.php';
        header("Location: $url");
      }
      unset($_GET);
      $_GET['message']='null';
    }
    $_GET['message']='null';
  ?>

  <script>
  $( "#dialog" ).dialog({ autoOpen: false });
  $( "#opener" ).click(function() {
    $( "#dialog" ).dialog( "open" );
  });
  </script>

  <script>
  $( "#dialog1" ).dialog({ autoOpen: false });
  document.querySelector('ul').addEventListener('click', e => {
  var message = e.target.innerHTML;
  location.href = "main.php?message=" + message;
  });
  </script>

  <script>
  var flag = '<?php echo "$flag"; ?>';
  if (flag)
  {
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('ul');
      $( "#dialog1" ).dialog( "open" );
  }
  </script>

  <script>
  $( "#dialog1" ).dialog({ autoOpen: false });
  document.querySelector('ol').addEventListener('click', e => {
  var message = e.target.innerHTML;
  location.href = "main.php?message=" + message;
  });
  </script>

  <script>
  var flag = '<?php echo "$flag"; ?>';
  if (flag)
  {
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('ol');
      $( "#dialog1" ).dialog( "open" );
  }
  </script>

  <script>
  $( "#dialog1" ).dialog({ autoOpen: false });
  document.querySelector('dl').addEventListener('click', e => {
  var message = e.target.innerHTML;
  location.href = "main.php?message=" + message;
  });
  </script>

  <script>
  var flag = '<?php echo "$flag"; ?>';
  if (flag)
  {
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('dl');
      $( "#dialog1" ).dialog( "open" );
  }
  </script>

 </body>
</html>
