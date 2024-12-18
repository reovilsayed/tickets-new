<a href="{{ route('voyager.events.analytics', $event) }}" class="btn btn-custom">Analytics</a>
<a href="{{ route('voyager.events.ticketParticipanReport.analytics', $event) }}" class="btn btn-custom">Participants</a>
<a href="{{ route('voyager.events.salesReport.analytics', $event) }}" class="btn btn-custom">Financial</a>
<a href="{{ route('voyager.events.customer.analytics', $event) }}" class="btn btn-custom">Customer</a>
<a href="{{ route('voyager.events.invites.analytics', $event) }}" class="btn btn-custom">Invites</a>
<a href="{{ route('voyager.events.checkinReport.analytics', $event) }}" class="btn btn-custom">Check In</a>
<a href="{{ route('voyager.orders.index', ['key' => 'event_id', 'filter' => 'equals', 's' => $event]) }}" class="btn btn-custom" target="_blank">Orders</a>
