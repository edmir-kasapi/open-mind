<!--begin::Add User Modal-->
                <div class="modal fade" id="modal-add-user" tabindex="-1" aria-labelledby="modal-add-user-label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <form action="./createUser" method="POST">
                        <div class="modal-header">
                        <h5 class="modal-title" id="modal-add-user-label">Add new user</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <section class="">

                            <!-- Look for csrf token -->
                            <div class="form-group">
                                <label class="form-label">Username:</label>
                                <input type="text" name="registerName" class="form-control" placeholder="Enter username here..." required value=<?php if(isset($_SESSION['autofill']['reg_name_fill'])){ echo $_SESSION['autofill']['reg_name_fill']; } ?> > 
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Email:</label>
                                <input type="email" name="registerEmail" class="form-control" placeholder="Enter email here..." required  value=<?php if(isset($_SESSION['autofill']['reg_email_fill'])){ echo $_SESSION['autofill']['reg_email_fill']; } ?> >
                            </div>
                                
                            <div class="form-group mt-3">
                                <label class="form-label">Password:</label>
                                <input type="password" name="registerPassword" class="form-control" required>
                            </div>

                            <div class="form-group mt-3">
                                <label class="form-label">Role:</label>
                                <select class="form-select" name="registerRole"  required>
                                    <option selected="" disabled="" value="">Choose…</option>
                                    <option value="1">Admin</option>
                                    <option value="2" >User</option>
                                </select>
                            </div>

                            

                            <input type="hidden" name="_token" value=<?php echo $_SESSION['token'] ?> >

                        </section>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" class="btn btn-primary">Create user</button>
                        </div>
                    </form>
                    </div>
                </div>
                </div>
 <!--end::Add User Modal-->