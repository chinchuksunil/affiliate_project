<?php include 'header.php'; ?>
<div class="content">

    <h2>Payout History</h2>

    <table>
        <thead>
            <tr>
                <th>Payout ID</th>
                <th>User</th>
                <th>Commission Amount</th>
                <th>Payout Date</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
        <?php if (!empty($payouts)) { $i = 1; ?>
            <?php foreach ($payouts as $p) { ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= htmlspecialchars($p['user_name']); ?></td>
                    <td class="amount">₹<?= number_format($p['amount'], 2); ?></td>
                    <td><?= $p['created_at']; ?></td>
                    <td>
                        <?php if ($p['status'] == 'paid') { ?>
                            <span class="status-paid">PAID</span>
                        <?php } else { ?>
                            <span class="status-pending">PENDING</span>
                        <?php } ?>
                    </td>
                </tr>
            <?php $i++; } ?>
        <?php } else { ?>
            <tr>
                <td colspan="5" style="text-align:center; color:#777;">No payout records found</td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>
