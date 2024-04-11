@extends('layouts.default')

@section('title', '订单详情')
@section('body-class','order-detail')

@section('content')
    <section class="page-section">
        <div class="container">
            <p class="text-center text-safety-orange">
                Order #{{$order->order_no}} was placed on {{$order->created_at->format('d/m/Y')}} and is
                currently {{$order->status}}.
            </p>
            <h3>Order details</h3>
            <div class="order-products">
                <div class="order-product order-product-header">
                    <div class="order-product__title">Product</div>
                    <div class="order-product__price">Price</div>
                </div>
                @foreach($order->items as $item)
                    <div class="order-product">
                        <img src="{{$item->image}}" class="order-product__thumb" alt="">
                        <div class="order-product__title">
                            <div class="title">{{ $item->title }}</div>
                            @if(!empty($item->meta_data))
                                <div class="metas">
                                    @foreach($item->meta_data as $meta)
                                        <dl class="meta-data-item">
                                            <dt>{{$meta['key'] ?? ''}}</dt>
                                            <dd>{{ $meta['value']??'' }}</dd>
                                        </dl>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="order-product__price">
                            <strong>€{{$item->price}}</strong>
                            <span>x{{$item->quantity}}</span>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="order-totals">
                <div class="order-total">
                    <div class="order-total__label">Subtotal</div>
                    <div class="order-total__value">€{{$order->total}}</div>
                </div>
                <div class="order-total">
                    <div class="order-total__label">Shipping</div>
                    <div class="order-total__value">€{{$order->shipping_total}} via {{$order->shipping_method}}</div>
                </div>
                <div class="order-total">
                    <div class="order-total__label">Total</div>
                    <div class="order-total__value">€{{$order->total}}</div>
                </div>
            </div>
            <div class="blank-2"></div>
            <h3>Shipping Address</h3>
            <div class="order-shipping">
                <div>{{$order->shipping['name'] ?? ''}}</div>
                <div>
                    {{$order->shipping['address'] ?? ''}}
                </div>
                @if(isset($order->shipping['city']))
                    <div>
                        {{$order->shipping['city'] ?? ''}}
                    </div>
                @endif
                @if(isset($order->shipping['state']))
                    <div>
                        {{$order->shipping['state'] ?? ''}}
                    </div>
                @endif
                @if(isset($order->shipping['country']))
                    <div>
                        {{$order->shipping['country'] ?? ''}}
                    </div>
                @endif
                <div>
                    <i class="bi bi-telephone"></i>
                    <span>{{$order->shipping['phone'] ?? ''}}</span>
                </div>
                @if(isset($order->shipping['email']))
                    <div>
                        <i class="bi bi-envelope"></i>
                        {{$order->shipping['email'] ?? ''}}
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection