<h3>There was an issue with a product you're tracking</h3>
<p>There was an error while fetching the price data for <a href="{{ $product->product_url }}">{{ $product->product_name }}</a></p>
@switch($error)
    @case('not_found')
        <p>The product URL you provided no longer exists. This means the product is no longer on sale, or has moved to a different URL.</p>
        <p>Make a new tracker with an updated URL to continue monitoring the price of this product.</p>
        @break
    @case('argument_exception')
        <p>We couldn't find some of the required information at the URL you gave for the product. Please ensure the link to the product is still working.</p>
        <p>If everything looks good, then the issue is likely caused by a change in the site's layout, and we will fix it as soon as possible.</p>
        @break
    @default
        <p>Please ensure the link you provided is still working. If everything looks right, it's likely a problem on our end, and we will work to fix it as soon as possible.</p>
        
@endswitch