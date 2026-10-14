<style>
    .content-page .content .container-fluid .page-title-box {
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        overflow: hidden;
        min-height: 104px;
        margin-bottom: 22px;
        padding: 21px 26px;
        border: 1px solid #e5eaf3;
        border-radius: 13px;
        background: linear-gradient(115deg, #fff 0%, #f6f8fc 68%, #eef2f8 100%);
        box-shadow: 0 7px 22px rgba(35, 47, 74, .045);
    }

    .content-page .content .container-fluid .page-title-box:after {
        position: absolute;
        top: -90px;
        right: 14%;
        width: 210px;
        height: 210px;
        border: 1px solid rgba(106, 127, 177, .1);
        border-radius: 50%;
        box-shadow: 0 0 0 22px rgba(106, 127, 177, .03), 0 0 0 46px rgba(106, 127, 177, .02);
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
        margin: 0 0 5px;
        color: #344054;
        font-size: 21px;
        font-weight: 700;
    }

    .content-page .content .container-fluid .page-title-box .breadcrumb {
        justify-content: flex-end;
        margin: 0 0 6px;
        padding: 0;
        background: transparent;
    }

    .content-page .content .container-fluid .page-title-box .breadcrumb-item,
    .content-page .content .container-fluid .page-title-box .breadcrumb-item a {
        color: #7b8494;
        font-size: 11px;
    }

    .content-page .content .container-fluid .page-title-box small.text-danger {
        color: #82907f !important;
        font-size: 10px;
    }

    .content-page .content .container-fluid > .row > .col-12 > .alert {
        border: 1px solid #e4e9ed;
        border-radius: 9px;
        font-size: 12px;
    }

    .content-page .content .container-fluid > .row > .col-12 > .card-box.table-responsive {
        overflow: hidden;
        padding: 18px 20px 14px;
        border: 1px solid #e8ecf2;
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 5px 18px rgba(35, 47, 74, .04);
    }

    .content-page .content .container-fluid .dataTables_wrapper {
        color: #7b8494;
        font-size: 11px;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 15px;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 36px;
        margin: 0;
        padding: 7px 13px;
        border: 1px solid #dfe5ed;
        border-radius: 7px;
        color: #596477;
        background: #fff;
        box-shadow: none;
        font-size: 11px;
        font-weight: 600;
        transition: background-color .15s ease, border-color .15s ease, transform .15s ease;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn:hover {
        transform: translateY(-1px);
        border-color: #cbd4e0;
        background: #f8f9fb;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-gradient,
    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-primary {
        border-color: #5e806b;
        color: #fff;
        background: #668873;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-success {
        border-color: #dce8e0;
        color: #54836a;
        background: #edf5f0;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-warning {
        border-color: #eee4ce;
        color: #927845;
        background: #faf5e9;
    }

    .content-page .content .container-fluid .dataTables_wrapper .toolbar .btn-danger {
        border-color: #f0dfe1;
        color: #aa6c70;
        background: #f9eff0;
    }

    .content-page .content .container-fluid .dataTables_filter {
        margin-bottom: 12px;
        text-align: right;
    }

    .content-page .content .container-fluid .dataTables_filter label {
        color: #7b8494;
        font-weight: 500;
    }

    .content-page .content .container-fluid .dataTables_filter input {
        height: 35px;
        margin-left: 6px;
        padding: 6px 10px;
        border: 1px solid #e3e7ee;
        border-radius: 7px;
        color: #465166;
        background: #fff;
        outline: 0;
        box-shadow: none;
    }

    .content-page .content .container-fluid .dataTables_filter input:focus {
        border-color: #aebbd2;
        box-shadow: 0 0 0 3px rgba(106, 127, 177, .09);
    }

    .content-page .content .container-fluid table.dataTable {
        width: 100% !important;
        margin: 0 !important;
        border-collapse: separate !important;
        border-spacing: 0;
        border: 0;
    }

    .content-page .content .container-fluid table.dataTable thead th {
        padding: 11px 12px;
        border-top: 1px solid #edf0f5;
        border-bottom: 1px solid #e8ecf2;
        color: #7f8999;
        background: #f8f9fb;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .content-page .content .container-fluid table.dataTable tbody td {
        padding: 11px 12px;
        border-top: 0;
        border-bottom: 1px solid #f0f2f6;
        color: #596477;
        font-size: 11px;
        vertical-align: middle;
    }

    .content-page .content .container-fluid table.dataTable tbody tr:hover {
        background-color: #fafbfd;
    }

    .content-page .content .container-fluid table.dataTable tbody td:last-child {
        white-space: nowrap;
    }

    .content-page .content .container-fluid table.dataTable .btn-sm {
        margin: 2px;
        padding: 5px 9px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
    }

    .content-page .content .container-fluid table.dataTable .badge {
        padding: 5px 9px;
        border-radius: 14px;
        font-size: 9px;
        font-weight: 700;
    }

    .content-page .content .container-fluid .dataTables_info {
        padding-top: 12px;
        color: #8a93a2;
    }

    .content-page .content .container-fluid .dataTables_paginate {
        padding-top: 8px;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button {
        padding: 0;
        border: 0 !important;
        background: transparent !important;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button a {
        margin-left: 3px;
        border: 1px solid #e8ebf1;
        border-radius: 6px;
        color: #68748a !important;
        background: #fff;
        font-size: 10px;
    }

    .content-page .content .container-fluid .dataTables_paginate .paginate_button.active a {
        border-color: #718c7a;
        color: #fff !important;
        background: #718c7a;
    }

    .content-page .content .container-fluid .dataTables_processing {
        padding: 12px;
        border: 1px solid #e8ecf2;
        border-radius: 8px;
        color: #68748a;
        background: rgba(255, 255, 255, .96);
        box-shadow: 0 4px 16px rgba(35, 47, 74, .07);
    }

    @media (max-width: 767.98px) {
        .content-page .content .container-fluid .page-title-box {
            align-items: flex-start;
            flex-direction: column;
            padding: 19px;
        }

        .content-page .content .container-fluid .page-title-box > .float-right {
            align-self: flex-start;
            margin-top: 12px;
        }

        .content-page .content .container-fluid .page-title-box .breadcrumb {
            justify-content: flex-start;
        }

        .content-page .content .container-fluid > .row > .col-12 > .card-box.table-responsive {
            padding: 14px 12px;
        }

        .content-page .content .container-fluid .dataTables_filter {
            text-align: left;
        }

        .content-page .content .container-fluid .dataTables_filter input {
            max-width: 65vw;
        }
    }
</style>
