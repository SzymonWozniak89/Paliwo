<?php
namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class EmailService{
    public function __construct(
        public readonly Security $security,
        public readonly UserRepository $userRepository,
        public readonly MailerInterface $mailer
        ){

    }

    public function registrationConfirmation(string $userEmail)
    {
        $email = (new TemplatedEmail())
            ->from('hello@example.com')
            ->to($userEmail)
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject('Registration confirm')
            ->htmlTemplate('user/email.html.twig');
            //->text('TEST');
            // ->context([
            //     'logged' => $logged, 
            // ]);
        try{
            $this->mailer->send($email);
        } catch(TransportExceptionInterface $e) {
            dd($e->getMessage());
        }
    }
}