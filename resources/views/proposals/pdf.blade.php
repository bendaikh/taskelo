<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $translations['document_label'] ?? 'Proposal' }} - {{ $proposal->proposal_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            background: #fff;
            padding: 0;
            margin: 0;
        }
        
        .container {
            padding: 20px 40px 40px 40px;
            margin: 0;
        }
        
        .header {
            /* Solid color fallback for PDF renderers that don't support gradients */
            background-color: #667eea;
            background-image: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
            padding: 20px 40px 18px 40px;
            margin: 0;
            width: auto;
            min-height: 120px;
            display: block;
        }
        
        .header-content {
            display: table;
            width: 100%;
            margin: 0;
            padding: 0;
        }
        
        .business-info {
            display: table-cell;
            vertical-align: top;
            width: 60%;
            margin: 0;
            padding: 0;
        }
        
        .business-logo {
            max-width: 120px;
            max-height: 80px;
            margin-bottom: 5px;
            display: block;
            vertical-align: top;
        }
        
        .business-info h1 {
            font-size: 26px;
            margin-top: 0;
            margin-bottom: 3px;
            font-weight: bold;
            line-height: 1.2;
        }
        
        .business-info p {
            font-size: 11px;
            opacity: 0.95;
            margin: 1px 0;
            line-height: 1.3;
        }
        
        .proposal-info {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            width: 40%;
            margin: 0;
            padding: 0;
            color: #ffffff !important;
        }
        
        .proposal-info h2 {
            font-size: 24px;
            margin-top: 0;
            margin-bottom: 4px;
            font-weight: bold;
            line-height: 1.2;
            /* Use a dark color so the title is visible even if the header background renders white */
            color: #fdfdfd;
            display: block;
        }
        
        .proposal-info p {
            font-size: 11px;
            margin: 2px 0;
            opacity: 0.95;
            line-height: 1.3;
            color: white;
        }
        
        .proposal-title-section {
            background: #f8f9fa;
            padding: 10px 30px;
            margin-top: 0 !important;
            margin-bottom: 20px;
            border-left: 4px solid #667eea;
        }
        
        .proposal-title-section h3 {
            font-size: 18px;
            margin-top: 0;
            margin-bottom: 10px;
            color: #667eea;
            font-weight: bold;
        }
        
        .details-grid {
            display: table;
            width: 100%;
            margin-top: 0;
            margin-bottom: 0;
        }
        
        .detail-item {
            display: table-cell;
            padding-right: 30px;
            vertical-align: top;
        }
        
        .detail-label {
            font-size: 9px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }
        
        .detail-value {
            font-size: 13px;
            font-weight: 600;
            color: #333;
        }
        
        .total-amount {
            font-size: 18px;
            color: #667eea;
        }
        
        .client-section {
            margin-bottom: 25px;
            padding: 15px 20px;
            background: #fafafa;
            border-radius: 4px;
        }
        
        .client-section h4 {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 10px;
            letter-spacing: 0.5px;
            font-weight: bold;
        }
        
        .client-section p {
            font-size: 12px;
            margin: 4px 0;
            line-height: 1.5;
        }
        
        .client-section strong {
            font-size: 13px;
        }
        
        .services-section {
            margin: 25px 0;
            page-break-inside: avoid;
        }
        
        .services-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        
        .services-table thead {
            background: #667eea;
            color: white;
        }
        
        .services-table th {
            padding: 12px 10px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .services-table th.text-right {
            text-align: right;
        }
        
        .services-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e0e0e0;
            font-size: 11px;
            line-height: 1.4;
        }
        
        .services-table tbody tr:last-child td {
            border-bottom: none;
        }
        
        .services-table td.text-right {
            text-align: right;
        }
        
        .total-row {
            background: #f8f9fa;
            font-weight: bold;
        }
        
        .total-row td {
            padding: 15px 10px;
            font-size: 13px;
            border-top: 2px solid #667eea;
        }
        
        .total-amount-cell {
            font-size: 16px;
            color: #667eea;
        }
        
        .notes-section {
            margin: 25px 0;
            padding: 20px 25px;
            background: #f8f9fa;
            border-left: 4px solid #667eea;
            border-radius: 4px;
        }
        
        .notes-section h4 {
            font-size: 11px;
            color: #667eea;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: bold;
        }
        
        .notes-section p {
            font-size: 12px;
            color: #555;
            white-space: pre-wrap;
            line-height: 1.6;
        }
        
        .footer {
            margin-top: 40px;
            padding: 20px 0;
            border-top: 2px solid #e0e0e0;
            text-align: center;
            color: #666;
            font-size: 10px;
            line-height: 1.6;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .status-draft {
            background: #e0e0e0;
            color: #666;
        }
        
        .status-sent {
            background: #2196F3;
            color: white;
        }
        
        .status-accepted {
            background: #4CAF50;
            color: white;
        }
        
        .status-rejected {
            background: #f44336;
            color: white;
        }
        
        @media print {
            .header {
                page-break-inside: avoid;
            }
            
            .services-section {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    @php
        $language = $language ?? 'en';
        $statusLabels = $translations['status_labels'] ?? [];
        $dateFormat = $translations['formats']['date'] ?? 'F d, Y';
        $dateTimeFormat = $translations['formats']['datetime'] ?? 'F d, Y \a\t H:i';
    @endphp
    <!-- Header -->
    <div class="header">
        <div class="header-content">
            <div class="business-info">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" alt="Logo" class="business-logo">
                @endif
                <h1>{{ $businessName }}</h1>
                @if(!empty($companyWebsite))
                    <p>{{ $companyWebsite }}</p>
                @endif
                @if($user->email)
                    <p>{{ $user->email }}</p>
                @endif
            </div>
            <div class="proposal-info">
                <h2 style="color: #ffffff !important; font-size: 24px; font-weight: bold; margin: 0 0 8px 0; display: block;">{{ $translations['proposal_heading'] ?? 'PROPOSAL' }}</h2>
                <p><strong>{{ $translations['number_label'] ?? 'Number' }}:</strong> {{ $proposal->proposal_number }}</p>
                <p><strong>{{ $translations['date_label'] ?? 'Date' }}:</strong> {{ $proposal->date->locale($language)->translatedFormat($dateFormat) }}</p>
                @if($proposal->valid_until)
                    <p><strong>{{ $translations['valid_until_label'] ?? 'Valid Until' }}:</strong> {{ $proposal->valid_until->locale($language)->translatedFormat($dateFormat) }}</p>
                @endif
            </div>
        </div>
    </div>

    <div class="container">
        <!-- Proposal Title Section -->
        <div class="proposal-title-section">
            <h3>{{ $proposal->title }}</h3>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">{{ $translations['status_label'] ?? 'Status' }}</span>
                    <span class="detail-value">
                        <span class="status-badge status-{{ $proposal->status }}">
                            {{ $statusLabels[$proposal->status] ?? ucfirst($proposal->status) }}
                        </span>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">{{ $translations['total_amount_label'] ?? 'Total Amount' }}</span>
                    <span class="detail-value total-amount">{{ $user->currency }} {{ number_format($proposal->total_amount, 2) }}</span>
                </div>
            </div>
        </div>
        
        <!-- Client Information -->
        @if($proposal->client)
            <div class="client-section">
                <h4>{{ $translations['client_information_heading'] ?? 'Client Information' }}</h4>
                <p><strong>{{ $proposal->client->name }}</strong></p>
                @if($proposal->client->company)
                    <p>{{ $proposal->client->company }}</p>
                @endif
                @if($proposal->client->email)
                    <p>{{ $translations['email_label'] ?? 'Email' }}: {{ $proposal->client->email }}</p>
                @endif
                @if($proposal->client->phone)
                    <p>{{ $translations['phone_label'] ?? 'Phone' }}: {{ $proposal->client->phone }}</p>
                @endif
                @if($proposal->client->address)
                    <p>{{ $proposal->client->address }}</p>
                @endif
            </div>
        @endif
        
        <!-- Services Table -->
        <div class="services-section">
            <table class="services-table">
                <thead>
                    <tr>
                        <th style="width: 30%;">{{ $translations['service_label'] ?? 'Service' }}</th>
                        <th style="width: 50%;">{{ $translations['description_label'] ?? 'Description' }}</th>
                        <th class="text-right" style="width: 20%;">{{ $translations['amount_label'] ?? 'Amount' }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($proposal->services as $service)
                        @php
                            $serviceAmount = $service['total'] ?? ($service['price'] ?? 0);
                        @endphp
                        <tr>
                            <td><strong>{{ $service['name'] }}</strong></td>
                            <td>{{ $service['description'] ?? '-' }}</td>
                            <td class="text-right"><strong>{{ $user->currency }} {{ number_format($serviceAmount, 2) }}</strong></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="2" class="text-right" style="padding-right: 20px;"><strong>{{ $translations['total_amount_label'] ?? 'Total Amount' }}:</strong></td>
                        <td class="text-right total-amount-cell">{{ $user->currency }} {{ number_format($proposal->total_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <!-- Notes -->
        @if($proposal->notes)
            <div class="notes-section">
                <h4>{{ $translations['notes_heading'] ?? 'Notes' }}</h4>
                <p>{{ $proposal->notes }}</p>
            </div>
        @endif
        
        <!-- Footer -->
        <div class="footer">
            @php
                $generatedOn = now()->locale($language)->translatedFormat($dateTimeFormat);
            @endphp
            <p>{{ str_replace(':datetime', $generatedOn, $translations['footer_generated'] ?? 'This proposal was generated on :datetime') }}</p>
            <p>{{ $translations['footer_contact'] ?? 'For questions or clarifications, please contact us using the information above.' }}</p>
        </div>
    </div>
</body>
</html>
