<?php
$no = str_replace ("zadanie", "", array_pop( explode("/", dirname(_FILE_))));
?>
<html>
<head>
  <title>Tytuł dokumentu: zadanie<?=$no?></title>
  <meta charset="UTF-8">
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate" >
  <meta http-equiv="Pragma" content="no-cache" >
  <link rel="Stylesheet" href="style.css" style="text/css">
</head>    

<body>
<div id='header'>
<h1>Tytuł dokumentu - Zadanie <?=$no?></h1>
</div>
<div id="nav">
<a href="../" title="Strona początkowa serwisu" target="_self" >Home</a> 
<?php for($n=1;$n<11;$n++): ?>

    
<a href="../zadanie<?=$n?>/" title="Zadanie <?=$n?>" target="_self" >Zadanie <?=$n?></a>

<?php endfor ?>
</div>
  
<?php
if($_SERVER['REQUEST_METHOD'] == "POST") {
$ip = $_SERVER['REMOTE_ADDR'];
$data = date('Y-m-d H:i:s');
$input_tytul = htmlspecialchars($_POST['form_tytul']);
$tresc = str_replace(array("\r\n", "\r", "\n"), "<br />",htmlspecialchars($_POST['form_tresc']));
$do_pliku = $input_tytul ."\n". $tresc ."\n".$ip."\n".$data."\n";
$mojplik = fopen("dane.txt", "a+");
fwrite($mojplik, $do_pliku);
fclose($mojplik);
}
if(filesize("dane.txt") > 0) {
$count=0;
$fp = fopen("dane.txt", "r");
$wiersze = array();
$j=0;
while(!feof($fp)){
$wiersze[$j] = fgets ($fp, 255);
$j++;
}
fclose($fp);
$count=0;
array_pop($wiersze);
for ($i=0; $i<count($wiersze); $i=$i+4)    {
    echo "<article name=".$i."><header>".$wiersze[$i]."</header><div id='d'>".$wiersze[$i+1]."</div><div id='footer'>IP: ".$wiersze[$i+2]."; Data: ".$wiersze[$i+3]." </div></article>";
$count++;
}
}
?>
    <aside>
        <?php
        echo "Ostatni wpis: ".$wiersze[count($wiersze)-1]."<br>";
        echo "Liczba wpisów: ".$count;
        
        ?>
    </aside>
    <div id="form">
    <form action="index.php" method="post">
     <header><h2>Wypełnij i zapisz</h2></header>  
     <input type="text" name="form_tytul" placeholder="Tytuł wiadomosci"><br>
     <textarea name="form_tresc" cols="80" rows="10" placeholder="Tresć wiadomosci"></textarea><br>
     <button type="submit">Zapisz</button>
  </form>
</div>




<footer>
<p>-KP- <?=date("d.F.Y G:i")?></p>
</footer>
</body>
</html>
