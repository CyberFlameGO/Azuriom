@extends('admin.layouts.admin')

@section('title', $user->name)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @method('PATCH')
                        @csrf

                        <div class="form-group">
                            <label for="nameInput">Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="nameInput" name="name" value="{{ old('name', $user->name) }}" required>

                            @error('name')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="emailInput">E-Mail Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="emailInput" name="email" value="{{ old('email', $user->email) }}" required>

                            @error('email')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="passwordInput">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="passwordInput" name="password">

                            @error('password')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="roleSelect">Role</label>
                            <select class="custom-select @error('role') is-invalid @enderror" id="roleSelect" name="role">
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}" @if($user->role_id === $role->id) selected @endif>{{ $role->name }}</option>
                                @endforeach
                            </select>

                            @error('role')
                            <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="registerInput">Register at</label>
                        <input type="text" class="form-control" id="registerInput" value="{{ $user->created_at }}" disabled>
                    </div>

                    <form action="{{ route('admin.users.verify', $user) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="emailVerifiedInput">Email verified</label>

                            @if($user->hasVerifiedEmail())
                                <input type="text" class="form-control text-success" id="emailVerifiedInput" value="Yes" disabled>
                            @else
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control text-danger" id="emailVerifiedInput" value="No" disabled>

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-success" type="submit">Verify email</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>

                    <form action="{{ route('admin.users.2fa', $user) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="2faInput">Two Factor Auth verification</label>

                            @if(! $user->hasTwoFactorAuth())
                                <input type="text" class="form-control text-danger" id="2faInput" value="No" disabled>
                            @else
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control text-success" id="2faInput" value="Yes" disabled>

                                    <div class="input-group-append">
                                        <button class="btn btn-outline-danger" type="submit">Disable 2fa</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </form>

                    <div class="form-group">
                        <label for="registerInput">Address</label>
                        <input type="text" class="form-control" id="registerInput" value="{{ empty($user->last_ip) ? 'Unknown' : $user->last_ip }}" disabled>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
