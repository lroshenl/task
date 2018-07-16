<?php
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
