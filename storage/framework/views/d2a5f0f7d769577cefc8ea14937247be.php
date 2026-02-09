<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Conception - <?php echo e($conception->title); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            line-height: 1.6;
            background: #fff;
        }
        
        .header {
            background-color: #667eea;
            color: white;
            padding: 25px 30px;
            margin-bottom: 25px;
        }
        
        .header-title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header-subtitle {
            font-size: 16px;
            opacity: 0.95;
        }
        
        .container {
            padding: 0 30px 30px 30px;
        }
        
        .company-info {
            margin-bottom: 25px;
            padding: 15px 20px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
        }
        
        .company-name {
            font-size: 16px;
            font-weight: bold;
            color: #667eea;
            margin-bottom: 8px;
        }
        
        .company-details {
            color: #555;
            line-height: 1.8;
        }
        
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        
        .info-table td {
            padding: 10px 15px;
            border-bottom: 1px solid #e0e0e0;
            vertical-align: top;
        }
        
        .info-table .label {
            width: 30%;
            font-weight: bold;
            color: #667eea;
            background: #f8f9fa;
        }
        
        .info-table .value {
            width: 70%;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #333;
            margin: 25px 0 15px 0;
            padding-bottom: 8px;
            border-bottom: 2px solid #667eea;
        }
        
        .overview-text {
            margin-bottom: 20px;
            line-height: 1.8;
            color: #555;
        }
        
        .section-item {
            margin-bottom: 15px;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-left: 4px solid #667eea;
            background: #fafafa;
            page-break-inside: avoid;
        }
        
        .section-header-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .section-number {
            width: 30px;
            height: 30px;
            background: #667eea;
            color: white;
            text-align: center;
            line-height: 30px;
            border-radius: 50%;
            font-weight: bold;
            font-size: 12px;
            display: inline-block;
        }
        
        .section-name {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            padding-left: 10px;
        }
        
        .section-price {
            font-size: 14px;
            font-weight: bold;
            color: #667eea;
            text-align: right;
        }
        
        .section-description {
            margin-top: 10px;
            padding-left: 40px;
            color: #666;
            line-height: 1.7;
        }
        
        .total-box {
            margin-top: 25px;
            padding: 20px;
            background-color: #667eea;
            color: white;
        }
        
        .total-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .total-label {
            font-size: 18px;
            font-weight: bold;
            text-align: left;
        }
        
        .total-amount {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
        }
        
        .notes-box {
            margin-top: 25px;
            padding: 15px 20px;
            background: #fffbea;
            border-left: 4px solid #f59e0b;
        }
        
        .notes-title {
            font-weight: bold;
            color: #92400e;
            margin-bottom: 8px;
            font-size: 12px;
        }
        
        .notes-content {
            color: #78350f;
            line-height: 1.8;
        }
        
        .warning-box {
            margin-top: 25px;
            padding: 15px 20px;
            background: #fef2f2;
            border: 2px solid #ef4444;
            page-break-inside: avoid;
        }
        
        .warning-title {
            font-size: 13px;
            font-weight: bold;
            color: #991b1b;
            margin-bottom: 10px;
        }
        
        .warning-content {
            color: #7f1d1d;
            line-height: 1.6;
            font-size: 10px;
        }
        
        .highlight {
            background: #fef3c7;
            padding: 2px 5px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #e0e0e0;
            text-align: center;
            color: #999;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="header-title"><?php echo e($trans['title']); ?></div>
        <div class="header-subtitle"><?php echo e($conception->title); ?></div>
    </div>
    
    <div class="container">
        <!-- Company Information -->
        <?php if($conception->user->company_name): ?>
        <div class="company-info">
            <div class="company-name"><?php echo e($conception->user->company_name); ?></div>
            <div class="company-details">
                <?php if($conception->user->company_address): ?>
                    <?php echo e($conception->user->company_address); ?><br>
                <?php endif; ?>
                <?php if($conception->user->company_phone): ?>
                    <?php echo e($trans['phone']); ?>: <?php echo e($conception->user->company_phone); ?><br>
                <?php endif; ?>
                <?php if($conception->user->email): ?>
                    <?php echo e($trans['email']); ?>: <?php echo e($conception->user->email); ?>

                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        
        <!-- Conception Information -->
        <table class="info-table">
            <?php if($conception->client): ?>
            <tr>
                <td class="label"><?php echo e($trans['client']); ?></td>
                <td class="value"><?php echo e($conception->client->name); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="label"><?php echo e($trans['date']); ?></td>
                <td class="value"><?php echo e($conception->date->format($lang == 'fr' ? 'd F Y' : 'F d, Y')); ?></td>
            </tr>
            <?php if($conception->valid_until): ?>
            <tr>
                <td class="label"><?php echo e($trans['valid_until']); ?></td>
                <td class="value"><?php echo e($conception->valid_until->format($lang == 'fr' ? 'd F Y' : 'F d, Y')); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td class="label"><?php echo e($trans['status']); ?></td>
                <td class="value"><?php echo e($trans['status_' . $conception->status]); ?></td>
            </tr>
        </table>
        
        <?php if($conception->description): ?>
        <div class="section-title"><?php echo e($trans['project_overview']); ?></div>
        <p class="overview-text"><?php echo e($conception->description); ?></p>
        <?php endif; ?>
        
        <!-- Sections -->
        <div class="section-title"><?php echo e($trans['project_sections']); ?></div>
        
        <?php $__currentLoopData = $conception->sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="section-item">
            <table class="section-header-table">
                <tr>
                    <td style="width: 40px; vertical-align: middle;">
                        <span class="section-number"><?php echo e($index + 1); ?></span>
                    </td>
                    <td class="section-name" style="vertical-align: middle;">
                        <?php echo e($section['name']); ?>

                    </td>
                    <td class="section-price" style="width: 120px; vertical-align: middle;">
                        <?php if(!empty($section['price']) && $section['price'] > 0): ?>
                            <?php echo e($conception->user->currency); ?> <?php echo e(number_format($section['price'], 2, $lang == 'fr' ? ',' : '.', $lang == 'fr' ? ' ' : ',')); ?>

                        <?php else: ?>
                            <span style="color: #999; font-style: italic; font-size: 10px;">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
            <?php if(!empty($section['description'])): ?>
            <div class="section-description">
                <?php echo e($section['description']); ?>

            </div>
            <?php endif; ?>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        <!-- Total Price -->
        <div class="total-box">
            <table class="total-table">
                <tr>
                    <td class="total-label"><?php echo e($trans['total_project_price']); ?></td>
                    <td class="total-amount"><?php echo e($conception->user->currency); ?> <?php echo e(number_format($conception->total_price, 2, $lang == 'fr' ? ',' : '.', $lang == 'fr' ? ' ' : ',')); ?></td>
                </tr>
            </table>
        </div>
        
        <!-- Notes -->
        <?php if($conception->notes): ?>
        <div class="notes-box">
            <div class="notes-title"><?php echo e($trans['additional_notes']); ?></div>
            <div class="notes-content"><?php echo e($conception->notes); ?></div>
        </div>
        <?php endif; ?>
        
        <!-- Important Warning -->
        <div class="warning-box">
            <div class="warning-title"><?php echo e($trans['important_scope']); ?></div>
            <div class="warning-content">
                <?php echo e($trans['scope_warning']); ?>

                <span class="highlight"><strong><?php echo e($trans['scope_highlight']); ?></strong></span>
                <?php echo e($trans['scope_agreement']); ?>

            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <?php echo e($trans['generated_on']); ?> <?php echo e(now()->format($lang == 'fr' ? 'd F Y' : 'F d, Y')); ?> <?php echo e($trans['at']); ?> <?php echo e(now()->format('H:i')); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Espacegamers\Documents\bendaikh project\resources\views/conceptions/pdf.blade.php ENDPATH**/ ?>