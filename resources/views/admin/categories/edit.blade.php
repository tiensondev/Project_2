@extends('admin.layouts.app')

@section('title', 'Edit Category')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h1 class="h3 mb-0 text-gray-800">
            Edit Category
        </h1>


    </div>

    {{-- Error --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    {{-- Card --}}
    <div class="card shadow">

        <div class="card-header py-3">

            <h6 class="m-0 font-weight-bold text-primary">
                Category Information
            </h6>

        </div>

        <div class="card-body">

            <form method="POST"
                  action="{{ route('admin.categories.update', $category->id) }}">

                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="mb-3">

                    <label class="form-label">
                        Name
                    </label>

                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $category->name) }}"
                           required>

                </div>

                {{-- Description --}}
                <div class="mb-3">

                    <label class="form-label">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $category->description) }}</textarea>

                </div>

                {{-- Status --}}
                <div class="mb-4">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select"
                            required>

                        <option value="1"
                            {{ old('status', $category->status) == '1' ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0"
                            {{ old('status', $category->status) == '0' ? 'selected' : '' }}>
                            Hidden
                        </option>

                    </select>

                </div>

                {{-- Buttons --}}
                <div class="d-flex gap-2">

                    <button type="submit"
                            class="btn btn-success">
                        Update
                    </button>

                    <a href="{{ route('admin.categories.list') }}"
                       class="btn btn-light border">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection