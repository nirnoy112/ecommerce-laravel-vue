@if (count($breadcrumbs))
    @foreach ($breadcrumbs as $breadcrumb)
        <li><a href="{{ $breadcrumb->url }}">{{ ucwords(strtolower($breadcrumb->title)) }}</a></li>
    @endforeach
@endif