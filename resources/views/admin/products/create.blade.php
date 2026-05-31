@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Create Product</h1>
    </div>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center bg-white py-3">
            <h5 class="mb-0">Add New Product</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Product Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name') }}" required>
                        @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="category_id" class="form-label">Category *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            <option value="">Select Category</option>
                            @foreach($categories as $cate)
                            <option value="{{ $cate->id }}" {{ old('category_id') == $cate->id ? 'selected' : '' }}>{{ $cate->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label">Price *</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price') }}" step="0.01" required>
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="stock" class="form-label">Stock *</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock') }}" required>
                        @error('stock')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" rows="4">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group mt-3 mb-3">
                    <label>Thông số kỹ thuật (Nhập mỗi dòng 1 thông số)</label>
                    <textarea name="spec_text" id="spec_textarea" class="form-control" rows="6"></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">Product Images</label>
                    <input type="file" name="image[]" class="form-control @error('image.*') is-invalid @enderror" id="image" onchange="previewImages(event)" accept="image/*" multiple>

                    @error('image.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-3 d-flex flex-wrap gap-3" id="preview-container">
                        @if(!empty($product->image) && is_array($product->image))
                        @foreach($product->image as $index => $img)
                        <div class="position-relative old-preview-box" style="width: 120px; height: 120px;">
                            <img src="{{ asset('uploads/' . $img) }}" class="img-thumbnail w-100 h-100 {{ $index === 0 ? 'border-primary border-2' : '' }}" style="object-fit: cover;" />
                            @if($index === 0)
                                <span class="badge bg-primary position-absolute bottom-0 start-0 m-1" style="font-size: 10px;">Main</span>
                            @else
                                <span class="badge bg-secondary position-absolute bottom-0 start-0 m-1" style="font-size: 10px;">Sub</span>
                            @endif
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">Create Product</button>
                    <a href="{{ route('admin.products.list') }}" class="btn btn-secondary px-4">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let selectedFiles = new DataTransfer();

    function previewImages(event) {
        const container = document.getElementById('preview-container');
        const input = document.getElementById('image');
        const files = event.target.files;

        if (files) {
            Array.from(files).forEach(file => {
                selectedFiles.items.add(file);

                const reader = new FileReader();
                const fileId = file.name + '-' + file.size;

                reader.onload = function(e) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'position-relative new-preview-item';
                    wrapper.setAttribute('data-id', fileId);
                    wrapper.style.width = '120px';
                    wrapper.style.height = '120px';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail w-100 h-100';
                    img.style.objectFit = 'cover';

                    // Nút xóa ảnh xem trước
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '&times;';
                    removeBtn.className = 'btn btn-danger btn-sm position-absolute rounded-circle d-flex align-items-center justify-content-center';
                    removeBtn.style.top = '-8px';
                    removeBtn.style.right = '-8px';
                    removeBtn.style.width = '22px';
                    removeBtn.style.height = '22px';
                    removeBtn.style.padding = '0';
                    removeBtn.style.zIndex = '10';

                    removeBtn.onclick = function() {
                        removeFileFromInput(fileId);
                        wrapper.remove();
                        refreshBadges(); 
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    container.appendChild(wrapper);

                    refreshBadges(); 
                }

                reader.readAsDataURL(file);
            });

            input.files = selectedFiles.files;
        }
    }

    function removeFileFromInput(fileId) {
        const input = document.getElementById('image');
        const dt = new DataTransfer();

        Array.from(selectedFiles.files).forEach(file => {
            const currentId = file.name + '-' + file.size;
            if (currentId !== fileId) {
                dt.items.add(file);
            }
        });

        selectedFiles = dt;
        input.files = selectedFiles.files;
    }

    function refreshBadges() {
        const previewItems = document.querySelectorAll('.new-preview-item');
        
        previewItems.forEach((item, index) => {
            const oldBadge = item.querySelector('.image-badge');
            if (oldBadge) oldBadge.remove();

            const imgElement = item.querySelector('img');
            const badge = document.createElement('span');
            badge.className = 'badge position-absolute bottom-0 start-0 m-1 image-badge';
            badge.style.fontSize = '10px';


            if (index === 0) {
                badge.innerText = 'Main';
                badge.classList.add('bg-primary');
                imgElement.className = 'img-thumbnail w-100 h-100 border-primary border-2';
            } else {
                badge.innerText = 'Sub';
                badge.classList.add('bg-secondary');
                imgElement.className = 'img-thumbnail w-100 h-100';
            }

            item.appendChild(badge);
        });
    }
</script>
@endsection