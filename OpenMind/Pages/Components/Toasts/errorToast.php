<div id="error-toast" class="toast align-items-center bg-danger text-white z-3 position-absolute top-0 start-50 translate-middle-x" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="d-flex">
            <div class="toast-body">
            <?php 
            echo $_SESSION['messages']['error'];
            unset($_SESSION['messages']['error']); 
            ?>
            </div>
            <button type="button" class="btn-close me-2 m-auto bg-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
</div>


<script>

    const toastElement = document.getElementById('error-toast');
    const toastInstance = bootstrap.Toast.getOrCreateInstance(toastElement);
    toastInstance.show();

</script>