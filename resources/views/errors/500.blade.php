@extends('errors.layout')

@section('title', 'Server xətası')

@section('content')
  <div class="error-emoji">⚙️</div>
  <div class="error-code">500</div>
  <div class="error-title">Server xətası</div>
  <p class="error-text">
    Nə isə yaxşı getmədi. Komandamız artıq xəbərdar oldu və problemi həll edir.
    Bir neçə dəqiqədən sonra yenidən cəhd edin.
  </p>
  <div class="error-actions">
    <a href="{{ url('/') }}" class="btn-primary">🏠 Əsas səhifə</a>
    <a href="{{ url('/#contact') }}" class="btn-secondary">📞 Bizə xəbər ver</a>
  </div>
@endsection
