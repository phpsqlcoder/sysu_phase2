@php $page = $item->page; @endphp
@if (!empty($page) && $item->is_page_type() && $page->is_published())
    <li @if(url()->current() == $page->get_url() || ($page->id == 1 && url()->current() == env('APP_URL'))) class="current-menu active" @endif @if ($item->has_sub_menus()) class="dropdown_menu" @endif>
        <a href="{{ $page->get_url() }}" class="btn">
            @if (!empty($page->label))
                {{ $page->label }}
            @else
                {{ $page->name }}
            @endif
        </a>
        @if ($item->has_sub_menus())
            <ul class="rd-navbar-dropdown">
                @foreach ($item->sub_pages as $subItem)
                    @include('theme.sysu.layout.menu-item', ['item' => $subItem])
                @endforeach
            </ul>
        @endif
    </li>
@elseif ($item->is_external_type())
    <li>
        <a href="{{ $item->uri }}" target="{{ $item->target }}" class="btn">{{ $item->label }}</a>
        @if ($item->has_sub_menus())
            <ul class="rd-navbar-dropdown">
                @foreach ($item->sub_pages as $subItem)
                    @include('theme.sysu.layout.menu-item', ['item' => $subItem])
                @endforeach
            </ul>
        @endif
    </li>
@endif
