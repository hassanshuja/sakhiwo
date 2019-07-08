<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>

<h3>Hello {{$name}}</h3>
<h2>Quotes Status : {!! $type !!}</h2>


<div>
    @if($status == '3')
    Please note that your claim for job card number {{$job_card_number}} has been rejected in the pre-vetting checks for the following reason {{$reason}} please correct the claim and send back to ecdoh.queries@gmail.com
  			<br>
    @elseif($status == '4')
    Please note that your claim for job card number {{$job_card_number}} has been rejected at vetting for the following reason {{$reason}} please correct the claim and send back to ecdoh.queries@gmail.com
    <br>
  	@elseif($status == '5')
    This is a notification that we have received your corrections for job card number {{$job_card_number}} and your corrections have been accepted. The corrections will be sent to the next available vetting session.
		<br>
  	@else
  	Your Quotes Status for Job card Nos is {{$type}}
		<br>
  	@endif
</div>

</body>
</html>