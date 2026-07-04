<h2>New Tour Reservation Received</h2>

<p><strong>Tour Slug:</strong> {{ $slug }}</p>

<p><strong>Your Name:</strong> {{ $data['full_name'] }}</p>
<p><strong>Your Email:</strong> {{ $data['email'] }}</p>
<p><strong>Nationality:</strong> {{ $data['nationality'] }}</p>
<p><strong>Contact Number:</strong> {{ $data['phone'] }}</p>
<p><strong>Preferred Arrival Date:</strong> {{ $data['arrival_date'] }}</p>
<p><strong>Departure Date:</strong> {{ $data['departure_date'] }}</p>
<p><strong>Preferred Duration (Days):</strong> {{ $data['duration_days'] }}</p>
<p><strong>No. of Adults:</strong> {{ $data['adults'] }}</p>
<p><strong>No. of Children:</strong> {{ $data['children'] ?? 0 }}</p>
<p><strong>Your Message / Specific Requests:</strong></p>
<p>{{ $data['message'] }}</p>
