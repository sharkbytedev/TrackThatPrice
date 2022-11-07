<div>
    <h3>A product you're tracking has had a price drop.</h3>
    <p>A product you're tracking, <a href="{{ $product->product_url }}">"{{ $product->product_name }}"</a>, has had a price drop of {{ $change_type == 'flat' ? $change_value : $change_value.'%' }}</p>
    <p><del style="color:red;">{{ $old_price/100.0 }}</del> -> <b style="color: green;">{{ $product->price/100.0 }}</b></p>
</div>