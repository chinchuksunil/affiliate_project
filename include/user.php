<?php
function getAllUsers(){
    global $db;
    $stmt = $db->prepare("SELECT * FROM users ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function isEmailExists($email){
    global $db;
    $stmt = $db->prepare("SELECT COUNT(id) FROM users WHERE email = ?");
    $stmt->execute([$email]);
    return $stmt->fetchColumn() > 0;
}

function getUserById($id){
    global $db;
    $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function addUser($name, $email, $parent_id){
    global $db;
    $stmt = $db->prepare("INSERT INTO users (name,email,parent_id) VALUES (?,?,?)");
    return $stmt->execute([$name,$email,$parent_id]);
}

function getUsers(){
    global $db;
    $sql = "SELECT  u.*,p.name AS parent_name
        FROM users u
        LEFT JOIN users p ON u.parent_id = p.id
        ORDER BY u.id DESC ";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getUserLevel($user_id){
    global $db;
    $level = 0;
    while(true){
        $stmt = $db->prepare("SELECT parent_id FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $parent = $stmt->fetchColumn();
        if(!$parent) break;
        $level++;
        $user_id = $parent;
    }
    return $level;
}
?>