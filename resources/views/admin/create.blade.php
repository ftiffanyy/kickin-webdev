@extends('base.base')

@section('content')

<div class="container" style="font-family: 'Fredoka', sans-serif; background-color: #ffffff; margin-top: 20px; ">
    <h2 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E; margin-top: 30px; font-weight: bold;">
        <i class="bi bi-plus-circle" style="color: #181B1E; font-size: 30px; margin-right: 10px;"></i> Insert New Product
    </h2>

    <!-- Display Success Message -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Display Error Message -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form action="{{ route('create_product') }}" method="POST" enctype="multipart/form-data" class="shadow p-4 bg-white rounded-lg">
        @csrf

        <div class="row" style="margin-left: -10px; margin-right: -10px;">
            <!-- Left Column -->
            <div class="col-md-6" style="min-height: 600px; padding-right: 60px;">
                <!-- Name -->
                <div class="form-group mb-3">
                    <label for="product_name" class="form-label" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E;">Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <!-- Price -->
                <div class="form-group mb-3">
                    <label for="price" class="form-label" style="color: #181B1E;">Price</label>
                    <div class="input-group">
                        <span class="input-group-text" style="background-color: #F8F9FA; color: #181B1E;">Rp</span>
                        <input type="number" name="price" id="price" class="form-control" required>
                    </div>
                </div>

                <!-- Discount -->
                <div class="form-group mb-3">
                    <label for="discount" class="form-label" style="color: #181B1E;">Discount <span style="color: #A5A9AE;">(Optional)</span></label>
                    <div class="input-group">
                        <input type="number" name="discount" id="discount" class="form-control" min="0" max="100">
                        <span class="input-group-text" id="percent-sign" style="background-color: #F8F9FA; color: #181B1E;">%</span>
                    </div>
                </div>

                <!-- Brand -->
                <div class="form-group mb-3">
                    <label for="brand" class="form-label" style="color: #181B1E;">Brand</label>
                    <input type="text" name="brand" id="brand" class="form-control" required>
                </div>

                <!-- Gender -->
                <div class="form-group mb-3">
                    <label for="gender" class="form-label" style="color: #181B1E;">Gender</label>
                    <div class="custom-select-container">
                        <select name="gender" id="gender" class="form-control custom-select" required>
                            <option value="Unisex">Unisex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label" style="color: #181B1E;">Description</label>
                    <textarea name="description" id="description" rows="6" class="form-control" style="min-height: 400px;" required></textarea>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-md-6" style="min-height: 600px; padding-left: 20px;">
                <!-- Replace the entire Product Images section with this -->
                <div class="form-group mb-3">
                    <label for="images" class="form-label" style="color: #181B1E;">Product Images (Up to 10)</label>
                    <div id="image-upload-container">
                        <div class="uploaded-images mb-3">
                            <!-- Display images dynamically -->
                        </div>
                        <input type="file" name="images[]" class="form-control image-input" accept="image/*" multiple id="imageInput">
                    </div>

                    <small class="text-muted">Max 10 images</small>

                    <!-- Display Images Below -->
                    <div id="imagePreview" class="d-flex flex-wrap" style="gap: 10px; margin-top: 20px;">
                        <!-- Dynamically display image previews here -->
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
                                <label for="sizes[{{ $size }}]" class="form-label" style="color: #181B1E;">{{ $size }}</label>
                                <input type="number" name="sizes[{{ $size }}]" id="sizes[{{ $size }}]" class="form-control" min="0" placeholder="Quantity">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary btn-lg w-100" style="background-color: #5F6266; border: none;">Add Product</button>
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
    // Array to store all selected files
    let selectedFiles = [];
    let fileCounter = 0;

    // Wait for DOM to be ready
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('imageInput');
        
        if (imageInput) {
            imageInput.addEventListener('change', handleImageSelection);
        }
        
        // Initialize
        selectedFiles = [];
        fileCounter = 0;
        updateImagePreview();
    });

    function handleImageSelection(event) {
        const input = event.target;
        const newFiles = Array.from(input.files);
        
        // Check if adding new files would exceed the limit
        if (selectedFiles.length + newFiles.length > 10) {
            alert('You can upload a maximum of 10 images. Currently you have ' + selectedFiles.length + ' images.');
            input.value = ''; // Clear the input
            return;
        }
        
        // Add new files to selectedFiles array
        newFiles.forEach(file => {
            // Create a unique identifier for each file
            file.uniqueId = 'file_' + (++fileCounter);
            selectedFiles.push(file);
        });
        
        // Clear the input value to allow selecting the same file again if needed
        input.value = '';
        
        // Update the preview
        updateImagePreview();
        
        // Update the form data
        updateFormData();
    }

    function updateImagePreview() {
        const previewContainer = document.getElementById('imagePreview');
        if (!previewContainer) return;
        
        previewContainer.innerHTML = '';  // Clear previous previews

        selectedFiles.forEach((file, index) => {
            const reader = new FileReader();
            
            reader.onload = function (e) {
                const imageContainer = document.createElement('div');
                imageContainer.classList.add('image-preview-container');
                imageContainer.style.cssText = `
                    width: 100px; 
                    height: 100px; 
                    border: 1px solid #ccc; 
                    display: flex; 
                    justify-content: center; 
                    align-items: center; 
                    position: relative;
                    border-radius: 8px;
                    overflow: hidden;
                    background: #f8f9fa;
                `;
                imageContainer.setAttribute('data-file-id', file.uniqueId);

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = 'Image Preview';
                img.style.cssText = 'max-width: 100%; max-height: 100%; object-fit: cover;';

                const closeBtn = document.createElement('button');
                closeBtn.innerHTML = '×';
                closeBtn.type = 'button';
                closeBtn.style.cssText = `
                    position: absolute; 
                    top: 2px; 
                    right: 2px; 
                    background: rgba(255, 255, 255, 0.9); 
                    border: none; 
                    color: #ff4444; 
                    font-size: 18px; 
                    cursor: pointer;
                    width: 22px;
                    height: 22px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-weight: bold;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.2);
                `;
                
                closeBtn.onclick = function (e) {
                    e.preventDefault();
                    removeImage(file.uniqueId);
                };

                // Add hover effect for close button
                closeBtn.addEventListener('mouseenter', function() {
                    this.style.background = 'rgba(255, 255, 255, 1)';
                    this.style.transform = 'scale(1.1)';
                });
                closeBtn.addEventListener('mouseleave', function() {
                    this.style.background = 'rgba(255, 255, 255, 0.9)';
                    this.style.transform = 'scale(1)';
                });

                imageContainer.appendChild(img);
                imageContainer.appendChild(closeBtn);
                previewContainer.appendChild(imageContainer);
            };

            reader.readAsDataURL(file);
        });
    }

    function removeImage(fileId) {
        // Remove file from selectedFiles array
        selectedFiles = selectedFiles.filter(file => file.uniqueId !== fileId);
        
        // Update preview
        updateImagePreview();
        
        // Update form data
        updateFormData();
    }

    function updateFormData() {
        // Create a new DataTransfer object to store files
        const dt = new DataTransfer();
        
        // Add all selected files to DataTransfer
        selectedFiles.forEach(file => {
            dt.items.add(file);
        });
        
        // Update the file input with the new file list
        const input = document.getElementById('imageInput');
        if (input) {
            input.files = dt.files;
        }
    }
</script>
@endsection
@endsection