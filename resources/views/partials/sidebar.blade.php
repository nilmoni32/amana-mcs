 <!-- Sidebar menu-->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
 <aside class="app-sidebar">
   <div class="app-sidebar__user">
     <div class="pl-2">
        <p class="app-sidebar__user-name">{{ Auth::guard('web')->user()->name  }}</p>
        <p class="app-sidebar__user-designation">[ Full Stack Developer ]</p>
     </div>
   </div>
   <ul class="app-menu">
        <li>
            {{-- if current route name is dashboard we will set active class  --}}
            <a class="app-menu__item {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">{{ __('Dashboard') }}</span>
            </a>
        </li>
        <li>
          {{-- if current route name is admin.categories.index we will set active class here --}}
          <a class="app-menu__item {{ Route::currentRouteName() == 'branch.index' ? 'active' : '' }}"
            href="{{ route('branch.index')}}">
            <i class="app-menu__icon fa fa-tags"></i>
            <span class="app-menu__label">{{ __('Branch List') }}</span></a>
        </li>
        @php if(Route::currentRouteName() == 'GMcode.index' || Route::currentRouteName() == 'DGMcode.index' ||
                Route::currentRouteName() == 'RSMcode.index' || Route::currentRouteName() == 'ASMcode.index' ||
                Route::currentRouteName() == 'BMcode.index' || Route::currentRouteName() == 'MOcode.index' ){
                $temp = 1;
              }else{
                $temp = 0;
              }
        @endphp
        <li class="{{ $temp ? 'treeview is-expanded' : 'treeview' }}">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa-chrome"></i><span class="app-menu__label">{{ __('Chain Code') }}</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">
            <li>
              {{-- if current route name is dashboard we will set active class  --}}
              <a class="treeview-item {{ Route::currentRouteName() == 'GMcode.index' ? 'active' : ''}}"
                href="{{route('GMcode.index')}}">
                <i class="app-menu__icon fa fa-arrow-circle-o-right"></i>
                <span class="app-menu__label">{{ __('GM') }}</span>
              </a>
            </li>
            <li>
              {{-- if current route name is dashboard we will set active class  --}}
              <a class="treeview-item {{ Route::currentRouteName() == 'DGMcode.index' ? 'active' : ''}}"
                href="{{route('DGMcode.index')}}">
                <i class="app-menu__icon fa fa-arrow-circle-o-right"></i>
                <span class="app-menu__label">{{ __('DGM') }}</span>
              </a>
            </li>
            <li>
              {{-- if current route name is dashboard we will set active class  --}}
              <a class="treeview-item {{ Route::currentRouteName() == 'RSMcode.index' ? 'active' : ''}}"
                href="{{route('RSMcode.index')}}">
                <i class="app-menu__icon fa fa-arrow-circle-o-right"></i>
                <span class="app-menu__label">{{ __('RSM') }}</span>
              </a>
            </li>
            <li>
              {{-- if current route name is dashboard we will set active class  --}}
              <a class="treeview-item {{ Route::currentRouteName() == 'ASMcode.index' ? 'active' : ''}}"
                href="{{route('ASMcode.index')}}">
                <i class="app-menu__icon fa fa-arrow-circle-o-right"></i>
                <span class="app-menu__label">{{ __('ASM') }}</span>
              </a>
            </li>
            <li>
              {{-- if current route name is dashboard we will set active class  --}}
              <a class="treeview-item {{ Route::currentRouteName() == 'BMcode.index' ? 'active' : ''}}"
                href="{{route('BMcode.index')}}">
                <i class="app-menu__icon fa fa-arrow-circle-o-right"></i>
                <span class="app-menu__label">{{ __('BM') }}</span>
              </a>
            </li>
            <li>
              {{-- if current route name is dashboard we will set active class  --}}
              <a class="treeview-item {{ Route::currentRouteName() == 'MOcode.index' ? 'active' : ''}}"
                href="{{route('MOcode.index')}}">
                <i class="app-menu__icon fa fa-arrow-circle-o-right"></i>
                <span class="app-menu__label">{{ __('MO') }}</span>
              </a>
            </li>
          </ul>
        </li>
        <li>
          {{-- if current route name is dashboard we will set active class  --}}
          <a class="app-menu__item {{ Route::currentRouteName() == 'settings' ? 'active' : '' }}" href="{{ route('settings') }}">
              <i class="app-menu__icon fa fa-cogs"></i>
              <span class="app-menu__label">Settings</span>
          </a>
        </li> 
   </ul>
 </aside>