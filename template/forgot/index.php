<div class="container row">
    <div class="col-md-2 col-2 col-sm-12 col-xs-12">
        <a href="login.php"><- Go Back</a>
    </div>

    <div class="col-md-8 col-8 col-sm-12 col-xs-12">
       
    </div>
    
    <div class="col-md-2 col-2 col-sm-12 col-xs-12">
        
    </div>

    <div class="clearfix"><hr></div>

    <div class="row">
        <div class="col-12 col-md-12">
        
            <?php if(!Session::exists('forgot_user')): ?>
                <h3>Please enter your account security code below :</h3>
                <!-- Process request -->
                <?php if(isset($_POST) && isset($_POST['forgotPassword'])){
                        $userID = (new User)->getByAccountKey($_POST['code']);
                        if(!empty($userID)){
                            Session::insert('forgot_user',$userID);
                            Redirect::to($_SERVER['PHP_SELF']);
                        }else{
                            echo "<div class='alert alert-danger'>Invalid recovery code. Please try again or contact admin.</div>";
                        }
                    } 
                ?>
                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="form">
                    <input type="text" name="code" placeholder="Account Recovery Code" require/>
                    <br />
                    <div class="col-md-4 col-4">

                    </div>
                    <div class="col-md-4 col-4">
                        <button type="submit" name="forgotPassword" class="btn btn-default">Reset Password</button>
                    </div>
                    <div class="col-md-4 col-4">

                    </div>
                    
                </form>
            <?php elseif(Session::exists('forgot_user')): ?>
            <h3>Password Changer : </h3>
            <div id="password-change-resp">
                    <?php if(isset($_POST) && isset($_POST['updatePassword'])){
                            if(!Session::exists('forgot_user')){
                                Redirect::to($_SERVER['PHP_SELF']);
                            }
                        $validator = new Validator;
                        $valData = $validator->validate($_POST,[
                            'password' => [
                                'required' => true,
                                'min' => 8,
                                'max' => 30
                            ],
                            're_password' => [
                                'required' => true,
                                'matches' => 'password'
                            ]
                        ]);

                        if($valData->passed()){
                            if((new User)->update(Session::get('forgot_user'),[
                                'password' => encrypt($_POST['password']),
                                '_key' => generateRandomKey()
                            ])){
                                echo "<div class='alert alert-success'>Password Changed Success! New recovery code assigned please login to check new recovery code.</div>";
                                (new User)->createLog(Session::get('forgot_user'),'(Forgot Password)Password token updated from '. getIP());
                                Session::del('forgot_user');
                            }else{
                                echo "<div class='alert alert-warning'>Something went wrong while changing password. Please try again later.</div>";
                            }
                        }else{
                            foreach($valData->errors() as $err){
                                echo "<div class='alert alert-danger'>{$err}</div>"; 
                            }
                        }
                    }
                    ?>
            </div>
                <ul class="list-group">
                    <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="form">
                        <li class="list-group-item">
                            <div class="form-group">
                                <h5>New Password : </h5>
                                <input type="password" class="form-control" name="password" placeholder="New Password" require>
                                <small id="usernameCheckResp" class="form-text text-muted">Password must contain numeric,upper,lower case and special characters.</small>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="form-group">
                                <h5>Repeat Password : </h5>
                                <input type="password" class="form-control" name="re_password" placeholder="New Password" require>
                            </div>
                        </li>
                        <br />
                        <div class="col-md-6 col-6">
                                <button style="float:right" type="submit" class="btn btn-success" name="updatePassword">Update Password</button>
                        </div>
                        <div class="col-md-6 col-6">
                                <button style="float:left" type="reset" class="btn btn-warning" name="resetPassword ">Reset</button>
                        </div>
                    </form>
                </ul>
            <?php else: ?>
                <h2><span style='color:red'>Invalid Request!</span></h2>
            <?php endif; ?>
            
        </div>
    </div>
    
    <hr />
</div>
