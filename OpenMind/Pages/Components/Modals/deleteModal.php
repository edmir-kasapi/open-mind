<!--begin::Delete User Modal-->
                                    <div class="modal fade" id="modal-delete-user-<?php echo $user['user_info']["user_id"] ?>" tabindex="-1" aria-labelledby="modal-delete-user-label" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modal-delete-user-label">Delete user</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">
                                            Are you sure you want to delete this user? All content owned by the account
                                            will be deleted. This action cannot be undone.
                                            </p>
                                        </div>
                                        <div class="modal-footer">

                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                            </button>

                                            <form action="./deleteUser" method="post">
                                                <input type="hidden" name="userId" value=<?php echo $user['user_info']["user_id"] ?> >
                                                <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >
                                                <input type="submit" class="btn btn-outline-danger" value="Delete User">
                                            </form> 

                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                    <!--end::Delete User Modal-->