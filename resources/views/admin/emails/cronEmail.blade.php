<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
  @foreach($singleContractor as $jobcards)
  @if($jobcards->status == '1')
      <h2>Captured Claims</h2>
      @php break; @endphp
    @elseif($jobcards->status == '2')
      <h2>Approved Claims</h2>
      @php break; @endphp

    @elseif($jobcards->status == '6')
     <h2>Vetted Claims</h2>
      @php break; @endphp
    @endif
  @endforeach
<div>
    
    @foreach($singleContractor as $jobcards)
    @if($jobcards->status == '1')
      This is an acknowledgement of the receipt of your claims submitted to Sakhiwo. The attached claims have been recorded as received and are in the process of being prepared for vetting. Should you have any queries please send an email to the following email  ecdoh.queries@gmail.com
  			<br>
        @php break; @endphp
  	@elseif($jobcards->status == '2')
      This serves to notify you that the attached claims have been checked at Sakhiwo and approved as correct and will be sent for vetting to the next available vetting session. Should you have any queries please send an email to the following email  ecdoh.queries@gmail.com
		<br>
    @php break; @endphp
  	@elseif($jobcards->status == '6')
  	This serves to notify you that the attached claims were vetted by the department and you have not yet invoiced them. You will now need to do an invoice per district (not per sub-district) for
    the quotations which were approved. Make sure that the date on the invoice
    is the date on which you send the invoice. You may receive multiple pages for one district, you are welcome to combine them when you do the invoice.

    Your invoices are supposed to be submitted within 2 working days  after vetting ensure VAT is charged at 15%. Should you have any queries please send an email to the following email  ecdoh.queries@gmail.com. Please note that you will continue receiving this email everyday until you invoice.

		<br>
    @php break; @endphp
  	@endif
    @endforeach
</div>

</body>
</html>