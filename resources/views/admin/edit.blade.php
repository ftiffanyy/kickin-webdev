@extends('base.base')

@section('content')

<div class="container" style="font-family: 'Fredoka', sans-serif; background-color: #ffffff; margin-top: 20px;">
    <h2 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E; margin-top: 30px; font-weight: bold;">
        <i class="bi bi-pencil-square" style="color: #181B1E; font-size: 30px; margin-right: 10px;"></i> Edit Product
    </h2>

    <form action="{{ route('update_product', ['id' => $product->id]) }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded-lg">
        @csrf
        @method('PUT')

        <div class="row" style="margin-left: -10px; margin-right: -10px;">
            <!-- Left Column -->
            <div class="col-md-6" style="min-height: 600px; padding-right: 60px;">
                <!-- Product Name -->
                <div class="form-group mb-3">
                    <label for="name" class="form-label" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E;">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Price -->
                <div class="form-group mb-3">
                    <label for="price" class="form-label" style="color: #181B1E;">Price</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #F8F9FA; color: #181B1E;">Rp</span>
                        <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}" required>
                    </div>
                    @error('price')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Discount -->
                <div class="form-group mb-3">
                    <label for="discount" class="form-label" style="color: #181B1E;">Discount <span style="color: #A5A9AE;">(Optional)</span></label>
                    <div class="input-group">
                        <input type="number" name="discount" id="discount" class="form-control" value="{{ old('discount', $product->discount ?? 0) }}" min="0" max="100">
                        <span class="input-group-text" style="background-color: #F8F9FA; color: #181B1E;">%</span>
                    </div>
                    @error('discount')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Brand -->
                <div class="form-group mb-3">
                    <label for="brand" class="form-label" style="color: #181B1E;">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control" value="{{ old('brand', $product->brand) }}" required>
                    @error('brand')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gender -->
                <div class="form-group mb-3">
                    <label for="gender" class="form-label" style="color: #181B1E;">Gender</label>
                    <div class="custom-select-container">
                        <select name="gender" id="gender" class="form-control custom-select" required>
                            <option value="Unisex" {{ old('gender', $product->gender) == 'Unisex' ? 'selected' : '' }}>Unisex</option>
                            <option value="Male" {{ old('gender', $product->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $product->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                    @error('gender')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label" style="color: #181B1E;">Description</label>
                    <textarea name="description" id="description" rows="6" class="form-control" style="min-height: 400px;" required>{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6" style="min-height: 600px; padding-left: 20px;">
                <!-- Product Images -->
                <div class="form-group mb-3">
                    <label for="images" class="form-label" style="color: #181B1E;">Product Images (Up to 10)</label>
                    <div id="image-upload-container">
                        <input type="file" name="images[]" class="form-control image-input" accept="image/*" multiple>
                    </div>
                    <small class="text-muted">Max 10 images. Leave empty to keep existing images.</small>
                    @error('images')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    @error('images.*')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                    <!-- Display Current Images -->
                    @if(isset($product->images) && count($product->images) > 0)
                        <div class="mt-3">
                            <label class="form-label" style="color: #181B1E;">Current Images:</label>
                            <div id="currentImages" class="d-flex flex-wrap" style="gap: 10px; margin-top: 10px;">
                                @foreach ($product->images as $index => $image)
                                    <div class="image-preview-container" id="image-container-{{ $image->id }}" style="width: 100px; height: 100px; border: 1px solid #ccc; display: flex; justify-content: center; align-items: center; position: relative;">
                                        <img src="{{ asset('images/' . $image->url) }}" alt="Current Image" style="max-width: 100%; max-height: 100%; object-fit: cover;" />
                                        <button type="submit" name="delete_image" value="{{ $image->id }}" class="remove-existing-image" data-image-id="{{ $image->id }}" style="position: absolute; top: 2px; right: 2px; background: rgba(255,0,0,0.8); border: none; color: white; font-size: 12px; cursor: pointer; width: 20px; height: 20px; border-radius: 50%;" onclick="return confirm('Are you sure you want to remove this image?')">×</button>
                                        <input type="hidden" name="keep_images[]" value="{{ $image->id }}" class="keep-image-{{ $image->id }}">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Preview New Images -->
                    <div id="imagePreview" class="d-flex flex-wrap" style="gap: 10px; margin-top: 20px;"></div>
                </div>

                <!-- Additional Info for Admin -->
                <div class="form-group mb-3">
                    <p style="color: #A5A9AE; font-size: 14px;">
                        Please ensure that the images are of high quality. Images should be clear and of a proper size to ensure the best user experience. 
                        Avoid using watermarked or low-resolution images. 
                    </p>
                </div>

                <!-- Sizes and Quantities -->
                <div class="form-group mb-3">
                    <label for="sizes" class="form-label" style="color: #181B1E;">Sizes <span style="color: #A5A9AE;">(EU)</span></label>
                    <div class="row">
                        @foreach(range(35, 46, 0.5) as $size)
                            @php
                                $sizeKey = number_format($size, 1);
                                $currentQuantity = 0;
                                
                                // Find current quantity for this size by checking if it exists in the product's variants
                                $variant = $product->variants->firstWhere('size', $sizeKey);
                                if ($variant) {
                                    $currentQuantity = $variant->stock;
                                }
                            @endphp
                            <div class="col-3 mb-2">
                                <label for="size_{{ $sizeKey }}" class="form-label" style="color: #181B1E;">{{ $sizeKey }}</label>
                                <input 
                                    type="number" 
                                    name="sizes[{{ $sizeKey }}]" 
                                    id="size_{{ $sizeKey }}" 
                                    class="form-control" 
                                    value="{{ old('sizes.' . $sizeKey, $currentQuantity) }}" 
                                    min="0" 
                                    placeholder="Quantity"
                                >
                            </div>
                        @endforeach
                    </div>
                    @error('sizes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary btn-lg w-100" style="background-color: #5F6266; border: none;">Update Product</button>
        </div>
    </form>
</div>

@push('styles')
    <style>
        /* Custom select container for dropdown */
        .custom-select-container {
            position: relative;
        }

        /* Custom styling for select dropdown */
        .custom-select {
            padding-right: 30px; /* Add space for the dropdown arrow */
            appearance: none; /* Remove the default dropdown arrow */
            -webkit-appearance: none;
            -moz-appearance: none;
        }

        /* Dropdown arrow styling */
        .custom-select-container::after {
            content: '\25BC'; /* Downward arrow symbol */
            font-size: 18px;
            color: #181B1E; /* Arrow color */
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none; /* Prevent the arrow from being clickable */
        }

        .remove-existing-image:hover {
            background: rgba(255,0,0,1) !important;
        }
    </style>
@endpush

@section('scripts')
<script>
    // Handle new image previews when files are selected
    document.addEventListener('change', function(event) {
        if (event.target.classList.contains('image-input')) {
            const files = event.target.files;
            const imagePreview = document.getElementById("imagePreview");
            
            // Clear previous previews
            imagePreview.innerHTML = '';

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const container = document.createElement('div');
                    container.className = 'image-preview-container';
                    container.style.cssText = 'width: 100px; height: 100px; border: 1px solid #ccc; display: flex; justify-content: center; align-items: center; position: relative;';
                    
                    const img = document.createElement("img");
                    img.src = e.target.result;
                    img.alt = "New Image Preview";
                    img.style.cssText = "max-width: 100%; max-height: 100%; object-fit: cover;";
                    
                    const removeBtn = document.createElement('button');
                    removeBtn.type = 'button';
                    removeBtn.innerHTML = '×';
                    removeBtn.style.cssText = 'position: absolute; top: 2px; right: 2px; background: rgba(255,0,0,0.8); border: none; color: white; font-size: 12px; cursor: pointer; width: 20px; height: 20px; border-radius: 50%;';
                    
                    removeBtn.addEventListener('click', function() {
                        container.remove();
                    });
                    
                    container.appendChild(img);
                    container.appendChild(removeBtn);
                    imagePreview.appendChild(container);
                };

                reader.readAsDataURL(file);
            });
        }
    });

    // Handle removal of existing images - No longer needed since we're using submit buttons
    // document.addEventListener('click', function(event) {
    //     if (event.target.classList.contains('remove-existing-image')) {
    //         event.preventDefault();
    //         const imageId = event.target.getAttribute('data-image-id');
    //         const container = document.getElementById('image-container-' + imageId);
    //         const keepInput = document.querySelector('.keep-image-' + imageId);
            
    //         if (confirm('Are you sure you want to remove this image?')) {
    //             // Hide the container
    //             container.style.display = 'none';
    //             // Remove the keep_images input so this image won't be kept
    //             if (keepInput) {
    //                 keepInput.remove();
    //             }
    //         }
    //     }
    // });
</script>
@endsection
@endsection