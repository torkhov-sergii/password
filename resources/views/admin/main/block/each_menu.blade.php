
<li class="m-menu__item m-menu__item--submenu {{ (in_array($category->id, $opened_categories)) ? 'm-menu__item--expanded m-menu__item--open' : '' }} {{ ($category->id == $selected_category) ? 'm-menu__item--active' : '' }}" aria-haspopup="true" data-menu-submenu-toggle="hover">

    @if(!$category->children()->count())
        <a class="m-menu__link m-menu__toggle2" href="{{ route('admin.main.edit', [$category->id, 'selected_category'=>$category->id]) }}" style2="padding-left: {{ ($category['depth']-0.5)*20 }}px">
            <i class="m-menu__link-icon {{$category->type->icon}}"></i>
            <span class="m-menu__link-text">
                {{$category->name}}
            </span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
    @elseif($category->children()->first()->children()->count())
        <a class="m-menu__link m-menu__toggle2" href="{{ route('admin.main.index', ['selected_category'=>$category->children()->first()->id]) }}" style2="padding-left: {{ ($category['depth']-0.5)*20 }}px">
            <i class="m-menu__link-icon {{$category->type->icon}}"></i>
            <span class="m-menu__link-text">
                {{$category->name}}
            </span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
    @else
        <a class="m-menu__link m-menu__toggle2" href="{{ route('admin.main.index', ['selected_category'=>$category->id]) }}" style2="padding-left: {{ ($category['depth']-0.5)*20 }}px">
            <i class="m-menu__link-icon {{$category->type->icon}}"></i>
            <span class="m-menu__link-text">
                {{$category->name}}
            </span>
            <i class="m-menu__ver-arrow la la-angle-right"></i>
        </a>
    @endif

    @if (count($category['children']) > 0)
    <div class="m-menu__submenu ">
        <span class="m-menu__arrow"></span>
        <ul class="m-menu__subnav">
                @foreach($category['children'] as $category)
                    @include('admin.main.block.each_menu', ['category' => $category, 'opened_categories' => $opened_categories, 'selected_category' => $selected_category])
                @endforeach
        </ul>
    </div>
    @endif

</li>
