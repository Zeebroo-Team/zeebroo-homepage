<?php

namespace Tests\Feature;

use App\Mail\ContactMessage;
use App\Models\Enquiry;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactPageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array<string, string>
     */
    private function validPayload(): array
    {
        return [
            'name' => 'Nimal Perera',
            'email' => 'nimal@example.com',
            'phone' => '+94 77 123 4567',
            'business' => 'Corner Café',
            'topic' => 'demo',
            'message' => 'I would like to see the POS running in a café.',
        ];
    }

    public function test_contact_page_renders_the_topics(): void
    {
        $this->get(route('contact'))->assertOk()->assertSee('Book a demo')->assertSee('Partnership');
    }

    public function test_submitting_the_form_saves_a_new_enquiry_and_emails_the_team(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), $this->validPayload())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('contact_sent', true);

        $enquiry = Enquiry::sole();
        $this->assertSame('Nimal Perera', $enquiry->name);
        $this->assertSame('Corner Café', $enquiry->business);
        $this->assertSame('Book a demo', $enquiry->topic_label);
        $this->assertSame(Enquiry::STATUS_NEW, $enquiry->status);
        $this->assertNotNull($enquiry->ip_address);
        Mail::assertSent(ContactMessage::class, fn (ContactMessage $mail): bool => $mail->topic === 'Book a demo');
    }

    public function test_enquiry_is_saved_even_when_mail_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $this->post(route('contact.store'), $this->validPayload())->assertRedirect(route('contact'));

        $this->assertDatabaseCount('enquiries', 1);
    }

    public function test_honeypot_submissions_are_not_saved(): void
    {
        Mail::fake();

        $this->post(route('contact.store'), [...$this->validPayload(), 'website' => 'http://spam.test'])
            ->assertRedirect(route('contact'));

        $this->assertDatabaseCount('enquiries', 0);
        Mail::assertNothingSent();
    }

    public function test_invalid_submissions_are_rejected(): void
    {
        $this->post(route('contact.store'), ['name' => '', 'email' => 'nope', 'topic' => 'pizza', 'message' => 'short'])
            ->assertSessionHasErrors(['name', 'email', 'topic', 'message']);

        $this->assertDatabaseCount('enquiries', 0);
    }
}
