<ul class="app-menu">
    <li>
        <a class="app-menu__item bg-white text-primary {{ Route::currentRouteName() == 'BMcode.edit' ? 'active' : '' }}"
            href="{{ route('BMcode.edit', $bm->id) }}">
            <span class="app-menu__label">{{ __('General') }}</span>
        </a>
    </li>
    @php if(Route::currentRouteName() == 'BMcode.nominee.index' ||
    Route::currentRouteName() == 'BMcode.nominee.create'){
    $temp = 1;
    }else{
    $temp = 0;
    }
    @endphp
    <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
        <a class="app-menu__item bg-white text-primary" href="#" data-toggle="treeview">
            <span class="app-menu__label">{{ __('BM Nominee') }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
        </a>
        <ul class="treeview-menu">
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'BMcode.nominee.index' ? 'current' : '' }}"
                    href="{{ route('BMcode.nominee.index', $bm->id)}}">{{ __('Nominee List') }}</a>
            </li>
            <li>
                <a class="treeview-item bg-white text-primary {{ Route::currentRouteName() == 'BMcode.nominee.create' ? 'current' : '' }}"
                    href="{{ route('BMcode.nominee.create', $bm->id)}}">{{ __('Add Nominee') }}</a>
            </li>
        </ul>
    </li>
    
</ul>