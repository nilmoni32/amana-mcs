<ul class="app-menu">
    <li>
        <a class="app-menu__item bg-white text-primary {{ Route::currentRouteName() == 'DGMcode.edit' ? 'active' : '' }}"
            href="{{ route('DGMcode.edit', $dgm->id) }}">
            <span class="app-menu__label">{{ __('General') }}</span>
        </a>
    </li>
    @php if(Route::currentRouteName() == 'DGMcode.nominee.index' ||
    Route::currentRouteName() == 'DGMcode.nominee.create'){
    $temp = 1;
    }else{
    $temp = 0;
    }
    @endphp
    <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
        <a class="app-menu__item bg-white text-primary" href="#" data-toggle="treeview">
            <span class="app-menu__label">{{ __('DGM Nominee') }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'DGMcode.nominee.index' ? 'current' : '' }}"
                    href="{{ route('DGMcode.nominee.index', $dgm->id)}}">{{ __('Nominee List') }}</a>
            </li>
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'DGMcode.nominee.create' ? 'current' : '' }}"
                    href="{{ route('DGMcode.nominee.create', $dgm->id)}}">{{ __('Add Nominee') }}</a>
            </li>
        </ul>
    </li>
    
</ul>