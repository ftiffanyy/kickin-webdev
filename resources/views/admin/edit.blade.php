@extends('base.base')

@section('content')

<div class="container" style="font-family: 'Fredoka', sans-serif; background-color: #ffffff; margin-top: 20px;">
    <h2 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E; margin-top: 30px; font-weight: bold;">
        <i class="bi bi-pencil-square" style="color: #181B1E; font-size: 30px; margin-right: 10px;"></i> Edit Product
    </h2>

    <form action="{{ route('update_product') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded-lg">
        @csrf

        <div class="row" style="margin-left: -10px; margin-right: -10px;">
            <!-- Left Column -->
            <div class="col-md-6" style="min-height: 600px; padding-right: 60px;">
                <!-- Product Name -->
                <div class="form-group mb-3">
                    <label for="product_name" class="form-label" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E;">Product Name</label>
                    <input type="text" name="product_name" id="product_name" class="form-control" value="air force 1 '07 men's basketball shoes - white" required>
                </div>

                <!-- Price -->
                <div class="form-group mb-3">
                    <label for="price" class="form-label" style="color: #181B1E;">Price</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #F8F9FA; color: #181B1E;">Rp</span>
                        <input type="number" name="price" id="price" class="form-control" value="1549000" required>
                    </div>
                </div>

                <!-- Discount -->
                <div class="form-group mb-3">
                    <label for="discount" class="form-label" style="color: #181B1E;">Discount <span style="color: #A5A9AE;">(Optional)</span></label>
                    <div class="input-group">
                        <input type="number" name="discount" id="discount" class="form-control" value="30" min="0" max="100" required>
                        <span class="input-group-text" style="background-color: #F8F9FA; color: #181B1E;">%</span>
                    </div>
                </div>

                <!-- Brand -->
                <div class="form-group mb-3">
                    <label for="brand" class="form-label" style="color: #181B1E;">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control" value="NIKE" required>
                </div>

                <!-- Gender -->
                <div class="form-group mb-3">
                    <label for="gender" class="form-label" style="color: #181B1E;">Gender</label>
                    <div class="custom-select-container">
                        <select name="gender" id="gender" class="form-control custom-select" required>
                            <option value="Unisex" @if(old('gender') == 'Unisex') selected @endif>Unisex</option>
                            <option value="Men" @if(old('gender') == 'Men' || old('gender') == '' ) selected @endif>Men</option>
                            <option value="Women" @if(old('gender') == 'Women') selected @endif>Women</option>
                        </select>
                    </div>
                </div>


                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label" style="color: #181B1E;">Description</label>
                    <textarea name="description" id="description" rows="6" class="form-control" style="min-height: 400px;" required>Step into a legend with the Nike Air Force 1 '07. Featuring crisp white leather and classic hoops-inspired style, this icon brings timeless street appeal and durable comfort. Padded collars and Nike Air cushioning provide all-day support on and off the court.</textarea>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6" style="min-height: 600px; padding-left: 20px;">
                <!-- Product Images -->
                <div class="form-group mb-3">
                    <label for="images" class="form-label" style="color: #181B1E;">Product Images (Up to 10)</label>
                    <div id="image-upload-container">
                        <div class="uploaded-images mb-3">
                            <!-- Display images dynamically -->
                        </div>
                        <input type="file" name="images[]" class="form-control image-input" accept="image/*" multiple>
                    </div>

                    <small class="text-muted">Max 10 images</small>

                    <!-- Display Images Below -->
                    <div id="imagePreview" class="d-flex flex-wrap" style="gap: 10px; margin-top: 20px;">
                        <!-- Loop through the imageUrls and display each image -->
                        @foreach ($imageUrls as $imageUrl)
                            <div class="image-preview-container" style="width: 100px; height: 100px; border: 1px solid #ccc; display: flex; justify-content: center; align-items: center; position: relative;">
                                <img src="{{ $imageUrl }}" alt="Image Preview" style="max-width: 100%; max-height: 100%;" />
                                <!-- Close button to remove image -->
                                <button type="button" class="close-btn" style="position: absolute; top: 5px; right: 5px; background: transparent; border: none; color: #CFD1D4; font-size: 16px; cursor: pointer;">X</button>
                            </div>
                        @endforeach
                    </div>
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
                            <div class="col-3 mb-2">
                                <label for="size_{{ $size }}" class="form-label" style="color: #181B1E;">{{ $size }}</label>
                                <!-- Use the old() function to preserve values after validation failure, and fill the values from existingQuantities -->
                                <input 
                                    type="number" 
                                    name="sizes[{{ $size }}]" 
                                    id="size_{{ $size }}" 
                                    class="form-control" 
                                    value="{{ old('sizes.' . $size, isset($existingQuantities[$size]) ? $existingQuantities[$size] : 0) }}" 
                                    min="0" 
                                    placeholder="Quantity"
                                >
                            </div>
                        @endforeach
                    </div>
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
    </style>
@endpush

@section('scripts')
<script>
    // Add event listener for "Add More Images" button
    document.getElementById('add-more-images').addEventListener('click', function() {
        const container = document.getElementById('image-upload-container');
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'images[]';
        newInput.classList.add('form-control', 'image-input');
        newInput.accept = 'image/*';
        newInput.id = 'imageInput' + (container.querySelectorAll('input').length + 1);  // Ensure unique IDs

        // Add the new input to the container
        container.appendChild(newInput);
    });

    // Handle image previews when files are selected
    document.getElementById("image-upload-container").addEventListener("change", function(event) {
        if (event.target.classList.contains('image-input')) {
            var reader = new FileReader();

            reader.onload = function(e) {
                var imagePreview = document.getElementById("imagePreview");
                
                // Create an img element for the preview
                var img = document.createElement("img");
                img.src = e.target.result;
                img.alt = "Image Preview";
                img.style.maxWidth = "100%";  // Ensure the image is responsive within the container
                img.style.maxHeight = "100%"; // Limit height to fit container
                
                // Append the image to the preview container
                imagePreview.appendChild(img);
            };

            reader.readAsDataURL(event.target.files[0]);
        }
    });
</script>
@endsection
@endsection