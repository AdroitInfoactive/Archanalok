<div class="access-btn">
    <a href="javascript:void(0);" class="btn-search"><i class="nss-search1"></i></a>
    <a href="{{ route('dashboard') }}" class="btn-user"><i class="nss-user1"></i></a>
    <a href="{{ route('cart.index') }}" class="btn-cart">
        <i class="nss-shopping-cart1"></i>
        <span class="cart-count">
            @if(@$cartDetails)
                {{ $cartDetails->count() }}
            @else
                0
            @endif
        </span>
    </a>
</div>
