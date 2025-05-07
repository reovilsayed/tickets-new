@extends('layouts.app')

@section('title', 'Delete Account')

@section('css')
    <style>
        p,
        ul,
        li {
            color: white !important;
        }
    </style>
@endsection

@section('content')
    <div class="container py-5">
        <h1 class="mb-4 text-danger">Delete Account</h1>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <p class="mb-4">Warning: Deleting your account is permanent and cannot be undone.</p>

        <form method="POST" action="{{ route('account.delete') }}">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label for="password" class="form-label">Confirm Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-danger">Permanently Delete My Account</button>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
