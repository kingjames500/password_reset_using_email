<?php
class Login extends Dbh
{
    protected function getUser($uid, $pwd){
        $stmt = $this->dbConnect()->prepare('SELECT users_pwd FROM users WHERE users_uid = ? OR users_email = ?;');

        if (!$stmt->execute(array($uid, $pwd))) {
            $stmt = null;
            header("location: ../login.php?error=stmtfailed");
            exit();
        }

        if ($stmt->rowCount() == 0) {
            $stmt = null;
            header("location: ../login.php?error=user not found");
            exit();
        }
        $pwdHashed = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $checkPwd = password_verify($pwd, $pwdHashed[0]["users_pwd"]);

        if ($checkPwd == false) {
            $stmt = null;
            header("location: ../login.php?error=wrongpassword");
            exit();
        }

        elseif ($checkPwd == true) {
            $stmt = $this->dbConnect()->prepare('SELECT users_pwd FROM users WHERE users_uid = ? OR users_email = ?;');

            if (!$stmt->execute(array($uid, $pwd))) {
                $stmt = null;
                header("location: ../login.php?error=stmtfailed");
                exit();

            }

            if ($stmt->rowCount() == 0) {
                $stmt = null;
                header("location: ../login.php?error=usernotfound");
                exit();
            }
            $user = $stmt->fetchAll(PDO::FETCH_ASSOC);

            session_start();
            $_SESSION["userid"] = $user["users_id"];
            $_SESSION["useruid"] = $user["users_uid"];
        }
        $stmt = null;
    }
}