<?php
$user = $parameters['user'];
echo '<form class="do-submit col col-md-4" name="updateuser" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="update" />
            <div class="form-group">
                <label for="user[name_last]">Last Name</label>
                <input class="form-control" type="text" name="user[name_last]" value="'.$user['name_last'].'" />
            </div>
            <div class="form-group">
                <label for="user[name_first]">First Name</label>
                <input class="form-control" type="text" name="user[name_first]" value="'.$user['name_first'].'" />
            </div>
            <div class="form-group">
                <label for="user[email]">Email</label>
                <input class="form-control" type="text" name="user[email]" value="'.$user['email'].'" />
            </div>
            <input class="btn btn-default" type="submit" name="submituser" value="Update User" />
        </form>';
echo '<form class="do-submit-reset col col-md-4 col-md-push-4" name="updateuserpassword" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="update" />
            <div class="form-group">
                <label for="user[password]">Password</label>
                <input class="form-control" id="newPassword" type="password" name="user[password]" />
            </div>
            <div class="form-group">
                <label for="confirmpassword">Confirm Password</label>
                <input class="form-control" id="confirmNewPassword" type="password" name="confirmpassword" />
            </div>
            <input class="btn btn-default" id="submitPasswordReset" type="submit" name="submitpassword" value="Reset Password" disabled />
        </form>';
?>
