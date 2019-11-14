<div class="container row">
    <div class="col-md-2 col-2 col-sm-12 col-xs-12">
        
    </div>

    <div class="col-md-8 col-8 col-sm-12 col-xs-12">
        <?php if(Session::exists('password_changed')){
            echo "<span style='color:red'><b>We have detected password change. You will be logged out in 5 sec.</b></span>";
            Session::del('password_changed');
            (new User)->createLog($userData->id,'Logged out by system on password change.');
            echo "<script>
            setInterval(function(){
                window.location = 'logout.php'
            },5000);
            </script>";
        }
        ?>
    </div>
    
    <div class="col-md-2 col-2 col-sm-12 col-xs-12">
        
    </div>

    <div class="clearfix"><hr></div>

    <div class="row">
        <div class="col-md-4 col-4">
            <img src="<?= $userData->avatar ?>" width="60%" height="60%" class="img img-fluid-thumbnail" alt="avatar-image" />
        </div>
        <div class="col-md-8 col-8">
                <ul class="list-group">
                    <li class="list-group-item"><h5><b>Username:</b> <?= $userData->username ?></h5></li>
                    <li class="list-group-item"><h5><b>First Name:</b> <?= $userData->first ?></h5></li>
                    <li class="list-group-item"><h5><b>Last Name:</b> <?= $userData->last ?></h5></li>
                    <li class="list-group-item"><h5><b>E-mail:</b> <a href="mailto:<?= $userData->email ?>"><?= $userData->email ?></a></h5></li>
                    <li class="list-group-item"><h5><b>Member Since:</b> <?= timeElapsedString($userData->created) ?></h5></li>
                    <li class="list-group-item"><h5><b>Last Activity:</b> <?= timeElapsedString($userData->last_update) ?></h5></li>
                    <li class="list-group-item"><h5><b>Total Activites:</b> <?= count((new User)->getLogs($userData->id)) ?></h5></li>
                    <li class="list-group-item"><h5><b>Account Recovery Key:</b> <?= $userData->_key ?> <a href="#" data-toggle="modal" data-target="#recoveryHelp">(Help?)</a></h5></li>
                    <li class="list-group-item"><h5><b>Account Status:</b> <?= ($userData->status == 1) ? "<span style='color:green'>Active</span>" : "<span style='color:red'>In-Active</span>" ?></h5></li>
                </ul>


                <div class="row">
                    <div class="col-md-4 col-4">
                        <a href="profile.php" class="btn btn-md btn-info">Edit Profile</a>    
                    </div>
                    <div class="col-md-4 col-4">
                        <a href="#" data-toggle="modal" data-target="#viewLogs" class="btn btn-md btn-warning">Check Account Logs</a>
                    </div>
                    <div class="col-md-4 col-4">
                        <a href="logout.php" class="btn btn-md btn-success" style="float:right;">Logout?</a>    
                    </div>
                </div>
        </div>
    </div>
    <hr />
</div>

<!-- Logs Modal -->
<!-- Modal -->
<div id="viewLogs" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><?= $userData->username ?> Account Logs</h4>
      </div>
      <div class="modal-body">
        <ul>
            <?php foreach((new User)->getLogs($userData->id) as $data): ?>
                <?php foreach($data as $time => $msg): ?>
                    <li>[<?= $time ?>] : <?= $msg ?></li>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Logs Modal End -->
<!-- Recovery Help Modal -->
<!-- Modal -->
<div id="recoveryHelp" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Recovery Code</h4>
      </div>
      <div class="modal-body">
        <p>Please note the recovery code at safe place.</p>
        <br />
        <p>Recovery code will be used to reset password in case your forgot your password.
        After each password reset recovery code will also get regerate due to security process.
        For more information feel free to contact staff or email on <?= Config::get('support/email') ?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<!-- Recovery Help Modal End -->
