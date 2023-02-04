@extends('layout.default')
@section('content')

<main class="signup-form mt-3">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header text-center">Change Password</h3>
                    <div class="card-body">
                        <form action="{{ route('password.update',$user->id) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="password" placeholder="Current Password" id="current-password" class="form-control"
                                    name="current-password" required>
                                @if ($errors->has('current-password'))
                                <span class="text-danger">{{ $errors->first('current-password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="New Password" id="new-password" class="form-control"
                                    name="new-password" required>
                                @if ($errors->has('new-password'))
                                <span class="text-danger">{{ $errors->first('new-password') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <input type="password" placeholder="New Confirm Password" id="new-password-confirm" class="form-control"
                                    name="new-password-confirm" required>
                                @if ($errors->has('new-password-confirm'))
                                <span class="text-danger">{{ $errors->first('new-password-confirm') }}</span>
                                @endif
                            </div>
                            <div class="d-grid mx-auto">
                                <button type="submit" class="btn btn-dark btn-block">Sign up</button>
                            </div>
                        </form>
                        <br>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection