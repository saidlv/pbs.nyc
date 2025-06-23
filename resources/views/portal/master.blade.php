@extends('adminlte::page')

@section('meta_tags')
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
    @vite(['resources/css/app.css'])
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
@append


@include('portal.partials.footer')