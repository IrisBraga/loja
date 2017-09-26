<?php
require_once 'init.php';
// pega os dados do formuário
$name = isset($_POST['name']) ? $_POST['name'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;
$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null; 
// validação (bem simples, só pra evitar dados vazios)
if (empty($name) || empty($color) || empty($price) || empty($startdate) || empty($quantity) )
{
    echo "Volte e preencha todos os campos";
    exit;
}
// a data vem no formato dd/mm/YYYY
// então precisamos converter para YYYY-mm-dd
$isoDate = dateConvert($startdate);
// insere no banco
$PDO = db_connect();
$sql = "INSERT INTO products(name, color, price, startdate, quantity) VALUES(:name, :color, :price, :startdate, :quantity)";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':color', $color);
$stmt->bindParam(':price', $price);
$stmt->bindParam(':startdate', $isoDate);
$stmt->bindParam(':quantity', $quantity);
if ($stmt->execute())
{
    header('Location: index.php');
}
else
{
    echo "Erro ao cadastrar";
    print_r($stmt->errorInfo());
}

