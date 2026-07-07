<!--
    <main class="app-main">

        <h1 class="text-center display-4 mt-3">Welcome, admin!</h1>

        <section class="w-50 mx-auto">

            <div class="app-content">
                <!--begin::Container-->
                <div class="container-fluid">
                    <!--begin::Row-->
                    <div class="row">
                        <div class="col-12">
                            <!--begin::Card-->
                            <div class="card mb-4">
                                <!--begin::Card Header-->
                                <div class="card-header">
                                    <div class="row g-2 align-items-center">
                                        <div class="col-12 col-md-4">
                                            <h3 class="card-title">User Directory</h3>
                                        </div>
                                        <div class="col-12 col-md-8">
                                            <div class="d-flex flex-wrap justify-content-md-end gap-2">
                                                <div class="input-group input-group-sm w-auto">
                                                    <span class="input-group-text">
                                                        <i class="bi bi-search" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="search" id="user-search" class="form-control" placeholder="Search users" aria-label="Search users" style="width: 180px">
                                                </div>
                                                <select id="user-role-filter" class="form-select form-select-sm w-auto" aria-label="Filter by role">
                                                    <option value="all" selected="">All roles</option>
                                                    <option value="administrator">Administrator</option>
                                                    <option value="editor">Editor</option>
                                                    <option value="author">Author</option>
                                                    <option value="subscriber">Subscriber</option>
                                                </select>
                                                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-add-user">
                                                    <i class="bi bi-person-plus-fill me-1" aria-hidden="true"> </i>
                                                    New user
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Card Header-->
                                <!--begin::Card Body-->
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle m-0" role="table">
                                            <thead>
                                                <tr>

                                                    <th>
                                                        <div class="tabulator-col tabulator-sortable tabulator-col-sorter-element" role="columnheader" aria-sort="none" tabulator-field="name" style="min-width: 40px; width: 163px; height: 84px;">
                                                            <div class="tabulator-col-content">
                                                                <div class="tabulator-col-title-holder">
                                                                    <div class="tabulator-col-title">Name</div>
                                                                    <div class="tabulator-col-sorter">
                                                                        <div class="tabulator-arrow">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="tabulator-header-filter"><input type="search" placeholder="" style="padding: 4px; width: 100%; box-sizing: border-box;">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </th>

                                                    <th scope="col">User</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Role</th>
                                                    <th scope="col">Created</th>
                                                    <th class="text-end" scope="col">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php $cnt = 0; ?>
                                                <?php foreach ($usersList as $user): ?>
                                                    <?php
                                                    $picture = 'Pictures/Uploads/Profile_Pictures/' . $user['user_profile']['photo_hash_name'] . '.' . $user['user_profile']['photo_extension'];
                                                    $name = $user['user_info']['user_name'];
                                                    $email = $user['user_info']['user_email'];
                                                    $registrationDate = $user['user_info']['user_registration_date'];
                                                    $role = $user['user_info']['role_name'];

                                                    $badgeColor = '';

                                                    switch ($role) {

                                                        case 'USER':
                                                            $badgeColor = 'text-bg-info';
                                                            break;

                                                        case 'ADMIN':
                                                            $badgeColor = 'text-bg-danger';
                                                            break;

                                                        default:
                                                            break;
                                                    }
                                                    ?>

                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <img src="<?php echo $picture; ?>" alt="" onerror="this.onerror=null; this.src='Pictures/Assets/default_profile.png'" class="img-size-32 rounded-circle me-2">
                                                                <span class="fw-medium"><?php echo $name; ?></span>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <?php echo $email; ?>
                                                        </td>
                                                        <td>
                                                            <span class="badge <?php echo $badgeColor; ?>"><?php echo $role; ?></span>
                                                        </td>
                                                        <td>
                                                            <?php echo $registrationDate; ?>
                                                        </td>
                                                        <td class="text-end">
                                                            <div class="btn-group btn-group-sm">

                                                                <a href="./inspectUser?editingUser=<?php echo $user['user_info']['user_id'] ?>" class="btn btn-outline-secondary">
                                                                    <i class="bi bi-pencil" aria-hidden="true"> </i>
                                                                </a>



                                                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-delete-user-<?php echo $cnt; ?>" aria-label="Delete Daniel Cooper">
                                                                    <i class="bi bi-trash" aria-hidden="true"> </i>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>


                                                    <?php include("Components/Modals/deleteModal.php"); ?>


                                                    <?php $cnt++; ?>
                                                <?php endforeach; ?>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!--end::Card Body-->
                                <!--begin::Card Footer-->
                                <div class="card-footer clearfix">
                                    <div class="float-start pt-1 fs-7 text-body-secondary">
                                        Showing <?php echo (($currentPage - 1) * 10) + 1 ?> to <?php echo (($currentPage - 1) * 10) + $userCount ?> of <?php echo $total ?> users
                                    </div>

                                    <?php

                                    $totalPages = ceil($total / 10.0);

                                    $visiblePages = 5;
                                    $start = max(1, $currentPage - floor($visiblePages / 2));
                                    $end = min($totalPages, $start + $visiblePages);

                                    ?>

                                    <ul class="pagination pagination-sm m-0 float-end">
                                        <li class="page-item <?php if ($currentPage <= 1) {
                                                                    echo "disabled";
                                                                }  ?>">
                                            <a class="page-link" href="./adminMenu?currentPage=<?php echo 1; ?>" aria-label="Previous"> « </a>
                                        </li>

                                        <?php for ($i = $start; $i <= $end; $i++):  ?>

                                            <li class="page-item <?php if ($i == $currentPage) {
                                                                        echo "active";
                                                                    }  ?>">
                                                <a class="page-link" href="./adminMenu?currentPage=<?php echo $i; ?>"> <?php echo $i; ?> </a>
                                            </li>

                                        <?php endfor; ?>

                                        <li class="page-item <?php if ($currentPage >= $totalPages) {
                                                                    echo "disabled";
                                                                }  ?> ">
                                            <a class="page-link" href="./adminMenu?currentPage=<?php echo $totalPages ?>" aria-label="Next"> » </a>
                                        </li>
                                    </ul>
                                </div>
                                <!--end::Card Footer-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!--end::Row-->
        </section>

        <?php include('Components/Tables/adminUsersTable.php') ?>

    
    

    <?php include('Components/Modals/userModal.php') ?>


    </div>
    <!--end::Container-->
    </div>


    
    </main>
    -->