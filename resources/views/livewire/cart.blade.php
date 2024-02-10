<a href="{{route('cart')}}" class="cart-menu-btn" title="Cart">
    <span class="icon me-lg-1"><i class="icon_cart_alt"></i></span>
    <span class="text d-none d-lg-block">{{dynamicLang('Cart')}}</span>
    @if($data != 0)
        <span class="cart-counts">{{$data}}</span>
    @else

    @endif 
</a>