@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<h1>Edit User</h1>
<div class="app-content">
  <div class="container-fluid">
    <div class="card mb-4">
      <div class="card-header">
        <h3 class="card-title">Edit User</h3>
      </div>
      <div class="card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
          <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name *</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email *</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Phone *</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="role" class="form-label fw-bold">Role *</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                  <option value="">Select Role</option>
                  <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                  <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                  <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="card bg-light mb-3 border-0">
            <div class="card-body p-3">
              <h6 class="fw-bold text-secondary mb-2"><i class="fas fa-map-marker-alt me-1"></i> Shipping Address Information</h6>
              
              {{-- Hiện địa chỉ cũ giúp admin dễ quản lý --}}
              @if($user->province)
              <div class="alert alert-info py-2 small mb-3">
                <strong>Current Saved Address:</strong> {{ $user->address_detail }}, {{ $user->ward }}, {{ $user->district }}, {{ $user->province }}
              </div>
              @endif

              <div class="row">
                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="province" class="form-label fw-bold small text-muted">Province / City *</label>
                    <select class="form-select @error('province') is-invalid @enderror" id="province" name="province" required>
                      <option value="">-- Select Province --</option>
                    </select>
                    @error('province')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="district" class="form-label fw-bold small text-muted">District *</label>
                    <select class="form-select @error('district') is-invalid @enderror" id="district" name="district" required disabled>
                      <option value="">-- Select District --</option>
                    </select>
                    @error('district')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="mb-3">
                    <label for="ward" class="form-label fw-bold small text-muted">Ward / Commune *</label>
                    <select class="form-select @error('ward') is-invalid @enderror" id="ward" name="ward" required disabled>
                      <option value="">-- Select Ward --</option>
                    </select>
                    @error('ward')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                  </div>
                </div>
              </div>

              <div class="mb-0">
                <label for="address_detail" class="form-label fw-bold small text-muted">Specific Address Detail *</label>
                <input type="text" class="form-control @error('address_detail') is-invalid @enderror" id="address_detail" name="address_detail" value="{{ old('address_detail', $user->address_detail) }}" placeholder="House number, street name..." required>
                @error('address_detail')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password (Leave blank if no change)</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
              </div>
            </div>
          </div>

          <div class="mb-4">
            <label for="avatar" class="form-label fw-bold">User Image</label>
            <input type="file" name="avatar" class="form-control @error('avatar') is-invalid @enderror" id="avatar" onchange="previewImage(event)">
            @error('avatar')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="mt-2">
              @if($user->avatar)
              <img id="preview" src="{{ asset('uploads/' . $user->avatar) }}" width="150" class="img-thumbnail" />
              @else
              <img id="preview" width="150" style="display: none;" class="img-thumbnail" />
              @endif
            </div>
          </div>

          <div class="d-flex justify-content-between">
            <button type="submit" class="btn btn-primary fw-bold px-4">Update User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('preview');

    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(input.files[0]);
    } else {
      preview.src = '';
      preview.style.display = 'none';
    }
  }

  document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    axios.get('https://provinces.open-api.vn/api/p/')
      .then(response => {
        response.data.forEach(province => {
          let option = new Option(province.name, province.name);
          option.dataset.code = province.code;
          provinceSelect.add(option);
        });
      })
      .catch(error => console.error('Error fetching provinces:', error));

    provinceSelect.addEventListener('change', function () {
      districtSelect.innerHTML = '<option value="">-- Select District --</option>';
      wardSelect.innerHTML = '<option value="">-- Select Ward --</option>';
      districtSelect.disabled = true;
      wardSelect.disabled = true;

      const selectedOption = this.options[this.selectedIndex];
      const provinceCode = selectedOption.dataset.code;

      if (provinceCode) {
        axios.get(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
          .then(response => {
            response.data.districts.forEach(district => {
              let option = new Option(district.name, district.name);
              option.dataset.code = district.code;
              districtSelect.add(option);
            });
            districtSelect.disabled = false;
          })
          .catch(error => console.error('Error fetching districts:', error));
      }
    });

    districtSelect.addEventListener('change', function () {
      wardSelect.innerHTML = '<option value="">-- Select Ward --</option>';
      wardSelect.disabled = true;

      const selectedOption = this.options[this.selectedIndex];
      const districtCode = selectedOption.dataset.code;

      if (districtCode) {
        axios.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
          .then(response => {
            response.data.wards.forEach(ward => {
              wardSelect.add(new Option(ward.name, ward.name));
            });
            wardSelect.disabled = false;
          })
          .catch(error => console.error('Error fetching wards:', error));
      }
    });
  });
</script>
@endsection