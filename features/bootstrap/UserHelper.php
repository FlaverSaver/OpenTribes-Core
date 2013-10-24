<?php

<<<<<<< HEAD
use OpenTribes\Core\Account\Create\Context as AccountCreateContext;
use OpenTribes\Core\Account\Create\Request as AccountCreateRequest;

//dependencies
=======
//UseCases
use OpenTribes\Core\Account\Create\Request as AccountCreateRequest;
use OpenTribes\Core\Account\Create\Context as AccountCreateContext;
//Entities
use OpenTribes\Core\User;
use OpenTribes\Core\Role;
use OpenTribes\Core\User\Role as UserRole;
>>>>>>> 005af1fdb371df2736b7e2ce4dca90b7429d8a2b
//Repositories
use OpenTribes\Core\Mock\User\Repository as UserRepository;
use OpenTribes\Core\Mock\User\Role\Repository as UserRoleRepository;
<<<<<<< HEAD
use OpenTribes\Core\Mock\Role\Repository as RoleRepository;
use OpenTribes\Core\Mock\User\ActivationMail\Repository as ActivationMailRepository;
//Services
use OpenTribes\Core\Mock\Service\Md5Hasher as Hasher;
use OpenTribes\Core\Mock\Service\QwertyGenerator as Generator;
use OpenTribes\Core\Mock\Service\DumpMailer as Mailer;

=======
use OpenTribes\Core\Mock\User\Activation\Mail\Repository as ActivationMailRepository;
//Services
use OpenTribes\Core\Mock\Service\Md5Hasher as Hasher;
use OpenTribes\Core\Mock\Service\DumpMailer as Mailer;
use OpenTribes\Core\Mock\Service\QwertyGenerator as Generator;
//Requests
use OpenTribes\Core\User\Create\Request as UserCreateRequest;
use OpenTribes\Core\User\Login\Request as UserLoginRequest;
use OpenTribes\Core\User\Activate\Request as UserActivateRequest;
use OpenTribes\Core\User\Create\Validation\Request as UserCreateValidationRequest;
use OpenTribes\Core\User\ActivationMail\Create\Request as ActivationMailCreateRequest;
use OpenTribes\Core\User\ActivationMail\Send\Request as ActivationMailSendRequest;
use OpenTribes\Core\User\Authenticate\Request as UserAuthenticateRequest;
//Interactors
use OpenTribes\Core\User\Create\Interactor as UserCreateInteractor;
use OpenTribes\Core\User\Login\Interactor as UserLoginInteractor;
use OpenTribes\Core\User\Activate\Interactor as UserActivateInteractor;
use OpenTribes\Core\User\ActivationMail\Create\Interactor as ActivationMailCreateInteractor;
use OpenTribes\Core\User\ActivationMail\Send\Interactor as ActivationMailSendInteractor;
use OpenTribes\Core\User\Authenticate\Interactor as UserAuthenticateInteractor;
//Validators
use OpenTribes\Core\Mock\User\Validator as UserValidator;
//Exceptions
use OpenTribes\Core\User\Create\Exception as UserCreateException;
//Value Objects
use OpenTribes\Core\User\UserValue;
>>>>>>> 005af1fdb371df2736b7e2ce4dca90b7429d8a2b

require_once 'vendor/phpunit/phpunit/PHPUnit/Framework/Assert/Functions.php';

class UserHelper {

    protected $user;
    protected $roleRepository;
    protected $userRepository;
    protected $response;
    protected $codeGenerator;
    protected $exception = null;
    protected $mailSender;
    protected $userRoleRepository;
    protected $messageRepository;
    protected $activationMailRepository;
    protected $userValidator;
    protected $messageHelper;
    protected $hasher;
    //responses
    protected $userCreateResponse = null;
    protected $userActivateResponse = null;
    protected $activationMailCreateResponse = null;
    protected $activationMailSendResponse = null;
    protected $userLoginResponse = null;
    protected $accountCreateResponse;

    public function __construct(MessageHelper $messageHelper) {
        $this->roleRepository = new RoleRepository();
        $this->userRepository = new UserRepository();
        $this->userRoleRepository = new UserRoleRepository();
        $this->activationMailRepository = new ActivationMailRepository();
        $this->hasher = new Hasher();
        $this->codeGenerator = new Generator();
        $this->mailSender = new Mailer();
        $this->userValidator = new UserValidator(new UserValue);
        $this->messageHelper = $messageHelper;
        $this->initRoles();
    }

    // Default Methods to initialize Data

    /**
     * Method to Init base Roles
     */
    private function initRoles() {
        $this->roleRepository->add(new Role('Guest'));
        $this->roleRepository->add(new Role('User'));
        $this->roleRepository->add(new Role('Admin'));
    }

    /**
     * Method to create empty user 
     */
    public function newUser() {
        $this->user = new User(null, 'Guest', null, null);
    }

    /**
     * Methode to add a role to current user
     * @param String $name Rolename
     */
    public function addRole($name) {

        //Load guest role
        $role = $this->roleRepository->findByName($name);
        $userRole = new UserRole($this->user, $role);
        $this->user->addRole($userRole);
        $this->userRoleRepository->add($userRole);
        $this->userRepository->add($this->user);
    }

    /**
     * Method to create a DumpUsers, to simulate UserDatabase
     * @param array $data Userdata
     */
    public function createDumpUser(array $data) {

        foreach ($data as $row) {
            $user = new User($row['id'], $row['username'], $this->hasher->hash($row['password']), $row['email']);
            $role = $this->roleRepository->findByName('Guest');
            $userRole = new UserRole($user, $role);
            $user->addRole($userRole);
            $this->userRoleRepository->add($userRole);
            $this->userRepository->add($user);
        }
    }

    public function getUserRepository() {
        return $this->userRepository;
    }

    //Interactor tests
    /**
     * Method to create a user with an interactor
     * @param array $data Userdata
     */
    public function createAccount(array $data) {
        $accountCreateRequest = new AccountCreateRequest();
<<<<<<< HEAD
        foreach ($data as $row) {
            $userCreateValidationRequest = new UserCreateValidationRequest($row['username'], $row['password'], $row['email'], $row['password_confirm'], $row['email_confirm']);
            
        }
        $userCreateValidationInteractor = new UserCreateValidationInteractor($this->userRepository,$this->userValidator);

        $userCreateInteractor = new UserCreateInteractor(
                $this->userRepository, $this->roleRepository, $this->userRoleRepository, $this->hasher, $this->codeGenerator
        );
        $activationMailCreateInteractor = new ActivationMailCreateInteractor($this->activationMailRepository);
        $activationMailSendInteractor = new ActivationMailSendInteractor($this->mailer);

=======
        $accountCreateContext = new AccountCreateContext($this->userRepository, $this->userRoleRepository, $this->roleRepository, $this->activationMailRepository, $this->codeGenerator, $this->hasher, $this->mailSender, $this->userCreateValidator);
>>>>>>> 005af1fdb371df2736b7e2ce4dca90b7429d8a2b
        try {
            $this->accountCreateResponse = $accountCreateContext->invoke($accountCreateRequest, $this->user->getRoles());
        } catch (\Exception $e) {
            
        }
    }

    /**
     * Method to login as registered User with an interactor
     * @param array $data Userdata
     */
    public function login(array $data) {

        foreach ($data as $row) {
            $request = new UserLoginRequest($row['Username'], $row['Password']);
        }
        $interactor = new UserLoginInteractor($this->userRepository, $this->hasher);

        try {
            $this->response = $interactor($request);
            $authRequest = new UserAuthenticateRequest($this->response->getUser(), 'User');
            $authInteractor = new UserAuthenticateInteractor($this->userRepository, $this->roleRepository, $this->userRoleRepository);

            $this->response = $authInteractor($authRequest);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    /**
     * Method to send an Activation Mail with an interactor
     * it use the response of UserCreateInteractor
     */
    public function sendActivationCode() {
        assertTrue($this->activationMailSendResponse->getResult());
    }

    /**
     * Method to activate account and set a role for an active use with an interactor
     * @param array $data Userdata
     */
    public function activateAccount(array $data) {
        foreach ($data as $row) {
            $userActivateRequest = new UserActivateRequest($row['username'], $row['activation_code'], 'User');
        }
        $userActivateInteractor = new UserActivateInteractor($this->userRepository, $this->roleRepository, $this->userRoleRepository);
        try {
            $this->userActivateResponse = $userActivateInteractor->invoke($userActivateRequest);
        } catch (\Exception $e) {
            $this->exception = $e;
        }
    }

    //Assertion Methods for testing
    public function asserRegistrationFailed() {
        assertNull($this->userCreateResponse);
    }

    public function assertActivationFailed() {
        assertNull($this->userActivateResponse);
    }

    /**
     * Assert Login was successfull
     */
    public function assertIsLoginResponse() {
        assertInstanceOf('\OpenTribes\Core\User\Authenticate\Response', $this->response);

        assertNotNull($this->response->getUser()->getId());
    }

    /**
     * Assert Create Account was successfull
     */
    public function assertIsCreateResponse() {
        assertInstanceOf('\OpenTribes\Core\User\Create\Response', $this->userCreateResponse);
        assertNotNull($this->userCreateResponse->getUser());
    }

    /**
     * Assert an activation code mail was created
     */
    public function assertHasActivationCode() {

        assertInstanceOf('\OpenTribes\Core\User\ActivationMail\Create\Response', $this->activationMailCreateResponse);
        assertNotNull($this->userCreateResponse->getUser()->getActivationCode());
    }

    /**
     * Assert account is activated
     */
    public function assertActivated() {
        assertNotNull($this->userActivateResponse);
        assertInstanceOf('\OpenTribes\Core\User\Activate\Response', $this->userActivateResponse);
        assertEmpty($this->userActivateResponse->getUser()->getActivationCode());
    }

    /**
     * Assert account has role
     * @param String $role Role
     */
    public function assertHasRole($role) {
        $user = $this->response->getUser();

        assertTrue($user->hasRole($role));
    }

}

?>
