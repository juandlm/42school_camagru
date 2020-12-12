<style>
@import url(https://fonts.googleapis.com/css?family=Anonymous+Pro);

html{
  min-height: 100%;
  overflow: hidden;
}
body{
  height: calc(100vh - 8em);
  padding: 4em;
  color: rgba(255,255,255,.75);
  font-family: 'Anonymous Pro', monospace;  
  background-color: rgb(25,25,25);  
}
.line-1{
    position: relative;
    top: 50%;  
    width: 24em;
    margin: 0 auto;
    border-right: 2px solid rgba(255,255,255,.75);
    font-size: 180%;
    text-align: center;
    white-space: nowrap;
    overflow: hidden;
    transform: translateY(-50%);    
}

.anim-typewriter{
  animation: typewriter 4s steps(44) 1s 1 normal both,
             blinkTextCursor 500ms steps(44) infinite normal;
}
@keyframes typewriter{
  from{width: 0;}
  to{width: 24em;}
}
@keyframes blinkTextCursor{
  from{border-right-color: rgba(255,255,255,.75);}
  to{border-right-color: transparent;}
}

.lds-heart {
  display: inline-block;
  position: relative;
  width: 64px;
  height: 64px;
  transform: rotate(45deg);
  transform-origin: 32px 32px;
}
.lds-heart div {
  top: 23px;
  left: 19px;
  position: absolute;
  width: 26px;
  height: 26px;
  background: red;
  animation: lds-heart 1.2s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
}
.lds-heart div:after,
.lds-heart div:before {
  content: " ";
  position: absolute;
  display: block;
  width: 26px;
  height: 26px;
  background: red;
}
.lds-heart div:before {
  left: -17px;
  border-radius: 50% 0 0 50%;
}
.lds-heart div:after {
  top: -17px;
  border-radius: 50% 50% 0 0;
}
@keyframes lds-heart {
  0% {
    transform: scale(0.95);
  }
  5% {
    transform: scale(1.1);
  }
  39% {
    transform: scale(0.85);
  }
  45% {
    transform: scale(1);
  }
  60% {
    transform: scale(0.95);
  }
  100% {
    transform: scale(0.9);
  }
}
</style>
<p class="line-1 anim-typewriter">
	Welcome to Camagru
	<div class="lds-heart"><div></div></div>
	<br>
<?php
$br = "<br/>";

require_once(APP . "config/database.php");

echo "Begin of installation - Camagru - " . date('Y-m-d H:i:s') . $br . $br;

//////////////////////////////////////////////////////////////////
//
// Connecting to server
//
//////////////////////////////////////////////////////////////////

$srv = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);


//////////////////////////////////////////////////////////////////
//
// Testing and creating database db_camagru
//
//////////////////////////////////////////////////////////////////

echo "Database Camagru :$br";

// _______________________________________________________________

//
// Drop database if exists
//

try {
    $sql = "DROP DATABASE IF EXISTS db_camagru;";
    $srv->exec($sql);
    echo " - Tests if database already exists.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . $br;
}

// _______________________________________________________________

//
// Creates database
//

try {
    $sql = "CREATE DATABASE IF NOT EXISTS `db_camagru` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;";
    $srv->exec($sql);
    echo " - Creates database db_camagru.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . $br;
}

// _______________________________________________________________

//
// Connects to created database
//

$db = new PDO("mysql:dbname=db_camagru;host=mysql;charset=utf8mb4", "root", "rootpass");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //Error Handling


//////////////////////////////////////////////////////////////////
//
// Creating tables and dumping data
//
//////////////////////////////////////////////////////////////////

echo "$br Tables :$br";

// _______________________________________________________________

//
// Table structure for table `t_comments`
//

$table = "t_comments";

try {
    $sql = "CREATE TABLE $table (
            `cmt_id` int(11) NOT NULL,
            `cmt_usr_id` int(11) NOT NULL,
            `cmt_img_id` int(11) NOT NULL,
            `cmt_body` varchar(512) COLLATE utf8mb4_bin NOT NULL,
            `cmt_active` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '1' COMMENT '1 : active, 0 : not active',
            `cmt_dtcrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    $db->exec($sql);
    echo " - Created table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Table structure for table `t_followups`
//

$table = "t_followups";

try {
    $sql = "CREATE TABLE $table (
            `fol_id` int(11) NOT NULL,
            `fol_followed_id` int(11) NOT NULL,
            `fol_following_id` int(11) NOT NULL,
            `fol_active` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '1' COMMENT '1 : active, 0 : not active',
            `fol_dtcrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    $db->exec($sql);
    echo " - Created table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Table structure for table `t_images`
//

$table = "t_images";

try {
    $sql = "CREATE TABLE $table (
            `img_id` int(11) NOT NULL,
            `img_usr_id` int(11) NOT NULL,
            `img_upl_id` int(11) NOT NULL,
            `img_name` varchar(191) COLLATE utf8mb4_bin NOT NULL,
            `img_description` varchar(1000) COLLATE utf8mb4_bin DEFAULT '0',
            `img_active` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '1' COMMENT '1 : active, 0 : not active',
            `img_dtcrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    $db->exec($sql);
    echo " - Created table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

//
// Dumping data for table `t_images`
//

try {
    $sql = "INSERT INTO $table
            (`img_id`, `img_usr_id`, `img_upl_id`, `img_name`, `img_description`, `img_active`, `img_dtcrea`) 
            VALUES
            (1, 2, 326, '15630111581549655768.png', NULL, '1', '2019-05-15 04:49:07'),
            (2, 2, 327, '1563011242712645338.png', NULL, '1', '2019-05-15 05:49:07'),
            (3, 2, 317, '1563011125256852586.png', NULL, '1', '2019-05-15 06:49:07'),
            (4, 2, 318, '15630111301350453240.png', NULL, '1', '2019-05-15 07:49:07'),
            (5, 7, 319, '15630111352007231633.png', NULL, '1', '2019-05-15 08:49:07'),
            (6, 7, 320, '1563011138355836517.png', NULL, '1', '2019-05-15 09:49:07'),
            (7, 2, 321, '1563011140782836944.png', NULL, '1', '2019-05-15 10:49:07'),
            (8, 7, 322, '1563011144965886841.png', NULL, '1', '2019-05-15 11:49:07'),
            (9, 2, 323, '1563011148485969967.png', NULL, '1', '2019-05-15 12:49:07'),
            (10, 7, 324, '1563011151956373089.png', NULL, '1', '2019-05-15 13:49:07'),
            (11, 7, 325, '1563011154132857798.png', 'children of the world #africa', '1', '2019-05-15 14:49:07');";
    $db->exec($sql);
    echo " - Inserted data in table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}


// _______________________________________________________________

//
// Table structure for table `t_likes`
//

$table = "t_likes";

try {
    $sql = "CREATE TABLE $table (
            `lik_id` int(11) NOT NULL,
            `lik_usr_id` int(11) NOT NULL,
            `lik_img_id` int(11) NOT NULL,
            `lik_active` varchar(10) COLLATE utf8mb4_bin NOT NULL DEFAULT '1' COMMENT '1 : active,  0 : not active',
            `lik_dtcrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    $db->exec($sql);
    echo " - Created table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Table structure for table `t_uploads`
//

$table = "t_uploads";

try {
    $sql = "CREATE TABLE $table (
            `upl_id` int(11) NOT NULL,
            `upl_usr_id` int(11) NOT NULL,
            `upl_url` varchar(2048) COLLATE utf8mb4_bin NOT NULL,
            `upl_type` varchar(1) COLLATE utf8mb4_bin NOT NULL COMMENT '2 : profile pic, 1 : studio, 0 : upload',
            `upl_active` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '0' COMMENT '2: posted, 1 : saved, 0 : inactive',
            `upl_dtcrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    $db->exec($sql);
    echo " - Created table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}


//
// Dumping data for table `t_uploads`
//

try {
    $sql = "INSERT INTO $table
            (`upl_id`, `upl_usr_id`, `upl_url`, `upl_type`, `upl_active`, `upl_dtcrea`) 
            VALUES
            (317, 7, '//localhost/camagru/public/img/userupload/1563011125256852586.png', '0', '2', '2019-07-13 09:45:24'),
            (318, 7, '//localhost/camagru/public/img/userupload/15630111301350453240.png', '0', '2', '2019-07-13 09:45:30'),
            (319, 7, '//localhost/camagru/public/img/userupload/15630111352007231633.png', '0', '2', '2019-07-13 09:45:34'),
            (320, 7, '//localhost/camagru/public/img/userupload/1563011138355836517.png', '0', '2', '2019-07-13 09:45:37'),
            (321, 7, '//localhost/camagru/public/img/userupload/1563011140782836944.png', '0', '2', '2019-07-13 09:45:40'),
            (322, 7, '//localhost/camagru/public/img/userupload/1563011144965886841.png', '0', '2', '2019-07-13 09:45:43'),
            (323, 7, '//localhost/camagru/public/img/userupload/1563011148485969967.png', '0', '2', '2019-07-13 09:45:47'),
            (324, 7, '//localhost/camagru/public/img/userupload/1563011151956373089.png', '0', '2', '2019-07-13 09:45:51'),
            (325, 7, '//localhost/camagru/public/img/userupload/1563011154132857798.png', '0', '2', '2019-07-13 09:45:54'),
            (326, 7, '//localhost/camagru/public/img/userupload/15630111581549655768.png', '0', '2', '2019-07-13 09:45:57'),
            (327, 7, '//localhost/camagru/public/img/userupload/1563011242712645338.png', '0', '2', '2019-07-13 09:47:22')";
    $db->exec($sql);
    echo " - Inserted data in table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Table structure for table `t_users`
//

$table = "t_users";

try {
    $sql = "CREATE TABLE $table (
            `usr_id` int(11) NOT NULL,
            `usr_login` varchar(25) COLLATE utf8mb4_bin NOT NULL,
            `usr_pwd` varchar(512) COLLATE utf8mb4_bin NOT NULL,
            `usr_name` varchar(20) COLLATE utf8mb4_bin NOT NULL,
            `usr_bio` varchar(100) COLLATE utf8mb4_bin NOT NULL,
            `usr_ppic` mediumtext COLLATE utf8mb4_bin NOT NULL,
            `usr_email` varchar(254) COLLATE utf8mb4_bin NOT NULL,
            `usr_token` varchar(2048) COLLATE utf8mb4_bin DEFAULT NULL,
            `usr_confirmed` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '0' COMMENT '1 : confirmed, 0 : not confirmed',
            `usr_cmt_sendmail` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '1' COMMENT '1 : send email on new commentary, 0 : none',
            `usr_lik_sendmail` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '1',
            `usr_group` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT 'c' COMMENT 'c : customer, a : admin',
            `usr_active` varchar(1) COLLATE utf8mb4_bin NOT NULL DEFAULT '1' COMMENT '1 : active, 0 : not active',
            `usr_dtcrea` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;";
    $db->exec($sql);
    echo " - Created table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

//
// Dumping data for table `t_users`
//

try {
    $sql = "INSERT INTO $table
            (`usr_id`, `usr_login`, `usr_pwd`, `usr_name`, `usr_bio`, `usr_ppic`, `usr_email`, `usr_token`, `usr_confirmed`, `usr_cmt_sendmail`, `usr_lik_sendmail`, `usr_group`, `usr_active`, `usr_dtcrea`) 
            VALUES
            (2, 'juan', '123', 'Juan', '', 'public/img/nopic.png', 'admin@camagru.com 	', '', '0', '1', '1', 'a', '1', '2019-05-15 12:39:34'),
            (3, 'fadi', '\$2y\$10\$JOwNE/ovubxnaaqlkCtywuQokTNzypxsd62qe3fv2oMW/4GykzcX6', 'Fadi', '', 'public/img/nopic.png', 'tstcamagru@akl.cc', '', '1', '1', '1', 'a', '1', '2019-05-15 12:39:34'),
            (7, 'test', '\$2y\$10\$DuGNzWI4O65TJOX7nJfXUeMj945MQnwoR7lbURuHucDLytZkVwToC', 'FELICIA THE GOAT', 'I like cheese 🧀🧀🧀', 'public/img/userupload/1563398205524727749.jpg', 'aa@aa.aaaaa', NULL, '1', '1', '0', 'c', '1', '2019-05-26 21:35:14'),
            (8, 'test2', '\$2y\$10\$DuGNzWI4O65TJOX7nJfXUeMj945MQnwoR7lbURuHucDLytZkVwToC', 'Pierrot', '', 'public/img/nopic.png', 'test2@te.st', NULL, '1', '1', '1', 'c', '1', '2019-06-01 10:54:18');";
    $db->exec($sql);
    echo " - Inserted data in table $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}


//////////////////////////////////////////////////////////////////
//
// Indexes
//
//////////////////////////////////////////////////////////////////

echo "$br Indexes :$br";

// _______________________________________________________________

//
// Indexes for table `t_comments`
//

$table = "t_comments";

try {
    $sql = "ALTER TABLE $table
            ADD PRIMARY KEY (`cmt_id`),
            ADD UNIQUE KEY `cmt_id` (`cmt_id`) USING BTREE,
            ADD KEY `cmt_usr_id` (`cmt_usr_id`) USING BTREE,
            ADD KEY `cmt_img_id` (`cmt_img_id`),
            ADD KEY `cmt_usr_id_img_id` (`cmt_usr_id`,`cmt_img_id`);";
    $db->exec($sql);
    echo " - Created index for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Indexes for table `t_followups`
//

$table = "t_followups";

try {
    $sql = "ALTER TABLE $table
    ADD PRIMARY KEY (`fol_id`) USING BTREE,
    ADD UNIQUE KEY `fol_id` (`fol_id`) USING BTREE,
    ADD UNIQUE KEY `followed_id_followed_id` (`fol_followed_id`,`fol_following_id`) USING BTREE,
    ADD KEY `fol_followed_id` (`fol_followed_id`) USING BTREE,
    ADD KEY `fol_following_id` (`fol_following_id`) USING BTREE;";
    $db->exec($sql);
    echo " - Created index for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Indexes for table `t_images`
//

$table = "t_images";

try {
    $sql = "ALTER TABLE $table
            ADD PRIMARY KEY (`img_id`),
            ADD UNIQUE KEY `img_id` (`img_id`) USING BTREE,
            ADD UNIQUE KEY `img_name` (`img_name`),
            ADD KEY `img_usr_id` (`img_usr_id`),
            ADD KEY `img_upl_id` (`img_upl_id`);";
    $db->exec($sql);
    echo " - Created index for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Indexes for table `t_likes`
//

$table = "t_likes";

try {
    $sql = "ALTER TABLE $table
            ADD PRIMARY KEY (`lik_id`),
            ADD UNIQUE KEY `lik_id` (`lik_id`) USING BTREE,
            ADD UNIQUE KEY `lik_usr_id_img_id` (`lik_usr_id`,`lik_img_id`) USING BTREE,
            ADD KEY `lik_usr_id` (`lik_usr_id`) USING BTREE,
            ADD KEY `lik_img_id` (`lik_img_id`) USING BTREE;";
    $db->exec($sql);
    echo " - Created index for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Indexes for table `t_uploads`
//

$table = "t_uploads";

try {
    $sql = "ALTER TABLE $table
              ADD PRIMARY KEY (`upl_id`),
              ADD UNIQUE KEY `upl_id` (`upl_id`) USING BTREE,
              ADD KEY `upl_usr_id` (`upl_usr_id`),
              ADD KEY `upl_url` (`upl_url`(191));";
    $db->exec($sql);
    echo " - Created index for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Indexes for table `t_users`
//

$table = "t_users";

try {
    $sql = "ALTER TABLE $table
            ADD PRIMARY KEY (`usr_id`),
            ADD UNIQUE KEY `usr_id` (`usr_id`),
            ADD UNIQUE KEY `usr_login` (`usr_login`);";
    $db->exec($sql);
    echo " - Created index for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}


//////////////////////////////////////////////////////////////////
//
// Auto increments
//
//////////////////////////////////////////////////////////////////

echo "$br Auto increments :$br";

// _______________________________________________________________

//
// Auto increments for table `t_comments`
//

$table = "t_comments";

try {
    $sql = "ALTER TABLE $table
            MODIFY `cmt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;";
    $db->exec($sql);
    echo " - Set auto increment for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Auto increments for table `t_followups`
//

$table = "t_followups";

try {
    $sql = "ALTER TABLE $table
            MODIFY `fol_id` int(11) NOT NULL AUTO_INCREMENT;";
    $db->exec($sql);
    echo " - Set auto increment for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Auto increments for table `t_images`
//

$table = "t_images";

try {
    $sql = "ALTER TABLE $table
            MODIFY `img_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;";
    $db->exec($sql);
    echo " - Set auto increment for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Auto increments for table `t_likes`
//

$table = "t_likes";

try {
    $sql = "ALTER TABLE $table
            MODIFY `lik_id` int(11) NOT NULL AUTO_INCREMENT;";
    $db->exec($sql);
    echo " - Set auto increment for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Auto increments for table `t_uploads`
//

$table = "t_uploads";

try {
    $sql = "ALTER TABLE $table
            MODIFY `upl_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=440;";
    $db->exec($sql);
    echo " - Set auto increment for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Auto increments for table `t_users`
//

$table = "t_users";

try {
    $sql = "ALTER TABLE $table
            MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;";
    $db->exec($sql);
    echo " - Set auto increment for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}


//////////////////////////////////////////////////////////////////
//
// Constraints
//
//////////////////////////////////////////////////////////////////

echo "$br Constraints :$br";

// _______________________________________________________________

//
// Constraints for table `t_comments`
//

$table = "t_comments";

try {
    $sql = "ALTER TABLE $table
            ADD CONSTRAINT `t_comments_ibfk_1` FOREIGN KEY (`cmt_usr_id`) REFERENCES `t_users` (`usr_id`),
            ADD CONSTRAINT `t_comments_ibfk_2` FOREIGN KEY (`cmt_img_id`) REFERENCES `t_images` (`img_id`);";
    $db->exec($sql);
    echo " - Set constraints for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Constraints for table `t_followups`
//

$table = "t_followups";

try {
    $sql = "ALTER TABLE $table
            ADD CONSTRAINT `t_followups_ibfk_1` FOREIGN KEY (`fol_followed_id`) REFERENCES `t_users` (`usr_id`),
            ADD CONSTRAINT `t_followups_ibfk_2` FOREIGN KEY (`fol_following_id`) REFERENCES `t_users` (`usr_id`);";
    $db->exec($sql);
    echo " - Set constraints for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Constraints for table `t_images`
//

$table = "t_images";

try {
    $sql = "ALTER TABLE $table
            ADD CONSTRAINT `t_images_ibfk_1` FOREIGN KEY (`img_usr_id`) REFERENCES `t_users` (`usr_id`),
            ADD CONSTRAINT `t_images_ibfk_2` FOREIGN KEY (`img_upl_id`) REFERENCES `t_uploads` (`upl_id`);";
    $db->exec($sql);
    echo " - Set constraints for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Constraints for table `t_likes`
//

$table = "t_likes";

try {
    $sql = "ALTER TABLE $table
            ADD CONSTRAINT `t_likes_ibfk_1` FOREIGN KEY (`lik_usr_id`) REFERENCES `t_users` (`usr_id`),
            ADD CONSTRAINT `t_likes_ibfk_2` FOREIGN KEY (`lik_img_id`) REFERENCES `t_images` (`img_id`);";
    $db->exec($sql);
    echo " - Set constraints for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}

// _______________________________________________________________

//
// Constraints for table `t_uploads`
//

$table = "t_uploads";

try {
    $sql = "ALTER TABLE $table
            ADD CONSTRAINT `t_uploads_ibfk_1` FOREIGN KEY (`upl_usr_id`) REFERENCES `t_users` (`usr_id`);";
    $db->exec($sql);
    echo " - Set constraints for $table.$br";
} catch (PDOException $e) {
    echo $e->getMessage() . " - in table : $table" . $br;
}


//////////////////////////////////////////////////////////////////
//
// Configuration
//
//////////////////////////////////////////////////////////////////

echo $br . "Configuration :$br";

// _______________________________________________________________

echo " - Writing 'index.php'.";

$new_file = "<?php" . PHP_EOL;
$new_file .= "if (empty(session_id()))" . PHP_EOL;
$new_file .= "	session_start();" . PHP_EOL;
$new_file .= "" . PHP_EOL;
$new_file .= "if(isset(\$_COOKIE['auth']) && !isset(\$_SESSION['user_id'])) {" . PHP_EOL;
$new_file .= "	\$auth = htmlspecialchars(\$_COOKIE['auth']);" . PHP_EOL;
$new_file .= "	\$auth = explode('---', \$auth);" . PHP_EOL;
$new_file .= "	\$model = new \Camagru\Core\Model;" . PHP_EOL;
$new_file .= "	\$user = \$model->db->prepare(\"SELECT * FROM user WHERE id = ?\", [\$auth[0]], true, true, false);" . PHP_EOL;
$new_file .= "	\$key = sha1(\$user->username . \$user->password . \$_SERVER['REMOTE_ADDR']);" . PHP_EOL;
$new_file .= "	if (\$key == \$auth[1]) {" . PHP_EOL;
$new_file .= "		\$_SESSION['user_id']       = \$user->id;" . PHP_EOL;
$new_file .= "		\$_SESSION['user_username'] = \$user->username;" . PHP_EOL;
$new_file .= "		setcookie('auth', \$user->id . '---' . \$key, time() + 3600 * 24 * 365, null, null, false, true);" . PHP_EOL;
$new_file .= "	}" . PHP_EOL;
$new_file .= "	else" . PHP_EOL;
$new_file .= "		setcookie('auth', '', time() - 3600, null, null, false, true);" . PHP_EOL;
$new_file .= "}" . PHP_EOL;
$new_file .= "" . PHP_EOL;
$new_file .= "define(\"ROOT\", dirname(__FILE__) . '/');" . PHP_EOL;
$new_file .= "define(\"APP\", ROOT . \"app\" . '/');" . PHP_EOL;
$new_file .= "" . PHP_EOL;
$new_file .= "require (APP . \"Core/Autoloader.php\");" . PHP_EOL;
$new_file .= "new Camagru\Core\Autoloader();" . PHP_EOL;
$new_file .= "" . PHP_EOL;
$new_file .= "require (APP . \"config/config.php\");" . PHP_EOL;
$new_file .= "" . PHP_EOL;
$new_file .= "use Camagru\Core\Application;" . PHP_EOL;
$new_file .= "" . PHP_EOL;
$new_file .= "\$app = new Application();" . PHP_EOL;

file_put_contents("index.php", $new_file);

// _______________________________________________________________

echo $br . $br . "End of installation - Camagru - " . date('Y-m-d H:i:s');

// _______________________________________________________________

unlink(__FILE__);

header("refresh:8; url=index.php");

?>
</p>