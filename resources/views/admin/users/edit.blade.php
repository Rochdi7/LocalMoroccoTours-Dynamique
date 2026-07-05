@extends('layouts.main')

@section('title', 'Edit User')
@section('breadcrumb-item', 'Users')
@section('breadcrumb-item-active', 'Edit User')
@section('page-animation', 'animate__rollIn')

@section('css')
    <link rel="stylesheet" href="{{ asset('build/css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('build/css/plugins/animate.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">

        @if ($errors->any())
            <div class="alert alert-danger animate__animated animate__shakeX">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div id="user-form-card" class="card animate__animated animate__rollIn">
                <div class="card-header">
                    <h5>Edit User</h5>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name', $user->name) }}" required>
                                <div class="invalid-feedback">
                                    @error('name') {{ $message }} @else Please enter a name. @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $user->email) }}" required>
                                <div class="invalid-feedback">
                                    @error('email') {{ $message }} @else Please enter a valid email. @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password <span class="text-muted">(leave blank to keep current)</span></label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                       minlength="8">
                                <div class="invalid-feedback">
                                    @error('password') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                       class="form-control" minlength="8">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="mb-0">
                                <label for="phone" class="form-label">Phone <span class="text-muted">(optional)</span></label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone', $user->phone) }}">
                                <div class="invalid-feedback">
                                    @error('phone') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary"
                       onclick="rollOutCard(event, this, 'user-form-card')">Cancel</a>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Bootstrap validation
    (function () {
        'use strict';
        window.addEventListener('load', function () {
            const forms = document.getElementsByClassName('needs-validation');
            Array.prototype.forEach.call(forms, function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    function rollOutCard(event, link, cardId = 'user-form-card') {
        event.preventDefault();
        const card = document.getElementById(cardId);
        if (!card) return;
        card.classList.remove('animate__rollIn');
        card.classList.add('animate__animated', 'animate__rollOut');
        setTimeout(() => {
            window.location.href = link.href;
        }, 1000);
    }
</script>
@endsection
