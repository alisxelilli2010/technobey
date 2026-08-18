@php
    $siteUrl   = rtrim(url('/'), '/');
    $canonical = route('blog.index');
    $metaTitle = 'Bloq – kompüter, printer və proyektor üzrə məsləhətlər | Texnobəy';
    $metaDesc  = 'Kompüter, noutbuk, printer və proyektorların təmiri və seçimi üzrə praktik bələdçilər. Texnobəy servis mərkəzinin təcrübəsindən yazılmış məqalələr.';
    $shareImage = asset('og-image.png');
    $shareAlt   = 'Texnobəy bloqu';

    $blogSchema = [
        '@context' => 'https://schema.org',
        '@type'    => 'Blog',
        '@id'      => $canonical . '#blog',
        'name'     => 'Texnobəy Bloqu',
        'url'      => $canonical,
        'inLanguage' => 'az-AZ',
        'publisher'  => ['@id' => $siteUrl . '/#store'],
        'blogPost'   => $posts->map(fn ($p) => [
            '@type'         => 'BlogPosting',
            'headline'      => $p->title,
            'url'           => route('blog.show', $p->slug),
            'datePublished' => optional($p->published_at)->toAtomString(),
            'image'         => $p->image ? url($p->image) : $shareImage,
        ])->all(),
    ];
@endphp

@extends('layouts.site')

@push('head')
<script type="application/ld+json">{!! json_encode($blogSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endpush

@section('content')
<main class="blog">
  <header class="blog-head">
    <div class="eyebrow">Bloq</div>
    <h1>Texnika haqqında bildiklərimizi paylaşırıq</h1>
    <p>Servis masamızda gördüklərimiz və müştərilərimizin ən çox verdiyi suallar. Nasazlığı özünüz tanımaq, cihazı düzgün seçmək və onu daha uzun işlətmək üçün praktik bələdçilər.</p>
  </header>

  <nav class="blog-filter" aria-label="Bloq kateqoriyaları">
    <a href="{{ route('blog.index') }}" class="filter-btn{{ $activeCat ? '' : ' active' }}">Hamısı</a>
    @foreach (\App\Models\Post::CATS as $key => $label)
      <a href="{{ route('blog.index', ['kateqoriya' => $key]) }}" class="filter-btn{{ $activeCat === $key ? ' active' : '' }}">{{ $label }}</a>
    @endforeach
  </nav>

  @if ($posts->isEmpty())
    <p class="blog-empty">Bu kateqoriyada hələ yazı yoxdur.</p>
  @else
    <div class="blog-grid">
      @foreach ($posts as $post)
        <article class="blog-card">
          <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-media" tabindex="-1" aria-hidden="true">
            @if ($post->image)
              <img src="{{ $post->image }}" alt="" loading="lazy" width="600" height="338">
            @else
              <div class="blog-card-emoji">{{ $post->icon ?: '📄' }}</div>
            @endif
            <span class="blog-card-icon">{{ $post->icon ?: '📄' }}</span>
          </a>
          <div class="blog-card-body">
            <div class="blog-card-meta">
              <span class="blog-tag">{{ $post->cat_name }}</span>
              <span>{{ $post->read_min }} dəq oxu</span>
            </div>
            <h2><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h2>
            <p>{{ $post->excerpt }}</p>
            <a href="{{ route('blog.show', $post->slug) }}" class="blog-more">Oxu <span aria-hidden="true">→</span></a>
          </div>
        </article>
      @endforeach
    </div>
  @endif

  <aside class="blog-cta">
    <div>
      <h2>Cihazınızla bağlı sualınız var?</h2>
      <p>Diaqnostika pulsuzdur. Nasazlığı təsvir edin, nə edilməli olduğunu və nə qədər tutacağını əvvəlcədən deyək.</p>
    </div>
    <a href="{{ url('/') }}#order" class="btn-primary">Bizə yazın</a>
  </aside>
</main>
@endsection
