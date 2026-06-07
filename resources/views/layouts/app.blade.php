<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Activity Tracker') - Support Team</title>
    <meta name="description" content="Applications Support Team Activity Tracker">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar__brand">
                <div class="sidebar__logo">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <span class="sidebar__title">ActivityTracker</span>
            </div>
            <nav class="sidebar__nav">
                <a href="{{ route('dashboard') }}" class="sidebar__link {{ request()->routeIs('dashboard') || request()->routeIs('home') ? 'sidebar__link--active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
                    <span>Dashboard</span>
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('activities.index') }}" class="sidebar__link {{ request()->routeIs('activities.*') ? 'sidebar__link--active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z"/></svg>
                    <span>Activities</span>
                </a>
                @endif
                <a href="{{ route('reports.index') }}" class="sidebar__link {{ request()->routeIs('reports.*') ? 'sidebar__link--active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                    <span>Reports</span>
                </a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('users.index') }}" class="sidebar__link {{ request()->routeIs('users.*') ? 'sidebar__link--active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
                    <span>Team Members</span>
                </a>
                @endif
            </nav>
            <div class="sidebar__footer">
                <div class="sidebar__user">
                    <div class="sidebar__avatar">{{ substr(auth()->user()->name, 0, 1) }}</div>
                    <div class="sidebar__user-info">
                        <span class="sidebar__user-name">{{ auth()->user()->name }}</span>
                        <span class="sidebar__user-role">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="sidebar__logout">
                    @csrf
                    <button type="submit" class="sidebar__logout-btn" title="Logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar">
                <button class="topbar__menu-btn" id="menu-toggle" aria-label="Toggle menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                <h1 class="topbar__title">@yield('page-title', 'Dashboard')</h1>
                <div class="topbar__actions">
                    <button class="topbar__theme-toggle" id="theme-toggle" aria-label="Toggle theme">
                        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
                        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/></svg>
                    </button>
                </div>
            </header>

            @if(session('success'))
            <div class="alert alert--success" id="flash-message">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span>{{ session('success') }}</span>
                <button class="alert__close" onclick="this.parentElement.remove()">&times;</button>
            </div>
            @endif
            @if(session('error'))
            <div class="alert alert--error" id="flash-error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <span>{{ session('error') }}</span>
                <button class="alert__close" onclick="this.parentElement.remove()">&times;</button>
            </div>
            @endif
            @if($errors->any())
            <div class="alert alert--error">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                <div>@foreach($errors->all() as $error)<p>{{ $error }}</p>@endforeach</div>
                <button class="alert__close" onclick="this.parentElement.remove()">&times;</button>
            </div>
            @endif

            <div class="content">@yield('content')</div>

            <footer class="app-footer">
                <p>&copy; {{ date('Y') }} Dennis Samuel Asante-Asare. All rights reserved.</p>
            </footer>
        </main>
    </div>
    <div class="sidebar-overlay" id="sidebar-overlay"></div>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
