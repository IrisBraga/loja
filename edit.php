<?php
require_once 'init.php';
// pega os dados do formuário
$name = isset($_POST['name']) ? $_POST['name'] : null;
$color = isset($_POST['color']) ? $_POST['color'] : null;
$price = isset($_POST['price']) ? $_POST['price'] : null;
$startdate = isset($_POST['startdate']) ? $_POST['startdate'] : null;
$quantity = isset($_POST['quantity']) ? $_POST['quantity'] : null; 
$id = isset($_POST['id']) ? $_POST['id'] : null;
// validação (bem simples, só pra evitar dados vazios)
if (empty($name) || empty($color) || empty($price) || empty($startdate) || empty($quantity) )
{
    echo "Volte e preencha todos os campos";
    exit;
}
// a data vem no formato dd/mm/YYYY
// então precisamos converter para YYYY-mm-dd
$isoDate = dateConvert($startdate);
// atualiza o banco
$PDO = db_connect();
$sql = "UPDATE products SET name = :name, color = :color,"
        . " price = :price, startdate = :startdate, quantity = :quantity WHERE id = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':color', $color);
$stmt->bindParam(':price', $price);
$stmt->bindParam(':startdate', $startdate);
$stmt->bindParam(':quantity', $quantity);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
if ($stmt->execute())
{
    header('Location: index.php');
}
else
{
    echo "Erro ao alterar";
    print_r($stmt->errorInfo());
}

