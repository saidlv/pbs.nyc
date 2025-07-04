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
        .main-footer {
            background-color: #38403e !important;
            border: 0 !important;
            color: #dce2e1 !important;
        }

        .main-footer a.text-muted {
            color: #a2acaa !important;
        }

        .main-footer a.text-muted:hover {
            color: white !important;
        }
        
        /* Additional portal-specific styling */
        .content-header h1 {
            color: #38403e !important;
        }
        
        .info-box-icon {
            background-color: #38403e !important;
        }
        
        .small-box .icon {
            color: rgba(255, 255, 255, 0.8) !important;
        }
        
        /* Card customization for portal pages */
        .card-header {
            background-color: #38403e !important;
            color: #ffffff !important;
            border-bottom: 1px solid #505955 !important;
        }
        
        .card-primary .card-header {
            background-color: #38403e !important;
        }
        
        /* Table enhancements */
        .table th {
            border-top: 1px solid #a2acaa !important;
            color: #38403e !important;
            font-weight: 600 !important;
        }
        
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(162, 172, 170, 0.05) !important;
        }
        
        /* Form styling improvements */
        .form-group label {
            color: #38403e !important;
            font-weight: 500 !important;
        }
        
        /* Widget box styling */
        .box.box-primary {
            border-top-color: #38403e !important;
        }
        
        .box.box-primary .box-header {
            background-color: #38403e !important;
            color: #ffffff !important;
        }
        
        /* Status indicators */
        .badge-primary {
            background-color: #38403e !important;
        }
        
        .badge-success {
            background-color: #5d8a5f !important;
        }
        
        .badge-info {
            background-color: #6c8a93 !important;
        }
        
        .badge-warning {
            background-color: #b8a05c !important;
        }
        
        .badge-danger {
            background-color: #a55c5c !important;
        }
        
        /* Navigation improvements */
        .nav-tabs .nav-link.active {
            color: #38403e !important;
            background-color: #ffffff !important;
            border-color: #38403e #38403e #ffffff !important;
        }
        
        .nav-tabs .nav-link {
            color: #616c66 !important;
        }
        
        .nav-tabs .nav-link:hover {
            color: #38403e !important;
            border-color: #dce2e1 #dce2e1 #dee2e6 !important;
        }
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