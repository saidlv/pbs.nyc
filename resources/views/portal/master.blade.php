@extends('adminlte::page')

@section('meta_tags')
    <title>@yield('title', 'PBS Portal')</title>
    <meta name="description" content="@yield('meta_description', 'PBS Portal for property management, alerts, and more.')">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-RW51TYX51S"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', 'G-RW51TYX51S');
    </script>
@endsection

@section('css')
    @vite(['resources/css/app-optimized.css'])
    <style>
        /* --- Portal Customizations (minified for performance) --- */
        .main-footer{background:#38403e!important;border:0!important;color:#dce2e1!important}.main-footer a.text-muted{color:#a2acaa!important}.main-footer a.text-muted:hover{color:#fff!important}.content-header h1{color:#38403e!important}.info-box-icon{background:#38403e!important}.small-box .icon{color:rgba(255,255,255,.8)!important}.card-header{background:#38403e!important;color:#fff!important;border-bottom:1px solid #505955!important}.card-primary .card-header{background:#38403e!important}.table th{border-top:1px solid #a2acaa!important;color:#38403e!important;font-weight:600!important}.table-striped tbody tr:nth-of-type(odd){background:rgba(162,172,170,.05)!important}.form-group label{color:#38403e!important;font-weight:500!important}.box.box-primary{border-top-color:#38403e!important}.box.box-primary .box-header{background:#38403e!important;color:#fff!important}.badge-primary{background:#38403e!important}.badge-success{background:#5d8a5f!important}.badge-info{background:#6c8a93!important}.badge-warning{background:#b8a05c!important}.badge-danger{background:#a55c5c!important}.nav-tabs .nav-link.active{color:#38403e!important;background:#fff!important;border-color:#38403e #38403e #fff!important}.nav-tabs .nav-link{color:#616c66!important}.nav-tabs .nav-link:hover{color:#38403e!important;border-color:#dce2e1 #dce2e1 #dee2e6!important}
        /* --- Sidebar Logo Alignment & Hover Fix --- */
        .main-sidebar .brand-link{display:flex!important;align-items:center!important;justify-content:center!important;height:70px!important;padding:0!important;background:#38403e!important;border-bottom:1px solid rgba(255,255,255,0.1)!important;position:relative!important;}
        .main-sidebar .brand-link img,.main-sidebar .brand-link .brand-image,.main-sidebar .brand-link .brand-image-xl{height:48px!important;width:auto!important;margin:0 auto!important;display:block!important;background:none!important;box-shadow:none!important;border:none!important;}
        .main-sidebar .brand-link:after,.main-sidebar .brand-link:before{display:none!important;content:none!important;}
        .main-sidebar .brand-link:hover,.main-sidebar .brand-link:focus,.main-sidebar .brand-link:active{background:#38403e!important;box-shadow:none!important;outline:none!important;}
        .main-sidebar .brand-link *:hover,.main-sidebar .brand-link *:focus{background:none!important;box-shadow:none!important;outline:none!important;}
        .main-sidebar .brand-link .brand-text{display:none!important;}
    </style>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Only apply mobile sidebar functionality on mobile screens
            function handleMobileSidebar() {
                if (window.innerWidth <= 768) {
                    // Find the sidebar toggle button
                    const sidebarToggle = document.querySelector('[data-widget="pushmenu"]');
                    
                    if (sidebarToggle) {
                        // Remove any existing event listeners to prevent duplicates
                        sidebarToggle.removeEventListener('click', handleSidebarToggle);
                        sidebarToggle.addEventListener('click', handleSidebarToggle);
                    }
                    
                    // Handle sidebar toggle
                    function handleSidebarToggle(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        
                        // Simple toggle without any animations or delays
                        document.body.classList.toggle('sidebar-open');
                        console.log('Sidebar toggled:', document.body.classList.contains('sidebar-open'));
                    }
                    
                    // Close sidebar when clicking outside (overlay area)
                    document.addEventListener('click', function(e) {
                        if (document.body.classList.contains('sidebar-open')) {
                            const sidebar = document.querySelector('.main-sidebar');
                            const toggleButton = document.querySelector('[data-widget="pushmenu"]');
                            
                            // Check if click is outside sidebar and not on toggle button
                            if (sidebar && !sidebar.contains(e.target) && 
                                toggleButton && !toggleButton.contains(e.target) && 
                                !e.target.closest('[data-widget="pushmenu"]')) {
                                document.body.classList.remove('sidebar-open');
                                console.log('Sidebar closed by clicking outside');
                            }
                        }
                    });
                }
            }
            
            // Initialize
            handleMobileSidebar();
            
            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    // Remove mobile classes on larger screens
                    document.body.classList.remove('sidebar-open');
                } else {
                    // Re-initialize mobile sidebar on resize to mobile
                    handleMobileSidebar();
                }
            });
        });
    </script>
@append


@include('portal.partials.footer')