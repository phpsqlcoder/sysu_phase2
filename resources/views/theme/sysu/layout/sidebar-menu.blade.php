<ul class="quicklinks ul-none no-padding mb-3">
    <li @if(Route::current()->getName() == 'my-account.manage-account') class="active" @endif><a href="{{ route('my-account.manage-account') }}">Manage Account</a></li>
    <li @if(Route::current()->getName() == 'profile.sales') class="active" @endif><a href="{{ route('profile.sales') }}">My Orders</a></li>
    <li @if(Route::current()->getName() == 'profile.favorites') class="active" @endif><a href="{{ route('profile.favorites') }}">My Favorites</a></li>
    <li @if(Route::current()->getName() == 'profile.wishlist') class="active" @endif><a href="{{ route('profile.wishlist') }}">My Wishlist <span style="background-color: white; height: 23px; width: 20px;" class="badge">{{ \App\EcommerceModel\CustomerWishlist::wishlist_available() }}</span></a></li>
    <li @if(Route::current()->getName() == 'coupons-available') class="active" @endif><a href="#">My Coupons</a>
		<ul class="ul-none">
			<li @if(Route::current()->getName() == 'coupons-available') class="active" @endif><a href="{{ route('coupons-available') }}" style="color:@if(Route::current()->getName() == 'coupons-available') white @else black @endif">Available Coupons</a></li>
			<li><a href="#">Expired Coupons</a></li>
			<li><a href="#">Claimed Coupons</a></li>
		</ul>
	</li>
</ul>