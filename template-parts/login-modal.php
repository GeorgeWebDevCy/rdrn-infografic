<div class="mt-5 modal fade" id="loginModal" aria-labelledby="loginModalLabel">
  <div class="modal-dialog modal-md">
    
    <div class="modal-content p-2">
        <div class="text-end px-4 pt-4">
          <button type="button" class="btn-close me-2 mt-2" data-bs-dismiss="modal" aria-label="Close"></button>

        </div>
        <div class="px-5 pb-5 text-center">
            <i class="bi bi-box-arrow-in-right text-primary h1"></i>
            <h2 class="mb-5">Account Login</h2>
            <div class="alert alert-danger d-none" id="login_error"></div>
            <div class="alert alert-success d-none" id="login_success"></div>
            <form id="modalLoginForm" method="post" enctype="multipart/form-data">
              <input type="hidden" name="security_nonce" id="security_nonce" value="<?php echo wp_create_nonce('ajax_login'); ?>">
              <input type="hidden" id="ajax_url" value="<?php echo admin_url('admin-ajax.php'); ?>">
              <div class="mb-3">
                <label for="username" class="form-label">Username or Email</label>
                <input type="text" class="form-control" id="username" name="username" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <div class="recap text-center">
                <div class="g-recaptcha" data-sitekey="6Lc3EvgpAAAAAOSHZRGzWcQjjOymoRxjdnabE3pI"></div>
              </div>
              <button type="submit" class="btn btn-primary mt-3 w-100" id="login_button">Login <span class="spinner-border spinner-border-sm d-none" id="login_button_load"  aria-hidden="true"></span>
              </button>
            </form>
           <div class="my-2">
              <small>Don't have an account? <a href="#" class="cursor-pointer" data-bs-toggle="modal" data-bs-target="#regModal" >Sign up</a><br>
              <a href="#">Forgotten Password?</a></small>
           </div> 
        </div>
    </div>
  </div>
</div>
