<!-- Modal -->
<div class="modal fade" id="regModal" aria-labelledby="regModalLabel">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">

      <div class="container">
        <div class="row">
            <div class="d-none d-xl-block col-lg-4 left p-5" id="info_panel">
              
              <div class="row">
                  <div class="col-10 col-xl-12">
                      <h1 class="text-white pt-xl-5 mt-4 mb-4">Why Join?</h1>
                  </div>
                  <div class="col-2 d-xl-none pt-2">
                      <i class="h1 bi bi-x-circle-fill text-white"  id="toggle_help_close"></i>
                  </div>
              </div>

              <p class="text-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
              <a href="mailto:info@rd-rn.org" class="mt-3 btn btn-secondary"><i class="bi bi-flag-fill"></i> Report issues/feedback</a>
              <a class="mt-5 d-flex w-100 text-white" href="<?php echo get_privacy_policy_url();?>"><small>Privacy Policy</small></a>
            </div>
            <div class="col-xl-8">

                <div class="row px-4 py-5">
                  <div class="col-10">
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                      <div class="progress-bar"></div>
                    </div>
                  </div>
                  <div class="col-2 text-end">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                </div>
         

              <div class="px-3 pb-3">
                <?php get_template_part('template-parts/register-form'); ?>
              </div>

            </div>
        </div>
      </div>
    
      <div class="progress d-none" role="progressbar" aria-label="Example 1px high" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 1px" id="action_loading_bar">
        <div class="progress-bar" style="width: 25%"></div>
      </div>

      <div class="modal-footer px-5">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary previous_reg d-none">Previous</button>
        <button type="button" class="btn btn-primary next_reg" disabled>Next   
          <span class="spinner-border spinner-border-sm d-none" id="next_button_load"  aria-hidden="true"></span>
        </button>
        <button type="button" class="btn btn-primary complete_reg d-none">Complete
          <span class="spinner-border spinner-border-sm d-none" id="complete_button_load"  aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>
</div>