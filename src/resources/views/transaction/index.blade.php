<h1>Showing all</h1>

@forelse ($lists as $list)
    <li>{{ $list->chat_account }}</li>
@empty
    <p> 'No data yet' </p>
@endforelse
