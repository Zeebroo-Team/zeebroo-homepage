{{-- Bell dropdown items. Needs: $notifications (also rendered by Admin\NotificationController@index for polling) --}}
@forelse ($notifications as $notification)
  <a href="{{ route('admin.notifications.show', $notification->id) }}" @class(['adm-bell-item', 'unread' => $notification->unread()])>
    <i class="fa-solid fa-envelope"></i>
    <span>
      <b>New enquiry from {{ $notification->data['name'] }}</b>
      <small>{{ $notification->data['topic'] }} · {{ $notification->created_at->diffForHumans() }}</small>
      <small>{{ $notification->data['excerpt'] }}</small>
    </span>
  </a>
@empty
  <p class="adm-bell-empty">You're all caught up.</p>
@endforelse
