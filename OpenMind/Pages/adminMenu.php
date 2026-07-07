<?php

$title = "Admin Dashboard";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include("Components/Head/baseHeadCode.php"); ?>
</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary app-loaded">
    
    <?php include("Components/Sidebar/sidebar.php"); ?>
    <?php include("Components/Navbar/adminNavbar.php"); ?>


    <main class="app-main p-1" id="main" tabindex="-1">

        <h1 class="w-25 mx-auto text-center display-4 mt-3">Welcome, admin!</h1>

        <section class="w-50 mx-auto">

            <div class="app-content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Users Directory</h3>
                            <div class="card-tools">
                                <div class="input-group input-group-sm" style="width: 16rem">
                                    <span class="input-group-text">
                                        <i class="bi bi-search" aria-hidden="true"></i>
                                    </span>
                                    <input id="table-filter" type="search" class="form-control" placeholder="Filter rows…" aria-label="Filter rows">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex gap-2 mb-3">
                                <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                                    Export CSV
                                </button>
                                <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                                    Export JSON
                                </button>
                                <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-printer me-1" aria-hidden="true"></i>
                                    Print
                                </button>
                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-user">
                                    <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                    New user
                                </button>
                            </div>
                            <div id="users-table" class="tabulator" role="grid" aria-owns="tabulator-table-body" tabulator-layout="fitColumns">
                                <div class="tabulator-header" role="rowgroup">
                                    <div class="tabulator-header-contents">
                                        <div class="tabulator-headers" role="row" style="height: 84px;">
                                            <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="none" tabulator-field="id" style="min-width: 40px; width: 60px; height: 84px;">
                                                <div class="tabulator-col-content">
                                                    <div class="tabulator-col-title-holder">
                                                        <div class="tabulator-col-title">#</div>
                                                        <div class="tabulator-col-sorter">
                                                            <div class="tabulator-arrow"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><span class="tabulator-col-resize-handle" style="height: 84px;"></span>
                                            <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="none" tabulator-field="name" style="min-width: 40px; width: 163px; height: 84px;">
                                                <div class="tabulator-col-content">
                                                    <div class="tabulator-col-title-holder">
                                                        <div class="tabulator-col-title">Name</div>
                                                        <div class="tabulator-col-sorter">
                                                            <div class="tabulator-arrow"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tabulator-header-filter"><input type="search" placeholder="" style="padding: 4px; width: 100%; box-sizing: border-box;"></div>
                                                </div>
                                            </div><span class="tabulator-col-resize-handle" style="height: 84px;"></span>
                                            <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="none" tabulator-field="email" style="min-width: 40px; width: 163px; height: 84px;">
                                                <div class="tabulator-col-content">
                                                    <div class="tabulator-col-title-holder">
                                                        <div class="tabulator-col-title">Email</div>
                                                        <div class="tabulator-col-sorter">
                                                            <div class="tabulator-arrow"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tabulator-header-filter"><input type="search" placeholder="" style="padding: 4px; width: 100%; box-sizing: border-box;"></div>
                                                </div>
                                            </div><span class="tabulator-col-resize-handle" style="height: 84px;"></span>
                                            <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="none" tabulator-field="role" style="min-width: 40px; width: 120px; height: 84px;">
                                                <div class="tabulator-col-content">
                                                    <div class="tabulator-col-title-holder">
                                                        <div class="tabulator-col-title">Role</div>
                                                        <div class="tabulator-col-sorter">
                                                            <div class="tabulator-arrow"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tabulator-header-filter"><input type="search" placeholder="" style="padding: 4px; width: 100%; box-sizing: border-box; cursor: default; caret-color: transparent;"></div>
                                                </div>
                                            </div><span class="tabulator-col-resize-handle" style="height: 84px;"></span>
                                            <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="descending" tabulator-field="status" style="min-width: 40px; width: 130px; height: 84px;">
                                                <div class="tabulator-col-content">
                                                    <div class="tabulator-col-title-holder">
                                                        <div class="tabulator-col-title">Status</div>
                                                        <div class="tabulator-col-sorter">
                                                            <div class="tabulator-arrow"></div>
                                                        </div>
                                                    </div>
                                                    <div class="tabulator-header-filter"><input type="search" placeholder="" style="padding: 4px; width: 100%; box-sizing: border-box; cursor: default; caret-color: transparent;"></div>
                                                </div>
                                            </div><span class="tabulator-col-resize-handle" style="height: 84px;"></span>
                                            <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="none" tabulator-field="joined" style="min-width: 40px; width: 130px; height: 84px;">
                                                <div class="tabulator-col-content">
                                                    <div class="tabulator-col-title-holder">
                                                        <div class="tabulator-col-title">Joined</div>
                                                        <div class="tabulator-col-sorter">
                                                            <div class="tabulator-arrow"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><span class="tabulator-col-resize-handle" style="height: 84px;"></span>
                                        </div>
                                        <div class="tabulator-frozen-rows-holder" style="min-width: 0px;"></div>
                                    </div>
                                </div>
                                <div class="tabulator-tableholder table-responsive" tabindex="0" style="height: 490px;">


                                    <div class="tabulator-footer">
                                        <div class="tabulator-footer-contents"><span class="tabulator-paginator"><label>Page Size</label><select class="tabulator-page-size" aria-label="Page Size" title="Page Size">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                </select><button class="tabulator-page" type="button" role="button" aria-label="First Page" title="First Page" data-page="first" disabled="">First</button><button class="tabulator-page" type="button" role="button" aria-label="Prev Page" title="Prev Page" data-page="prev" disabled="">Prev</button><span class="tabulator-pages"><button class="tabulator-page active" type="button" role="button" aria-label="Show Page 1" title="Show Page 1" data-page="1">1</button><button class="tabulator-page" type="button" role="button" aria-label="Show Page 2" title="Show Page 2" data-page="2">2</button></span><button class="tabulator-page" type="button" role="button" aria-label="Next Page" title="Next Page" data-page="next">Next</button><button class="tabulator-page" type="button" role="button" aria-label="Last Page" title="Last Page" data-page="last">Last</button></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-secondary small">
                                Powered by
                                <a href="https://tabulator.info/" target="_blank" rel="noopener">Tabulator</a>
                                — vanilla JS, no jQuery required.
                            </div>
                        </div>
                    </div>
                </div>


                <?php foreach ($usersList as $user): ?>

                    <?php include("Components/Modals/deleteModal.php"); ?>

                <?php endforeach; ?>

        </section>

        <?php include('Components/Modals/userModal.php') ?>


        </div>
        <!--end::Container-->
        </div>



    </main>

    <main class="app-main" id="main" tabindex="-1">

    </main>


    <?php include("Components/Links/bootstrapjs.html"); ?>
</body>

</html>


<?php include("Pages/Components/Toasts/toastScript.php"); ?>

<script>
    const roleBadge = (cell) => {
        const value = cell.getValue();
        const map = {
            ADMIN: 'danger',
            USER: 'info',
        };
        const color = map[value] || 'secondary';
        return `<span class="badge text-bg-${color}">${value}</span>`;
    };

    const actionButtons = (cell) => {
        const value = cell.getValue();

        return `<div class="btn-group btn-group-sm">
                    <a href="./inspectUser?editingUser=${value}" class="btn btn-outline-secondary"><i class="bi bi-pencil" aria-hidden="true"> </i> </a>
                    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-user-${value}" aria-label="Delete">
                            <i class="bi bi-trash" aria-hidden="true"> </i>
                    </button>
                </div>`;

    }

    const userProfile = () => {
        return ` `
    }

    document.addEventListener('DOMContentLoaded', () => {
        const data = <?php echo json_encode($usersList); ?>

        const table = new Tabulator('#users-table', {
            data: data,
            layout: 'fitColumns',
            pagination: true,
            paginationSize: 10,
            paginationSizeSelector: [5, 10, 25, 50, 100],
            movableColumns: true,
            columns: [{
                    title: '#',
                    field: 'user_info.user_id',
                    width: 60,
                    headerSort: true
                },
                {
                    title: 'Name',
                    field: 'user_info.user_name',
                    headerFilter: 'input'
                },
                {
                    title: 'Email',
                    field: 'user_info.user_email',
                    headerFilter: 'input'
                },
                {
                    title: 'Role',
                    field: 'user_info.role_name',
                    formatter: roleBadge,
                    headerFilter: 'list',
                    headerFilterParams: {
                        values: ['', 'ADMIN', 'USER']
                    },
                    width: 120,
                },
                {
                    title: 'Joined',
                    field: 'user_info.user_registration_date',
                    sorter: 'datetime',
                    width: 130
                },
                {
                    title: 'Actions',
                    field: 'user_info.user_id',
                    formatter: actionButtons,
                    width: 100,
                    headerSort: false,
                    resizable: false

                },
            ],
        });

        document.getElementById('table-filter').addEventListener('input', (e) => {
            const value = e.target.value;
            if (value) {
                table.setFilter([
                    [{
                            field: 'user_info.user_name',
                            type: 'like',
                            value: value
                        },
                        {
                            field: 'user_info.user_email',
                            type: 'like',
                            value: value
                        },
                    ],
                ]);
            } else {
                table.clearFilter();
            }
        });

        document
            .getElementById('export-csv')
            .addEventListener('click', () => table.download('csv', 'users.csv'));
        document
            .getElementById('export-json')
            .addEventListener('click', () => table.download('json', 'users.json'));
        document
            .getElementById('print-table')
            .addEventListener('click', () => table.print(false, true));
    });
</script>