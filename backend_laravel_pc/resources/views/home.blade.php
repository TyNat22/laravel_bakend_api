@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <!-- In your navbar or dashboard view -->
                        @if(Auth::check())
                        @if(Auth::user()->role === 'admin')
                            <!-- Admin content -->
                            <span>{{ Auth::user()->name }}</span>
                            <!-- Other admin-related links -->
                        @elseif(Auth::user()->role === 'customer')
                            <!-- Customer content -->
                            <span>{{ Auth::user()->name }}</span>
                            <!-- Other customer-related links -->
                        @endif
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
