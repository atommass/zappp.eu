<p>You have received a new support request from the website:</p>

<p>
<strong>Name:</strong> {{ $data['name'] }}<br>
<strong>Email:</strong> {{ $data['email'] }}
</p>

<hr>

<p>{{ nl2br(e($data['message'])) }}</p>
