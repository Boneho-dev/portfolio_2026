<?php
/**
 * AGRE AGENCY — Endpoint de contact (AJAX / JSON)
 * Reçoit un POST multipart, envoie via PHPMailer, répond en JSON.
 * Appelé exclusivement par fetch() depuis main.js.
 */

declare(strict_types=1);

/* ── Forcer la réponse en JSON dès le départ ─────────────────────── */
header('Content-Type: application/json; charset=UTF-8');

/* ── Rejeter toute méthode autre que POST ────────────────────────── */
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
$hp      = $_POST['hp_field'] ?? ''; /* Honeypot — bot piège */

/* ── Piège anti-spam : honeypot rempli → rejet silencieux ────────── */
if (!empty($hp)) {
    echo json_encode(['status' => 'success']); /* on ne signale pas le rejet */
    exit;
}

/* ── Validation des champs obligatoires ──────────────────────────── */
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
    $mail = new PHPMailer(true); /* true = exceptions activées */

    /* Serveur SMTP */
    $mail->isSMTP();
    $mail->Host       = MAILER_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = MAILER_USERNAME;
    $mail->Password   = MAILER_PASSWORD;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = MAILER_PORT;
    $mail->CharSet    = MAILER_CHARSET;

    /* Expéditeur & destinataire */
    $mail->setFrom(MAILER_FROM_EMAIL, MAILER_FROM_NAME);
    $mail->addAddress(MAIL_TO, MAIL_NAME);
    $mail->addReplyTo($email, $name); /* répondre directement au visiteur */

    /* Corps HTML + texte brut */
    $mail->isHTML(true);
    $mail->Subject = "[Agre Agency] {$subject}";
    $mail->Body    = "
        <div style='font-family:Inter,sans-serif;max-width:600px;margin:0 auto;'>
          <div style='background:#134B5F;padding:24px 32px;border-radius:12px 12px 0 0;'>
            <h2 style='color:#2AC1C4;margin:0;font-size:18px;letter-spacing:.02em;'>
              Nouveau message — Portfolio
            </h2>
          </div>
          <div style='background:#071e2b;padding:32px;border-radius:0 0 12px 12px;
                      border:1px solid rgba(42,193,196,0.15);border-top:none;'>
            <p style='color:#94a3b8;font-size:13px;margin:0 0 24px;'>
              Reçu via le formulaire de contact d'Agre Agency.
            </p>
            <table style='width:100%;border-collapse:collapse;font-size:14px;'>
              <tr>
                <td style='color:#5BC0DE;padding:8px 0;font-weight:600;width:90px;vertical-align:top;'>Nom</td>
                <td style='color:#e2e8f0;padding:8px 0;'>{$name}</td>
              </tr>
              <tr>
                <td style='color:#5BC0DE;padding:8px 0;font-weight:600;vertical-align:top;'>Email</td>
                <td style='color:#e2e8f0;padding:8px 0;'>
                  <a href='mailto:{$email}' style='color:#2AC1C4;text-decoration:none;'>{$email}</a>
                </td>
              </tr>
              <tr>
                <td style='color:#5BC0DE;padding:8px 0;font-weight:600;vertical-align:top;'>Sujet</td>
                <td style='color:#e2e8f0;padding:8px 0;'>{$subject}</td>
              </tr>
            </table>
            <hr style='border:none;border-top:1px solid rgba(255,255,255,0.06);margin:20px 0;'>
            <p style='color:#5BC0DE;font-weight:600;font-size:13px;margin:0 0 10px;'>Message</p>
            <p style='color:#e2e8f0;font-size:14px;line-height:1.8;
                      white-space:pre-wrap;margin:0;'>{$message}</p>
          </div>
        </div>";

    $mail->AltBody = "Nouveau message depuis le portfolio\n\n"
                   . "Nom    : {$name}\n"
                   . "Email  : {$email}\n"
                   . "Sujet  : {$subject}\n\n"
                   . "Message :\n{$message}";

    $mail->send();

    echo json_encode([
        'status'  => 'success',
        'message' => 'Votre message a bien été envoyé ! Je vous répondrai dans les 24h.',
    ]);

} catch (MailerException $e) {
    /* On logue l'erreur technique côté serveur, on n'expose rien au client */
    error_log('[Agre Agency mailer] ' . $e->getMessage());

    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => "Une erreur est survenue lors de l'envoi. Contactez-moi directement : agrekevin09@gmail.com",
    ]);
}
