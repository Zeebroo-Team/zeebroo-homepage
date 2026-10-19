<div class="adm-table-wrap">
  <table class="adm-table">
    <thead><tr><th>Post</th><th>Category</th><th>Author</th><th>Publish date</th><th>Status</th><th></th></tr></thead>
    <tbody>
      @forelse ($blogs as $blog)
        <tr>
          <td>
            <div class="adm-post">
              @if ($blog->image_url)<img src="{{ $blog->image_url }}" alt="">@else<span><i class="fa-solid fa-image"></i></span>@endif
              <div><b>{{ $blog->title }}</b><small><code>/blog/{{ $blog->slug }}</code></small></div>
            </div>
          </td>
          <td>{{ $blog->category?->name ?? '—' }}</td>
          <td>{{ $blog->author_name ?: '—' }}</td>
          <td>{{ $blog->published_at?->format('M j, Y H:i') ?? '—' }}</td>
          <td>
            @if (! $blog->is_active)
              @include('admin.partials.status', ['active' => false])
            @elseif (! $blog->published_at)
              @include('admin.partials.status', ['active' => false, 'label' => 'Draft'])
            @elseif ($blog->published_at->isFuture())
              @include('admin.partials.status', ['active' => false, 'label' => 'Scheduled'])
            @else
              @include('admin.partials.status', ['active' => true, 'label' => 'Published'])
            @endif
          </td>
          <td>@include('admin.partials.actions', [
            'label' => $blog->title,
            'edit' => auth()->user()->can('edit blogs') ? route('admin.blog.posts.edit', $blog) : null,
            'delete' => auth()->user()->can('delete blogs') ? route('admin.blog.posts.destroy', $blog) : null,
          ])</td>
        </tr>
      @empty
        <tr><td colspan="6" class="adm-empty">No posts yet.</td></tr>
      @endforelse
    </tbody>
  </table>
</div>
