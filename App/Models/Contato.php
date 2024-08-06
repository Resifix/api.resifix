<?php

namespace App\Models;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Contato {

  private string $email;
  private string $nome;
  private string $celular;
  private string $mensagem;

  public function create($data) {
    $this->email = $data->email;
    $this->nome = $data->primeiroNome . ' ' . $data->ultimoNome;
    $this->celular = $data->celular;
    $this->mensagem = $data->mensagem;
    
    $this->sendMails();
  }

  private function configMailer(): ?PHPMailer {
    $mail = new PHPMailer(true);
    
    try {
      $mail->isSMTP();
      $mail->SMTPAuth = TRUE;
      $mail->SMTPSecure = 'ssl';
      $mail->Host = 'smtp.hostinger.com';
      $mail->Port = 465;
      $mail->Username = 'contato@resifix.com.br';
      $mail->Password = 'SassAp3002!';
      $mail->CharSet = PHPMailer::CHARSET_UTF8;
      $mail->setLanguage('pt');
      $mail->setFrom('contato@resifix.com.br', 'Contato Resifix');
      return $mail;
    } catch (Exception $e) {
      throw new Exception('Erro ao enviar e-mail: ' . $e->getMessage());
    }
  }

  private function sendMails() {
    $mail = $this->configMailer();

    try {
      $mail->addAddress($this->email, $this->nome);
      $mail->isHTML(true);
      $mail->Subject = 'Obrigado por entrar em Contato com a Resifix';
      $mail->Body = $this->getUserEmailBody();

      $mail->send();

      $mail->clearAddresses();
      $mail->addAddress('contato@resifix.com.br', 'Contato Resifix');
      $mail->Subject = "Formulário de Contato Resifix | $this->nome";
      $mail->Body = $this->getAdminEmailBody();

      $mail->send();
    } catch (Exception $e) {
      throw new Exception('Erro ao enviar e-mail: ' . $e->getMessage());
    }
  }

  private function getUserEmailBody(): string {
    return "Prezado(a) $this->nome,<br><br>
    Agradecemos por entrar em contato com a Resifix. Sua mensagem é muito importante para nós, e queremos garantir que você tenha a melhor experiência possível.<br><br>
    Nossa equipe está pronta para ajudar e responder a qualquer dúvida ou preocupação que você possa ter. Entraremos em contato o mais breve possível para atendê-lo da melhor forma.<br><br>
    Caso precise de assistência imediata, sinta-se à vontade para nos enviar um e-mail ou visitar nosso site em <a href='www.resifix.com.br'>www.resifix.com.br</a>.<br><br>
    Obrigado por escolher a Resifix. Estamos ansiosos para ajudar você!<br><br>
    Atenciosamente,<br><br>
    Equipe Resifix";
  }

  private function getAdminEmailBody(): string {
    return "Formulário de Contato Resifix.<br><br>
    $this->mensagem<br><br>
    $this->nome,<br>$this->celular,<br>$this->email.";
  }

}