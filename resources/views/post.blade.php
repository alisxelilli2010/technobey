@php
    $siteUrl    = rtrim(url('/'), '/');
    $canonical  = route('blog.show', $post->slug);
    $metaTitle  = $post->meta_title ?: ($post->title . ' | Texnobəy');
    $metaDesc   = $post->meta_desc ?: \Illuminate\Support\Str::limit(strip_tags((string) $post->excerpt), 158);
    $shareImage = $post->image ? url($post->image) : asset('og-image.png');
    $shareAlt   = $post->title;
    $ogType     = 'article';

    $articleSchema = array_filter([
        '@context'      => 'https://schema.org',
        '@type'         => 'BlogPosting',
        '@id'           => $canonical . '#article',
        'headline'      => $post->title,
        'description'   => $metaDesc,
        'image'         => $shareImage,
        'url'           => $canonical,
        'inLanguage'    => 'az-AZ',
        'datePublished' => optional($post->published_at)->toAtomString(),
        'dateModified'  => optional($post->updated_at)->toAtomString(),
        'articleSection' => $post->cat_name,
        'wordCount'     => str_word_count(strip_tags((string) $post->body)),
        'author'        => ['@type' => 'Organization', 'name' => 'Texnobəy', '@id' => $siteUrl . '/#store'],
        'publisher'     => ['@id' => $siteUrl . '/#store'],
        'mainEntityOfPage' => ['@type' => 'WebPage', '@id' => $canonical],
    ], fn ($v) => $v !== null && $v !== '');

    $breadcrumb = [
        '@context'        => 'https://schema.org',
        '@type'           => 'BreadcrumbList',
        'itemListElement' => [
            ['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana səhifə', 'item' => $siteUrl],
            ['@type' => 'ListItem', 'position' => 2, 'name' => 'Bloq', 'item' => route('blog.index')],
            ['@type' => 'ListItem', 'position' => 3, 'name' => $post->title, 'item' => $canonical],
        ],
    ];

    $faq = is_array($post->faq) ? array_values(array_filter($post->faq, fn ($f) => !empty($f['q']) && !empty($f['a']))) : [];
    $faqSchema = $faq ? [
        '@context'   => 'https://schema.org',
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn ($f) => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faq),
    ] : null;
@endphp

@extends('layouts.site')

@push('head')
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
<script type="application/ld+json">{!! json_encode($breadcrumb, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@if ($faqSchema)
<script type="application/ld+json">{!! json_encode($faqSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endif
@endpush

@section('content')
<main class="article">
  <nav class="pdp-crumbs" aria-label="Breadcrumb">
    <a href="{{ url('/') }}">Ana səhifə</a>
    <span>/</span>
    <a href="{{ route('blog.index') }}">Bloq</a>
    <span>/</span>
    <span aria-current="page">{{ $post->title }}</span>
  </nav>

  <header class="article-head">
    <div class="article-meta">
      <span class="blog-tag">{{ $post->cat_name }}</span>
      <span>{{ $post->read_min }} dəq oxu</span>
      @if ($post->published_at)
        <time datetime="{{ $post->published_at->toDateString() }}">{{ $post->published_at->translatedFormat('d F Y') }}</time>
      @endif
    </div>
    <h1><span class="article-icon" aria-hidden="true">{{ $post->icon }}</span>{{ $post->title }}</h1>
    @if ($post->excerpt)
      <p class="article-lead">{{ $post->excerpt }}</p>
    @endif
  </header>

  @if ($post->image)
    <figure class="article-cover">
      <img src="{{ $post->image }}" alt="{{ $post->title }}" width="1200" height="675">
    </figure>
  @endif

  <div class="article-body">
    {!! $post->body !!}
  </div>

  @if ($faq)
    <section class="article-faq">
      <h2>Tez-tez verilən suallar</h2>
      @foreach ($faq as $item)
        <details>
          <summary>{{ $item['q'] }}</summary>
          <p>{{ $item['a'] }}</p>
        </details>
      @endforeach
    </section>
  @endif

  <aside class="blog-cta">
    <div>
      <h2>Kömək lazımdır?</h2>
      <p>Diaqnostika pulsuzdur. Cihazınızı gətirin və ya nasazlığı yazın — nə edilməli olduğunu əvvəlcədən deyək.</p>
    </div>
    <div class="blog-cta-actions">
      <a href="{{ url('/') }}#order" class="btn-primary">Sifariş buraxın</a>
      <a href="{{ url('/') }}#products" class="btn-secondary">Məhsullara baxın</a>
    </div>
  </aside>

  @if ($related->isNotEmpty())
    <section class="pdp-related">
      <h2>Digər yazılar</h2>
      <div class="blog-grid blog-grid-3">
        @foreach ($related as $r)
          <article class="blog-card">
            <a href="{{ route('blog.show', $r->slug) }}" class="blog-card-media" tabindex="-1" aria-hidden="true">
              @if ($r->image)
                <img src="{{ $r->image }}" alt="" loading="lazy" width="600" height="338">
              @else
                <div class="blog-card-emoji">{{ $r->icon ?: '📄' }}</div>
              @endif
              <span class="blog-card-icon">{{ $r->icon ?: '📄' }}</span>
            </a>
            <div class="blog-card-body">
              <div class="blog-card-meta">
                <span class="blog-tag">{{ $r->cat_name }}</span>
                <span>{{ $r->read_min }} dəq</span>
              </div>
              <h3><a href="{{ route('blog.show', $r->slug) }}">{{ $r->title }}</a></h3>
            </div>
          </article>
        @endforeach
      </div>
    </section>
  @endif
</main>
@endsection
