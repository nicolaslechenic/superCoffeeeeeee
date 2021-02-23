<?php
	
require('vendor/autoload.php');

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$path = "mysql:host=".$_ENV['DB_HOST'].":".$_ENV['DB_PORT'].";dbname=".$_ENV['DB_NAME'].";charset=utf8";
	
$pdo = 
  new PDO(
    $path, 
    $_ENV['DB_USER'], 
    $_ENV['DB_PASSWORD']
  );


$sqlQuery =
  "SELECT w.name AS name, FORMAT(SUM(price), 2) AS turnover 
    FROM `Order` AS o 
    INNER JOIN `OrderEdible` AS oe ON o.id = oe.idOrder 
    INNER JOIN `Waiter` AS w ON o.idWaiter = w.id  
    GROUP BY w.id
  ";

?>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>CA</th>
        </tr>
    </thead>
    <tbody>

        <?php
            foreach ($pdo->query($sqlQuery) as $row) {
              echo "<tr>";	
              echo "<td>" . $row['name'] . "</td>";
              echo "<td>" . $row['turnover'] . "€</td>";
              echo "</tr>";
            }
          ?>

    </tbody>
</table>



