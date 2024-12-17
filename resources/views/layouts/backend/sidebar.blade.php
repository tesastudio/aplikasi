<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ asset('backend/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">TIARA KENCANA</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          {{-- <img src="{{ (Auth::user()->profile_image != null) ? url('upload/admin_images/'.Auth::user()->profile_image) : url('upload/no_image.jpg') }}" alt="User Image" class="img-circle elevation-2"> --}}
          <img src="{{ asset('backend/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">
            <?php
                  $userinfo = Auth::user()->name;
                
                  echo $userinfo
                  ?>
          </a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ url('utama') }}" class="nav-link  @if(Request::segment(1) == 'demo') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            
          </li>
          
          <li class="nav-item">
            <a href="{{ url('admin/dept') }}" class="nav-link @if(Request::segment(2) == 'dept') active @endif">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Department
                <span class="badge badge-info right">3</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/department') }}" class="nav-link @if(Request::segment(2) == 'dept') active @endif">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Department2
                <span class="badge badge-info right">3</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/employee') }}" class="nav-link @if(Request::segment(2) == 'employee') active @endif">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Employee
                <span class="badge badge-info right">3</span>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ url('admin/goods') }}" class="nav-link @if(Request::segment(2) == 'goods') active @endif">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Goods
                <span class="badge badge-info right">3</span>
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link  ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Goods Requisition
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('goodsrequest') }}" class="nav-link @if(Request::segment(1) == 'request') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('list_req_status') }}" class="nav-link @if(Request::segment(1) == 'status') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Status</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('allocatereq') }}" class="nav-link @if(Request::segment(1) == 'status') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alokasi ATK Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('editgoodsrequest/17') }}" class="nav-link @if(Request::segment(1) == 'status') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Test</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link  ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Purchase Requisition
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('purchaserequest') }}" class="nav-link @if(Request::segment(1) == 'request') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Request</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('list_purchase_status') }}" class="nav-link @if(Request::segment(1) == 'status') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Purchase Status</p>
                </a>
              </li>
              
            </ul>
          </li>
        </ul>
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
          <a href="{{ url('logout') }}" class="nav-link">
            <i class="nav-icon far fa-frown"></i>
            <p>
              Logout
              <span class="badge badge-info right"></span>
            </p>
          </a>
        </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
