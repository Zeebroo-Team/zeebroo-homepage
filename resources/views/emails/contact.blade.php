<x-mail::message>
# New website enquiry

**{{ $topic }}** from {{ $data['name'] }}

<x-mail::table>
| | |
|:--|:--|
| **Name** | {{ $data['name'] }} |
| **Email** | {{ $data['email'] }} |
| **Phone** | {{ $data['phone'] ?? '-' }} |
| **Business** | {{ $data['business'] ?? '-' }} |
| **Topic** | {{ $topic }} |
</x-mail::table>

**Message**

<x-mail::panel>
{{ $data['message'] }}
</x-mail::panel>

<x-mail::button :url="'mailto:' . $data['email']">
Reply to {{ $data['name'] }}
</x-mail::button>

Sent from the contact form on {{ config('app.url') }}
</x-mail::message>
