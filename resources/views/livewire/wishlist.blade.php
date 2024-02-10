<a href="{{route('wishlist')}}" class="wishlist_bt_top" title="Your wishlist">
    <span class="icon me-lg-1"><i class="icon_heart_alt"></i></span>
    <span class="text d-none d-lg-block">{{dynamicLang('Wishlist')}}</span> 
    @if($data != 0)
        <span class="wishlist-counts">{{$data}}</span>
    @else 
    @endif 
</a>