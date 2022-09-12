<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="" class="brand-link text-center">
        {{-- <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
        <span class="brand-text font-weight-dark">Stack Project</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            {{-- <div class="image">
                <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
            </div> --}}
            <div class="info">
                <a href="#" class="d-block">
                    <i class="nav-icon fas fa-user ml-3 mr-2"></i>
                    @if(Auth::check()){{ Auth::user()->name }} @endif
                </a>
            </div>
        </div>
        {{-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{url('/')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tag.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tag"></i>
                        <p>Tag</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('question.create')}}" class="nav-link">
                        <i class="nav-icon fas fa-question"></i>
                        <p>Ask Question</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>