
<li class="m-nav__separator">
    -
</li>
<li class="m-nav__item">
    @if($breadcrumb->getIsOnlyEdit())
        <a class="m-nav__link" href="{{ route('admin.main.edit', [$breadcrumb->id, 'selected_category'=>$breadcrumb->id]) }}">
            <span class="m-nav__link-text">
                {{ $breadcrumb->name }}
            </span>
        </a>
    @else
        <a class="m-nav__link" href="{{ route('admin.main.index', ['selected_category'=>$breadcrumb->id]) }}">
            <span class="m-nav__link-text">
                {{ $breadcrumb->name }}
            </span>
        </a>
    @endif
</li>

@if (count($breadcrumb['children']) > 0)
    @foreach($breadcrumb['children'] as $breadcrumb)
        @include('widgets.admin.each_breadcrumbs', $breadcrumb)
    @endforeach
@endif