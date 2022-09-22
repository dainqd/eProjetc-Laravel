@extends('layouts.master')
@section('main')
    <div id="app">
        @include('layouts.components.sidebar')
        <div id="main" class='layout-navbar'>
            @include('layouts.components.header')
            <div id="main-content" style="max-width: {{ $card_width ?? '1000px' }}; margin: 0 auto;">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 order-md-1 order-last mb-3">
                                <h3>
                                    @if(isset($back_href))
                                        <a href="{{ $back_href }}" style="margin-right: 10px; vertical-align: middle;">
                                            <i class="bi bi-arrow-left"></i>
                                        </a>
                                    @endif
                                    @if(!isset($hide_title) || !$hide_title)
                                        @yield('title')
                                    @endif
                                    @if(isset($create_href))
                                        <a href="{{ $create_href }}" class="btn btn-primary" style="margin-left: 10px;">
                                            {{ $create_label ?? 'Create' }}
                                        </a>
                                    @endif
                                </h3>
                                @hasSection('subtitle')
                                    <p class="text-subtitle text-muted">
                                        @yield('subtitle')
                                    </p>
                                @endif
                            </div>
                        </div>
                        <x-alert type="success" key="success"/>
                        <x-alert type="info" key="message"/>
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible show fade">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                            </div>
                        @else
                            <x-alert type="danger" key="error"/>
                        @endif
                    </div>
                    <section>
                        @yield('content')
                    </section>
                </div>
                @include('layouts.components.footer')
            </div>
        </div>
    </div>
@endsection
