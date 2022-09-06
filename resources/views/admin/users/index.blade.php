@extends('admin.layouts.app')
@section('title') @lang('app.users') @endsection
@section('content')
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">@lang('app.users')</h1>
        <div>
            <a class="btn btn-danger btn-sm" href="{{ route('admin.users.index') }}"
               onclick="event.preventDefault(); document.getElementById('userForm').submit();">
                Submit
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-striped">
            <thead>
            <tr class="fw-bold">
                <td>ID</td>
                <td>username</td>
                <td>role</td>
                <td>phone</td>
                <td>also seller</td>
                <td>seller id</td>
            </tr>
            <tr>
                <form action="{{ route('admin.users.index') }}" id="userForm">
                    <td>
                        <input type="text" class="form-control form-control-sm @error('id') is-invalid @enderror" name="id" id="id" value="{{ $id }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('username') is-invalid @enderror" name="username" id="userusername_id" value="{{ $username }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('role') is-invalid @enderror" name="role" id="role" value="{{ $role }}" maxlength="10">
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('phone') is-invalid @enderror" name="phone" id="phone" value="{{ $phone }}" maxlength="10">
                    </td>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="also_seller" id="also_seller" value="1" {{ $also_seller ? 'checked':'' }}>
                            <label class="form-check-label" for="also_seller">
                                also seller
                            </label>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control form-control-sm @error('seller_id') is-invalid @enderror" name="seller_id" id="seller_id" value="{{ $seller_id }}" maxlength="10">
                    </td>
                </form>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->username}}</td>
                    <td>{{ $user->role}}</td>
                    <td>{{ $user->phone}}</td>
                    <td>{{ $user->seller?"yes":"no"}}</td>
                    <td>{{ $user->seller?$user->seller->id:"no id"}}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12">Not found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
    {{ $users->links() }}
@endsection