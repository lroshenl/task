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
   <div  class="wrapper">
     <div> lol kek cheburek </div>
   </div>
   <tr><td><ul><?php
   require_once 'connection.php';
   $link = mysqli_connect($host, $user, $password, $database)
       or die("Ошибка " . mysqli_error($link));
   $query ="SELECT name,com FROM todo";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        echo "<li>$row[0]  "."($row[1])</li>";
     }
   }
   ?></ul></td>
   <td><ol><?php
   $query ="SELECT name,com FROM doing";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        echo "<li>$row[0]  "."($row[1])</li>";
     }
   }
   ?></ol></td>
   <td><dl><?php
   $query ="SELECT name,com FROM done";
   if($result = mysqli_query($link, $query)){
     while ($row = mysqli_fetch_row($result)) {
        echo "<dt>$row[0]  "."($row[1])</dt>";
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

<form id="dialog1" action="" method="post">
  <p><textarea type="text" name="description1" placeholder="description"></textarea></p>
  <p><select  name="select1" size="3" >
  <option selected value="todo">TODO</option>
  <option value="doing">DOING</option>
  <option value="done">DONE</option>
  </select>
  <input type="submit" value="Отправить" name = " submit1" align="center">
</form>

<?php
  if(isset($_POST['message']))
  {
    $uid = $_POST['message'];
    //echo "$uid"
    echo "LOLOLOLOL";;
  }
?>


  <script>
  $( "#dialog" ).dialog({ autoOpen: false });
  $( "#opener" ).click(function() {
    $( "#dialog" ).dialog( "open" );
  });
  </script>

  <script>
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('ul');
    ul.onclick = function(event) {
      $( "#dialog1" ).dialog( "open" );
    };
  </script>

  <script>
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('ol');
    ul.onclick = function(event) {
      $( "#dialog1" ).dialog( "open" );
    };
  </script>

  <script>
    $( "#dialog1" ).dialog({ autoOpen: false });
    var ul = document.querySelector('dl');
    ul.onclick = function(event) {
      $( "#dialog1" ).dialog( "open" );
    };
  </script>

  <script>
  document.querySelector('ul').addEventListener('click', e => {
    var message = e.target.innerHTML;
    alert(message);
    $.ajax({
                     type: "POST",
                     url: 'main.php',
                     data: {message:message},
                     success: function(data)
                     {
                         alert("success!");
                     }
                 });
  });


  </script>

  <script>
  document.querySelector('ol').addEventListener('click', e => {
  var message = e.target.innerHTML;
  $.ajax({
                   type: "POST",
                   url: 'main.php',
                   data: {message:message},
                   success: function(data)
                   {
                       alert("success!");
                   }
               });
  });
  </script>

  <script>
  document.querySelector('dl').addEventListener('click', e => {
    var message = e.target.innerHTML;
    $.ajax({
                     type: "POST",
                     url: 'main.php',
                     data: {message:message},
                     success: function(data)
                     {
                         alert("success!");
                     }
                 });
  });
  </script>

 </body>
</html>
