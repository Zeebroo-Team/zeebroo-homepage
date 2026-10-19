<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use App\Notifications\NewEnquiry;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AdminNotificationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
        Mail::fake();
    }

    private function userWithRole(string $role): User
    {
        return User::factory()->create()->assignRole($role);
    }

    private function submitContactForm(string $name = 'Nimal Perera'): Enquiry
    {
        $this->post(route('contact.store'), [
            'name' => $name,
            'email' => 'nimal@example.com',
            'topic' => 'sales',
            'message' => 'How much is the retail plan per month?',
        ])->assertRedirect(route('contact'));

        return Enquiry::latest('id')->first();
    }

    public function test_new_enquiry_notifies_only_admins_who_can_view_enquiries(): void
    {
        $superAdmin = User::firstWhere('email', 'admin@zeebroo.com');
        $editor = $this->userWithRole('editor');
        $author = $this->userWithRole('author');

        $enquiry = $this->submitContactForm();

        $this->assertCount(1, $superAdmin->unreadNotifications);
        $this->assertCount(1, $editor->unreadNotifications);
        $this->assertCount(0, $author->notifications);

        $notification = $editor->notifications->first();
        $this->assertSame(NewEnquiry::class, $notification->type);
        $this->assertSame($enquiry->id, $notification->data['enquiry_id']);
        $this->assertSame('Pricing and sales', $notification->data['topic']);
    }

    public function test_bell_shows_unread_notifications_in_the_admin_layout(): void
    {
        $editor = $this->userWithRole('editor');
        $this->submitContactForm('Kamal Silva');

        $this->actingAs($editor)->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('New enquiry from Kamal Silva')
            ->assertSee('Mark all as read');
    }

    public function test_feed_returns_unread_count_and_latest_notification(): void
    {
        $editor = $this->userWithRole('editor');
        $this->submitContactForm('First Lead');
        $this->travel(1)->minute();
        $this->submitContactForm('Second Lead');

        $this->actingAs($editor)->getJson(route('admin.notifications.index'))
            ->assertOk()
            ->assertJsonPath('unread', 2)
            ->assertJsonPath('new_enquiries', 2)
            ->assertJsonPath('latest.text', 'New enquiry from Second Lead')
            ->assertJsonPath('latest.topic', 'Pricing and sales');
    }

    public function test_opening_a_notification_marks_it_read_and_shows_the_enquiry(): void
    {
        $editor = $this->userWithRole('editor');
        $enquiry = $this->submitContactForm();
        $notification = $editor->notifications()->first();

        $this->actingAs($editor)->get(route('admin.notifications.show', $notification->id))
            ->assertRedirect(route('admin.enquiries.show', $enquiry));

        $this->assertNotNull($notification->fresh()->read_at);
    }

    public function test_opening_the_enquiry_directly_also_clears_its_notification(): void
    {
        $editor = $this->userWithRole('editor');
        $enquiry = $this->submitContactForm();

        $this->actingAs($editor)->get(route('admin.enquiries.show', $enquiry))->assertOk();

        $this->assertCount(0, $editor->fresh()->unreadNotifications);
    }

    public function test_mark_all_as_read(): void
    {
        $editor = $this->userWithRole('editor');
        $this->submitContactForm('One');
        $this->submitContactForm('Two');

        $this->actingAs($editor)->from(route('admin.dashboard'))
            ->post(route('admin.notifications.read-all'))
            ->assertRedirect(route('admin.dashboard'));

        $this->assertCount(0, $editor->fresh()->unreadNotifications);
    }

    public function test_admins_cannot_open_someone_elses_notification(): void
    {
        $editor = $this->userWithRole('editor');
        $otherEditor = $this->userWithRole('editor');
        $this->submitContactForm();
        $notification = $editor->notifications()->first();

        $this->actingAs($otherEditor)->get(route('admin.notifications.show', $notification->id))->assertNotFound();

        $this->assertNull($notification->fresh()->read_at);
    }
}
