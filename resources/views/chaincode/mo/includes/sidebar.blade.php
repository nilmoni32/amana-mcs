<ul class="app-menu">
    <li>
        <a class="app-menu__item bg-white text-primary {{ Route::currentRouteName() == 'MOcode.edit' ? 'active' : '' }}"
            href="{{ route('MOcode.edit', $mo->id) }}">
            <span class="app-menu__label">{{ __('General') }}</span>
        </a>
    </li>
    @php if(Route::currentRouteName() == 'MOcode.nominee.index' ||
    Route::currentRouteName() == 'MOcode.nominee.create'){
    $temp = 1;
    }else{
    $temp = 0;
    }
    @endphp
    <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
        <a class="app-menu__item bg-white text-primary" href="#" data-toggle="treeview">
            <span class="app-menu__label">{{ __('MO Nominee') }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'MOcode.nominee.index' ? 'current' : '' }}"
                    href="{{ route('MOcode.nominee.index', $mo->id)}}">{{ __('Nominee List') }}</a>
            </li>
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'MOcode.nominee.create' ? 'current' : '' }}"
                    href="{{ route('MOcode.nominee.create', $mo->id)}}">{{ __('Add Nominee') }}</a>
            </li>
        </ul>
    </li>
    
</ul>