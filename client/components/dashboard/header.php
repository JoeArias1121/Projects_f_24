<!-- Dashboard Header -->
<?php
/* Commeted out by SAL on September 28, 2023
 * reason: we are making the 'jobs tab be the new 'home' tab, thus making this code unecessary
 * Keeping code just incase we retract on this decision
 
 
include_once('../../backend/config.php');
switch ($_SESSION['user_type']) {
    case $GLOBALS['emp_type']:
        echo("<header class='w3-container'>
            <h5> <i class='fa fa-dashboard'></i>  Employee Dashboard </h5>
            </header>");
        break;
    case $GLOBALS['admin_type']:
       echo("<header class='w3-container'>
            <h5> <i class='fa fa-dashboard'></i>  Admin Dashboard </h5>
            </header>");
        break;
        
    case $GLOBALS['super_type']:
        echo("<header class='w3-container'>
            <h5> <i class='fa fa-dashboard'></i>  Supervisor Dashboard </h5>
            </header>");
        break;
    case $GLOBALS['cust_type']:
        echo("<header class='w3-container'>
            <h5> <i class='fa fa-dashboard'></i>  Customer Dashboard </h5>
            </header>");
        break;
    case $GLOBALS['owner_type']:
        echo("<header class='w3-container'>
            <h5> <i class='fa fa-dashboard'></i>  Owner Dashboard </h5>
            </header>");
        break;
        */
/*     case $GLOBALS['dean_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Dean Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['faculty_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Faculty Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['employer_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Employer Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['recreg_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Records and Registration Dashboard</b></h5>
            </header>");
        break;
    case $GLOBALS['crc_type']:
        echo("<header class='w3-container' style='padding-top:22px'>
            <h5><b><i class='fa fa-dashboard'></i>  Career Resource Center Dashboard</b></h5>
            </header>");
        break; 
}
*/
?>