<?php

namespace Tests\Feature;

use App\Models\Enquiry;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEnquiryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RolePermissionSeeder::class);
    }

    private function userWithRole(string $role): User
    {
        return User::factory()->create()->assignRole($role);
    }

    public function test_admin_enquiry_pages_render(): void
    {
        $enquiry = Enquiry::factory()->create(['business' => 'Corner Café']);
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.dashboard'))->assertOk()->assertSee('Enquiries');
        $this->get(route('admin.enquiries.index'))->assertOk()->assertSee($enquiry->name)->assertSee($enquiry->topic_label);
        $this->get(route('admin.enquiries.show', $enquiry))->assertOk()->assertSee($enquiry->email)->assertSee($enquiry->message);
    }

    public function test_index_filters_by_search_status_and_topic(): void
    {
        $fresh = Enquiry::factory()->create(['name' => 'Fresh Lead', 'topic' => 'demo']);
        $done = Enquiry::factory()->status('resolved')->create(['name' => 'Done Deal', 'topic' => 'sales']);
        $this->actingAs($this->userWithRole('editor'));

        $this->get(route('admin.enquiries.index', ['q' => 'Fresh']))->assertSee('Fresh Lead')->assertDontSee('Done Deal');
        $this->get(route('admin.enquiries.index', ['status' => 'resolved']))->assertSee('Done Deal')->assertDontSee('Fresh Lead');
        $this->get(route('admin.enquiries.index', ['topic' => 'demo']))->assertSee($fresh->name)->assertDontSee($done->name);
    }

    public function test_editor_can_change_status_and_add_notes(): void
    {
        $enquiry = Enquiry::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->from(route('admin.enquiries.show', $enquiry))
            ->patch(route('admin.enquiries.update', $enquiry), ['status' => 'in_progress', 'notes' => 'Called back, demo on Friday.'])
            ->assertRedirect(route('admin.enquiries.show', $enquiry));

        $enquiry->refresh();
        $this->assertSame('in_progress', $enquiry->status);
        $this->assertSame('Called back, demo on Friday.', $enquiry->notes);

        // the inline list dropdown only sends the status and must keep the notes
        $this->patch(route('admin.enquiries.update', $enquiry), ['status' => 'resolved']);

        $enquiry->refresh();
        $this->assertSame('resolved', $enquiry->status);
        $this->assertSame('Called back, demo on Friday.', $enquiry->notes);
    }

    public function test_status_must_be_a_known_value(): void
    {
        $enquiry = Enquiry::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->patch(route('admin.enquiries.update', $enquiry), ['status' => 'archived'])->assertSessionHasErrors('status');

        $this->assertSame(Enquiry::STATUS_NEW, $enquiry->fresh()->status);
    }

    public function test_editor_can_delete_an_enquiry(): void
    {
        $enquiry = Enquiry::factory()->create();
        $this->actingAs($this->userWithRole('editor'));

        $this->delete(route('admin.enquiries.destroy', $enquiry))->assertRedirect(route('admin.enquiries.index'));

        $this->assertModelMissing($enquiry);
    }

    public function test_enquiry_permissions_are_enforced(): void
    {
        $enquiry = Enquiry::factory()->create();
        $this->actingAs($this->userWithRole('author'));

        $this->get(route('admin.enquiries.index'))->assertForbidden();
        $this->get(route('admin.enquiries.show', $enquiry))->assertForbidden();
        $this->patch(route('admin.enquiries.update', $enquiry), ['status' => 'resolved'])->assertForbidden();
        $this->delete(route('admin.enquiries.destroy', $enquiry))->assertForbidden();
    }
}
