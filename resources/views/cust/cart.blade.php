@extends('base.base')

@section('content')
<h2 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E; margin-top: 30px; font-weight: bold;">
    <i class="bi bi-cart" style="color: #181B1E; font-size: 30px; margin-right: 10px;"></i> My Cart
</h2>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-success alert-danger fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px;">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(count($cart) > 0)
    <form action="{{ route('update_cart') }}" method="POST">
        <div style="overflow-x: auto;">
            @csrf
            <table class="table" style="background-color: #F8F9FA; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);">
                <thead class="thead-light" style="background-color: #CFD1D4; color: #181B1E;">
                    <tr>
                        <th> 
                            <input type="checkbox" id="select-all" onclick="toggleSelectAll()" style="cursor: pointer; width: 20px; height: 20px; border: 2px solid #CFD1D4; background-color: #FFF; accent-color: #181B1E; border-radius: 5px; transition: all 0.3s ease;">
                        </th>
                        <th style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;"></th>
                        <th style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;">Name</th>
                        <th style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;">Size</th>
                        <th style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;">Price</th>
                        <th style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;">Qty</th>
                        <th style="font-family: 'Bebas Neue', sans-serif; font-size: 1.2rem;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $item)
                        @php 
                            $total += $item->price * $item->qty; 
                            $productImage = $item->variant->image ?? 'default-image.jpg';
                            $discount = $item->variant->product->product_discount ?? $item->variant->product->discount ?? 0;
                            $originalPrice = $item->variant->product->price;
                            $discountedPrice = $originalPrice * (1 - $discount / 100);
                        @endphp
                        <tr style="background-color: #FFF; border-bottom: 1px solid #CFD1D4;" 
                            data-item-id="{{ $item->id }}" 
                            data-original-price="{{ $originalPrice }}" 
                            data-discounted-price="{{ $discountedPrice }}"
                            data-discount="{{ $discount }}">
                            
                            <!-- checkbox column -->
                            <td style="vertical-align: middle;">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" class="item-checkbox" onchange="updateButtonStates()" style="cursor: pointer; width: 20px; height: 20px; border: 2px solid #CFD1D4; background-color: #FFF; accent-color: #181B1E; border-radius: 5px; transition: all 0.3s ease;">
                            </td>
                            
                            <!-- image column -->
                            <td style="vertical-align: middle;">
                                <img src="{{ asset('images/' . ($item->variant->product->images->first()->url ?? 'default-image.jpg')) }}" alt="{{ $item->variant->product->name }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 5px;">
                            </td>
                            
                            <!-- name column -->
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                {{ strtoupper($item->variant->product->name) }}
                            </td>
                            
                            <!-- size column -->
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                {{ $item->variant->size }}
                            </td>
                            
                            <!-- price column -->
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                Rp{{ number_format($discountedPrice, 0, ',', '.') }}
                            </td>

                            <!-- quantity column -->
                            <td style="vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQuantity({{ $item->id }}, -1)" style="margin-right: 5px; padding: 5px 10px;">-</button>
                                    <input type="number" name="quantity[{{ $item->id }}]" value="{{ $item->qty }}" class="quantity-input" id="quantity-{{ $item->id }}" style="width: 50px; text-align: center; font-family: 'Fredoka', sans-serif; font-size: 1rem; border: 1px solid #CFD1D4; border-radius: 5px; padding: 5px; -moz-appearance: textfield; -webkit-appearance: none;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQuantity({{ $item->id }}, 1)" style="margin-left: 5px; padding: 5px 10px;">+</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-link" id="confirm-{{ $item->id }}" onclick="confirmQuantity({{ $item->id }})" style="display:none; text-decoration: underline; font-family: 'Fredoka', sans-serif; color: #5F6266;">Confirm</button>
                            </td>

                            <!-- subtotal column -->
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;" id="subtotal-{{ $item->id }}">
                                Rp{{ number_format($discountedPrice * $item->qty, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        
        <h5 style="font-family: 'Bebas Neue', sans-serif; color: #181B1E;">Total: Rp
            <span id="total-price">
                @php
                    $grandTotal = $cart->sum(function ($item) {
                        $discount = $item->variant->product->product_discount ?? $item->variant->product->discount ?? 0;
                        $discountedPrice = $item->variant->product->price * (1 - $discount / 100);
                        return $discountedPrice * $item->qty;
                    });
                @endphp
                {{ number_format($grandTotal, 0, ',', '.') }}
            </span>
        </h5>

        <button type="submit" name="action" value="remove" id="remove-btn" class="btn" disabled style="font-family: 'Fredoka', sans-serif; background-color: #5F6266; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-transform: uppercase; opacity: 0.5; cursor: not-allowed;">Remove</button>
        <button type="submit" name="action" value="checkout" id="checkout-btn" class="btn" disabled style="font-family: 'Fredoka', sans-serif; background-color: #181B1E; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-transform: uppercase; margin-left: 10px; opacity: 0.5; cursor: not-allowed;">Checkout</button>
    </form>

@else
    <p style="font-family: 'Fredoka', sans-serif; color: #5F6266;">Your cart is empty. Please add products to your cart.</p>
@endif
@endsection

@push('styles')
    <style>
        /* Remove up and down arrows in number input */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Button disabled styles */
        .btn:disabled {
            opacity: 0.5 !important;
            cursor: not-allowed !important;
            pointer-events: none;
        }

        .btn:not(:disabled) {
            opacity: 1 !important;
            cursor: pointer !important;
            pointer-events: auto;
        }

        @media (max-width: 992px) {
            .table th, .table td {
                font-size: 10px;
                padding: 8px;
            }

            .input-group .form-control {
                width: 150px;
            }

            .input-group .btn {
                font-size: 12px;
                padding-left: 6px;
                padding-right: 6px;
            }

            .custom-btn {
                max-width: 180px;
                padding-left: 15px;
                padding-right: 15px;
            }
        }

        @media (max-width: 768px) {
            .table th, .table td {
                font-size: 9px;
                padding: 5px;
            }

            .input-group .form-control {
                width: 100px;
            }

            .input-group .btn {
                font-size: 10px;
                padding-left: 5px;
                padding-right: 5px;
            }

            .custom-btn {
                max-width: 150px;
                padding-left: 10px;
                padding-right: 10px;
            }
        }

        @media (max-width: 576px) {
            .table th, .table td {
                font-size: 8px;
                padding: 4px;
            }

            .input-group .form-control {
                width: 100px;
            }

            .input-group .btn {
                font-size: 9px;
                padding-left: 4px;
                padding-right: 4px;
            }

            .custom-btn {
                width: auto;
                max-width: 120px;
            }

            .d-flex.justify-content-end {
                flex-direction: column;
                align-items: flex-start;
                margin-top: 15px;
            }
        }

    </style>
@endpush

<script>
    function toggleSelectAll() {
        var isChecked = document.getElementById('select-all').checked;
        var checkboxes = document.querySelectorAll('.item-checkbox');
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = isChecked;
        });
        updateButtonStates();
    }

    function updateButtonStates() {
        var checkboxes = document.querySelectorAll('.item-checkbox');
        var hasChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);
        
        var removeBtn = document.getElementById('remove-btn');
        var checkoutBtn = document.getElementById('checkout-btn');
        
        if (hasChecked) {
            // Enable buttons
            removeBtn.disabled = false;
            checkoutBtn.disabled = false;
            removeBtn.style.opacity = '1';
            removeBtn.style.cursor = 'pointer';
            checkoutBtn.style.opacity = '1';
            checkoutBtn.style.cursor = 'pointer';
        } else {
            // Disable buttons
            removeBtn.disabled = true;
            checkoutBtn.disabled = true;
            removeBtn.style.opacity = '0.5';
            removeBtn.style.cursor = 'not-allowed';
            checkoutBtn.style.opacity = '0.5';
            checkoutBtn.style.cursor = 'not-allowed';
        }
        
        // Update select-all checkbox state
        var selectAllCheckbox = document.getElementById('select-all');
        var totalCheckboxes = checkboxes.length;
        var checkedCheckboxes = Array.from(checkboxes).filter(checkbox => checkbox.checked).length;
        
        if (checkedCheckboxes === 0) {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = false;
        } else if (checkedCheckboxes === totalCheckboxes) {
            selectAllCheckbox.checked = true;
            selectAllCheckbox.indeterminate = false;
        } else {
            selectAllCheckbox.checked = false;
            selectAllCheckbox.indeterminate = true;
        }
    }

    function changeQuantity(id, delta) {
        var quantityInput = document.getElementById('quantity-' + id);
        var currentQuantity = parseInt(quantityInput.value);

        var newQuantity = currentQuantity + delta;
        if (newQuantity < 1) {
            newQuantity = 1;
        }

        quantityInput.value = newQuantity;
        
        // Update subtotal secara real-time menggunakan harga diskon
        updateSubtotalDisplay(id, newQuantity);
        
        document.getElementById('confirm-' + id).style.display = 'inline-block';
    }
    
    // Fungsi untuk update subtotal display tanpa AJAX
    function updateSubtotalDisplay(id, quantity) {
        var row = document.querySelector(`tr[data-item-id="${id}"]`);
        var discountedPrice = parseFloat(row.getAttribute('data-discounted-price'));
        var newSubtotal = discountedPrice * quantity;
        
        // Update subtotal display
        document.getElementById('subtotal-' + id).innerHTML = 'Rp' + formatNumber(newSubtotal);
        
        // Update total keseluruhan
        updateGrandTotal();
    }
    
    // Fungsi untuk format number seperti Laravel number_format
    function formatNumber(num) {
        return Math.round(num).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
    
    // Fungsi untuk update grand total
    function updateGrandTotal() {
        var total = 0;
        var rows = document.querySelectorAll('tr[data-item-id]');
        
        rows.forEach(function(row) {
            var id = row.getAttribute('data-item-id');
            var quantity = parseInt(document.getElementById('quantity-' + id).value);
            var discountedPrice = parseFloat(row.getAttribute('data-discounted-price'));
            total += discountedPrice * quantity;
        });
        
        document.getElementById('total-price').innerHTML = formatNumber(total);
    }
    
    function confirmQuantity(id) {
        var quantityInput = document.getElementById('quantity-' + id);
        var newQuantity = parseInt(quantityInput.value);
        
        // Hide confirm button
        document.getElementById('confirm-' + id).style.display = 'none';
        
        // Create form data
        var formData = new FormData();
        formData.append('id', id);
        formData.append('quantity', newQuantity);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
        
        // Send AJAX request
        fetch('/cart/update', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update dengan data dari server (untuk memastikan konsistensi)
                document.getElementById('total-price').innerText = data.new_total;
                document.getElementById('subtotal-' + id).innerHTML = 'Rp' + data.item_total;
                
                console.log('Quantity updated successfully!');
            } else {
                alert('Failed to update quantity');
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error updating cart:', error);
            alert('There was an error updating the cart.');
            location.reload();
        });
    }
    
    // Event listener untuk perubahan manual quantity input
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize button states on page load
        updateButtonStates();
        
        var quantityInputs = document.querySelectorAll('.quantity-input');
        quantityInputs.forEach(function(input) {
            input.addEventListener('input', function() {
                var id = this.id.replace('quantity-', '');
                var quantity = parseInt(this.value) || 1;
                
                if (quantity < 1) {
                    this.value = 1;
                    quantity = 1;
                }
                
                updateSubtotalDisplay(id, quantity);
                document.getElementById('confirm-' + id).style.display = 'inline-block';
            });
        });
    });
</script>