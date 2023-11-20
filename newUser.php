<?php
require 'php/sessionManager.php';
include_once 'models/users.php';

anonymousAccess();
UsersFile()->add(new User($_POST));
redirect('loginForm.php'); 