
<?php
class BancoDeDados{
    function abreConexao(){
        $host = "localhost";
        $user = "projeto_joao";
        $pass = "Joao@24445";
        $scdb = "projeto_joao";
        $conn;
        try {
            $conn = new PDO("mysql:host=$host;dbname=$scdb", $user, $pass);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Connected successfully";
        }
        catch(PDOException $e){
            echo "Connection failed: " . $e->getMessage();
        }
    }

    function query(){
          $sql = 'SELECT * FROM teste WHERE 1';
          $array = array();
          foreach ($conn->query($sql) as $row) {
              array_push($array, $row);
          }
          return $array;
    }

}
?>
