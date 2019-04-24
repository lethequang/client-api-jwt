@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <ul>
                        <li>Email: {{ $currentAuth['email'] }}</li>
                        <li>Full name: {{ $currentAuth['full_name'] }}</li>
                        <li>Phone: {{ $currentAuth['phone'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
