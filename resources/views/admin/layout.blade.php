<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{ asset('assets/images/icon-pmi.jpeg') }}" rel="icon" type="image/svg+xml">
    <link href="{{ asset('favicon.ico') }}" rel="alternate icon" type="image/x-icon">
    <title>@yield('title', 'Admin - Donasi PMI')</title>
    <link href="{{ asset('assets/admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/admin/css/ruang-admin.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/css/pmi-custom.css') }}" rel="stylesheet">

    <style>
        /* RuangAdmin Light Theme Style */

        /* Body and Background */
        body {
            background-color: #f8f9fc !important;
            color: #5a5c69;
        }

        #container-wrapper {
            background-color: #f8f9fc;
            min-height: calc(100vh - 56px);
            padding: 20px;
        }

        /* Sidebar - White Background */
        .sidebar {
            background-color: #fff !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
        }

        .sidebar-brand {
            background-color: #DC143C !important;
            color: #fff !important;
            padding: 1.2rem 1rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
        }

        .sidebar-brand:hover {
            background-color: #B71C1C !important;
            text-decoration: none;
        }

        .sidebar-brand-text {
            color: #fff !important;
            font-weight: 700;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.05rem;
            white-space: nowrap;
            line-height: 1.2;
        }

        .sidebar-brand-icon {
            color: #fff !important;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            margin-right: 10px;
        }

        .sidebar-brand-icon svg {
            width: 42px;
            height: 42px;
            flex-shrink: 0;
            display: block;
        }

        .sidebar .nav-link {
            color: #858796 !important;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.15s;
            border-radius: 0.35rem;
            margin: 0.2rem 0.5rem;
            display: block;
            width: auto;
            box-sizing: border-box;
        }

        .sidebar .nav-link:hover {
            color: #DC143C !important;
            background-color: rgba(220, 20, 60, 0.1);
            margin: 0.2rem 0.5rem;
            width: auto;
            box-sizing: border-box;
        }

        .sidebar .nav-link.active {
            color: #DC143C !important;
            background-color: rgba(220, 20, 60, 0.1);
            font-weight: 700;
            margin: 0.2rem 0.5rem;
            border-left: 3px solid #DC143C;
            width: auto;
            box-sizing: border-box;
        }

        /* Ensure nav-item doesn't stretch - limit width */
        .sidebar .nav-item {
            width: 100%;
            padding: 0;
        }

        .sidebar .nav-item .nav-link {
            width: auto;
            max-width: 100%;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }

        .sidebar-heading {
            color: #5a5c69 !important;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.1rem;
            padding: 0.75rem 1rem;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
            opacity: 1 !important;
            background-color: #f8f9fc !important;
            border-radius: 0.35rem;
            margin-left: 0.5rem;
            margin-right: 0.5rem;
        }

        .sidebar-divider {
            border-color: #eaecf4 !important;
            margin: 0 1rem 1rem;
        }

        .collapse-item {
            color: #858796 !important;
            padding: 0.5rem 1rem;
            font-size: 0.85rem;
            border-radius: 0.35rem;
            margin: 0.1rem 0.5rem;
            display: block;
            width: auto;
        }

        .collapse-item:hover {
            color: #DC143C !important;
            background-color: rgba(220, 20, 60, 0.1);
            margin: 0.1rem 0.5rem;
            width: auto;
        }

        .collapse-item.active {
            color: #DC143C !important;
            font-weight: 700;
            background-color: rgba(220, 20, 60, 0.1);
            margin: 0.1rem 0.5rem;
            border-left: 3px solid #DC143C;
            width: auto;
        }

        /* Ensure collapse-item doesn't stretch */
        .collapse-inner .collapse-item {
            width: calc(100% - 1rem);
            max-width: calc(100% - 1rem);
        }

        /* Progress Bars */
        .progress-bar {
            background-color: #df4e4e;
        }

        .progress-bar.bg-primary {
            background-color: #df4e4e !important;
        }

        .progress-bar.bg-success {
            background-color: #1cc88a !important;
        }

        .progress-bar.bg-info {
            background-color: #36b9cc !important;
        }

        .progress-bar.bg-warning {
            background-color: #f6c23e !important;
        }

        .progress-bar.bg-danger {
            background-color: #e74a3b !important;
        }

        /* Remove any red colors from icons */
        .text-primary {
            color: #df4e4e !important;
        }

        .fa-calendar.text-primary,
        .fas.fa-calendar.text-primary {
            color: #df4e4e !important;
        }

        /* Topbar - Blue Background */
        .bg-navbar {
            background-color: #df4e4e !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            overflow: hidden;
            min-height: 4.375rem;
        }

        /* Navbar text truncation */
        .topbar {
            overflow: hidden;
            width: 100%;
        }

        .topbar .navbar-nav {
            flex-wrap: nowrap;
            overflow: hidden;
            max-width: 100%;
        }

        .topbar .nav-item {
            white-space: nowrap;
            flex-shrink: 0;
        }

        .topbar .nav-link {
            display: flex;
            align-items: center;
            white-space: nowrap;
            overflow: hidden;
            max-width: 100%;
        }

        .topbar .nav-link span {
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        .topbar .img-profile {
            flex-shrink: 0;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .topbar-divider {
            width: 0;
            border-right: 1px solid rgba(255, 255, 255, 0.3);
            height: calc(4.375rem - 2rem);
            margin: auto 1rem;
        }

        @media (max-width: 991px) {
            .topbar .nav-link span {
                display: none;
            }

            .topbar .navbar-nav {
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .topbar .nav-item.dropdown:not(:last-child) {
                margin-right: 0.25rem;
            }
        }

        /* Text Colors */
        .text-gray-800,
        .text-gray-700,
        .text-gray-600,
        .text-gray-500,
        .text-gray-400,
        h1.text-gray-800,
        h2.text-gray-800,
        h3.text-gray-800,
        h4.text-gray-800,
        h5.text-gray-800,
        h6.text-gray-800,
        .h3.text-gray-800,
        .h4.text-gray-800,
        .h5.text-gray-800,
        .h6.text-gray-800,
        .font-weight-bold.text-gray-800,
        .h5.text-gray-800 {
            color: #5a5c69 !important;
        }

        .text-muted {
            color: #858796 !important;
        }

        /* Breadcrumb */
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-item a {
            color: #858796 !important;
            text-decoration: none;
        }

        .breadcrumb-item a:hover {
            color: #df4e4e !important;
        }

        .breadcrumb-item.active {
            color: #5a5c69 !important;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            color: #858796;
            content: "/";
            padding: 0 0.5rem;
        }

        /* Cards */
        .card {
            background-color: #fff;
            border: 0;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }

        .card-header {
            background-color: #f8f9fc !important;
            border-bottom: 1px solid #e3e6f0 !important;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
            color: #5a5c69;
        }

        /* Override any red card headers */
        .card-header[style*="red"],
        .card-header[style*="DC143C"],
        .card-header.bg-danger,
        .card-header[style*="background-color: #DC143C"],
        .card-header[style*="background-color:#DC143C"] {
            background-color: #f8f9fc !important;
            border-bottom: 1px solid #e3e6f0 !important;
        }

        /* Ensure card header text is not white on light background */
        .card-header h6:not(.text-white):not(.text-light) {
            color: #5a5c69 !important;
        }

        .card-header .font-weight-bold:not(.text-white):not(.text-light) {
            color: #5a5c69 !important;
        }

        .card-body {
            color: #5a5c69;
            padding: 1.25rem;
        }

        /* Tables - Simple Clean Style */
        .table {
            color: #333;
            margin-bottom: 0;
            border-collapse: collapse;
            width: 100%;
        }

        .table thead {
            background-color: #fff;
        }

        .table thead th {
            background-color: #fff;
            color: #333;
            border-bottom: 1px solid #ddd;
            padding: 12px;
            font-weight: 600;
            font-size: 14px;
            text-align: left;
        }

        .table tbody tr {
            border-bottom: 1px solid #ddd;
        }

        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table tbody td {
            color: #333;
            padding: 12px;
            vertical-align: middle;
            font-size: 14px;
        }

        /* Form Controls */
        .form-control,
        .form-control-sm {
            background-color: #fff;
            border: 1px solid #d1d3e2;
            color: #5a5c69;
            border-radius: 0.35rem;
        }

        .form-control:focus,
        .form-control-sm:focus {
            background-color: #fff;
            border-color: #bac8f3;
            color: #5a5c69;
            box-shadow: 0 0 0 0.2rem rgba(223, 78, 78, 0.25);
            outline: none;
        }

        .form-control::placeholder {
            color: #858796;
        }

        /* Buttons */
        .btn {
            border-radius: 0.35rem;
            font-weight: 400;
            padding: 0.375rem 0.75rem;
        }

        .btn-primary {
            background-color: #df4e4e;
            border-color: #df4e4e;
        }

        .btn-primary:hover {
            background-color: #c0392b;
            border-color: #a93226;
        }

        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
            color: #fff !important;
        }

        .btn-success:hover {
            background-color: #17a673;
            border-color: #169b6b;
            color: #fff !important;
        }

        .btn-info {
            background-color: #36b9cc;
            border-color: #36b9cc;
            color: #fff !important;
        }

        .btn-info:hover {
            background-color: #2c9faf;
            border-color: #2a96a5;
            color: #fff !important;
        }

        .btn-danger {
            background-color: #e74a3b;
            border-color: #e74a3b;
            color: #fff !important;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            border-color: #a93226;
            color: #fff !important;
        }

        /* Badges */
        .badge {
            padding: 0.25em 0.4em;
            font-weight: 700;
            font-size: 0.75em;
            border-radius: 0.35rem;
        }

        .badge-warning {
            background-color: #f6c23e;
            color: #fff !important;
        }

        .badge-success {
            background-color: #1cc88a;
            color: #fff !important;
        }

        .badge-danger {
            background-color: #e74a3b;
            color: #fff !important;
        }

        .badge-info {
            background-color: #36b9cc;
            color: #fff !important;
        }

        .badge-secondary {
            background-color: #858796;
            color: #fff !important;
        }

        /* DataTables - Simple Clean Style */
        .dataTables_wrapper {
            padding: 0;
            background: #fff;
        }

        .dataTables_wrapper .row:last-child {
            margin: 0;
            padding: 15px 0;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #333;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_length {
            float: left;
            padding: 10px 0;
        }

        .dataTables_wrapper .dataTables_length label {
            font-weight: 400;
            margin-bottom: 0;
        }

        .dataTables_wrapper .dataTables_length select {
            background-color: #fff;
            border: 1px solid #ddd;
            color: #333;
            padding: 5px 10px;
            font-size: 14px;
            margin: 0 5px;
        }

        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
            padding: 10px 0;
        }

        .dataTables_wrapper .dataTables_filter label {
            font-weight: 400;
            margin-bottom: 0;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: #fff;
            border: 1px solid #ddd;
            color: #333;
            padding: 5px 10px;
            font-size: 14px;
            margin-left: 5px;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #999;
            outline: none;
        }

        .dataTables_wrapper .dataTables_info {
            padding: 10px 0;
            color: #333;
            font-size: 14px;
            float: left;
        }

        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
            padding: 10px 0;
        }

        .dataTables_wrapper .dataTables_paginate .pagination {
            margin: 0;
            display: inline-flex;
            list-style: none;
            padding: 0;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: #333 !important;
            padding: 6px 12px;
            margin: 0 2px;
            border: 1px solid #ddd !important;
            background-color: #fff !important;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.disabled):not(.current) {
            background-color: #f5f5f5 !important;
            border-color: #999 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background-color: #333 !important;
            color: #fff !important;
            border-color: #333 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
            opacity: 0.5;
            cursor: not-allowed;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .dataTables_wrapper .dataTables_info {
                float: none;
                width: 100%;
                text-align: center;
                margin-bottom: 10px;
            }

            .dataTables_wrapper .dataTables_paginate {
                float: none;
                width: 100%;
                text-align: center;
            }
        }

        /* DataTable Table Styling - Simple */
        .table.dataTable {
            width: 100% !important;
            margin: 0 !important;
        }

        .table.dataTable thead {
            background-color: #fff;
        }

        .table.dataTable thead th {
            background-color: #fff;
            color: #333;
            border-bottom: 1px solid #ddd;
            font-weight: 600;
            font-size: 14px;
            padding: 12px;
            vertical-align: middle;
        }

        .table.dataTable thead th.sorting,
        .table.dataTable thead th.sorting_asc,
        .table.dataTable thead th.sorting_desc {
            padding-right: 30px;
            position: relative;
            cursor: pointer;
        }

        .table.dataTable thead th.sorting:before,
        .table.dataTable thead th.sorting:after,
        .table.dataTable thead th.sorting_asc:before,
        .table.dataTable thead th.sorting_asc:after,
        .table.dataTable thead th.sorting_desc:before,
        .table.dataTable thead th.sorting_desc:after {
            content: "";
            position: absolute;
            right: 8px;
            border: 4px solid transparent;
            opacity: 0.3;
        }

        .table.dataTable thead th.sorting:before,
        .table.dataTable thead th.sorting_asc:before,
        .table.dataTable thead th.sorting_desc:before {
            border-bottom-color: #333;
            top: 50%;
            margin-top: -6px;
        }

        .table.dataTable thead th.sorting:after,
        .table.dataTable thead th.sorting_asc:after,
        .table.dataTable thead th.sorting_desc:after {
            border-top-color: #333;
            bottom: 50%;
            margin-bottom: -6px;
        }

        .table.dataTable thead th.sorting_asc:before {
            opacity: 1;
        }

        .table.dataTable thead th.sorting_desc:after {
            opacity: 1;
        }

        .table.dataTable tbody tr {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .table.dataTable tbody tr:hover {
            background-color: #f5f5f5;
        }

        .table.dataTable tbody td {
            color: #333;
            padding: 12px;
            vertical-align: middle;
            font-size: 14px;
        }

        .table.dataTable tbody td a {
            color: #333;
            text-decoration: none;
        }

        .table.dataTable tbody td a:hover {
            text-decoration: underline;
        }

        /* Badge Styling */
        .table.dataTable tbody .badge {
            padding: 4px 8px;
            font-weight: 500;
            font-size: 12px;
            border-radius: 3px;
            display: inline-block;
        }

        .table.dataTable tbody .badge-success {
            background-color: #28a745;
            color: #fff !important;
        }

        .table.dataTable tbody .badge-warning {
            background-color: #ffc107;
            color: #fff !important;
        }

        .table.dataTable tbody .badge-danger {
            background-color: #dc3545;
            color: #fff !important;
        }

        .table.dataTable tbody .badge-info {
            background-color: #17a2b8;
            color: #fff !important;
        }

        .table.dataTable tbody .badge-secondary {
            background-color: #6c757d;
            color: #fff !important;
        }

        /* Badge styling for all tables (not just DataTable) */
        .table .badge,
        .badge {
            color: #fff !important;
        }

        .table .badge-success,
        .badge-success {
            background-color: #28a745;
            color: #fff !important;
        }

        .table .badge-warning,
        .badge-warning {
            background-color: #ffc107;
            color: #fff !important;
        }

        .table .badge-danger,
        .badge-danger {
            background-color: #dc3545;
            color: #fff !important;
        }

        .table .badge-info,
        .badge-info {
            background-color: #17a2b8;
            color: #fff !important;
        }

        .table .badge-secondary,
        .badge-secondary {
            background-color: #6c757d;
            color: #fff !important;
        }

        /* Action Buttons */
        .table.dataTable tbody .btn {
            padding: 6px 12px;
            font-size: 14px;
            border-radius: 3px;
            margin: 0 2px;
            border: 1px solid #ddd;
            cursor: pointer;
            display: inline-block;
        }

        .table.dataTable tbody .btn i {
            font-size: 14px;
        }

        .table.dataTable tbody .btn-info {
            background-color: #17a2b8;
            color: #fff;
            border-color: #17a2b8;
        }

        .table.dataTable tbody .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
            color: #fff !important;
        }

        .table.dataTable tbody .btn-danger {
            background-color: #dc3545;
            color: #fff !important;
            border-color: #dc3545;
        }

        .table.dataTable tbody .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            color: #fff !important;
        }

        .table.dataTable tbody .btn-primary {
            background-color: #007bff;
            color: #fff !important;
            border-color: #007bff;
        }

        .table.dataTable tbody .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
            color: #fff !important;
        }

        .table.dataTable tbody .btn-success {
            background-color: #28a745;
            color: #fff !important;
            border-color: #28a745;
        }

        .table.dataTable tbody .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
            color: #fff !important;
        }

        .table.dataTable tbody .btn-warning {
            background-color: #ffc107;
            color: #333;
            border-color: #ffc107;
        }

        .table.dataTable tbody .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        /* DataTables processing */
        .dataTables_wrapper .dataTables_processing {
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid #ddd;
            color: #333;
            font-size: 14px;
            padding: 10px;
        }

        /* Page Heading */
        h1.h3 {
            font-size: 1.75rem;
            font-weight: 400;
            color: #5a5c69;
            margin-bottom: 0.5rem;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Dropdown Menu Styling */
        .dropdown-list {
            background-color: #fff;
            border: 0;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .dropdown-item {
            color: #5a5c69;
            transition: all 0.15s;
        }

        .dropdown-item:hover {
            background-color: #f8f9fc;
            color: #3a3b45;
        }

        .dropdown-item:focus {
            background-color: #f8f9fc;
            color: #3a3b45;
        }

        .dropdown-header {
            background-color: #f8f9fc;
            color: #5a5c69;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.65rem;
            letter-spacing: 0.1rem;
            padding: 0.5rem 1rem;
        }

        /* Override any red colors - ensure all are blue */
        .text-primary,
        h6.text-primary,
        .font-weight-bold.text-primary,
        .m-0.font-weight-bold.text-primary {
            color: #df4e4e !important;
        }

        /* Ensure all primary colors are blue */
        .btn-primary,
        .badge-primary,
        .bg-primary:not(.progress-bar) {
            background-color: #df4e4e !important;
            border-color: #df4e4e !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background-color: #c0392b !important;
            border-color: #a93226 !important;
        }

        /* Card link colors */
        .card-link,
        .card-link.text-primary,
        a.text-primary.card-link {
            color: #df4e4e !important;
        }

        .card-link:hover,
        a.text-primary.card-link:hover {
            color: #c0392b !important;
        }

        /* Icon colors */
        .fa-calendar.text-primary,
        .fas.fa-calendar.text-primary,
        i.text-primary {
            color: #df4e4e !important;
        }

        /* Remove any red backgrounds from cards or headers */
        .card-header[style*="DC143C"],
        .card-header[style*="red"],
        .bg-danger:not(.badge-danger):not(.btn-danger):not(.progress-bar) {
            background-color: #df4e4e !important;
        }

        /* Progress bars - ensure first one is blue */
        .progress-bar:first-child {
            background-color: #df4e4e !important;
        }
    </style>

    @stack('styles')
</head>

<body id="page-top">
    <div id="wrapper">
        @include('admin.partials.sidebar')

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                @include('admin.partials.topbar')

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    @yield('content')
                </div>
                <!---Container Fluid-->
            </div>

            @include('admin.partials.footer')
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Modal Logout -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabelLogout">Konfirmasi Logout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin keluar?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/ruang-admin.min.js') }}"></script>

    @stack('scripts')
</body>

</html>
