<?php
$user = $parameters['user'];
echo '<form class="do-submit column column-half" name="updateuser" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="update" />
            <div>
                <label for="user[name_last]">Last Name</label>
                <input type="text" name="user[name_last]" value="'.$user['name_last'].'" />
                <label for="user[name_first]">First Name</label>
                <input type="text" name="user[name_first]" value="'.$user['name_first'].'" />
                <label for="user[email]">Email</label>
                <input type="text" name="user[email]" value="'.$user['email'].'" />
            </div>
            <input type="submit" name="submituser" value="Update User" />
        </form>';
echo '<form class="do-submit-reset column column-half" name="updateuserpassword" method="POST" action="'.$app_http.'">
            <input type="hidden" name="action" value="update" />
            <div>
                <label for="user[password]">Password</label>
                <input id="newPassword" type="password" name="user[password]" />
                <label for="confirmpassword">Confirm Password</label>
                <input id="confirmNewPassword" type="password" name="confirmpassword" />
            </div>
            <input id="submitPasswordReset" type="submit" name="submitpassword" value="Reset Password" disabled />
        </form>';
?>
