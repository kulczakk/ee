<?php
//------------------------------------------------------------------------------
// funkcja wyszukująca wypowiedzi na określony temat
//   $topicid - identyfikator tematu
//   $datafile - ścieżka do pliku zawierającego dane
//   $separator - znaki tworzące separator pól rekordu
//
// format pliku danych:
// postid:-:topicid:-:post:-:username:-:date
// 
function get_topics($datafile="wypowiedzi.txt", $separator=":-:")
{
   if( $data=file( $datafile ) ){
    $topics=array();
    foreach($data as $k=>$v){
        $record = explode( $separator, trim($v));
        if (!in_array($record[1],$topics))
        {
            $topics[]=array( 
               "topicid" => $record[1],
            );
    }
}
    return $topics;   
 }else{
    return FALSE;
 }
}
function get_posts($topicid, $datafile="wypowiedzi.txt", $separator=":-:")
{
   // wczytanie pliku do tablicy stringów
   if( $data=file( $datafile ) ){
      // utworzenie pustej tablicy wynikowej
      $posts=array();
      // dla każdego elementu tablicy $data
      //    $k - klucz ementu,  $v - wartość elementu
      foreach($data as $k=>$v){
          // umieszcza kolejne elementy wiersza rozdzielone separatoerm 
          // w kolejnych elementach zwracanej tablicy
          $record = explode( $separator, trim($v));
          // jesli pasuje identyfikator tematu
          if( $record[1]==$topicid ){
              // przepakowanie do $posts[] i dekodowanie danych użytkownika
              $posts[]=array( 
                 "postid"  => $record[0],
                 "topicid" => $record[1],
                 "post"    => hex2bin($record[2]),
                 "username"=> hex2bin($record[3]),
                 "date"    => $record[4]
              );
          }
      }
      // zwraca tablice z wynikami
      return $posts;   
   }else{
      // zwraca kod błędu
      return FALSE;
   }
}

//------------------------------------------------------------------------------
// funkcja zapisu do pliku wypowiedzi.txt
function put_post($topicid, $post, $username, $datafile="wypowiedzi.txt", $separator=":-:")
{
   // ostatni wiersz zawiera najmłodszy wpis
   if( is_file($datafile) ){
      // odczyt pliku
      $data=file( $datafile );
      // pobranie danych z ostatniego elementu tablicy $data
      $record = explode( $separator, trim(array_pop($data))); 
      $postid = $record[0]+1;
   }else{
      $postid = 1;    
   }
   // utworzenie nowego wiersz danych
   // zakodowanie przez bin2hex() danych przesłanych przez użtykownika
   $data = implode( $separator, 
                     array( $postid, 
                            $topicid, 
                            bin2hex($post), 
                            bin2hex($username), 
                            date("Y-m-d H:i:s") 
                    )
                  );
   // zapis danych na końcu pliku
   if( $fh = fopen( $datafile, "a+" )){
      fwrite($fh, $data."\n");
      fclose($fh);
      return $postid;
   }else{
      return FALSE;
   };                               
}
?>
