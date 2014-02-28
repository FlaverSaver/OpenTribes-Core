<?php

namespace OpenTribes\Core\Mock\Validator;

use OpenTribes\Core\Domain\Validator\Registration as AbstractRegistration;

/**
 * Description of Registration
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Registration extends AbstractRegistration {

    private $object;

    public function validate() {
        $this->object = $this->getObject();
        $this->checkUsername();
        $this->checkPassword();
    }

    private function checkUsername() {
        $username = $this->object->username;
        if (empty($username)) {
            $this->attachError("Username is empty");
        }
        if (strlen($username) < 4) {
            $this->attachError("Username is too short");
        }
        if (strlen($username) > 24) {
            $this->attachError("Username is too long");
        }
        if ((bool) preg_match('/^[-a-z0-9_]++$/iD', $username) === false) {
            $this->attachError("Username contains invalid character");
        }
        if (!$this->object->isUniqueUsername) {
            $this->attachError("Username exists");
        }
    }
    private function checkPassword(){
        $password = $this->object->password;
        $passwordConfirm = $this->object->passwordConfirm;
        if(empty($password)){
            $this->attachError("Password is empty");
        }
        if(strlen($password)<6){
            $this->attachError("Password is too short");
        }
        if($password !== $passwordConfirm){
            $this->attachError("Password confirm not match");
        }
    }
}
