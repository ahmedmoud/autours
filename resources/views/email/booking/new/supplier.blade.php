<html>
Dear {{json_decode($body)->supplier->name}} !,<br>

We hope this message finds you well. We would like to inform you of a new booking request that requires your immediate<br>
attention. Below are the details of the booking:<br>

Booking Details:<br>

Reservation Number: {{json_decode($body)->order_number}}<br>
Customer's Name: {{json_decode($body)->customer->name}}<br>
Pick-Up Date & Time: {{\Carbon\Carbon::parse(json_decode($body)->start_date)->toDateString()}} {{\Carbon\Carbon::parse(json_decode($body)->start_time)->toTimeString()}}<br>
Return Date & Time: {{\Carbon\Carbon::parse(json_decode($body)->end_date)->toDateString()}} {{\Carbon\Carbon::parse(json_decode($body)->end_time)->toTimeString()}}<br>
Pick-Up Location: {{json_decode($body)->branch->adresse}}<br>
Car Model: {{json_decode($body)->vehicle->name}}<br>
Action Required:<br>

Please confirm the availability of the requested vehicle and provide any necessary details or documentation required to<br>
fulfill this booking. We kindly request your confirmation by 12 hours to ensure smooth processing and customer<br>
satisfaction.<br>

Should you have any questions or need further information, do not hesitate to contact us at admin@autours.net or 122263.<br>

We appreciate your prompt attention to this booking and look forward to your confirmation.<br>

Best regards,<br>

Autours Team<br>
</html>
