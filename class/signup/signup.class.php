<?php
class Signup extends Dbh{
    protected function registerUser($uid, $pwd, $email){
        $stmt = $this->dbConnect()->prepare('INSERT INTO users(users_uid, users_pwd, users_email) VALUES(?, ?, ?);');

        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

        if (!$stmt->execute(array($uid, $hashedPwd, $email))) {
            $stmt = null;
            header("location: ../index.php?error=stmtFailed");
            exit();
        }
        $stmt = null;
    }
    protected function checkUser($uid, $email){
        $stmt = $this->dbConnect()->prepare('SELECT users_uid FROM users WHERE users_uid = ? OR users_email = ?;');

        if (!$stmt->execute(array($uid, $email))) {
            $stmt = null;
            header("location: ..index.php?error=stmtFailed");
            exit();
        }
        $resultCheck;
        if ($stmt->rowCount() > 0) {
            $resultCheck = false;
        }else {
            $resultCheck = true;
        }
        return $resultCheck;
    }
    
}
?>