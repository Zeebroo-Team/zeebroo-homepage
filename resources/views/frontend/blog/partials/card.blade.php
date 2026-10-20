@php($variant = $variant ?? null)
<a @class(['blog-card', 'reveal', 'lead' => $variant === 'lead', 'mini' => $variant === 'mini']) href="{{ route('blog.show', $post->slug) }}">
  <div class="blog-card-art">
    @if ($post->image_url)
      <img src="{{ $post->image_url }}" alt="" loading="{{ $variant === 'lead' ? 'eager' : 'lazy' }}">
    @else
      <span class="fi"><i class="fa-solid fa-newspaper"></i></span>
    @endif
    @if ($post->category)<span class="chip blog-card-cat">{{ $post->category->name }}</span>@endif
  </div>
  <div class="blog-card-body">
    <div class="blog-card-meta">
      @if ($variant === 'lead')<span class="blog-card-flag"><i class="fa-solid fa-star"></i> Featured</span>@endif
      <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('M j, Y') }}</time>
      <span>{{ $post->reading_minutes }} min read</span>
    </div>
    <b>{{ $post->title }}</b>
    @if ($variant !== 'mini')<p>{{ $post->excerpt }}</p>@endif
    <span class="feat-more">Read post <i class="fa-solid fa-arrow-right"></i></span>
  </div>
</a>
