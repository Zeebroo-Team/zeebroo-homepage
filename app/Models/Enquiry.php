<?php

namespace App\Models;

use Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * One message sent through the /contact form. Admins read it in
 * /admin/enquiries and move it through the statuses below.
 */
#[Fillable([
    'name', 'email', 'phone', 'business', 'topic', 'message', 'status', 'notes', 'ip_address',
])]
class Enquiry extends Model
{
    /** @use HasFactory<EnquiryFactory> */
    use HasFactory;

    /**
     * What the visitor picked under "How can we help?".
     *
     * @var array<string, string>
     */
    public const TOPICS = [
        'demo' => 'Book a demo',
        'sales' => 'Pricing and sales',
        'support' => 'Help with my account',
        'partnership' => 'Partnership',
        'other' => 'Something else',
    ];

    /**
     * Where the team is with the enquiry. Every new one starts as "new".
     *
     * @var array<string, string>
     */
    public const STATUSES = [
        'new' => 'New',
        'in_progress' => 'In progress',
        'resolved' => 'Resolved',
        'spam' => 'Spam',
    ];

    public const STATUS_NEW = 'new';

    /**
     * @param  Builder<self>  $query
     */
    public function scopeUnread(Builder $query): void
    {
        $query->where('status', self::STATUS_NEW);
    }

    protected function topicLabel(): Attribute
    {
        return Attribute::get(fn (): string => self::TOPICS[$this->topic] ?? $this->topic);
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn (): string => self::STATUSES[$this->status] ?? $this->status);
    }
}
