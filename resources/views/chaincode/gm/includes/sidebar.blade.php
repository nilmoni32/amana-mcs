<ul class="app-menu">
    <li>
        <a class="app-menu__item bg-white text-primary {{ Route::currentRouteName() == 'GMcode.edit' ? 'active' : '' }}"
            href="{{ route('GMcode.edit', $gm->id) }}">
            <span class="app-menu__label">{{ __('General') }}</span>
        </a>
    </li>
    @php if(Route::currentRouteName() == 'GMcode.nominee.index' ||
    Route::currentRouteName() == 'GMcode.nominee.create'){
    $temp = 1;
    }else{
    $temp = 0;
    }
    @endphp
    <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
        <a class="app-menu__item bg-white text-primary" href="#" data-toggle="treeview">
            <span class="app-menu__label">{{ __('GM Nominee') }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'GMcode.nominee.index' ? 'current' : '' }}"
                    href="{{ route('GMcode.nominee.index', $gm->id)}}">{{ __('Nominee List') }}</a>
            </li>
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'GMcode.nominee.create' ? 'current' : '' }}"
                    href="{{ route('GMcode.nominee.create', $gm->id)}}">{{ __('Add Nominee') }}</a>
            </li>
        </ul>
    </li>
    
</ul>