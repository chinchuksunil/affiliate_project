<?php
function addSale($user_id, $amount){
    global $db;
    $stmt = $db->prepare("INSERT INTO sales (user_id, amount) VALUES (?,?)");
    $stmt->execute([$user_id, $amount]);
    // $stmt->debugDumpParams();die;
    return $db->lastInsertId();
}

function getAllSales(){
    global $db;
    $sql = "SELECT u.name AS user_name, s.*, SUM(c.amount) AS total_commission
            FROM sales s
            LEFT JOIN users u ON u.id = s.user_id
            LEFT JOIN commissions c ON c.sale_id = s.id
            GROUP BY s.id ORDER BY s.id DESC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>