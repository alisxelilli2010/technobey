@extends('errors.layout')

@section('title', 'Xidmət hazırda əlçatan deyil')

@section('content')
  <div class="error-emoji">🚧</div>
  <div class="error-code">503</div>
  <div class="error-title">Texniki xidmət</div>
  <p class="error-text">
    Sayt qısa müddət ərzində texniki xidmət modundadır.
    Tezliklə geri qayıdacağıq — səbriniz üçün təşəkkür edirik.
  </p>
  <div class="error-actions">
    <a href="{{ url('/') }}" class="btn-primary">🔄 Yenidən yüklə</a>
  </div>
@endsection
