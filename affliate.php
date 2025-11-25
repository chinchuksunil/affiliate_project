<?php
require_once 'include/config.php';
require_once 'include/user.php';
require_once 'include/sales.php';
require_once 'include/commission.php';

$action = (!isset($_REQUEST['action']) || $_REQUEST['action'] == '') ? 'index' : $_REQUEST['action'];
call_user_func($action);

function index(){
    global $db;
    $sales_list = getAllSales();
    require 'templates/affiliate.php';
}

function list_users(){
    global $db;
    $all_users = getAllUsers();
    $users = getUsers();
    foreach ($users as &$u) {
        $u['level'] = getUserLevel($u['id']);
    }
    $tree = '';
    $userTree = buildUserTree($users);
    $treeHtml = renderUserTree($userTree);
    require 'templates/list_users.php';
}

function view_sales(){
    global $db;
    
    $all_users = getAllUsers();
    require_once 'templates/sales.php';  
}

function save_user(){
    global $db;
    
    $name  = isset($_REQUEST['name']) ? trim($_REQUEST['name']) : '';
    $email = isset($_REQUEST['email']) ? trim($_REQUEST['email']) : '';
    $parent  = (isset($_REQUEST['parentId']) && !empty($_REQUEST['parentId'])) ? $_REQUEST['parentId'] : 0;
    
    if (empty($name)) {
        echo json_encode(['status' => 'error', 'type' =>'name','message' => "Name field is mandatory."]);
        exit;
    }
   
    if (strlen($name) < 3 || strlen($name) > 25 ) {
        echo json_encode(['status' => 'error', 'type' =>'name', 'message' => "Please enter a valid Name."]);
        exit;
    }
    
    if (empty($email)) {
        echo json_encode(['status' => 'error', 'type' =>'email','message' => "Email field is mandatory."]);
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'type' =>'email','message' => "Enter a valid Email"]);
        exit;
    }
   
    if (isEmailExists($email)) {
        echo json_encode(['status' => 'error', 'type' =>'email','message' => "Email already exists"]);
        exit;
    }
    
    if (addUser($name, $email, $parent)) {
        echo json_encode(['status' => 'success','message' => "User saved successfully"]);
    } else {
        echo json_encode(['status' => 'error','message' => "Failed to save user"]);
    }
    exit;
}

function add_sale(){
    global $db;
    $user_id = isset($_REQUEST['user_id']) ? intval($_REQUEST['user_id']) : 0;
    $amount  = isset($_REQUEST['amount']) ? floatval($_REQUEST['amount']) : 0;

    if ($user_id <= 0 || $amount <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid user or amount']);
        exit;
    }

    $sale_id = addSale($user_id, $amount);
   
    $commissionData = generateCommission($sale_id, $user_id, $amount);
     
    echo json_encode([
        "status" => "success",
        "message" => "Sale recorded & commissions generated",
        "commissions" => $commissionData
    ]);
    exit;

}

function get_commission_hierarchy(){
    global $db;

    $sale_id = isset($_REQUEST['sale_id']) ? $_REQUEST['sale_id'] : 0;
    
    if(!is_numeric($_REQUEST['sale_id'])) exit;
    
    $data = generateUserCommission($sale_id);

    echo json_encode($data);
    exit;
}

function buildUserTree($users) {
    $refs = [];
    $tree = [];

    foreach ($users as $u) {
        $u['children'] = [];
        $refs[$u['id']] = $u;
    }

    foreach ($refs as $id => $u) {
        if ($u['parent_id'] == 0 || $u['parent_id'] == null) {
            $tree[$id] = &$refs[$id];
        } else {
            $refs[$u['parent_id']]['children'][$id] = &$refs[$id];
        }
    }

    return $tree;
}
function renderUserTree($nodes) {
    $html = "<ul>";

    foreach ($nodes as $node) {

        $hasChildren = !empty($node['children']);
        $btn = $hasChildren ? "<button class='toggle-btn'>–</button>" : "";

        $html .= "<li>$btn" . htmlspecialchars($node['name']);

        if ($hasChildren) {
            $html .= renderUserTree($node['children']);
        }

        $html .= "</li>";
    }

    $html .= "</ul>";

    return $html;
}







