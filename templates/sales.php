<?php include 'header.php'; ?>

<div class="page-container">

    <h2>Sales & Commission View</h2>

    <div class="box">
        <h3>Add New Sale</h3>

        <label>User</label>
        <select id="sale_user">
            <option value="">-- Select User --</option>
            <?php foreach ($all_users as $u) { ?>
                <option value="<?= $u['id']; ?>"><?= htmlspecialchars($u['name']); ?></option>
            <?php } ?>
        </select>
        <span id="err_usr" class="error-text"></span>
        
        <label>Sale Amount</label>
        <input type="text" id="sale_amount" placeholder="Enter sale amount">
        <span id="err_amt" class="error-text"></span>
        
        <button class="btn-main" id="saveSaleBtn">Save</button>
    </div>
   
    <div id="commissionBox" style="display:none; margin-top:20px;">
        <h3>Commission List</h3>
    
        <table border="1" width="100%" cellpadding="10" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th>Level</th>
                    <th>User ID</th>
                    <th>Commission Percentage</th>
                    <th>Commission Amount</th>
                </tr>
            </thead>
            <tbody id="commissionOutput"></tbody>
        </table>
    </div>


    

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
var baseURL = "affliate.php";

clearErrors();
$("#sale_user").val('');
$("#sale_amount").val('');

$("#saveSaleBtn").click(function () {
    clearErrors();
    let user_id = $("#sale_user").val();
    let amount = $("#sale_amount").val().trim();
    let hasError = false;

    if (!user_id) {
        $("#err_usr").text("Please select a user");
        hasError = true;
    }
    if (!amount || isNaN(amount) || Number(amount) <= 0) {
        $("#err_amt").html("Enter a valid sale amount");
        hasError = true;
    }

    if (hasError) return;

    $.post(baseURL, {
        action: "add_sale",
        user_id: user_id,
        amount: amount
    })
    .done(function(response) {

        let res = JSON.parse(response);

        if (res.status === "success") {
            
            $("#sale_user").val('');
            $("#sale_amount").val('');
          
            $("#commissionBox").show();
            $("#commissionOutput").html("");

            if (res.commissions && res.commissions.length > 0) {
                res.commissions.forEach(function(c){
                    $("#commissionOutput").append(`
                        <tr>
                            <td>${c.level}</td>
                            <td>${c.user_name}</td>
                            <td> ${c.percentage} %</td>
                            <td>₹ ${parseFloat(c.amount).toFixed(2)}</td>
                        </tr>
                    `);
                });

            } else {
                $("#commissionOutput").html("<p>No commissions generated</p>");
            }

            alert("Sale Recorded Successfully!");
            // setTimeout(() => location.reload(), 1200);

        } else {
            alert(res.message || "Something went wrong");
        }
    })
   
});

$("#sale_amount").on("input", function () {
    this.value = this.value.replace(/[^0-9.]/g, "").replace(/(\..*)\./g, "$1");
});


function clearErrors() {
    $("#err_usr").text("");
    $("#err_amt").text("");
}

</script>

</body>
</html>
