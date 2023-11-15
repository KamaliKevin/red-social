@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Manage your profile</div>
                    <div class="card-body">
                        <form method="POST" action="/profile/store" id="updateImage" enctype="multipart/form-data">
                            @csrf
                            <div class="row mb-3">
                                <label for="imageUpload" class="col-md-4 col-form-label text-md-end">
                                    Use a profile image:
                                </label>
                                <div class="col-md-6">
                                    @if($user->profile->imageUpload)
                                        <img src="{{ asset(Str::replace("public/", "storage/", $user->profile->imageUpload)) }}"
                                             class="mb-3" alt="User Image">
                                    @else
                                        <p>No image available</p>
                                    @endif
                                    <input type="file" id="imageUpload" name="imageUpload"
                                           class="form-control @error('imageUpload') is-invalid @enderror"
                                           value="{{ old('imageUpload') }}" autofocus>

                                    @error('imageUpload')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update profile
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
