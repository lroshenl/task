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
        echo "$row[0]  "."($row[1])";
     }
   }
   ?></td>
  </table>
  <button id="opener">Create task</button>
  <form id="dialog" placeholder="description" >
    <p><input placeholder="name" name="name"> </p>
    <p><textarea name="description" placeholder="description"></textarea></p>
    <p><select name="select" size="3" multiple>
    <option selected value="s1">TODO</option>
    <option value="s2">DOING</option>
    <option value="s3">DONE</option>
    </select>
    <br>
   <input type="submit" value="Отправить" align="center"></p>
  </form>

  <script>
  $( "#dialog" ).dialog({ autoOpen: false });
  $( "#opener" ).click(function() {
    $( "#dialog" ).dialog( "open" );
  });
  </script>
 </body>
</html>
