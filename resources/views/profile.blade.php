@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Profile</div>
                <div class="card-body">
                    <ul>
                        <li>Email: {{ $user['email'] }}</li>
                        <li>Full name: {{ $user['full_name'] }}</li>
                        <li>Phone: {{ $user['phone'] }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
