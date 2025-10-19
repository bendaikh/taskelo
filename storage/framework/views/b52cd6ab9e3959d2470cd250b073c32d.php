<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total {
            font-weight: bold;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Payment Report</h1>
    <p><strong>Generated:</strong> <?php echo e(now()->format('M d, Y H:i')); ?></p>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Client</th>
                <th>Project</th>
                <th>Type</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($payment->date->format('M d, Y')); ?></td>
                    <td><?php echo e($payment->client->name); ?></td>
                    <td><?php echo e($payment->project->title); ?></td>
                    <td><?php echo e(ucfirst($payment->type)); ?></td>
                    <td><?php echo e(number_format($payment->amount, 2)); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
            <tr class="total">
                <td colspan="4" style="text-align: right;">Total:</td>
                <td><?php echo e(number_format($total, 2)); ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

<?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/payments/pdf.blade.php ENDPATH**/ ?>