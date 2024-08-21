<html>

Dear {{json_decode($body)->customer->name}},<br>

Thank you for booking with Autours! Your reservation has been confirmed.<br>

Booking Details:<br>
- Reservation Number: {{json_decode($body)->order_number}}<br>
- Car Model: {{json_decode($body)->vehicle->name}}<br>
- Pickup Date and Time:  {{\Carbon\Carbon::parse(json_decode($body)->start_date)->toDateString()}} {{\Carbon\Carbon::parse(json_decode($body)->start_time)->toTimeString()}}<br>
- Drop-off Date and Time:  {{\Carbon\Carbon::parse(json_decode($body)->end_date)->toDateString()}} {{\Carbon\Carbon::parse(json_decode($body)->end_time)->toTimeString()}}<br>
- Pickup Location: {{json_decode($body)->branch->adresse}}<br>
<br>
If you have any questions or need further assistance, please contact our customer service.<br>

Best regards,<br>
</html>
