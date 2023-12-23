@extends('layouts.main')

@section('content')
<!-- Shopping Cart Section Begin -->
<section class="shopping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @if(Session::has('cart'))
                            @foreach(Session::get('cart') as $id=>$product)
                                    <tr>
                                        <td class="product__cart__item">
                                            <div class="product__cart__item__pic">
                                                <img src="{{ asset('img/' . $product['image']) }}"
                                                    alt="" style="width: 200px;" height="200px">
                                            </div>
                                            <div class="product__cart__item__text">
                                                <h6>{{ $product['name'] }}</h6>
                                                <h5>{{ $product['price'] }}</h5>
                                            </div>
                                        </td>
                                        <td class="quantity__item">
                                            <div class="quantity">
                                                <div class="pro-qty-2">
                                                    <form method="post"
                                                        action="{{ route('edit_product_quantity') }}">
                                                        @csrf
                                                        <input type="text" name="quantity"
                                                            value="{{ $product['quantity'] }}">
                                                        <input type="hidden" name="id"
                                                            value="{{ $product['id'] }}">
                                                        <input type="submit" value="Edit"
                                                            name="edit_product_quantity_button">
                                                    </form>
                                                </div>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="cart__price">$
                                            {{ $product['quantity'] * $product['price'] }}
                                        </td>
                                        <td class="cart__close">
                                            <form method="post"
                                                action="{{ route('remove_from_cart') }}">
                                                @csrf
                                                <input type="hidden" name="id"
                                                    value="{{ $product['id'] }}">
                                                <button type="submit" name="remove_button" class="fa fa-close"
                                                    value="remove"></button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="#">Continue Shopping</a>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn update__btn">
                            <a href="#"><i class="fa fa-spinner"></i> Update cart</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                @if(Session::has('total'))

                    <div class="cart__total">
                        <h6>Cart total</h6>
                        <ul>
                            <li>Total <span>${{ Session::get('total') }}</span></li>
                        </ul>
                        @if(Session::get('total') != null)
                            <!-- Updated the form method from GET to POST -->
                            <form method="GET" action="{{ url('checkout') }}">
                                <a href="{{ url('/checkout') }}" class="primary-btn">Proceed to
                                    checkout</a>
                            </form>
                        @endif
                    </div>

                @endif
            </div>

        </div>
    </div>
</section>
<!-- Shopping Cart Section End -->

@endsection
