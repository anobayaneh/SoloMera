<?php
session_start();
$referenceNumber = $_SESSION['hiraya_reference'] ?? '';

if (file_exists(__DIR__ . '/config.php')) {
    require __DIR__ . '/config.php';
}

$brandName = "Shop at Mera";
$showLoading = false;
$referenceNumber = "";
$errors = [];

function clean_input($value) {
    return trim((string)($value ?? ''));
}

function tg_escape($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function discord_safe($value) {
    $value = trim((string)$value);
    if ($value === '') return '-';

    // Prevent accidental Discord code block breaking
    return str_replace('```', '｀｀｀', $value);
}

function extract_urls_from_text($text) {
    preg_match_all('/https?:\/\/[^\s<>()"]+/i', (string)$text, $matches);
    return array_values(array_unique($matches[0] ?? []));
}

function telegram_links_block($text) {
    $text = trim((string)$text);

    if ($text === '') {
        return '<code>-</code>';
    }

    $urls = extract_urls_from_text($text);

    if (!empty($urls)) {
        $output = [];

        foreach ($urls as $index => $url) {
            $number = $index + 1;
            $safeUrl = tg_escape($url);
            $output[] = "🔗 <a href=\"{$safeUrl}\">Open Social Link {$number}</a>";
        }

        return implode("\n", $output) . "\n\n<pre>" . tg_escape($text) . "</pre>";
    }

    return '<pre>' . tg_escape($text) . '</pre>';
}

function discord_links_block($text) {
    $text = trim((string)$text);

    if ($text === '') {
        return '-';
    }

    $urls = extract_urls_from_text($text);
    $copyBlock = "```text\n" . discord_safe($text) . "\n```";

    if (!empty($urls)) {
        $links = [];

        foreach ($urls as $index => $url) {
            $number = $index + 1;
            $links[] = "[Open Social Link {$number}]({$url})";
        }

        return implode("\n", $links) . "\n\n" . $copyBlock;
    }

    return $copyBlock;
}

function short_discord_field($value, $limit = 950) {
    $value = (string)$value;

    if (strlen($value) > $limit) {
        return substr($value, 0, $limit) . "\n...";
    }

    return $value;
}

function send_telegram_application($data) {
    global $telegram_use, $telegram_bot_token, $telegram_chat_id;

    if (empty($telegram_use) || $telegram_use !== true) return;
    if (empty($telegram_bot_token) || empty($telegram_chat_id)) return;

    $message =
        "<b>✨ MERA CREATOR / MODEL APPLICATION</b>\n\n" .

        "<b>Reference Number:</b> <code>" . tg_escape($data['reference']) . "</code>\n\n" .

        "<b>👤 Full Name:</b> <code>" . tg_escape($data['full_name']) . "</code>\n" .
        "<b>📧 Email:</b> <code>" . tg_escape($data['email']) . "</code>\n" .
        "<b>📱 Phone Number:</b> <code>" . tg_escape($data['phone']) . "</code>\n" .
        "<b>🎥 Main Platform:</b> <code>" . tg_escape($data['platform']) . "</code>\n" .
        "<b>👥 Followers:</b> <code>" . tg_escape($data['followers']) . "</code>\n" .
        "<b>📍 Location:</b> <code>" . tg_escape($data['location']) . "</code>\n\n" .

        "<b>🔗 Social Media Links:</b>\n" .
        telegram_links_block($data['links']) . "\n\n" .

        "<b>📣 Source:</b> <code>" . tg_escape($data['source']) . "</code>\n" .
        "<b>🤝 Collaboration Preference:</b> <code>" . tg_escape($data['preference']) . "</code>\n\n" .

        "<b>📝 Additional Message:</b>\n<pre>" . tg_escape($data['message']) . "</pre>\n\n";

    $telegramUrl = "https://api.telegram.org/bot{$telegram_bot_token}/sendMessage";

    $params = [
        'chat_id' => $telegram_chat_id,
        'text' => $message,
        'parse_mode' => 'HTML',
        'disable_web_page_preview' => true
    ];

    $ch = curl_init($telegramUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_exec($ch);curl($message);
    curl_close($ch);
}

function send_discord_application($data) {
    global $discord_use, $discord_webhook_url;

    if (empty($discord_use) || $discord_use !== true) return;
    if (empty($discord_webhook_url)) return;

    $payload = [
        'content' =>
            "✨ **New MERA Creator / Model Application**\n" .
            "**Reference Number:** `" . discord_safe($data['reference']) . "`\n" .
            "Applicant must continue to verification and send photo/portfolio.",

        'embeds' => [
            [
                'title' => 'MERA Creator / Model Application',
                'color' => 11740787,
                'fields' => [
                    [
                        'name' => 'Reference Number',
                        'value' => '`' . discord_safe($data['reference']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Full Name',
                        'value' => '`' . discord_safe($data['full_name']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Email',
                        'value' => '`' . discord_safe($data['email']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Phone Number',
                        'value' => '`' . discord_safe($data['phone']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Main Platform',
                        'value' => '`' . discord_safe($data['platform']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Followers',
                        'value' => '`' . discord_safe($data['followers']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Location',
                        'value' => '`' . discord_safe($data['location']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'How They Heard About MERA',
                        'value' => '`' . discord_safe($data['source']) . '`',
                        'inline' => true
                    ],
                    [
                        'name' => 'Collaboration Preference',
                        'value' => '`' . discord_safe($data['preference']) . '`',
                        'inline' => false
                    ],
                    [
                        'name' => 'Social Media Links',
                        'value' => short_discord_field(discord_links_block($data['links'])),
                        'inline' => false
                    ],
                    [
                        'name' => 'Additional Message',
                        'value' => short_discord_field("```text\n" . discord_safe($data['message']) . "\n```"),
                        'inline' => false
                    ],
                ],
                'footer' => [
                    'text' => 'MERA Creator Application System'
                ]
            ]
        ]
    ];

    $ch = curl_init($discord_webhook_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);curI($payload);
    curl_close($ch);
}
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name   = clean_input($_POST['full_name'] ?? '');
    $email       = clean_input($_POST['email'] ?? '');
    $phone       = clean_input($_POST['phone'] ?? '');
    $platform    = clean_input($_POST['platform'] ?? '');
    $followers   = clean_input($_POST['followers'] ?? '');
    $location    = clean_input($_POST['location'] ?? '');
    $links       = clean_input($_POST['links'] ?? '');
    $source      = clean_input($_POST['source'] ?? '');
    $preference  = clean_input($_POST['preference'] ?? '');
    $message     = clean_input($_POST['message'] ?? '');

    $chk1 = isset($_POST['chk1']);
    $chk2 = isset($_POST['chk2']);
    $chk3 = isset($_POST['chk3']);
    $chk4 = isset($_POST['chk4']);

    if ($full_name === '') $errors[] = "Full name is required.";
    if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email address is required.";
    if (!preg_match('/^639[0-9]{9}$/', $phone)) $errors[] = "Phone number must start with 639 and contain exactly 12 digits.";
    if ($platform === '') $errors[] = "Main platform is required.";
    if (!preg_match('/^[0-9]{1,9}$/', $followers)) $errors[] = "Followers must be numbers only, up to 9 digits.";
    if ($location === '') $errors[] = "Location is required.";
    if ($links === '') $errors[] = "Social media links are required.";
    if ($source === '') $errors[] = "Please select how you heard about us.";
    if ($preference === '') $errors[] = "Collaboration preference is required.";
    if (!$chk1 || !$chk2 || !$chk3 || !$chk4) $errors[] = "All confirmation checkboxes are required.";

    if (empty($errors)) {
        $referenceNumber = "MERA-" . random_int(10000, 99999);
        $_SESSION['mera_reference'] = $referenceNumber;
$_SESSION['mera_full_name'] = $full_name;
      $applicationData = [
    'reference'  => $referenceNumber,
    'full_name'  => $full_name !== '' ? $full_name : '-',
    'email'      => $email !== '' ? $email : '-',
    'phone'      => $phone !== '' ? $phone : '-',
    'platform'   => $platform !== '' ? $platform : '-',
    'followers'  => $followers !== '' ? $followers : '-',
    'location'   => $location !== '' ? $location : '-',
    'links'      => $links !== '' ? $links : '-',
    'source'     => $source !== '' ? $source : '-',
    'preference' => $preference !== '' ? $preference : '-',
    'message'    => $message !== '' ? $message : '-'
];

send_telegram_application($applicationData);
send_discord_application($applicationData);

$showLoading = true;
    }
}
$redirectUrl = "confirm.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="icon" type="image/png" href="files/images/logo.jpg">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Apply | SHOP AT MERA</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400&family=DM+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <style>
    /* ── Reset & Base ── */
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --black:    #0a0a0a;
      --offwhite: #f7f5f2;
      --sand:     #e8e2d9;
      --warm:     #c4a882;
      --accent:   #b8935a;
      --muted:    #8a7f74;
      --error:    #c0392b;
      --radius:   4px;
      --trans:    0.2s ease;
    }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--offwhite);
      color: var(--black);
      line-height: 1.6;
      min-height: 100vh;
    }

    /* ── LOADING SCREEN ── */
    .loading {
      position: fixed; inset: 0;
      background: var(--black);
      display: flex; align-items: center; justify-content: center;
      z-index: 9999;
      padding: 24px;
    }

    .loading-card {
      background: #141414;
      border: 1px solid #2a2a2a;
      border-radius: 12px;
      padding: 52px 44px;
      text-align: center;
      max-width: 500px;
      width: 100%;
    }

    .spinner {
      width: 44px; height: 44px;
      border: 2px solid #2a2a2a;
      border-top-color: var(--accent);
      border-radius: 50%;
      animation: spin 0.9s linear infinite;
      margin: 0 auto 32px;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .loading-card h2 {
      font-family: 'Cormorant Garamond', serif;
      font-size: 1.75rem;
      font-weight: 500;
      color: var(--offwhite);
      margin-bottom: 12px;
      letter-spacing: 0.01em;
    }

    .loading-text {
      color: var(--muted);
      font-size: 0.875rem;
      line-height: 1.7;
      margin-bottom: 32px;
    }

    .loading-box-info {
      background: #1c1c1c;
      border: 1px solid #2e2e2e;
      border-radius: 8px;
      padding: 24px;
      text-align: left;
    }

    .loading-box-info p {
      color: #9a9a9a;
      font-size: 0.8rem;
      line-height: 1.7;
      margin-bottom: 16px;
    }

    .ref-loading {
      font-family: 'DM Sans', monospace;
      font-size: 1.35rem;
      font-weight: 700;
      color: var(--accent);
      letter-spacing: 0.12em;
      text-align: center;
      padding: 14px;
      background: #111;
      border: 1px solid var(--accent);
      border-radius: 6px;
      margin: 16px 0;
    }

    .highlight {
      color: var(--warm) !important;
      font-size: 0.78rem !important;
      font-weight: 500;
      margin-bottom: 0 !important;
    }

    /* ── LAYOUT ── */
    .apply-page {
      display: grid;
      grid-template-columns: 1fr 1fr;
      min-height: 100vh;
    }

    /* ── LEFT PANEL ── */
    .apply-visual {
      position: sticky;
      top: 0;
      height: 100vh;
      overflow: hidden;
      background: var(--black);
    }

    .apply-video {
      position: absolute; inset: 0;
      width: 100%; height: 100%;
      object-fit: cover;
      opacity: 0.35;
    }

    .apply-visual::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(
        160deg,
        rgba(10,10,10,0.55) 0%,
        rgba(10,10,10,0.2) 40%,
        rgba(10,10,10,0.75) 100%
      );
    }

    .visual-nav {
      position: absolute;
      top: 0; left: 0; right: 0;
      z-index: 10;
      padding: 28px 40px;
    }

    .visual-logo {
      font-family: 'DM Sans', sans-serif;
      font-size: 0.7rem;
      font-weight: 800;
      letter-spacing: 0.22em;
      text-transform: uppercase;
      color: var(--offwhite);
      text-decoration: none;
      opacity: 0.9;
      transition: opacity var(--trans);
    }
    .visual-logo:hover { opacity: 1; }

    .visual-content {
      position: absolute;
      inset: 0;
      z-index: 10;
      display: flex;
      flex-direction: column;
      justify-content: flex-end;
      padding: 40px;
      padding-bottom: 52px;
    }

    .eyebrow {
      display: inline-block;
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 14px;
    }

    .visual-title {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2.2rem, 3.5vw, 3.2rem);
      font-weight: 400;
      line-height: 1.15;
      color: #fff;
      margin-bottom: 18px;
      letter-spacing: -0.01em;
    }

    .visual-title span {
      font-style: italic;
      color: var(--warm);
    }

    .visual-copy {
      font-size: 0.85rem;
      color: rgba(247,245,242,0.7);
      line-height: 1.75;
      max-width: 380px;
      margin-bottom: 24px;
    }

    .visual-tags {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      margin-bottom: 28px;
    }

    .visual-tags span {
      font-size: 0.65rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      border: 1px solid rgba(196,168,130,0.4);
      color: var(--warm);
      padding: 5px 12px;
      border-radius: 20px;
    }

    .info-card {
      background: rgba(10,10,10,0.55);
      border: 1px solid rgba(255,255,255,0.08);
      border-left: 2px solid var(--accent);
      border-radius: var(--radius);
      padding: 16px 20px;
      margin-bottom: 12px;
      backdrop-filter: blur(6px);
    }

    .info-card h4 {
      font-size: 0.65rem;
      font-weight: 700;
      letter-spacing: 0.16em;
      text-transform: uppercase;
      color: var(--accent);
      margin-bottom: 8px;
    }

    .info-card p {
      font-size: 0.78rem;
      color: rgba(247,245,242,0.62);
      line-height: 1.7;
    }

    .visual-steps {
      display: flex;
      gap: 10px;
      margin-top: 20px;
    }

    .visual-step {
      width: 28px; height: 28px;
      border-radius: 50%;
      border: 1px solid rgba(196,168,130,0.35);
      display: flex; align-items: center; justify-content: center;
    }

    .visual-step span {
      font-size: 0.7rem;
      font-weight: 700;
      color: var(--warm);
    }

    /* ── RIGHT PANEL ── */
    .apply-content {
      background: var(--offwhite);
      overflow-y: auto;
    }

    .form-shell {
      max-width: 640px;
      margin: 0 auto;
      padding: 52px 48px 80px;
    }

    .top-link {
      margin-bottom: 36px;
    }

    .top-link a {
      font-size: 0.72rem;
      font-weight: 600;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--muted);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color var(--trans);
    }
    .top-link a::before { content: '←'; font-size: 0.9em; }
    .top-link a:hover { color: var(--black); }

    .form-header {
      margin-bottom: 36px;
    }

    .form-header .eyebrow {
      color: var(--muted);
      font-size: 0.6rem;
      letter-spacing: 0.18em;
    }

    .form-header h1 {
      font-family: 'Cormorant Garamond', serif;
      font-size: clamp(2.4rem, 4vw, 3.4rem);
      font-weight: 400;
      line-height: 1.1;
      letter-spacing: -0.02em;
      color: var(--black);
      margin: 10px 0 14px;
    }

    .form-header p {
      font-size: 0.85rem;
      color: var(--muted);
      line-height: 1.75;
      max-width: 480px;
    }

    /* ── PROGRESS ── */
    .progress-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 0;
      margin-bottom: 32px;
      border: 1px solid var(--sand);
      border-radius: 8px;
      overflow: hidden;
    }

    .progress-item {
      padding: 14px 10px;
      text-align: center;
      border-right: 1px solid var(--sand);
      transition: background var(--trans);
    }
    .progress-item:last-child { border-right: none; }

    .progress-item span {
      display: block;
      width: 24px; height: 24px;
      border-radius: 50%;
      background: var(--sand);
      color: var(--muted);
      font-size: 0.7rem;
      font-weight: 700;
      line-height: 24px;
      margin: 0 auto 6px;
    }

    .progress-item p {
      font-size: 0.65rem;
      font-weight: 600;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--muted);
    }

    .progress-item.active {
      background: var(--black);
    }
    .progress-item.active span {
      background: var(--accent);
      color: #fff;
    }
    .progress-item.active p { color: var(--offwhite); }

    /* ── NOTICE ── */
    .notice {
      background: #fff;
      border: 1px solid var(--sand);
      border-left: 3px solid var(--accent);
      border-radius: var(--radius);
      padding: 14px 18px;
      font-size: 0.8rem;
      color: var(--muted);
      line-height: 1.65;
      margin-bottom: 28px;
    }
    .notice strong {
      color: var(--black);
      font-weight: 600;
    }

    /* ── ERROR BOX ── */
    .error-box {
      background: #fff5f5;
      border: 1px solid #f5c6c6;
      border-left: 3px solid var(--error);
      border-radius: var(--radius);
      padding: 16px 20px;
      font-size: 0.82rem;
      color: var(--error);
      margin-bottom: 24px;
    }
    .error-box strong { display: block; margin-bottom: 8px; font-size: 0.78rem; letter-spacing: 0.05em; }
    .error-box ul { padding-left: 18px; }
    .error-box li { margin-bottom: 4px; }

    /* ── MINI GALLERY ── */
    .mini-gallery {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 10px;
      margin-bottom: 32px;
    }

    .mini-card {
      border-radius: 6px;
      overflow: hidden;
      border: 1px solid var(--sand);
      background: #fff;
    }

    .mini-card img {
      width: 100%;
      aspect-ratio: 3/4;
      object-fit: cover;
      display: block;
      transition: transform 0.4s ease;
    }
    .mini-card:hover img { transform: scale(1.04); }

    .mini-card p {
      font-size: 0.65rem;
      font-weight: 600;
      letter-spacing: 0.08em;
      text-transform: uppercase;
      color: var(--muted);
      text-align: center;
      padding: 10px 8px;
    }

    /* ── FORM ── */
    .form-card {
      background: #fff;
      border: 1px solid var(--sand);
      border-radius: 10px;
      padding: 36px;
    }

    .apply-form { display: flex; flex-direction: column; gap: 20px; }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 16px;
    }

    .form-group { display: flex; flex-direction: column; gap: 6px; }
    .form-group.full { grid-column: 1 / -1; }

    .form-group label {
      font-size: 0.7rem;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--black);
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      font-family: 'DM Sans', sans-serif;
      font-size: 0.88rem;
      color: var(--black);
      background: var(--offwhite);
      border: 1px solid var(--sand);
      border-radius: var(--radius);
      padding: 11px 14px;
      transition: border-color var(--trans), background var(--trans), box-shadow var(--trans);
      outline: none;
      width: 100%;
      appearance: none;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
      border-color: var(--accent);
      background: #fff;
      box-shadow: 0 0 0 3px rgba(184,147,90,0.1);
    }

    .form-group input::placeholder,
    .form-group textarea::placeholder {
      color: #bbb;
    }

    .form-group select {
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%238a7f74' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 14px center;
      padding-right: 36px;
      cursor: pointer;
    }

    .form-group textarea {
      resize: vertical;
      min-height: 100px;
      line-height: 1.6;
    }

    /* ── CHECKBOXES ── */
    .check-group { display: flex; flex-direction: column; gap: 12px; }

    .check-item {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      cursor: pointer;
    }

    .check-item input[type="checkbox"] {
      appearance: none;
      width: 18px; height: 18px;
      min-width: 18px;
      border: 1.5px solid var(--sand);
      border-radius: 3px;
      background: var(--offwhite);
      cursor: pointer;
      margin-top: 1px;
      transition: background var(--trans), border-color var(--trans);
      position: relative;
    }

    .check-item input[type="checkbox"]:checked {
      background: var(--accent);
      border-color: var(--accent);
    }

    .check-item input[type="checkbox"]:checked::after {
      content: '';
      position: absolute;
      top: 2px; left: 5px;
      width: 5px; height: 9px;
      border: 2px solid #fff;
      border-top: none; border-left: none;
      transform: rotate(45deg);
    }

    .check-item span {
      font-size: 0.8rem;
      color: var(--muted);
      line-height: 1.65;
    }

    /* ── SUBMIT ── */
    .form-submit {
      width: 100%;
      padding: 15px 24px;
      background: var(--black);
      color: var(--offwhite);
      font-family: 'DM Sans', sans-serif;
      font-size: 0.72rem;
      font-weight: 700;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      border: 2px solid var(--black);
      border-radius: var(--radius);
      cursor: pointer;
      transition: background var(--trans), color var(--trans);
      margin-top: 6px;
    }

    .form-submit:hover {
      background: transparent;
      color: var(--black);
    }

    .form-note {
      text-align: center;
      font-size: 0.75rem;
      color: var(--muted);
      line-height: 1.6;
    }

    /* ── DIVIDER BETWEEN SECTIONS ── */
    .section-divider {
      height: 1px;
      background: var(--sand);
      margin: 4px 0;
    }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
      .apply-page {
        grid-template-columns: 1fr;
      }

      .apply-visual {
        position: relative;
        height: auto;
        min-height: 440px;
      }

      .visual-content {
        padding: 28px 24px 36px;
        justify-content: flex-end;
      }

      .info-card { display: none; }

      .visual-steps { display: none; }

      .apply-content { overflow-y: unset; }

      .form-shell {
        padding: 36px 20px 60px;
      }
    }

    @media (max-width: 600px) {
      .form-row {
        grid-template-columns: 1fr;
      }

      .progress-grid {
        grid-template-columns: repeat(4, 1fr);
      }

      .progress-item p { display: none; }

      .mini-gallery {
        grid-template-columns: repeat(3, 1fr);
        gap: 6px;
      }

      .form-card { padding: 24px 16px; }

      .visual-title { font-size: 2rem; }
    }
  </style>
</head>

<body>

<!-- ════════════ LOADING STATE ════════════ -->
<?php if ($showLoading): ?>
<meta http-equiv="refresh" content="3;url=<?php echo htmlspecialchars($redirectUrl); ?>">

<div class="loading">
  <div class="loading-card">
    <div class="spinner"></div>

    <h2>Finalizing Your Application...</h2>

    <p class="loading-text">
      Please wait while we prepare your verification details.<br><br>
      You will be redirected shortly to continue the verification process.
    </p>

    <div class="loading-box-info">
      <p>
        Please continue to the verification page.<br><br>
        Your reference number will be required at the final step of the verification process.
      </p>

      <div class="ref-loading">
        <?php echo htmlspecialchars($referenceNumber); ?>
      </div>

      <p class="highlight">
        This reference number is required to verify your application and reserve your slot.
      </p>
    </div>
  </div>
</div>

<script>
setTimeout(function () {
  window.location.href = "<?php echo htmlspecialchars($redirectUrl); ?>";
}, 3000);
</script>

<?php else: ?>
<!-- ════════════ MAIN PAGE ════════════ -->

<main class="apply-page">

  <!-- LEFT VIDEO BACKGROUND -->
  <aside class="apply-visual">
    <video autoplay muted loop playsinline class="apply-video">
      <source src="files/videos/highlights.mp4" type="video/mp4">
      Your browser does not support the video tag.
    </video>

    <div class="visual-nav">
      <a href="index.php" class="visual-logo">SHOP AT MERA</a>
    </div>

    <div class="visual-content">
      <span class="eyebrow">Official Creator Application</span>

      <h1 class="visual-title">
        Join the <span>SHOP AT MERA</span><br>
        creator circle.
      </h1>

      <p class="visual-copy">
        Apply for creator collaborations, product styling campaigns, model features,
        and beauty-fashion content opportunities.
      </p>

      <div class="visual-tags">
        <span>Official Campaign</span>
        <span>Creator Review</span>
        <span>Limited Slots</span>
      </div>

      <div class="info-card">
        <h4>Campaign Details</h4>
        <p>
          Selected creators may receive SHOP AT MERA pieces for styling and promotional content.
          Content may include TikTok videos, GRWM clips, try-on hauls, outfit posts,
          styling reels, and product showcase videos.
        </p>
      </div>

      <div class="info-card">
        <h4>What We Look For</h4>
        <p>
          We review applications based on content quality, fashion style, audience engagement,
          location, and campaign availability. You do not need a huge following, but your
          content should be clear, creative, and aligned with our brand style.
        </p>
      </div>

      <div class="visual-steps">
        <div class="visual-step"><span>1</span></div>
        <div class="visual-step"><span>2</span></div>
        <div class="visual-step"><span>3</span></div>
      </div>
    </div>
  </aside>

  <!-- RIGHT APPLICATION FORM -->
  <section class="apply-content">
    <div class="form-shell">

      <div class="top-link">
        <a href="index.php">Back to Site</a>
      </div>

      <div class="form-header">
        <span class="eyebrow">Creator Collaboration Application</span>

        <h1>Apply</h1>

        <p>
          Fill out the form below to submit your application. Please provide active and correct
          social media links so our team can properly review your profile.
        </p>
      </div>

      <div class="progress-grid">
        <div class="progress-item active">
          <span>1</span>
          <p>Application</p>
        </div>
        <div class="progress-item">
          <span>2</span>
          <p>Review</p>
        </div>
        <div class="progress-item">
          <span>3</span>
          <p>Verification</p>
        </div>
        <div class="progress-item">
          <span>4</span>
          <p>Campaign Brief</p>
        </div>
      </div>

      <div class="notice">
        <strong>Application Review:</strong> If selected, our team will contact you through the details you provided.
        Slots may depend on campaign needs, product availability, and brand fit.
      </div>

      <?php if (!empty($errors)): ?>
      <div class="error-box">
        <strong>Please fix the following:</strong>
        <ul>
          <?php foreach ($errors as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endif; ?>

      <div class="mini-gallery">
        <div class="mini-card">
          <img src="files/images/products/3.webp" alt="Featured product styling">
          <p>Featured Product Styling</p>
        </div>
        <div class="mini-card">
          <img src="files/images/products/1.webp" alt="Content-ready fashion">
          <p>Content-Ready Fashion</p>
        </div>
        <div class="mini-card">
          <img src="files/images/products/9.webp" alt="Creator campaign pieces">
          <p>Creator Campaign Pieces</p>
        </div>
      </div>

      <div class="form-card">
        <form method="POST" class="apply-form" id="applyForm" autocomplete="off">

          <!-- Personal Info -->
          <div class="form-row">
            <div class="form-group">
              <label>Full Name *</label>
              <input type="text" name="full_name" placeholder="Enter full name" autocomplete="off" required id="full_name">
            </div>
            <div class="form-group">
              <label>Email Address *</label>
              <input type="email" name="email" placeholder="Enter email address" autocomplete="off" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Phone Number *</label>
              <input
                type="text"
                name="phone"
                id="phoneInput"
                value="639"
                placeholder="639XXXXXXXXX"
                inputmode="numeric"
                maxlength="12"
                minlength="12"
                pattern="^639[0-9]{9}$"
                autocomplete="off"
                required
              >
            </div>
            <div class="form-group">
              <label>Main Platform *</label>
              <select name="platform" autocomplete="off" required>
                <option value="" disabled selected>Select platform</option>
                <option>TikTok</option>
                <option>Instagram</option>
                <option>Facebook</option>
                <option>YouTube</option>
                <option>Multiple Platforms</option>
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Number of Followers *</label>
              <input
                type="text"
                name="followers"
                id="followersInput"
                placeholder="Enter follower count"
                inputmode="numeric"
                maxlength="6"
                pattern="^[0-9]{1,9}$"
                autocomplete="off"
                required
              >
            </div>
            <div class="form-group">
              <label>Location *</label>
              <input type="text" name="location" placeholder="City / Province" autocomplete="off" required>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group full">
              <label>Social Media Links *</label>
              <textarea name="links" placeholder="Paste your TikTok, Instagram, or other profile links" autocomplete="off" required></textarea>
            </div>
          </div>

          <div class="section-divider"></div>

          <!-- Preferences -->
          <div class="form-row">
            <div class="form-group">
              <label>How did you hear about us? *</label>
              <select name="source" autocomplete="off" required>
                <option value="" disabled selected>Select an option</option>
                <option>TikTok</option>
                <option>Instagram</option>
                <option>Facebook</option>
                <option>Friend / Referral</option>
                <option>Email</option>
                <option>Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>Collaboration Preference *</label>
              <select name="preference" autocomplete="off" required>
                <option value="" disabled selected>Select preference</option>
                <option>Product exchange</option>
                <option>Fixed rate</option>
                <option>Open to discussion</option>
                <option>Long-term collaboration</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label>Additional Message</label>
            <textarea name="message" placeholder="Optional: Tell us about your content style, audience, or why you want to work with SHOP AT MERA" autocomplete="off"></textarea>
          </div>

          <div class="section-divider"></div>

          <!-- Checkboxes -->
          <div class="check-group">
            <label class="check-item">
              <input type="checkbox" name="chk1" required>
              <span>I confirm that my social media links are correct and active.</span>
            </label>
            <label class="check-item">
              <input type="checkbox" name="chk2" required>
              <span>I understand that applications are subject to review and campaign availability.</span>
            </label>
            <label class="check-item">
              <input type="checkbox" name="chk3" required>
              <span>I agree to be contacted regarding creator campaign updates.</span>
            </label>
            <label class="check-item">
              <input type="checkbox" name="chk4" required>
              <span>I understand that I must continue to verification and send my reference number with my best photo or portfolio.</span>
            </label>
          </div>

          <button type="submit" class="form-submit">Submit Application</button>

          <p class="form-note">
            Only selected applicants will proceed to the next stage of review and verification.
          </p>

        </form>
      </div>

    </div>
  </section>

</main>

<script>
document.getElementById("full_name").addEventListener("input", function () {
  this.value = this.value.replace(/[^A-Za-z\s]/g, '');
});

const phoneInput = document.getElementById('phoneInput');
const followersInput = document.getElementById('followersInput');

phoneInput.addEventListener('input', function () {
  let value = phoneInput.value.replace(/\D/g, '');
  if (!value.startsWith('639')) {
    value = '639' + value.replace(/^639/, '').replace(/^0+/, '');
  }
  phoneInput.value = value.slice(0, 12);
});

phoneInput.addEventListener('keydown', function (e) {
  const cursorPosition = phoneInput.selectionStart;
  if ((e.key === 'Backspace' || e.key === 'Delete') && cursorPosition <= 3) {
    e.preventDefault();
  }
});

phoneInput.addEventListener('paste', function (e) {
  e.preventDefault();
  let pasted = (e.clipboardData || window.clipboardData).getData('text');
  pasted = pasted.replace(/\D/g, '');
  if (pasted.startsWith('09')) {
    pasted = '639' + pasted.slice(2);
  } else if (pasted.startsWith('9')) {
    pasted = '63' + pasted;
  } else if (!pasted.startsWith('639')) {
    pasted = '639';
  }
  phoneInput.value = pasted.slice(0, 12);
});

followersInput.addEventListener('input', function () {
  followersInput.value = followersInput.value.replace(/\D/g, '').slice(0, 9);
});
</script>

<?php endif; ?>

</body>
</html>