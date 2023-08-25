<h1>Showing all</h1>

@forelse ($lists as $list)
    <li>{{ $list->va_payment_method_name }}</li>
@empty
    <p> 'No data yet' </p>
@endforelse
