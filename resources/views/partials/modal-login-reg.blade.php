
  <!-- MODAL LOGIN AND REG -->
  <div class="modal xs-modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">   
          <span class="icon icon-cross"></span>
        </button>
        <ul class="nav nav-tabs xs-tab-nav" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#login" role="tab" data-toggle="tab">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#signup" role="tab" data-toggle="tab">Signup</a>
          </li>
        </ul>

        <div class="tab-content">
          <div role="tabpanel" class="tab-pane fadeInRights show fade in active" id="login">
            <form action="#" method="POST" class="xs-customer-form">
              <div class="input-group input-group-append">
                 <input type="text" class="form-control" placeholder="Enter Your Username">
                 <i class="icon icon-profile-male input-group-text"></i>
              </div>
              <div class="input-group input-group-append">
                 <input type="password" class="form-control" placeholder="Enter Your Password">
                 <i class="icon icon-key2 input-group-text"></i>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
          </div>
          <div role="tabpanel" class="tab-pane fadeInRights fade" id="signup">
            <form action="#" method="POST" class="xs-customer-form">
              <div class="input-group input-group-append">
                <input type="text" class="form-control" placeholder="Enter your username">
                 <i class="icon icon-profile-male input-group-text"></i>
              </div>
              <div class="input-group input-group-append">
                <input type="email" class="form-control" placeholder="Enter your email">
                 <i class="icon icon-envelope2 input-group-text"></i>
              </div>
              <div class="input-group input-group-append">
                <input type="password" class="form-control" placeholder="Enter your password">
                 <i class="icon icon-key2 input-group-text"></i>
              </div>
              <div class="input-group input-group-append">
                <input type="password" class="form-control" placeholder="Enter your confirm password">
                 <i class="icon icon-key2 input-group-text"></i>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
