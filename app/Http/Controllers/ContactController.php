<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use App\Models\Enquiry;
use App\Notifications\NewEnquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        return view('frontend.contact.index', ['topics' => Enquiry::TOPICS]);
    }

    // POST /contact — validate, save the enquiry for /admin/enquiries, then email the team (a mail failure never loses the message)
    public function store(Request $request): RedirectResponse
    {
        // honeypot: real visitors never see or fill this field
        if (filled($request->input('website'))) {
            return redirect()->route('contact')->with('contact_sent', true);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:150'],
            'phone' => ['nullable', 'string', 'max:30'],
            'business' => ['nullable', 'string', 'max:150'],
            'topic' => ['required', 'in:'.implode(',', array_keys(Enquiry::TOPICS))],
            'message' => ['required', 'string', 'min:10', 'max:3000'],
        ]);

        $enquiry = Enquiry::create([...$data, 'ip_address' => $request->ip()]);

        Notification::send(NewEnquiry::recipients(), new NewEnquiry($enquiry));

        try {
            Mail::to(config('services.contact.to'))->send(new ContactMessage($data, $enquiry->topic_label));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('contact')->with('contact_sent', true);
    }
}
