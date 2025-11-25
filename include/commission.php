<?php
$LEVELS = [
    1 => 0.10,
    2 => 0.05,
    3 => 0.03,
    4 => 0.02,
    5 => 0.01,
];

function generateCommission($sale_id, $user_id, $amount){
    global $LEVELS, $db;
    
    $commissionData = [];
    $current = $user_id;

    for($level = 1; $level <= 5; $level++){
        $stmt = $db->prepare("SELECT parent_id FROM users WHERE id = ?");
        $stmt->execute([$current]);
        $parent = $stmt->fetchColumn();

        if(!$parent) break;

        $commissionAmount = $amount * $LEVELS[$level];

        $stmt = $db->prepare("INSERT INTO commissions (sale_id,user_id,level,amount,percentage) VALUES (?,?,?,?,?)");
        //  $stmt->debugDumpParams();die;
        $stmt->execute([$sale_id, $parent, $level, $commissionAmount, $LEVELS[$level]]);
        // $stmt->debugDumpParams();die;
      
        $stmt2 = $db->prepare("SELECT name FROM users WHERE id = ?");
        $stmt2->execute([$parent]);
        $parent_name = $stmt2->fetchColumn();
       
        $commissionData[] = [
            "level" => $level,
            "user_id" => $parent,
            "user_name" => $parent_name,
            "amount" => $commissionAmount,
            "percentage" => $LEVELS[$level] * 100
        ];

        $current = $parent;
    }

    return $commissionData;
}

function generateUserCommission($sale_id){
    global $LEVELS, $db;
    
    $stmt = $db->prepare("SELECT c.level , u.name AS user_name,c.amount, c.percentage
        FROM commissions c
        LEFT JOIN users u ON c.user_id = u.id
        WHERE c.sale_id = ?
        ORDER BY c.level ASC
    ");
    $stmt->execute([$sale_id]);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}
?>