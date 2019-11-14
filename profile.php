<?php

/**
 * Include initial file for all the configuration and settings.
 */
require 'init.php';

/**
 * Adding Header
 */
$pageTitle = "Home";
include Config::get('template/inc/header');
/**
 * Check is user logged in or not.
 * If user not logged in redirect to login page.
 */

if(!Session::exists('isLoggedIn')){
    Redirect::to('login.php');
}

$userData = (new User)->get(Session::get('U_ID'));
?>
<div class="container row">
    <div class="col-md-4 col-4 col-sm-12 col-xs-12">
        <a href="index.php" class=""><- Go back</a>
    </div>

    <div class="col-md-4 col-4 col-sm-12 col-xs-12">

    </div>
    
    <div class="col-md-4 col-4 col-sm-12 col-xs-12">
        
    </div>

    <div class="clearfix"><hr></div>

    <div class="row">
        <div class="col-md-12 col-12">
            <h3>Edit Profile : </h3>
            <div id="edit-profile-resp">
                <?php if(Session::exists('profile_updated')){
                    echo Session::flash('profile_updated');
                }
                ?>
                <?php
                    if(isset($_POST) && isset($_POST['updateProfile'])){
                        if($userData->username === $_POST['username']){
                            $validationArray = [
                                'username' => [
                                    'required' => true,
                                    'min' => 5,
                                    'max' => 35,
                                ],
                                'first_name' => [
                                    'required' => true,
                                    'max' => 30,
                                    'min' => 2
                                ],
                                'last_name' => [
                                    'required' => true,
                                    'max' => 30,
                                    'min' => 2
                                ]
                            ];
                        }else{
                            $validationArray = [
                                'username' => [
                                    'required' => true,
                                    'min' => 5,
                                    'max' => 35,
                                    'unique' => 'users'
                                ],
                                'first_name' => [
                                    'required' => true,
                                    'max' => 30,
                                    'min' => 2
                                ],
                                'last_name' => [
                                    'required' => true,
                                    'max' => 30,
                                    'min' => 2
                                ]
                            ];
                        }
                        
                        $validator = new Validator;
                        $valData = $validator->validate($_POST,$validationArray);

                        if($valData->passed()){
                            if((new User)->update($userData->id,[
                                'username' => senatize($_POST['username']),
                                'first' => senatize($_POST['first_name']),
                                'last' => senatize($_POST['last_name'])
                            ])){
                                Session::flash('profile_updated',"<div class='alert alert-success'>Profile data updated!</div>");
                                (new User)->createLog($userData->id,'Profile detail updated from '. getIP());
                                Redirect::to($_SERVER['PHP_SELF']);
                            }else{
                                echo "<div class='alert alert-warning'>Something went wrong while updating profile. Please try again.</div>";
                            }
                        }else{
                            foreach($valData->errors() as $err){
                                echo "<div class='alert alert-danger'>{$err}</div>";
                            }
                        }
                    }
                ?>
                <?php
                    if(isset($_POST) && isset($_POST['updateAvatar'])){
                        if(isset($_FILES['avatar'])){
                            $errors= array();
                            $file_name = $_FILES['avatar']['name'];
                            $file_size = $_FILES['avatar']['size'];
                            $file_tmp = $_FILES['avatar']['tmp_name'];
                            $file_type = $_FILES['avatar']['type'];
                            $file_ext = @strtolower(end(explode('.',$_FILES['avatar']['name'])));
                            $newfilename = round(microtime(true)) . '.' . ($file_ext);
                            
                            $extensions= array("jpeg","jpg","png");
                            
                            if(in_array(strtolower($file_ext),$extensions) === false){
                                $errors[] = "Extension not allowed, please choose a JPEG or PNG file.";
                            }
                            
                            if($file_size > 1025 * 1000) {
                                $errors[] = 'File size must be excately 1 MB';
                            }
                            
                            if(empty($errors)) {
                                //Remove if custom image and update avatar.
                                $oldAvatar = @end(explode('/',$userData->avatar));
                                if($oldAvatar == 'default-avatar.png'){
                                    move_uploaded_file($file_tmp,"assets/images/".$newfilename);
                                }else{
                                    //remove and move
                                    unlink('assets/images/'.$oldAvatar);
                                    move_uploaded_file($file_tmp,"assets/images/".$newfilename);
                                }

                                //perform db update.
                                if((new User)->update($userData->id,['avatar' => URL_ROOT . "assets/images/" . $newfilename])){
                                    (new User)->createLog($userData->id,'Changed Avatar Image from '. getIP());
                                    echo "<div class='alert alert-success'>Avatar updated!</div>";
                                }else{
                                    echo "<div class='alert alert-warning'>Something went wrong while updating avatar.</div>";
                                }
                            }else{
                                foreach($errors as $err){
                                    echo "<div class='alert alert-danger'>{$err}</div>";
                                }
                            }
                        }
                    }
                ?>
            </div>
            <ul class="list-group">
                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" class="form">
                    <li class="list-group-item">
                        <div class="form-group">
                            <h5>Change Avatar</h5>
                            <input type="file" name="avatar" class="form-control-file">
                            <small id="avatarNote" class="form-text text-muted">File types allowed are : png,jpg,jpeg. Max file size : 1MB</small>
                            <br />
                            <div class="col-md-6 col-6">
                                <button style="float:right" type="submit" class="btn btn-success" name="updateAvatar">Update Avatar</button>
                            </div>
                            <div class="col-md-6 col-6">
                                <button style="float:left" type="reset" class="btn btn-warning" name="resetAvatar">Reset</button>
                            </div>
                        </div>
                    </li>
                </form>
                <form method="POST" action="<?= $_SERVER['PHP_SELF'] ?>" class="form">
                    <li class="list-group-item">
                        <div class="form-group">
                            <h5>Username : </h5>
                            <input type="text" class="form-control" name="username" placeholder="Username" value=<?= $userData->username ?> require>
                            <small id="usernameCheckResp" class="form-text text-muted"></small>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group">
                            <h5>First Name : </h5>
                            <input type="text" class="form-control" name="first_name" placeholder="First name" value=<?= $userData->first ?> require>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group">
                            <h5>Last Name : </h5>
                            <input type="text" class="form-control" name="last_name" placeholder="Last name" value=<?= $userData->last ?> require>
                        </div>
                    </li>
                    <br />
                    <div class="col-md-6 col-6">
                            <button style="float:right" type="submit" class="btn btn-success" name="updateProfile">Update Profile</button>
                    </div>
                    <div class="col-md-6 col-6">
                            <button style="float:left" type="reset" class="btn btn-warning" name="resetProfile">Reset</button>
                    </div>
                </form>
            </ul>
        </div>
    </div>
    <hr />
    <div class="row">
        <div class="col-md-12 col-12">
            <h3>Password Changer : </h3>
            <div id="password-change-resp">
                    <?php if(isset($_POST) && isset($_POST['updatePassword'])){
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
                            if((new User)->update($userData->id,[
                                'password' => encrypt($_POST['password'])
                            ])){
                                echo "<div class='alert alert-success'>Password Changed Success!</div>";
                                (new User)->createLog($userData->id,'Password token updated from '. getIP());
                                Session::insert('password_changed',true);
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
                            <input type="text" class="form-control" name="password" placeholder="New Password" require>
                            <small id="usernameCheckResp" class="form-text text-muted">Password must contain numeric,upper,lower case and special characters.</small>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="form-group">
                            <h5>Repeat Password : </h5>
                            <input type="text" class="form-control" name="re_password" placeholder="New Password" require>
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
        </div>
    </div>
    <hr />
</div>

<?php

/**
 * Adding Footer
 */
include  Config::get('template/inc/footer');