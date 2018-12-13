
@if(isset($breadcrumbs))
<ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
    <li class="m-nav__item m-nav__item--home">
        <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
            <i class="m-nav__link-icon la la-home"></i>
        </a>
    </li>

    @foreach($breadcrumbs as $breadcrumb)
        @include('widgets.admin.each_breadcrumbs', ['breadcrumb' => $breadcrumb])
    @endforeach
</ul>
@endif
