@extends('errors.layout')

@section('title', 'Sessiya vaxtı bitdi')

@section('content')
  <div class="error-emoji">⏱️</div>
  <div class="error-code">419</div>
  <div class="error-title">Sessiya vaxtı bitdi</div>
  <p class="error-text">
    Səhifə açıq qaldığı üçün təhlükəsizlik məqsədilə sessiyanız yeniləndi.
    Səhifəni yeniləyin və yenidən cəhd edin.
  </p>
  <div class="error-actions">
    <button type="button" onclick="location.reload()" class="btn-primary">🔄 Səhifəni yenilə</button>
    <a href="{{ url('/') }}" class="btn-secondary">🏠 Əsas səhifə</a>
  </div>
@endsection
