@extends('admin.layouts.app')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h3 class="card-title mb-0 fw-bold">Edit Product</h3>
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

            <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Product Name *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price *</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" id="price" value="{{ old('price', $product->price) }}" step="0.01" required>
                            @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock *</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" id="stock" value="{{ old('stock', $product->stock) }}" required>
                            @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">Category *</label>
                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="image" class="form-label fw-bold text-primary">Product Images (New images will replace all old images)</label>
                    <input type="file" name="image[]" class="form-control @error('image.*') is-invalid @enderror" id="image" onchange="previewImages(event)" accept="image/*" multiple>
                    @error('image.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    @if(!empty($product->image) && is_array($product->image) && count($product->image) > 0)
                        <div class="mt-3">
                            <p class="text-muted small mb-2">Pictures shown on the system:</p>
                            <div class="d-flex flex-wrap gap-3 p-2 bg-light border rounded">
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
                            </div>
                        </div>
                    @endif

                    <div class="mt-3">
                        <div class="d-flex flex-wrap gap-3" id="preview-container"></div>
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-success px-4">Update Product</button>
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
                    wrapper.className = 'position-relative preview-item';
                    wrapper.setAttribute('data-id', fileId);
                    wrapper.style.width = '120px';
                    wrapper.style.height = '120px';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-thumbnail w-100 h-100';
                    img.style.objectFit = 'cover';

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
                        refreshNewBadges(); 
                    };

                    wrapper.appendChild(img);
                    wrapper.appendChild(removeBtn);
                    container.appendChild(wrapper);

                    refreshNewBadges(); 
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

    function refreshNewBadges() {
        const previewItems = document.querySelectorAll('#preview-container .preview-item');
        
        previewItems.forEach((item, index) => {
            const oldBadge = item.querySelector('.image-badge-new');
            if (oldBadge) oldBadge.remove();

            const imgElement = item.querySelector('img');
            const badge = document.createElement('span');
            badge.className = 'badge position-absolute bottom-0 start-0 m-1 image-badge-new';
            badge.style.fontSize = '10px';

            if (index === 0) {
                badge.innerText = 'Main';
                badge.classList.add('bg-success'); 
                imgElement.className = 'img-thumbnail w-100 h-100 border-success border-2';
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