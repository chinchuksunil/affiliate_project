<?php include 'header.php'; ?>
<style>
    .tab-header {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.tab-btn {
    padding: 10px 18px;
    border: none;
    background: #e8e8ff;
    border-radius: 6px;
    cursor: pointer;
    font-size: 15px;
    color: #333;
    transition: 0.2s;
}

.tab-btn.active {
    background: #4f52ff;
    color: white;
    font-weight: bold;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
}

/* TABLE STYLING */
.user-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

.user-table th {
    background: #4f52ff;
    color: white;
    padding: 10px;
    text-align: left;
}

.user-table td {
    padding: 10px;
    border-bottom: 1px solid #eee;
}

.user-table tr:hover {
    background: #f0f2ff;
}

.tree-container {
    padding: 15px;
    background: #fff;
    border-radius: 8px;
    border: 1px solid #ddd;
    max-width: 500px;
    font-family: Arial, sans-serif;
}

.tree ul {
    list-style: none;
    margin-left: 20px;
    padding-left: 15px;
    border-left: 1px dashed #bbb;
}

.tree li {
    margin: 6px 0;
    position: relative;
    padding-left: 5px;
}

.tree li::before {
    content: "";
    position: absolute;
    top: 12px;
    left: -15px;
    width: 12px;
    height: 1px;
    background: #bbb;
}

.toggle-btn {
    background: #007bff;
    color: #fff;
    border: none;
    padding: 2px 6px;
    margin-right: 6px;
    font-size: 12px;
    border-radius: 4px;
    cursor: pointer;
}

.toggle-btn:hover {
    background: #0056b3;
}

</style>
<div class="content">

    <h1>Users</h1>

    <button class="btn-main add_new_user"> + Add User</button>

    <div id="addForm" class="d-none">
        <h2>Add User</h2>
    
        <div class="form-group">
            <label>Name</label>
            <input type="text" id="name" placeholder="Enter user name">
            <span id="err_name" class="error-text"></span>
        </div>
    
        <div class="form-group">
            <label>Email</label>
            <input type="email" id="email" placeholder="Enter email">
            <span id="err_email" class="error-text"></span>
        </div>
    
        <div class="form-group">
            <label>Parent User</label>
            <select id="parent_id">
                <option value="">-- Select --</option>
                <?php 
                foreach($all_users as $user) {
                ?>
                    <option value="<?= $user['id'] ?>"><?= htmlspecialchars($user['name']) ?></option>
                <?php 
                  } 
                ?>
                
            </select>
            <span id="err_parent" class="error-text"></span>
        </div>
    
        <button class="btn-main" id="saveUserBtn">Save</button>
    </div>
    
     <div class="tab-header">
        <button class="tab-btn active" data-tab="tableView">Table View</button>
        <button class="tab-btn" data-tab="treeView">Tree View</button>
    </div>
    
    <div id="tableView" class="tab-content active">
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Parent</th>
                <th>Level</th>
            </tr>
    
            <tbody>
                <?php if (!empty($users)) { $i = 1;
                ?>
                    <?php foreach ($users as $usr) { ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?= htmlspecialchars($usr['name'])  ?></td>
                            <td><?= htmlspecialchars($usr['email']) ?></td>
                            <td><?= $usr['parent_name'] ? htmlspecialchars($usr['parent_name']) : "-" ?></td>
                            <td><?= $usr['level'] ?></td>
                        </tr>
                    <?php $i++; } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="5" style="text-align:center; color:#888;">No users found</td>
                    </tr>
                <?php } ?>
            </tbody>
            
        </table>
    </div>
    <div id="treeView" class="tab-content">
        <div class="tree">
            <?= $treeHtml ?>
        </div>
    </div>

    
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    var baseURL = 'affliate.php';
    
    $("#name").val("");
    $("#email").val("");
    $("#parent_id").val("");
   
    $("#saveUserBtn").click(function () {
        
        clearErrors();

        let name = $("#name").val().trim();
        let email = $("#email").val().trim();
        let parentId = $("#parent_id").val();
        let hasError = false;

        if (name === "") {
            $("#err_name").html("Name is required");
            hasError = true;
        }
        if (email === "") {
            $("#err_email").html("Email is required");
            hasError = true;
        }
        // if (parentId === "") {
        //     alert("Please select a Parent User");
        //     return;
        // }
        if (hasError) return;
        $.post(baseURL, {
            action: 'save_user',
            parentId: parentId,
            name: name,
            email : email
        })
        .done(function (response) {
            let data = JSON.parse(response);
            
            if (data.status === 'success') {
                alert(data.message);
                $("#name").val("");
                $("#email").val("");
                $("#parent_id").val("");
                
                setTimeout(() => location.reload(), 1200);
                
            }else {
                if (data.type == 'name') {
                   $("#err_name").text(data.message);
                }else if (data.type == 'email') {
                    $("#err_email").text(data.message);
                }
            }
        });

    });
    $(document).on('click', '.add_new_user', function () {
        $('#addForm').toggleClass('d-none');
    });
    
    function clearErrors() {
        $("#err_name").text("");
        $("#err_email").text("");
        $("#err_parent").text("");
    }

});
$(document).on("click", ".tab-btn", function () {
    $(".tab-btn").removeClass("active");
    $(this).addClass("active");

    let tab = $(this).data("tab");

    $(".tab-content").removeClass("active");
    $("#" + tab).addClass("active");
});

$(document).on("click", ".toggle-btn", function () {
    let childList = $(this).closest("li").children("ul");

    if (childList.is(":visible")) {
        childList.hide();
        $(this).text("+");
    } else {
        childList.show();
        $(this).text("–");
    }
});

</script>
</body>
</html>
