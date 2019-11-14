 <!-- Sing in  Form -->
 <section class="sign-in">
            <div class="container">
                <div class="signin-content">
                    <div class="signin-image">
                        <figure><img src="<?= URL_ROOT ?>assets/images/signin-image.jpg" alt="sing up image"></figure>
                        <a href="signup.php" class="signup-image-link">Create an account</a>
                        <a href="forgot.php" class="signup-image-link">Forgot Password</a>
                    </div>

                    <div class="signin-form">
                        <h2 class="form-title">Sign in</h2>
                        
                        <!-- User Message Area -->
                        <div id="sign_in_resp">
                            <!-- Login form processing -->
                            <?php if(isset($_POST) && isset($_POST['signin'])){
                                  $validator = new Validator;
                                  $valData = $validator->validate($_POST,[
                                      'user' => [
                                          'required' => true,
                                          'max' => 30
                                      ],
                                      'password' => [
                                          'required' => true,
                                          'min' => 5,
                                          'max' => 50
                                      ]
                                  ]);
                              
                                  if($valData->passed()){
                                      if((new User)->login(senatize($_POST['user']),$_POST['password'])){
                                          (new User)->createLog(Session::get('U_ID'),'Logged In from '. getIP());
                                          echo "<div class='alert alert-success'>Welcome, " . $_POST['user'] . "</div>";
                                          Redirect::to($_SERVER['PHP_SELF']);
                                      }else{
                                          echo "<div class='alert alert-warning'>Invalid username/password. Please try again.</div>";
                                      }
                                  }else{
                                        foreach($valData->errors() as $err){
                                            echo "<div class='alert alert-danger'>{$err}</div>";
                                        }
                                  }
                            }
                            ?>
                        </div>

                        <form method="POST" class="register-form" id="login-form">
                            <div class="form-group">
                                <label for="your_name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="user" id="user_user" placeholder="Username / Email"/>
                            </div>
                            <div class="form-group">
                                <label for="your_pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="user_password" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <input type="checkbox" name="remember-me" id="remember-me" class="agree-term" />
                                <label for="remember-me" class="label-agree-term"><span><span></span></span>Remember me</label>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signin" id="signin" class="form-submit" value="Log in"/>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </section>