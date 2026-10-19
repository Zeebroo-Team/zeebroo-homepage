<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EnquiryRequest;
use App\Models\Enquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;

class EnquiryController extends Controller implements HasMiddleware
{
    /**
     * @return list<Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view enquiries', only: ['index', 'show']),
            new Middleware('permission:edit enquiries', only: ['update']),
            new Middleware('permission:delete enquiries', only: ['destroy']),
        ];
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $status = array_key_exists((string) $request->query('status'), Enquiry::STATUSES) ? $request->query('status') : null;
        $topic = array_key_exists((string) $request->query('topic'), Enquiry::TOPICS) ? $request->query('topic') : null;

        $enquiries = Enquiry::query()
            ->when($search !== '', fn ($q) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('business', 'like', "%{$search}%")))
            ->when($status, fn ($q) => $q->where('status', $status))
            ->when($topic, fn ($q) => $q->where('topic', $topic))
            ->latest()
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        return view('admin.enquiries.index', [
            'enquiries' => $enquiries,
            'search' => $search,
            'status' => $status,
            'topic' => $topic,
        ]);
    }

    public function show(Request $request, Enquiry $enquiry): View
    {
        // opening the enquiry from the list also clears its bell notification
        $request->user()->unreadNotifications()->where('data->enquiry_id', $enquiry->id)->update(['read_at' => now()]);

        return view('admin.enquiries.show', ['enquiry' => $enquiry]);
    }

    public function update(EnquiryRequest $request, Enquiry $enquiry): RedirectResponse
    {
        $enquiry->update($request->validated());

        return back()->with('status', "Enquiry from {$enquiry->name} marked as {$enquiry->status_label}.");
    }

    public function destroy(Enquiry $enquiry): RedirectResponse
    {
        $enquiry->delete();

        return redirect()->route('admin.enquiries.index')->with('status', 'Enquiry deleted.');
    }
}
