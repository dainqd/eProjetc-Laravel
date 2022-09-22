<li class="sidebar-item {{ ($isActive ?? false) ? 'active' : '' }} {{ $slot->isNotEmpty() ? 'has-sub' : '' }}">
    <a href="{{ $href ?? '#' }}" class='sidebar-link'>
        <i class="{{ $icon }}"></i>
        <span>{{ $name }}</span>
    </a>
    @if($slot->isNotEmpty())
        <ul class="submenu" style="display: {{ $isActive ? 'block' : 'none' }};">
            {{ $slot }}
        </ul>
    @endif
</li>
