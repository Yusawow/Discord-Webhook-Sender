<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Überprüfen, ob die erforderlichen Felder gesetzt sind
    if (!isset($_POST['username']) || !isset($_POST['avatar_url']) || !isset($_POST['content']) || !isset($_POST['webhook_url'])) {
        die('Fehler: Nicht alle erforderlichen Felder wurden gesendet.');
    }
    
    // Die Daten aus dem Formular erhalten
    $username = $_POST['username'];
    $avatar_url = $_POST['avatar_url'];
    $content = $_POST['content'];
    $webhookURL = $_POST['webhook_url'];
    
    // Payload für den Discord-Webhook erstellen
    $payload = json_encode([
        'username' => $username,
        'avatar_url' => $avatar_url,
        'content' => $content
    ]);

    // CURL verwenden, um die Nachricht an den Discord-Webhook zu senden
    $ch = curl_init($webhookURL);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === FALSE) {
        die('Fehler: ' . curl_error($ch));
    }

    curl_close($ch);

    echo 'Nachricht erfolgreich gesendet!';
} else {
    echo 'Ungültige Anforderung.';
}
?>
