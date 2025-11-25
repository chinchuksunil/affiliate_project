<!DOCTYPE html>
<html>
<head>
    <title>Multi-Level Affliate Payout System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body { margin: 0; font-family: Arial; background: #f5f6fa; }
        .top-menu {
            width: 100%;
            background: #2c3e50;
            padding: 15px 0;
        }
        .error-text {
            color: red;
            font-size: 13px;
            display: block;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        .top-menu a {
            color: #fff;
            text-decoration: none;
            padding: 14px 20px;
            font-size: 15px;
        }
        .top-menu a:hover {
            background: #1abc9c;
        }
        .content {
            /*margin-left: 240px;*/
            padding: 20px;
        }

        .cards {
            display: flex;
            gap: 20px;
        }

        .card {
            width: 22%;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 8px #ddd;
        }

        .card h3 {
            margin: 0;
        }
        /* Table */
        table {
            width: 100%;
            background: white;
            border-radius: 8px;
            border-collapse: collapse;
            box-shadow: 0 0 10px #ccc;
        }

        table th {
            background: #34495e;
            color: white;
            padding: 12px;
            font-size: 14px;
        }

        table td {
            padding: 4px 68px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }

        .amount {
            font-weight: bold;
            color: #27ae60;
        }

        .commission-box {
          
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 10px;
           
        }

        .level-label {
            font-weight: bold;
            color: #2980b9;
        }
             
        .btn-main {
            background: #1abc9c;
            color: white;
            border: none;
            padding: 10px 16px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 25px;
        }

        .btn-main:hover {
            background: #16a085;
        }

        /* Add User Form */
        #addForm {
            background: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            box-shadow: 0 0 10px #ccc;
            
        }
        .page-container {
            /*margin-left: 240px;*/
            padding: 25px;
        }
        .amount {
            font-weight: bold;
            color: #27ae60;
        }

        /* Status Badges */
        .status-paid {
            color: white;
            background: #27ae60;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-pending {
            color: white;
            background: #f39c12;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 20px;
            color: #2c3e50;
        }

        /* Boxes */
        .box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px #ccc;
            margin-bottom: 25px;
        }

        h3 {
            margin-top: 0;
            margin-bottom: 18px;
            color: #34495e;
        }


        input, select {
            width: 100%;
            padding: 10px;
            margin-top: 8px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

       
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
        }
        .d-none {
            display:none;
        }
    </style>
</head>
<body>

<div class="top-menu">
    <a href="affliate.php">Dashboard</a>
    <a href="affliate.php?action=list_users">Users</a>
    <a href="affliate.php?action=view_sales">Sales</a>
   
</div>
