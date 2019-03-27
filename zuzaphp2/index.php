<?php 
require("dane.php");
if($_SERVER['REQUEST_METHOD'] == "POST") {
    $data = date('Y-m-d H:i:s');
    $input_tytul = htmlspecialchars($_POST['thread_name']);
    $input_tresc = str_replace(array("\r\n", "\r", "\n"), "<br />",htmlspecialchars($_POST['thread_post']));
    $input_nick = htmlspecialchars($_POST['thread_name']);
    put_post($input_tytul,$input_tresc,$input_nick);
}
    $tematy = get_topics();
    ?>
<html>
<head>
  <title>Tytuł dokumentu: zadanie </title>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" >
  <meta http-equiv="Pragma" content="no-cache" >
  <link rel="Stylesheet" href="style.css" style="text/css">
</head>    

<body>
<h1>Tytuł</h1>
<h2>Lista tematów</h2>
<?php
    foreach($tematy as $item) {
    echo '<div id="temat"><h3>' . $item['topicid'] . '</h3></div>';
    }
?>
<div id="form">
    <form action="index.php" method="post">
     <h2>Dodaj nowy temat</h2>  
     <input type="text" name="thread_name" placeholder="Nazwa tematu" autofocus="" \=""><br>
     <textarea name="thread_post" cols="80" rows="10" placeholder="Treść wypowiedzi"></textarea><br>
     <input type="text" name="thread_author" placeholder="Twój nick"><br>
     <button type="submit">Zapisz</button>
     
  </form>
</div>
<footer>
last_post_date
</footer>
</body>
</html>
