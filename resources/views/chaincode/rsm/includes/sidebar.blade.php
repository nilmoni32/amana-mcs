<ul class="app-menu">
    <li>
        <a class="app-menu__item bg-white text-primary {{ Route::currentRouteName() == 'RSMcode.edit' ? 'active' : '' }}"
            href="{{ route('RSMcode.edit', $rsm->id) }}">
            <span class="app-menu__label">{{ __('General') }}</span>
        </a>
    </li>
    @php if(Route::currentRouteName() == 'RSMcode.nominee.index' ||
    Route::currentRouteName() == 'RSMcode.nominee.create'){
    $temp = 1;
    }else{
    $temp = 0;
    }
    @endphp
    <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
        <a class="app-menu__item bg-white text-primary" href="#" data-toggle="treeview">
            <span class="app-menu__label">{{ __('RSM Nominee') }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'RSMcode.nominee.index' ? 'current' : '' }}"
                    href="{{ route('RSMcode.nominee.index', $rsm->id)}}">{{ __('Nominee List') }}</a>
            </li>
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'RSMcode.nominee.create' ? 'current' : '' }}"
                    href="{{ route('RSMcode.nominee.create', $rsm->id)}}">{{ __('Add Nominee') }}</a>
            </li>
        </ul>
    </li>
    
</ul>