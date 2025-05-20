@extends('base.base')

@section('content')
<h2 class="text-center mb-4" style="font-family: 'Bebas Neue', sans-serif; color: #181B1E; margin-top: 30px; font-weight: bold;">
    <i class="bi bi-cart" style="color: #181B1E; font-size: 30px; margin-right: 10px;"></i> My Cart
</h2>


@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3 shadow-lg z-3" role="alert" style="min-width: 300px; background-color: #A5A9AE; color: #fff;">
        {{ session('success') }}
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
                        <th> <input type="checkbox" id="select-all" onclick="toggleSelectAll()" style="cursor: pointer; width: 20px; height: 20px; border: 2px solid #CFD1D4; background-color: #FFF; accent-color: #181B1E; border-radius: 5px; transition: all 0.3s ease;"></th>
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
                    @foreach ($cart as $id => $item)
                        @php 
                            $total += $item['price'] * $item['quantity']; 
                            $productImage = $item['image'] ?? 'default-image.jpg'; // Retrieve the image from the cart data
                        @endphp
                        <tr style="background-color: #FFF; border-bottom: 1px solid #CFD1D4;">
                            <td style="vertical-align: middle;">
                                <input type="checkbox" name="selected_items[]" value="{{ $id }}" class="item-checkbox" style="cursor: pointer; width: 20px; height: 20px; border: 2px solid #CFD1D4; background-color: #FFF; accent-color: #181B1E; border-radius: 5px; transition: all 0.3s ease;">
                            </td>
                            <td style="vertical-align: middle;">
                                <img src="{{ $productImage }}" alt="{{ $item['name'] }}" style="width: 150px; height: 150px; object-fit: cover; border-radius: 5px;">
                            </td>
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                {{ $item['name'] }}
                            </td>
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                {{ $item['size'] ?? '36' }}
                            </td>
                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                Rp{{ number_format($item['price'], 0, ',', '.') }}
                            </td>

                            <td style="vertical-align: middle;">
                                <div style="display: flex; align-items: center;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQuantity({{ $id }}, -1)" style="margin-right: 5px; padding: 5px 10px;">-</button>
                                    <input type="number" name="quantity[{{ $id }}]" value="{{ $item['quantity'] }}" class="quantity-input" id="quantity-{{ $id }}" style="width: 50px; text-align: center; font-family: 'Fredoka', sans-serif; font-size: 1rem; border: 1px solid #CFD1D4; border-radius: 5px; padding: 5px; -moz-appearance: textfield; -webkit-appearance: none;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="changeQuantity({{ $id }}, 1)" style="margin-left: 5px; padding: 5px 10px;">+</button>
                                </div>
                                <button type="button" class="btn btn-sm btn-link" id="confirm-{{ $id }}" onclick="confirmQuantity({{ $id }})" style="display:none; text-decoration: underline; font-family: 'Fredoka', sans-serif; color: #5F6266;">Confirm</button>
                            </td>

                            <td style="font-family: 'Fredoka', sans-serif; font-size: 1rem; color: #5F6266; vertical-align: middle;">
                                Rp{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
            <h5 style="font-family: 'Bebas Neue', sans-serif; color: #181B1E;">Total: Rp<span id="total-price">{{ number_format($total, 0, ',', '.') }}</span></h5>

        <button type="submit" class="btn" style="font-family: 'Fredoka', sans-serif; background-color: #5F6266; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-transform: uppercase;">Remove</button>
        </form>
        <form action="{{ route('copage') }}" method="POST">
            @csrf
            <button type="submit" class="btn" style="font-family: 'Fredoka', sans-serif; background-color: #181B1E; color: white; border: none; padding: 10px 20px; border-radius: 5px; text-transform: uppercase;">
                Checkout
            </button>
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
    }

    function changeQuantity(id, delta) {
        var quantityInput = document.getElementById('quantity-' + id);
        var currentQuantity = parseInt(quantityInput.value);

        var newQuantity = currentQuantity + delta;
        if (newQuantity < 1) {
            newQuantity = 1;
        }

        quantityInput.value = newQuantity;

        document.getElementById('confirm-' + id).style.display = 'inline-block';
    }

    function confirmQuantity(id) {
        var quantityInput = document.getElementById('quantity-' + id);
        var newQuantity = parseInt(quantityInput.value);

        document.getElementById('confirm-' + id).style.display = 'none';

        var form = document.querySelector('form');
        form.submit();
    }
</script>