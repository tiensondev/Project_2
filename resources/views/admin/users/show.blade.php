@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
<h1>User Details</h1>
<div class="app-content">
  <div class="container-fluid">
    <div class="card mb-4 shadow-sm">
      <div class="card-header bg-light">
        <h3 class="card-title mb-0 fw-bold">Customer Info</h3>
        <div class="card-tools float-end">
          <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to list
          </a>
          <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white">
            <i class="fas fa-edit me-1"></i> Edit
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <div class="col-md-3 text-center mb-4 mb-md-0">
            <div class="mb-3">
              @if($user->avatar)
                <img src="{{ asset('uploads/' . $user->avatar) }}" class="img-thumbnail rounded shadow-sm" width="200" style="object-fit: cover; aspect-ratio: 1/1;">
              @else
                <div class="bg-light d-flex align-items-center justify-content-center rounded border mx-auto shadow-sm" style="width: 200px; height: 200px;">
                  <i class="fas fa-user fa-4x text-muted"></i>
                </div>
              @endif
            </div>
            <h5 class="fw-bold mb-0">{{ $user->name }}</h5>
            <p class="text-muted small">{{ ucfirst($user->role) }}</p>
          </div>

          <div class="col-md-9">
            <table class="table table-bordered table-striped align-middle">
              <tbody>
                <tr>
                  <th width="25%" class="bg-light fw-bold">ID</th>
                  <td>#{{ $user->id }}</td>
                </tr>
                <tr>
                  <th class="bg-light fw-bold">Full Name</th>
                  <td>{{ $user->name }}</td>
                </tr>
                <tr>
                  <th class="bg-light fw-bold">Email</th>
                  <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                </tr>
                <tr>
                  <th class="bg-light fw-bold">Phone</th>
                  <td>{{ $user->phone }}</td>
                </tr>

                <tr>
                  <th class="bg-light fw-bold">Full Address</th>
                  <td>
                    @if($user->province)
                      {{ $user->address_detail }}, {{ $user->ward }}, {{ $user->district }}, {{ $user->province }}
                    @else
                      <span class="text-muted italic">Not updated yet</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="bg-light fw-bold">Role</th>
                  <td>
                    @if($user->role == 'admin')
                      <span class="badge bg-danger">Admin</span>
                    @elseif($user->role == 'manager')
                      <span class="badge bg-warning text-dark">Manager</span>
                    @else
                      <span class="badge bg-success">User</span>
                    @endif
                  </td>
                </tr>
                <tr>
                  <th class="bg-light fw-bold">Created At</th>
                  <td>{{ $user->created_at ? $user->created_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                </tr>
                <tr>
                  <th class="bg-light fw-bold">Updated At</th>
                  <td>{{ $user->updated_at ? $user->updated_at->format('d/m/Y H:i:s') : 'N/A' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection