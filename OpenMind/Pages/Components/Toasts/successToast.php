<div id="success-toast" class="toast align-items-center bg-success text-white position-fixed bottom-0 end-0 p-3" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="d-flex">
            <div class="toast-body">
            <?php 
            echo $_SESSION['messages']['success'];
            unset($_SESSION['messages']['success']); 
            ?>
            </div>
            <button type="button" class="btn-close me-2 m-auto bg-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
</div>


<script>

    const toastElement = document.getElementById('success-toast');
    const toastInstance = bootstrap.Toast.getOrCreateInstance(toastElement);
    toastInstance.show();

</script>