<html>

Dear {{json_decode($body)->customer->name}},<br>

Thank you for booking with Autours! Your reservation has been confirmed.<br>

Booking Details:<br>
• Reservation Number: {{json_decode($body)->order_number}}<br>
• Car Model: {{json_decode($body)->vehicle->name}}<br>
• Pickup Date and Time:  {{\Carbon\Carbon::parse(json_decode($body)->start_date)->toDateString()}} {{\Carbon\Carbon::parse(json_decode($body)->start_time)->toTimeString()}}<br>
• Drop-off Date and Time:  {{\Carbon\Carbon::parse(json_decode($body)->end_date)->toDateString()}} {{\Carbon\Carbon::parse(json_decode($body)->end_time)->toTimeString()}}<br>
• Pickup Location: {{json_decode($body)->branch->adresse}}<br>
• Address: {{json_decode($body)->branch->adresse}}<br>
• Rental Duration:  {{\Carbon\Carbon::parse(json_decode($body)->start_date)->diffInDays(\Carbon\Carbon::parse(json_decode($body)->end_date)) }}<br>
• Supplier Name:  {{json_decode($body)->supplier->name}}<br>
• Amount :  {{json_decode($body)->supplier_price +  ( json_decode($body)->supplier_price * (json_decode($body)->profit / 100) )  }}<br>
<br>
If you have any questions or need further assistance, please contact our customer service.<br>
Important Information:<br>
• Car Model Notice: The car model you have booked is subject to availability. You may receive a similar vehicle based on the supplier’s fleet at the time of pickup.
Should you have any questions or require further assistance, please feel free to contact our customer service.<br>
Best regards,<br><br>
Autours Team<br><br>
</html>
