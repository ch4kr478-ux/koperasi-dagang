<style>
    /* ==========================================================================
       CORPORATE SHARED INDEX & DATATABLE PAGE STYLES
       ========================================================================== */

    .content-page .content .container-fluid .page-title-box {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        min-height: 96px;
        margin-bottom: 24px;
        padding: 22px 28px;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #0f766e;
        border-radius: 14px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 55%, #f0fdfa 100%);
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .content-page .content .container-fluid .page-title-box:after {
        position: absolute;
        top: -90px;
        right: 10%;
        width: 220px;
        height: 220px;
        border: 1px solid rgba(15, 118, 110, 0.08);
        border-radius: 50%;
        box-shadow: 0 0 0 24px rgba(15, 118, 110, 0.02), 0 0 0 52px rgba(15, 118, 110, 0.015);
        content: "";
        pointer-events: none;
    }

    .content-page .content .container-fluid .page-title-box > .float-left,
    .content-page .content .container-fluid .page-title-box > .float-right {
        position: relative;
        z-index: 1;
        float: none !important;
    }

    .content-page .content .container-fluid .page-title-box h4.page-title {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 20px;
        font-weight: 800;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .content-page .content .container-fluid .page-title-box .breadcrumb {
        justify-content: flex-end;
        margin: 0 0 4px;
        padding: 0;
        background: transparent;
    }

    .content-page .content .container-fluid .page-title-box .breadcrumb-item,
    .content-page .content .container-fluid .page-title-box .breadcrumb-item a {
        color: #64748b;
        font-size: 11.5px;
        font-weight: 500;
    }

    .content-page .content .container-fluid .page-title-box .breadcrumb-item a:hover {
        color: #0f766e;
    }

    .content-page .content .container-fluid .page-title-box small.text-danger {
        color: #0f766e !important;
        font-size: 11px;
        font-weight: 600;
    }

    .content-page .content .container-fluid > .row > .col-12 > .alert {
        border-radius: 10px;
        font-size: 13px;
        padding: 14px 18px;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    /* Corporate DataTables Container */
    .content-page .content .container-fluid > .row > .col-12 > .card-box.table-responsive {
        overflow: hidden;
        padding: 22px 24px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.03);
    }

    .content-page .content .container-fluid .dataTables_wrapper {
        color: #475569;
        font-size: 12.5px;
    }

    /* Toolbar Actions */
    .content-page .content .container-fluid .dataTables_wrapper .toolbar {
        display: flex;
        float: left;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        width: auto;
        margin: 0 12px 18px 0;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
        margin: 0;
        padding: 8px 16px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #334155;
        background: #ffffff;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
        font-size: 12px;
        font-weight: 600;
        transition: all 0.18s ease;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn:hover {
        transform: translateY(-1px);
        border-color: #94a3b8;
        background: #f8fafc;
        box-shadow: 0 3px 8px rgba(15, 23, 42, 0.07);
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-gradient,
    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-primary {
        border-color: transparent !important;
        color: #ffffff !important;
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%) !important;
        box-shadow: 0 3px 10px rgba(15, 118, 110, 0.25);
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-gradient:hover,
    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-primary:hover {
        background: linear-gradient(135deg, #0d635c 0%, #094742 100%) !important;
        box-shadow: 0 5px 14px rgba(15, 118, 110, 0.35);
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-success {
        border-color: #a7f3d0;
        color: #065f46;
        background: #ecfdf5;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-success:hover {
        background: #d1fae5;
        border-color: #6ee7b7;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-warning {
        border-color: #fde68a;
        color: #92400e;
        background: #fffbeb;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-warning:hover {
        background: #fef3c7;
        border-color: #fcd34d;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-danger {
        border-color: #fecaca;
        color: #991b1b;
        background: #fef2f2;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-danger:hover {
        background: #fee2e2;
        border-color: #fca5a5;
    }

    /* Search Box */
    .content-page .content .container-fluid .dataTables_filter {
        float: left;
        margin: 0 0 18px;
        text-align: left;
    }

    .content-page .content .container-fluid .dataTables_filter label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: #475569;
        font-weight: 600;
        font-size: 12.5px;
    }

    .content-page .content .container-fluid .dataTables_filter input {
        height: 38px;
        margin-left: 0;
        padding: 6px 14px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        color: #0f172a;
        background: #ffffff;
        outline: none;
        box-shadow: none;
        font-size: 12.5px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .content-page .content .container-fluid .dataTables_filter input:focus {
        border-color: #0f766e;
        box-shadow: 0 0 0 3px rgba(15, 118, 110, 0.15);
    }

    /* Enterprise Table Styling */
    .content-page .content .container-fluid table.dataTable {
        clear: both;
        width: 100% !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .content-page .content .container-fluid table.dataTable thead th {
        padding: 13px 14px;
        border-top: 0;
        border-bottom: 2px solid #e2e8f0;
        color: #475569;
        background: #f8fafc;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .content-page .content .container-fluid table.dataTable tbody td {
        padding: 13px 14px;
        border-top: 0;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 12.5px;
        vertical-align: middle;
    }

    .content-page .content .container-fluid table.dataTable tbody tr:hover {
        background-color: #f8fafc;
    }

    .content-page .content .container-fluid table.dataTable tbody td:last-child {
        white-space: nowrap;
    }

    /* Action Buttons in Tables */
    .content-page .content .container-fluid table.dataTable .btn-sm {
        margin: 2px;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .content-page .content .container-fluid table.dataTable td.dt-actions {
        min-width: 130px;
        white-space: nowrap;
    }

    .content-page .content .container-fluid table.dataTable .datatable-actions {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
    }

    .content-page .content .container-fluid table.dataTable .datatable-actions form {
        margin: 0;
    }

    .content-page .content .container-fluid table.dataTable .datatable-actions .btn-sm {
        min-width: 58px;
        margin: 0;
        padding: 6px 11px;
        line-height: 1.35;
    }

    .content-page .content .container-fluid table.dataTable .badge {
        padding: 5px 10px;
        border-radius: 9999px;
        font-size: 10.5px;
        font-weight: 700;
    }

    /* Pagination & Info */
    .content-page .content .container-fluid .dataTables_info {
        padding-top: 14px;
        color: #64748b;
        font-size: 12px;
    }

    .content-page .content .container-fluid .dataTables_paginate {
        padding-top: 10px;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button {
        padding: 0;
        border: 0 !important;
        background: transparent !important;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button a {
        margin-left: 4px;
        padding: 6px 12px;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #475569 !important;
        background: #ffffff;
        font-size: 11.5px;
        font-weight: 600;
        transition: all 0.15s ease;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button a:hover {
        border-color: #0f766e;
        color: #0f766e !important;
        background: #f0fdfa;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button.active a {
        border-color: transparent;
        color: #ffffff !important;
        background: linear-gradient(135deg, #0f766e 0%, #115e59 100%);
        box-shadow: 0 2px 6px rgba(15, 118, 110, 0.3);
    }

    .content-page .content .container-fluid .dataTables_processing {
        padding: 14px 22px;
        border: 1px solid #cbd5e1;
        border-radius: 10px;
        color: #0f766e;
        font-weight: 600;
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 6px 20px rgba(15, 23, 42, 0.08);
    }

    @media (max-width: 767.98px) {
        .content-page .content .container-fluid .page-title-box {
            align-items: flex-start;
            flex-direction: column;
            padding: 18px 20px;
        }

        .content-page .content .container-fluid .page-title-box > .float-right {
            align-self: flex-start;
            margin-top: 10px;
        }

        .content-page .content .container-fluid .page-title-box .breadcrumb {
            justify-content: flex-start;
        }

        .content-page .content .container-fluid > .row > .col-12 > .card-box.table-responsive {
            padding: 16px 14px;
        }

        .content-page .content .container-fluid .dataTables_filter {
            text-align: left;
        }

        .content-page .content .container-fluid .dataTables_filter input {
            max-width: 100%;
            width: 100%;
            margin-left: 0;
            margin-top: 6px;
        }
    }
</style>
