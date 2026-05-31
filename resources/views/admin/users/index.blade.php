@extends('admin.layouts.app')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">User List</h1>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add User
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.users.search') }}" method="GET">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="small mb-1">Role</label>
                        <select name="role" class="form-select">
                            <option value="">All Roles</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="manager" {{ request('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="small mb-1">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Search name..." value="{{ request('name') }}">
                    </div>
                    <div class="col-md-4">
                        <label class="small mb-1">Email</label>
                        <input type="text" name="email" class="form-control" placeholder="Search email..." value="{{ request('email') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">ID</th>
                            <th>Avatar</th>
                            <th>Name</th>
                            <th>Contact</th>
                            <th>Address</th>
                            <th>Role</th>
                            <th width="15%" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr>
                            <td>#{{ $user->id }}</td>
                            <td>
                                @if($user->avatar)
                                <img src="{{ asset('uploads/' . $user->avatar) }}"
                                    class="rounded border"
                                    width="60"
                                    height="60"
                                    style="object-fit: cover;">
                                @else
                                <div class="bg-light d-flex align-items-center justify-content-center rounded border"
                                    style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $user->name }}</strong><br>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>{{ $user->phone }}</td>

                            <td>
                                @if($user->province)
                                @php
                                $fullAddress = "{$user->address_detail}, {$user->ward}, {$user->district}, {$user->province}";
                                @endphp {{-- <-- Đã đổi thành @endphp --}}
                                <span title="{{ $fullAddress }}">{{ Str::limit($fullAddress, 100) }}</span>
                                @else
                                <span class="text-muted small"><em>Not updated yet</em></span>
                                @endif
                            </td>
                            <td>
                                @if($user->role == 'admin')
                                <span class="badge bg-danger">Admin</span>
                                @elseif($user->role == 'manager')
                                <span class="badge bg-warning text-dark">Manager</span>
                                @else
                                <span class="badge bg-success">User</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm text-white">View</a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm text-white">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if(method_exists($users, 'links'))
        <div class="card-footer bg-white">
            <div class="float-end">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection