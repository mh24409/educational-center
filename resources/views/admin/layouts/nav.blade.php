<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin6">
            <a class="navbar-brand ms-4" href="{{route('admin.home')}}">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <img src="{{ asset('assets/images/logo-light-icon.png') }}" alt="homepage" class="dark-logo" />

                </b>
                <span class="logo-text">
                    <img src="{{ asset('assets/images/logo-light-text.png') }}" alt="homepage" class="dark-logo" />

                </span>
            </a>
            <a class="nav-toggler waves-effect waves-light text-white d-block d-md-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <ul class="navbar-nav d-lg-none d-md-block ">
                <li class="nav-item">
                    <a class="nav-toggler nav-link waves-effect waves-light text-white " href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                </li>
            </ul>
            <ul class="navbar-nav me-auto mt-md-0 ">

            </ul>
            <ul class="navbar-nav">

                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::guard('admin')->user()->name }}
                    </a>

                    <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.level.show') }}"
                        aria-expanded="false"><i class="mdi me-2 mdi-account-edit"></i><span
                            class="hide-menu">Levels</span></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.teacher.show') }}" aria-expanded="false"><i
                            class="mdi me-2 mdi-account-edit"></i><span class="hide-menu">Teachers</span></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.user.show') }}"
                        aria-expanded="false"><i class="mdi me-2 mdi-account"></i><span
                            class="hide-menu">Students</span></a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.subject.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Subjects</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.course.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Courses</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.matterial.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Matterials</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.homework.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Homework</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.quiz.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Quizzes</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.feedback.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Feedbacks</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link"
                        href="{{ route('admin.admin.show') }}" aria-expanded="false">
                        <i class="mdi me-2 mdi-folder-upload"></i>
                        <span class="hide-menu">Admins</span>
                    </a>
                </li>

            </ul>

        </nav>
    </div>
</aside>
