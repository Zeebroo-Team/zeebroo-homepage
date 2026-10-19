<a class="blog-card reveal" href="{{ route('blog.show', $post->slug) }}">
  <div class="blog-card-art">
    @if ($post->image_url)
      <img src="{{ $post->image_url }}" alt="" loading="lazy">
    @else
      <span class="fi"><i class="fa-solid fa-newspaper"></i></span>
    @endif
  </div>
  <div class="blog-card-meta">
    @if ($post->category)<span class="chip">{{ $post->category->name }}</span>@endif
    <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->format('M j, Y') }}</time>
  </div>
  <b>{{ $post->title }}</b>
  <p>{{ $post->excerpt }}</p>
  <span class="feat-more">Read post <i class="fa-solid fa-arrow-right"></i></span>
</a>
