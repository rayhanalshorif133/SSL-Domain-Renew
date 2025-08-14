<!DOCTYPE html>
<html>
<head>
    <title>Domain Renew Notice</title>
</head>
<body>
   <h2>Domain Renew Notice</h2>
  <table cellpadding="8" cellspacing="0" border="1" style="border-collapse: collapse; width: 100%; font-family: Arial, sans-serif; font-size: 14px; border: 1px solid #ddd;">
    <thead>
        <tr style="background-color: #f8f9fa; text-align: left;">
            <th style="border: 1px solid #ddd; padding: 8px;">Domain Name</th>
            <th style="border: 1px solid #ddd; padding: 8px;">Renewal Date</th>
            <th style="border: 1px solid #ddd; padding: 8px;">Domain Buyer</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="border: 1px solid #ddd; padding: 8px;">{{ $domain->domain_name }}</td>
            <td style="border: 1px solid #ddd; padding: 8px;">{{ \Carbon\Carbon::parse($domain->expiration_date)->format('d M Y') }}</td>
            <td style="border: 1px solid #ddd; padding: 8px;">{{ $domain->domain_buyer }}></td>
        </tr>
    </tbody>
</table>
   <p style="color: red;
    display: block;
    text-align: center;
    margin-top: 2rem;
    font-weight: bold;
    font-size: 1.5rem;"
   >Please renew this domain within the expiration date.</p>
</body>
</html>
