<?php include 'header.php'; ?>
<div class="content">
    <h1>Welcome to Affiliate Dashboard</h1>

    <div class="box">
        <h3>Sales List</h3>

        <table>
            <thead>
                <tr>
                    <th></th>
                    <th>Sale ID</th>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Total Commission</th>
                    <th>Date</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($sales_list)) { 
                $i = 1;
                // print_r($sales_list);
                ?>
                    
                    <?php foreach ($sales_list as $s) { ?>
                        <tr>
                            <td>
                                <?php if ($s['total_commission'] > 0) { ?>
                                <button class="expand-btn" data-sale="<?= $s['id']; ?>"><i class="fa-solid fa-expand"></i></button>
                                <?php } ?>
                            </td>
                            <td>
                                <?= $i; ?>
                            </td>
                            <td><?= htmlspecialchars($s['user_name']); ?></td>
                            <td class="amount">₹<?= number_format($s['amount'], 2); ?></td>
                            <td class="amount">₹<?= number_format($s['total_commission'], 2); ?></td>
                            <td><?= $s['created_at']; ?></td>
                        </tr>
                        <tr class="commission-row commission-<?= $s['id']; ?>" style="display:none;">
                            <td colspan="6">
                                <div class="commission-box">
                                    Loading...
                                </div>
                            </td>
                        </tr>
                    <?php $i++;
                    } ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="6" style="text-align:center; color:#777;">No sales found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    var baseURL = 'affliate.php';
    
    $(".expand-btn").click(function(){
        let saleId = $(this).data("sale");
        let row = $(".commission-" + saleId);
        let btn = $(this);
    
        if(row.is(":visible")){
            row.hide();
            btn.html(`<i class="fa-solid fa-expand"></i>`);
            return;
        }
    
        btn.text("-");
      
        $.post(baseURL, { action: "get_commission_hierarchy", sale_id: saleId }, function(res){
            let data = JSON.parse(res);
            let html = `
                <table class="inner-table">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>User</th>
                            <th>Commission Amount</th>
                            <th>Commission Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
           
            data.forEach(function(c){
                html += `
                    <tr>
                        <td>Level ${c.level}</td>
                        <td>${c.user_name}</td>
                        <td>₹${c.amount}</td>
                        <td>${c.percentage * 100} %</td>
                    </tr>
                `;
            });
    
            html += "</tbody></table>";
    
            $(".commission-" + saleId + " .commission-box").html(html);
            row.show();
        });
    });
});


</script>
</body>
</html>
