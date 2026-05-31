@extends('admin.layouts.app')

@section('title', 'Create User')

@section('content')
<h1>Create User</h1>
<div class="app-content">
  <div class="container-fluid">
    <div class="card mb-4">
      <div class="card-header">
        <h3 class="card-title">Add New User</h3>
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

        <form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
          @csrf

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="name" class="form-label fw-bold">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="email" class="form-label fw-bold">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="phone" class="form-label fw-bold">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="role" class="form-label fw-bold">Role</label>
                <select class="form-select @error('role') is-invalid @enderror" id="role" name="role" required>
                  <option value="">Select Role</option>
                  <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                  <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                  <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-3">
                <label for="province" class="form-label fw-bold">Province / City</label>
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
                <label for="district" class="form-label fw-bold">District</label>
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
                <label for="ward" class="form-label fw-bold">Ward / Commune</label>
                <select class="form-select @error('ward') is-invalid @enderror" id="ward" name="ward" required disabled>
                  <option value="">-- Select Ward --</option>
                </select>
                @error('ward')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <div class="mb-3">
            <label for="address_detail" class="form-label fw-bold">Specific Address Detail</label>
            <input type="text" class="form-control @error('address_detail') is-invalid @enderror" id="address_detail" name="address_detail" value="{{ old('address_detail') }}" placeholder="House number, street name..." required>
            @error('address_detail')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label for="password" class="form-label fw-bold">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-md-6">
              <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-bold">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
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
              <img id="preview" width="150" style="display: none;" class="img-thumbnail" />
            </div>
          </div>

          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Thêm Axios để gọi API Tỉnh/Thành --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  // Hàm preview ảnh đại diện cũ của bạn giữ nguyên
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

  // Khối mã Javascript xử lý API địa chính Việt Nam
  document.addEventListener("DOMContentLoaded", function () {
    const provinceSelect = document.getElementById('province');
    const districtSelect = document.getElementById('district');
    const wardSelect = document.getElementById('ward');

    // 1. Tải danh sách Tỉnh/Thành
    axios.get('https://provinces.open-api.vn/api/p/')
      .then(response => {
        response.data.forEach(province => {
          let option = new Option(province.name, province.name);
          option.dataset.code = province.code;
          provinceSelect.add(option);
        });
      })
      .catch(error => console.error('Error fetching provinces:', error));

    // 2. Thay đổi Tỉnh -> Tải Huyện
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

    // 3. Thay đổi Huyện -> Tải Xã
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