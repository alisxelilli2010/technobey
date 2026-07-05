@extends('errors.layout')

@section('title', 'Həddindən çox sorğu')

@section('content')
  <div class="error-emoji">🐢</div>
  <div class="error-code">429</div>
  <div class="error-title">Bir az yavaş...</div>
  <p class="error-text">
    Qısa müddət ərzində çoxlu sorğu göndərmisiniz. Bir dəqiqə gözləyib
    yenidən cəhd edin.
  </p>
  <div class="error-actions">
    <a href="{{ url('/') }}" class="btn-primary">🏠 Əsas səhifə</a>
  </div>
@endsection
