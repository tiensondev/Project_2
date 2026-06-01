@extends('web-layouts.app')

@section('title', 'Your Cart')
@section('content')
<div class="container py-4">
    <h2 class="mb-4">Your Shopping Cart</h2>

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @if(isset($cartItems) && count($cartItems) > 0)
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th scope="col">Product</th>
                    <th scope="col" style="width: 140px;">Price</th>
                    <th scope="col" style="width: 140px;">Quantity</th>
                    <th scope="col" style="width: 140px;">Total</th>
                    <th scope="col" style="width: 100px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            @php
                            $images = $item->product->image;
                            if (is_string($images)) {
                            $images = json_decode($images, true) ?? [$images];
                            }
                            $firstImage = is_array($images) ? ($images[0] ?? 'placeholder.png') : 'placeholder.png';
                            @endphp

                            <img src="{{ asset('uploads/' . $firstImage) }}" alt="{{ $item->product->name }}" class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                            <span>{{ $item->product->name }}</span>
                        </div>
                    </td>
                    <td class="text-center">{{ number_format($item->product->price, 0, ',', '.') }}đ</td>
                    <td class="text-center">
                        <form action="{{ route('cart.update') }}" method="POST" class="d-flex justify-content-center">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <input type="number" name="quantity" class="form-control form-control-sm text-center quantity-input" value="{{ $item->quantity }}" min="1" style="width: 80px;" onchange="this.form.submit()">
                        </form>
                    </td>
                    <td class="text-center fw-bold text-primary">{{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}đ</td>

                    <td class="text-center">
                        <form action="{{ route('cart.remove') }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to remove this product from cart?')">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center p-2 mx-auto" style="width: 35px; height: 35px;" title="Delete Item">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-end mt-3">
        @php
        $grandTotal = 0;
        foreach($cartItems as $item) {
        $grandTotal += $item->product->price * $item->quantity;
        }
        @endphp
        <h4 class="fw-bold">Grand Total: <span class="text-danger">{{ number_format($grandTotal, 0, ',', '.') }} đ</span></h4>
    </div>

    <form action="{{ route('cart.checkout') }}" method="POST" class="mt-4">
        @csrf

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0 fw-bold text-secondary"></i>Delivery information</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Delivery phone number<span class="text-danger">*</span></label>
                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                        value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="Enter the phone number for delivery." required>
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="province" class="form-label fw-bold">Province/City<span class="text-danger">*</span></label>
                    <select name="province" id="province" class="form-select @error('province') is-invalid @enderror" required>
                        <option value="">-- Province/City --</option>
                    </select>
                    @error('province')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="district" class="form-label fw-bold">District/County<span class="text-danger">*</span></label>
                    <select name="district" id="district" class="form-select @error('district') is-invalid @enderror" required disabled>
                        <option value="">-- Select District/County --</option>
                    </select>
                    @error('district')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ward" class="form-label fw-bold">Ward/Commune<span class="text-danger">*</span></label>
                    <select name="ward" id="ward" class="form-select @error('ward') is-invalid @enderror" required disabled>
                        <option value="">-- Select Ward/Commune --</option>
                    </select>
                    @error('ward')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address_detail" class="form-label fw-bold">Specific address<span class="text-danger">*</span></label>
                    <input type="text" name="address_detail" id="address_detail" class="form-control @error('address_detail') is-invalid @enderror"
                        placeholder="House numbers, alleys, street names..." value="{{ old('address_detail') }}" required>
                    @error('address_detail')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold py-3 shadow">
           Confirm payment
        </button>
    </form>
    @else
    <div class="text-center py-5">
        <i class="fas fa-shopping-cart fa-4x text-muted mb-3 d-block"></i>
        <h3>Your cart is empty</h3>
        <p class="text-muted">Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ route('home') }}" class="btn btn-primary mt-3 px-4">
            <i class="fas fa-arrow-left me-2"></i> Start Shopping
        </a>
    </div>
    @endif
</div>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
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
            .catch(error => console.error('Error loading the list of provinces:', error));

        provinceSelect.addEventListener('change', function() {
            districtSelect.innerHTML = '<option value="">-- Select District/County --</option>';
            wardSelect.innerHTML = '<option value="">-- Select Ward/Commune--</option>';
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
                    .catch(error => console.error('Error loading district list:', error));
            }
        });

        districtSelect.addEventListener('change', function() {
            wardSelect.innerHTML = '<option value="">-- Select Ward/Commune --</option>';
            wardSelect.disabled = true;

            const selectedOption = this.options[this.selectedIndex];
            const districtCode = selectedOption.dataset.code;

            if (districtCode) {
                axios.get(`https://provinces.open-api.vn/api/d/${districtCode}?depth=2`)
                    .then(response => {
                        response.data.wards.forEach(ward => {
                            let option = new Option(ward.name, ward.name);
                            wardSelect.add(option);
                        });
                        wardSelect.disabled = false;
                    })
                    .catch(error => console.error('Error loading the list of communes:', error));
            }
        });
    });
</script>
@endsection