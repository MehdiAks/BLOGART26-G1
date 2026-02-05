<?php
// curl function
function curl($url, $type, $data = null, $headers = null){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $type);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    if($data){
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    if($headers){
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $ba_bec_result = curl_exec($ch);
    if(curl_errno($ch)){
        echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    return $ba_bec_result;
}

function isAllowedBbcodeUrl($url) {
    $url = trim((string) $url);
    if ($url === '') {
        return false;
    }

    if (str_starts_with($url, '#') || str_starts_with($url, '/')) {
        return true;
    }

    $parsed = parse_url($url);
    if ($parsed === false || empty($parsed['scheme'])) {
        return false;
    }

    return in_array(strtolower($parsed['scheme']), ['http', 'https'], true);
}

function isValidBbcodeContent($text) {
    if ($text === null || $text === '') {
        return true;
    }

    $allowedTags = ['b', 'i', 'u', 's', 'quote', 'code', 'url', 'emoji'];
    preg_match_all('/\\[(\\/)?([^\\]=\\s]+)(?:=([^\\]]*))?\\]/', $text, $matches, PREG_SET_ORDER);

    foreach ($matches as $match) {
        $isClosing = $match[1] === '/';
        $tag = strtolower($match[2]);
        $param = $match[3] ?? null;

        if (!in_array($tag, $allowedTags, true)) {
            return false;
        }

        if ($tag === 'emoji') {
            if ($isClosing || $param === null || trim($param) === '') {
                return false;
            }
            continue;
        }

        if ($tag === 'url') {
            if ($isClosing && $param !== null && $param !== '') {
                return false;
            }
            if (!$isClosing && $param !== null && trim($param) === '') {
                return false;
            }
            continue;
        }

        if ($param !== null && $param !== '') {
            return false;
        }
    }

    return true;
}

function renderBbcode($text) {
    $safeText = htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');

    $safeText = preg_replace_callback('/\\[url=(.*?)\\](.*?)\\[\\/url\\]/is', function ($matches) {
        $url = trim($matches[1]);
        $label = trim($matches[2]);

        if (!isAllowedBbcodeUrl($url)) {
            return $matches[0];
        }

        $label = $label === '' ? $url : $label;

        return sprintf('<a href="%s" rel="noopener noreferrer" target="_blank">%s</a>', $url, $label);
    }, $safeText);

    $safeText = preg_replace_callback('/\\[url\\](.*?)\\[\\/url\\]/is', function ($matches) {
        $url = trim($matches[1]);

        if (!isAllowedBbcodeUrl($url)) {
            return $matches[0];
        }

        return sprintf('<a href="%s" rel="noopener noreferrer" target="_blank">%s</a>', $url, $url);
    }, $safeText);

    $safeText = preg_replace('/\\[b\\](.*?)\\[\\/b\\]/is', '<strong>$1</strong>', $safeText);
    $safeText = preg_replace('/\\[i\\](.*?)\\[\\/i\\]/is', '<em>$1</em>', $safeText);
    $safeText = preg_replace('/\\[u\\](.*?)\\[\\/u\\]/is', '<span style="text-decoration: underline;">$1</span>', $safeText);
    $safeText = preg_replace('/\\[s\\](.*?)\\[\\/s\\]/is', '<span style="text-decoration: line-through;">$1</span>', $safeText);
    $safeText = preg_replace('/\\[quote\\](.*?)\\[\\/quote\\]/is', '<blockquote>$1</blockquote>', $safeText);
    $safeText = preg_replace('/\\[code\\](.*?)\\[\\/code\\]/is', '<pre><code>$1</code></pre>', $safeText);

    $emojiMap = [
        'smile' => '😊',
        'heart' => '❤️',
        'wink' => '😉',
        'thumbsup' => '👍',
        'clap' => '👏',
        'fire' => '🔥',
    ];

    $safeText = preg_replace_callback('/\\[emoji=(.*?)\\]/i', function ($matches) use ($emojiMap) {
        $key = strtolower(trim($matches[1]));
        return $emojiMap[$key] ?? $matches[0];
    }, $safeText);

    return nl2br($safeText);
}
?>
