@extends('errors.layout')

@section('title', 'Səhifə tapılmadı')

@section('content')
  <div class="error-emoji">🔍</div>
  <div class="error-code">404</div>
  <div class="error-title">Səhifə tapılmadı</div>
  <p class="error-text">
    Axtardığınız səhifə mövcud deyil, silinib və ya köçürülüb.
    Ana səhifədən yenidən başlayın və ya məhsullarımıza baxın.
  </p>
  <div class="error-actions">
    <a href="{{ url('/') }}" class="btn-primary">🏠 Əsas səhifə</a>
    <a href="{{ url('/#products') }}" class="btn-secondary">📦 Məhsullar</a>
    <a href="{{ url('/#contact') }}" class="btn-secondary">📞 Əlaqə</a>
  </div>
@endsection
