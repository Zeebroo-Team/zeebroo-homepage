<?php

namespace App\Notifications;

use App\Models\Enquiry;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

/**
 * Bell notification in the admin top bar for every contact form message.
 */
class NewEnquiry extends Notification
{
    use Queueable;

    public function __construct(public Enquiry $enquiry) {}

    /**
     * Every admin user who is allowed to read enquiries (super-admins included).
     *
     * @return Collection<int, User>
     */
    public static function recipients(): Collection
    {
        return User::all()->filter(fn (User $user): bool => $user->can('view enquiries'))->values();
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array{enquiry_id: int, name: string, topic: string, excerpt: string}
     */
    public function toArray(object $notifiable): array
    {
        return [
            'enquiry_id' => $this->enquiry->id,
            'name' => $this->enquiry->name,
            'topic' => $this->enquiry->topic_label,
            'excerpt' => Str::limit($this->enquiry->message, 90),
        ];
    }
}
