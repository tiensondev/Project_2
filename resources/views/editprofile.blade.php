@extends('web-layouts.app')

@section('title', 'My Profile')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Account Information & Shipping Address</h5>
                </div>
                <div class="card-body p-4">
                    
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="text-secondary border-bottom pb-2 mb-3">Personal Info</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Email Address</label>
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly title="Email cannot be changed">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Enter your phone number">
                        </div>

                        <h5 class="text-secondary border-bottom pb-2 mb-3 mt-4">Default Shipping Address</h5>
                        
                        {{-- Hiển thị địa chỉ hiện tại nếu có --}}
                        @if($user->province)
                            <div class="alert alert-info py-2 small">
                                <strong>Current Address:</strong> {{ $user->address_detail }}, {{ $user->ward }}, {{ $user->district }}, {{ $user->province }}
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Province / City</label>
                                <select name="province" id="province" class="form-select">
                                    <option value="">-- Select Province --</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">District</label>
                                <select name="district" id="district" class="form-select" disabled>
                                    <option value="">-- Select District --</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Ward / Commune</label>
                                <select name="ward" id="ward" class="form-select" disabled>
                                    <option value="">-- Select Ward --</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Specific Address Detail</label>
                            <input type="text" name="address_detail" id="address_detail" class="form-control" 
                                   value="{{ old('address_detail', $user->address_detail) }}" placeholder="House number, street name...">
                        </div>

                        <button type="submit" class="btn btn-primary fw-bold px-4 shadow">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const provinceSelect = document.getElementById('province');
        const districtSelect = document.getElementById('district');
        const wardSelect = document.getElementById('ward');

        // 1. Tải danh sách Tỉnh
        axios.get('https://provinces.open-api.vn/api/p/')
            .then(response => {
                response.data.forEach(province => {
                    let option = new Option(province.name, province.name);
                    option.dataset.code = province.code;
                    provinceSelect.add(option);
                });
            });

        // 2. Chọn Tỉnh -> Tải Huyện
        provinceSelect.addEventListener('change', function () {
            districtSelect.innerHTML = '<option value="">-- Select District --</option>';
            wardSelect.innerHTML = '<option value="">-- Select Ward --</option>';
            districtSelect.disabled = true;
            wardSelect.disabled = true;

            const provinceCode = this.options[this.selectedIndex].dataset.code;
            if (provinceCode) {
                axios.get(`https://provinces.open-api.vn/api/p/${provinceCode}?depth=2`)
                    .then(response => {
                        response.data.districts.forEach(district => {
                            let option = new Option(district.name, district.name);
                            option.dataset.code = district.code;
                            districtSelect.add(option);
                        });
                        districtSelect.disabled = false;
                    });
            }
        });

        // 3. Chọn Huyện -> Tải Xã
        districtSelect.addEventListener('change', function () {
            wardSelect.innerHTML = '<option value="">-- Select Ward --</option>';
            wardSelect.disabled = true;

            const districtCode = this.options[this.selectedIndex].dataset.code;
            if (districtCode) {
                axios.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => {
                        response.data.wards.forEach(ward => {
                            wardSelect.add(new Option(ward.name, ward.name));
                        });
                        wardSelect.disabled = false;
                    });
            }
        });
    });
</script>
@endsection