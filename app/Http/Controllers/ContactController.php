<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public const TOPICS = [
        'demo'        => 'Book a demo',
        'sales'       => 'Pricing and sales',
        'support'     => 'Help with my account',
        'partnership' => 'Partnership',
        'other'       => 'Something else',
    ];

    public function index(): View
    {
        return view('frontend.contact.index', ['topics' => self::TOPICS]);
    }

    // POST /contact — validate, then email the team (the message is also logged so nothing is lost if mail fails)
    public function store(Request $request): RedirectResponse
    {
        // honeypot: real visitors never see or fill this field
        if (filled($request->input('website'))) {
            return redirect()->route('contact')->with('contact_sent', true);
        }

        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'email', 'max:150'],
            'phone'    => ['nullable', 'string', 'max:30'],
            'business' => ['nullable', 'string', 'max:150'],
            'topic'    => ['required', 'in:' . implode(',', array_keys(self::TOPICS))],
            'message'  => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        $topic = self::TOPICS[$data['topic']];
        Log::info('Contact form message', $data);

        try {
            Mail::to(config('services.contact.to'))->send(new ContactMessage($data, $topic));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('contact')->with('contact_sent', true);
    }
}
