<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>✅ Payment Successful!</h2>
<p>Transaction ID: {{ $trx['trxID'] ?? '' }}</p>
<p>Amount: {{ $trx['amount'] ?? '' }}</p>
</body>
</html>
