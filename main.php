<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
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
   <tr><td><?php
   require_once 'connection.php'; // подключаем скрипт
   // подключаемся к серверу
   $link = mysqli_connect($host, $user, $password, $database)
       or die("Ошибка " . mysqli_error($link));
   // выполняем операции с базой данных
   $query ="SELECT name,com FROM todo";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        echo "$row[0]  "."($row[1])<br>";
     }
   }
   ?></td>
   <td>
     <?php
   $query ="SELECT name,com FROM doing";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        echo "$row[0]  "."($row[1])<br>";
     }
   }
   ?></td>
   <td>
     <?php
   $query ="SELECT name,com FROM done";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        echo "$row[0]  "."($row[1])<br>";
     }
   }
   ?>
 </td>
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

    //$name = htmlentities(mysql_real_escape_string($link, $_POST['name']));
    //$table_name  = htmlentities(mysql_real_escape_string($link, $_POST['select']));
    //$status = explode('  ', mysql_stat($link));
    $table_name = $_POST['select'];
    $name = $_POST['name'];
    if ($table_name == 'todo')
    {
      $query = "INSERT INTO todo (name,date,com) VALUES('$name','now()',0)";
      $result = mysqli_query($link,$query);
       header("Location: ".$_SERVER['REQUEST_URI']);

    }
    if ($table_name == 'doing')
    {
      $query = "INSERT INTO doing (name,date,com) VALUES('$name','now()',0)";
      $result = mysqli_query($link,$query);
       header("Location: ".$_SERVER['REQUEST_URI']);

    }
    if ($table_name == 'done')
    {
      $query = "INSERT INTO done (name,date,com) VALUES('$name','now()',0)";
      $result = mysqli_query($link,$query);
       header("Location: ".$_SERVER['REQUEST_URI']);


    }
    $_POST['select']= 'null';
  }


    ?>


  <script>
  $( "#dialog" ).dialog({ autoOpen: false });
  $( "#opener" ).click(function() {
    $( "#dialog" ).dialog( "open" );
  });
  </script>

 </body>
</html>
