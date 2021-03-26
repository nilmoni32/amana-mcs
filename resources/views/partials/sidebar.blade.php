 <!-- Sidebar menu-->
 <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
 <aside class="app-sidebar">
   <div class="app-sidebar__user">
     <div class="pl-2">
        <p class="app-sidebar__user-name">Nilmoni Mustafi</p>
        <p class="app-sidebar__user-designation">[ Full Stack Developer ]</p>
     </div>
   </div>
   <ul class="app-menu">
        <li>
            {{-- if current route name is dashboard we will set active class  --}}
            <a class="app-menu__item" href="#">
                <i class="app-menu__icon fa fa-dashboard"></i>
                <span class="app-menu__label">Dashboard</span>
            </a>
        </li>       
        <li class="treeview">
          <a class="app-menu__item" href="#" data-toggle="treeview">
            <i class="app-menu__icon fa fa fa-braille"></i><span class="app-menu__label">Reports</span>
            <i class="treeview-indicator fa fa-angle-right"></i>
          </a>
          <ul class="treeview-menu">        
            <li>
              <a class="treeview-item" href="#">
                <i class="icon fa fa-circle-o"></i>Profit and Loss</a>
            </li>        
            <li>
              <a class="treeview-item" href="#">
                <i class="icon fa fa-circle-o"></i>Cash Register Wise Sales</a>
            </li>
          </ul>
        </li>
   </ul>
 </aside>