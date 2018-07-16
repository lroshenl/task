<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
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
       echo "lol<br>";


   // выполняем операции с базой данных
   $query ="SELECT name FROM todo";
   $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
   if($result)
   {
     echo "ALL IS OKEY<br>";
     $rows = mysqli_num_rows($result); // количество полученных строк

     for ($i = 0 ; $i < $rows ; ++$i)
     {
         $row = mysqli_fetch_row($result);
             for ($j = 0 ; $j < 4 ; ++$j) echo " $row[$j] <br> ";

     }
     echo "</table>";

   mysqli_free_result($result);
   }
   // закрываем подключение
   mysqli_close($link);
   ?>

  </table>
  <!--<p style="text-align: center"><button>Создать задачу</button></p>!-->
  <button id="opener">Create task</button>
<form id="dialog" placeholder="description" >
  <p><input placeholder="name" name="name"> </p>
  <!--<p><input placeholder="description" name="description"> </p>!-->
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
