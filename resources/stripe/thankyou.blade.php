<!DOCTYPE html>
<html>
<head>
	<title>Thankyou</title>
</head>
<body>
	<h1>Your Payment was successFull</h1>
	<br>
	<span>Transaction Id : <strong>{{$stripe->transactionId}}</strong></span><br>
	<span>Amount Charged : Rs.<strong>{{$stripe->amount}} </strong></span>
</body>
</html>