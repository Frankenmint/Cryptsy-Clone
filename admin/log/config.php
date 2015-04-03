<?
/**
 * config.php
 *
 * This file is intended to group all constants to
 * make it easier for the site administrator to tweak
 * the login script.
 *
 * Written by: Alejandro U Alvarez http://urbanoalvarez.es
 * Last Updated: March 21, 2008
 */
 
/**
 * Database Constants - these constants are required
 * in order for there to be a successful connection
 * to the MySQL database. Make sure the information is
 * correct.
 */
define("DB_SERVER", "localhost");  //Here goes the server (Normally it will be localhost)
define("DB_USER", "root");     //Here goes the username
define("DB_PASS", "IOJIOjoijipj54r4g85r4g84r8g48er4g");     //The password
define("DB_NAME", "log");      //The database name

/**
 * Database Table Constants - these constants
 * hold the names of all the database tables used
 * in the script.
 */
 
define("TBL_LOG", "log");     //Database where logs will be stored

// Security constant, the one you'll have to use in order to delete the log:
define("LOG_PASS", ""); //MUST be sha1 encoded 

/**
 * Email Constants - these specify what goes in
 * the from field in the emails that the script
 * sends to users, and whether to send a
 * welcome email to newly registered users.
 */
define("SITE_NAME", "Crypto Maniac Urbano");
define("EMAIL_FROM_NAME", "admin");
define("EMAIL_FROM_ADDR", "support@crypto-maniac.com");
define("EMAIL_TO_ADDR", "adytech2010@gmail.com");
?>
