<?php
class user
{
  static function showing_tasks()
  {

    //require_once 'connection.php';
    $host = 'localhost'; // адрес сервера
    $database = 'task'; // имя базы данных
    $user = 'user'; // имя пользователя
    $password = '130987ac4d3'; // пароль
    $link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($link));
    $ar = array("todo","doing","done");
    $ar1 = array("ul","ol","dl");
    $query ="create table task(id int unsigned auto_increment primary key,name varchar(255),status varchar(255),date datetime)";
    $query1 ="create table task_com(id int ,com varchar(255))";
    mysqli_query($link,$query);
    mysqli_query($link,$query1);
    $i=0;
    foreach ($ar1 as $it) {
        ?><td><<?php echo "$it";?>><?php
        $query ="SELECT name FROM task where status = '$ar[$i]' ORDER BY task.date desc";
        if($result = mysqli_query($link, $query)){
          while ($row = mysqli_fetch_row($result)) {
             $res1 = mysqli_query($link,"SELECT id FROM task WHERE name = '$row[0]'");
             $row1 = mysqli_fetch_row($res1);
             $id = $row1[0];
             $count = 0;
             $res = mysqli_query($link,"SELECT com FROM task_com WHERE id = '$id'");
             while ($rew = mysqli_fetch_row($res))
             {
               $count++;
             }
             echo "<li>$row[0] "."($count)</li>";
          }
        }
        ?></td></<?php echo "$it";?>>
        <?php
        $i++;
    }
  }
  static function showing_com()
  {
    $host = 'localhost'; // адрес сервера
    $database = 'task'; // имя базы данных
    $user = 'user'; // имя пользователя
    $password = '130987ac4d3'; // пароль
    $link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($link));
    $message = $_GET['message'];
    $a = substr($message,0,strlen($message)-3);
    $query = "select id from task where name = '$a'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_row($result);
    $id = $row[0];
    $query = "select com from task_com where id = '$id'";
    if($result = mysqli_query($link, $query)){
      while ($row = mysqli_fetch_row($result)) {
         echo "$row[0]<br>";
      }
    }
    mysqli_close($link);
  }
  static function creating_task()
  {
    $host = 'localhost'; // адрес сервера
    $database = 'task'; // имя базы данных
    $user = 'user'; // имя пользователя
    $password = '130987ac4d3'; // пароль
    $link = mysqli_connect($host, $user, $password, $database)
        or die("Ошибка " . mysqli_error($link));
    if(isset($_POST['submit']))
    {
      $table_name = $_POST['select'];
      $name = $_POST['name'];
      $descr = $_POST['description'];
      $query = "INSERT INTO task (name,status,date) VALUES('$name','$table_name',NOW())";
      $result = mysqli_query($link,$query);
      $query = "select id from task where name = '$name'";
      $result = mysqli_query($link,$query);
      $row = mysqli_fetch_row($result);
      $id = $row[0];
      $query = "INSERT INTO task_com VALUES($id,'$descr')";
      $result = mysqli_query($link,$query);
      header("Location: ".$_SERVER['REQUEST_URI']);
      $_POST['select']= 'null';
    }
    mysqli_close($link);
  }
  static function creating_describe()
  {
      if(isset($_GET['message']))
      {

        $host = 'localhost'; // адрес сервера
        $database = 'task'; // имя базы данных
        $user = 'user'; // имя пользователя
        $password = '130987ac4d3'; // пароль
        $link = mysqli_connect($host, $user, $password, $database)
            or die("Ошибка " . mysqli_error($link));
        $message = $_GET['message'];
        $flag =true;
        $a = substr($message,0,strlen($message)-3);
        if(isset($_POST['submit1']))
        {
          $table_name = $_POST['select1'];
          $descr = $_POST['description1'];
          $query = "update task set status = '$table_name' where name = '$a'";
          $result = mysqli_query($link,$query);
          $query = "select id from task where name = '$a'";
          $result = mysqli_query($link,$query);
          $row = mysqli_fetch_row($result);
          $id = $row[0];
          if($descr!=="")
          {
            $query = "INSERT INTO task_com VALUES($id,'$descr')";
            $result = mysqli_query($link,$query);
          }
          $url = 'http://localhost/main.php';
          header("Location: $url");
        }
      }
      $flag = false;
      mysqli_close($link);
  }
}
?>
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
   <tr><?php user::showing_tasks(); ?>
   </tr>
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

  <?php user::creating_task(); ?>

<form id="dialog1" action="" method="post">
  <p><textarea type="text" name="description1" placeholder="description"></textarea></p>
  <p><select  name="select1" size="3" >
  <option selected value="todo">TODO</option>
  <option value="doing">DOING</option>
  <option value="done">DONE</option>
</select>
  <p><?php user::showing_com(); ?></p>
  <input type="submit" value="Отправить" name = " submit1" align="center">
</form>

  <?php user::creating_describe(); ?>

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
  var flag = '<?php $flag = isset($_GET['message']); echo "$flag"; ?>';
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
  var flag = '<?php $flag = isset($_GET['message']); echo "$flag"; ?>';
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
  var flag = '<?php $flag = isset($_GET['message']); echo "$flag"; ?>';
  if (flag)
  {
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('dl');
      $( "#dialog1" ).dialog( "open" );
  }
  </script>

 </body>
</html>
