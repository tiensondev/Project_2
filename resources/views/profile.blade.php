@extends('web-layouts.app') 

@section('title', 'My Profile')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">Account Information</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-light btn-sm fw-bold text-primary">Edit Profile</a> 
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center mb-4 mb-md-0 border-end">
                            <div class="position-relative d-inline-block mb-3">
                                @if($user->avatar)
                                    <img src="{{ asset('uploads/' . $user->avatar) }}" 
                                         class="rounded-circle img-thumbnail shadow-sm" 
                                         width="150" height="150" 
                                         style="object-fit: cover; aspect-ratio: 1/1;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-circle border mx-auto shadow-sm" 
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-secondary"></i>
                                    </div>
                                @endif
                            </div>
                            <h5 class="fw-bold text-dark mb-1">{{ $user->name }}</h5>
                            <span class="badge bg-secondary px-3 py-2 text-uppercase small">{{ $user->role }}</span>
                        </div>

                        <div class="col-md-8">
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0">
                                    <tbody>
                                        <tr>
                                            <th width="35%" class="text-secondary fw-bold"><i class="fas fa-envelope me-2"></i>Email Address</th>
                                            <td class="text-dark">{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary fw-bold"><i class="fas fa-phone me-2"></i>Phone Number</th>
                                            <td class="text-dark">{{ $user->phone ?? 'Not updated yet' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary fw-bold" style="vertical-align: top;"><i class="fas fa-map-marked-alt me-2"></i>Address</th>
                                            <td class="text-dark">
                                                @if($user->province)
                                                    {{ $user->address_detail }}<br>
                                                    <span class="text-muted small">
                                                        {{ $user->ward }}, {{ $user->district }}, {{ $user->province }}
                                                    </span>
                                                @else
                                                    <span class="text-muted small"><em>Not updated yet</em></span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="text-secondary fw-bold"><i class="fas fa-calendar-alt me-2"></i>Joined Date</th>
                                            <td class="text-muted small">
                                                {{ $user->created_at ? $user->created_at->format('d/m/Y') : 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection