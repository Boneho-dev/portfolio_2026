<?php

/**
 * AGRE AGENCY — Endpoint de contact (AJAX / JSON)
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=UTF-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['status' => 'error', 'message' => 'Méthode non autorisée.']);
  exit;
}

/* ── Dépendances ─────────────────────────────────────────────────── */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/mailer.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception as MailerException;

/* ── Lecture et nettoyage des champs ─────────────────────────────── */

$name    = htmlspecialchars(trim((string)($_POST['name']    ?? '')), ENT_QUOTES, 'UTF-8');
$email   = filter_var(trim((string)($_POST['email']  ?? '')), FILTER_SANITIZE_EMAIL);
$subject = htmlspecialchars(trim((string)($_POST['subject'] ?? '')), ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars(trim((string)($_POST['message'] ?? '')), ENT_QUOTES, 'UTF-8');
$hp      = $_POST['hp_field'] ?? '';

if (!empty($hp)) {
  echo json_encode(['status' => 'success']);
  exit;
}

if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$subject || !$message) {
  http_response_code(422);
  echo json_encode([
    'status'  => 'invalid',
    'message' => 'Veuillez remplir tous les champs correctement.',
  ]);
  exit;
}

/* ── Envoi via PHPMailer ──────────────────────────────────────────── */
try {
  $mail = new PHPMailer(true);

  /* Configuration Serveur SMTP (Adaptée pour InfinityFree) */
  $mail->isSMTP();
  /** @var string MAILER_HOST */
  $mail->Host       = MAILER_HOST;
  $mail->SMTPAuth   = true;
  /** @var string MAILER_USER */
  $mail->Username   = MAILER_USER;
  /** @var string MAILER_PASS */
  $mail->Password   = MAILER_PASS;
  $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
  /** @var int MAILER_PORT */
  $mail->Port       = MAILER_PORT;

  $mail->CharSet    = 'UTF-8';

  /* Expéditeur & destinataire */
  /** @var string MAILER_FROM_NAME */
  $mail->setFrom(MAILER_USER, MAILER_FROM_NAME);
  $mail->addAddress('agrekevin09@gmail.com', 'Agre Kevin'); // Votre adresse de réception
  $mail->addReplyTo($email, $name); // Permet de vous répondre directement

  /* Corps HTML */
  $mail->isHTML(true);
  $mail->Subject = "[Agre Agency] {$subject}";
  $mail->Body    = "
        <div style='font-family:sans-serif;max-width:600px;margin:0 auto;background:#f9f9f9;padding:20px;border-radius:10px;'>
            <h2 style='color:#134B5F;'>Nouveau message — Portfolio</h2>
            <p><strong>Nom :</strong> {$name}</p>
            <p><strong>Email :</strong> {$email}</p>
            <p><strong>Sujet :</strong> {$subject}</p>
            <hr>
            <p><strong>Message :</strong></p>
            <p style='white-space:pre-wrap;'>{$message}</p>
        </div>";

  $mail->AltBody = "Message de {$name} ({$email}) : \n\n{$message}";

  $mail->send();

  echo json_encode([
    'status'  => 'success',
    'message' => 'Votre message a bien été envoyé ! Je vous répondrai dans les 24h.',
  ]);
} catch (MailerException $e) {
  error_log('[Agre Agency mailer] ' . $e->getMessage());
  http_response_code(500);
  echo json_encode([
    'status'  => 'error',
    'message' => "Erreur d'envoi. Contactez-moi directement : agrekevin09@gmail.com",
  ]);
}
