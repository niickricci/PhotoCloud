<?php
// Default time out is 1440 seconds
// http://php.net/session.gc-maxlifetime
//

const defaultTimeout = 20 * 60;
session_start();
$_SESSION['timeout'] = defaultTimeout;
function set_Session_Timeout($timeout, $returnPage)
{
    $_SESSION['timeout'] = $timeout;
    if (isset($_SESSION['lastVisit'])) {
        // seconds since last visit
        $duration = time() - (int) $_SESSION['lastVisit'];
        if ($duration > $timeout) {
            delete_session();
            session_start();
            $_SESSION['timeoutOccured'] = true;
            redirect($returnPage);
        }
    }
    // renew last visit time
    $_SESSION['lastVisit'] = time();
}
function session_Timeout_Occured()
{
    return isset($_SESSION['timeoutOccured']);
}
function delete_session()
{
    session_destroy(); // effacer le fichier ../wamp64/tmp/sess_PHPSESSID
    session_start();
}
function redirect($url)
{
    header('location:' . $url);
    exit();
}
function anonymousAccess($timeout = defaultTimeout)
{
    if (isset($_SESSION["validUser"]) || isset($_SESSION["validAdmin"])) {
        set_Session_Timeout($timeout, 'loginForm.php');
    }
}
function userAccess($timeout = defaultTimeout)
{
    if (!isset($_SESSION['validUser'])) {
        redirect('forbidden.php');
    }
    else if (isset($_SESSION['isBlocked'])) {
        redirect('blocked.php');

    } else {
        set_Session_Timeout($timeout, 'loginForm.php');
    }
}
function adminAccess($timeout = defaultTimeout)
{
    if (isset($_SESSION['isAdmin'])) {
        if ((bool)$_SESSION["isAdmin"])
            set_Session_Timeout($timeout, 'loginForm.php');
        else
            redirect('illegalAction.php');
    } else
        redirect('illegalAction.php');
}
