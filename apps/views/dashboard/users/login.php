<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/* * ***********************************************************************
 *  File: login.php
 *  Path: application/views/dashboard/login.php
 *  Description: It's a login page of dashboard.
 * 
 * Function Added:
 *
 *  History:
 *  Programmer          Date                    Description
 *  -----------         ----------              ----------------
 *  Rahul Siwal         24/01/2020              Created
 *
 */
?>
<main class="main login">
    <div class="container-fluid">
        <div class="row login-container">
            <div class="col col-12">
                <div class="login-form-container card-1 card-shadow-1">
                    <div class="image-container d-flex justify-content-around align-items-center">
                        <img class="logo" src="<?php icon_url('sabnews.png') ?>">
                    </div>
                    <?php
                    if (!empty($error)) {
                        ?>
                        <div class="errnotice alert alert-danger"><?= $error; ?></div>
                        <?php
                    }
                    ?>
                    <form class="custom-login-form" action="<?php echo $loginurl; ?>" method="post">
                        <div class="input-field-container-outer full">
                            <div class="input-field-container" id="login-username">
                                <input type="text" name="username" id="username" class="form-control input-field font-20" required placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" />
                                <div class="image-container input-field-icon">
                                    <img src="<?php icon_url('username.png'); ?>" alt="" />
                                </div>
                            </div>
                            <div class="input-field-container" id="login-password">
                                <input type="password" name="password" class="form-control input-field font-20" required placeholder="Password" aria-label="Password" aria-describedby="basic-addon1" />
                                <div class="image-container input-field-icon">
                                    <img src="<?php icon_url('password.png'); ?>" alt="" />
                                </div>
                            </div>
                        </div>
                        <div class="input-field-actions-container" id="sign-in-forgot-link">
                            <div class="checkbox-container">
                                <div class="custom-checkbox-container">
                                    <label class="pointer">
                                        <input name="keeplogin" class="form-check-input" type="checkbox" aria-label="Checkbox for keep signed in" />
                                        <span>keep signin</span>
                                    </label>
                                </div>
                            </div>
                            <div class="forgot-password">
                                <a href="">Reset password?</a>
                            </div>
                        </div>
                        <div class="input-field-actions-container text-center">
                            <p class="font-12">By continuing, you agree to our <a href="">Terms of Service</a>.</p>
                        </div>
                        <div class="button-container mt-3 full" id="sign-in-button">
                            <button type="submit" class="btn btn-lg pt-2 pb-2 btn-primary full">Log In</button>
                        </div>
                        <div class="full my-5 divider text-center position-relative">
                            <span class="font-18 hr-center">OR</span>
                        </div>
                        <div class="full">
                            <div class="google">
                                <a class="btn btn-outline-secondary full font-16 pt-2 pb-2" href="<?= $g_login_url; ?>">
                                    <i class="fa fa-google font-20" aria-hidden="true"></i> 
                                    <span>Continue with Google</span>
                                </a>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</main>