  <!-- Sign up form -->
  <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <div class="signup-form">
                        <h2 class="form-title">Sign up</h2>
                        <!-- Signup Form Request Handler -->
                        <div id="sign-up-resp">
                            <?php
                                if(isset($_POST) && isset($_POST['signup'])){
                                    
                                    $validator = new Validator;
                                    $valData = $validator->validate($_POST,[
                                        'username' => [
                                            'required' => true,
                                            'min' => 5,
                                            'max' => 35,
                                            'unique' => 'users'
                                        ],
                                        'email' => [
                                            'required' => true,
                                            'max' => 60,
                                            'min' => 11,
                                            'unique' => 'users'
                                        ],
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
                                        if(pwdStrength($_POST['password'])){
                                            if((new User)->add([
                                                'username' => senatize($_POST['username']),
                                                'password' => encrypt($_POST['password']),
                                                'email' => senatize($_POST['email'],'email'),
                                                'first' => 'John',
                                                'last' => 'Doe',
                                                'ip' => getIP(),
                                                'avatar' => URL_ROOT . "assets/images/default-avatar.png",
                                                'created' => timestamp(),
                                                'last_update' => timestamp(),
                                                '_key' => generateRandomKey(),
                                                'logs' => '[]',
                                                'status' => 1
                                            ])){
                                                echo "<div class='alert alert-success'>New user (" . $_POST['username'] . ") created!</div>";
                                            }else{
                                                echo "<div class='alert alert-warning'>Something went wrong while adding new user. Please try again.</div>";
                                            }
                                        }else{
                                            echo "<div class='alert alert-danger'><b>Weak Password</b>. Please set password which have numeric,upper,lower case and special character.</div>";
                                        }
                                    }else{
                                        foreach($valData->errors() as $err){
                                            echo "<div class='alert alert-danger'>{$err}</div>";
                                        }
                                    }
                                }
                            ?>
                        </div>
                        <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="register-form" id="register-form">
                            <div class="form-group">
                                <label for="name"><i class="zmdi zmdi-account material-icons-name"></i></label>
                                <input type="text" name="username" id="name" placeholder="Your Name"/>
                            </div>
                            <div class="form-group">
                                <label for="email"><i class="zmdi zmdi-email"></i></label>
                                <input type="email" name="email" id="email" placeholder="Your Email"/>
                            </div>
                            <div class="form-group">
                                <label for="pass"><i class="zmdi zmdi-lock"></i></label>
                                <input type="password" name="password" id="pass" placeholder="Password"/>
                            </div>
                            <div class="form-group">
                                <label for="re-pass"><i class="zmdi zmdi-lock-outline"></i></label>
                                <input type="password" name="re_password" id="re_pass" placeholder="Repeat your password"/>
                            </div>
                            <div class="form-group form-button">
                                <input type="submit" name="signup" id="signup" class="form-submit" value="Register"/>
                            </div>
                        </form>
                    </div>
                    <div class="signup-image">
                        <figure><img src="<?= URL_ROOT ?>assets/images/signup-image.jpg" alt="sing up image"></figure>
                        <a href="login.php" class="signup-image-link">I am already member</a>
                    </div>
                </div>
            </div>
        </section>