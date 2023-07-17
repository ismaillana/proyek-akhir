@extends('layout.frontend.base')
@section('title')
    Verifikasi Email
@endsection
@section('content')
  <div id="app">
    <section class="section">
        <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">{{ __('Verifikasi Alamat Email Anda') }}</div>
        
                        <div class="card-body">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    {{ __('Link Verifikasi Telah Dikirim Ulang Ke Alamat Email Anda.') }}
                                </div>
                            @endif

                            {{ __('Klik button Verifikasi pada gmail yang telah kami kirim.') }}
                            {{ __('Jika Belum mendapatkan gmail verifikasi klik link dibawah ini atau hubungi admin') }},
                            <br>
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik disini ') }}</button>untuk mengirim ulang gmail verifikasi.
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>
@endsection
