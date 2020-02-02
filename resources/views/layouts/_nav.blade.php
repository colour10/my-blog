@foreach ($navs as $nav)
    @if ($nav['pid'] == 0)
        <li id="menu-item-{{ $nav['id'] }}"
            class="menu-item menu-item-type-taxonomy menu-item-object-category nav-menu<?php if ($routeInfo['path'] == $nav['uri']) { ?> current-menu-item<?php } ?>">
            <a title="{{ $nav['name'] }}"
               href="{{ route('channels.show', ['uri' => $nav['uri']]) }}">{{ $nav['name'] }}</a>
            @if ($subsnav_counts[$nav['id']])
                <ul class="sub-menu">
                    @foreach ($navs as $nav2)
                        @if ($nav2['pid'] == $nav['id'])
                            <li class="menu-item menu-item-type-post_type menu-item-object-page"
                                id="menu-item-{{ $nav2['id'] }}"><a
                                    href="{{ route('channels.show', ['uri' => $nav2['uri']]) }}">{{ $nav2['name'] }}</a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
@endforeach

