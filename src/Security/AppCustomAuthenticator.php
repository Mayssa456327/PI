<?php
// src/Security/AppCustomAuthenticator.php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class AppCustomAuthenticator extends AbstractLoginFormAuthenticator
{
use TargetPathTrait;

public const LOGIN_ROUTE = 'app_login';

public function __construct(private UrlGeneratorInterface $urlGenerator)
{
}

public function authenticate(Request $request): Passport
{
$email = $request->request->get('email', '');

$request->getSession()->set(Security::LAST_USERNAME, $email);

return new Passport(
new UserBadge($email),
new PasswordCredentials($request->request->get('password', '')),
[
new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
new RememberMeBadge(),
]
);
}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // Récupérer l'utilisateur
        $user = $token->getUser();

        // Récupérer les rôles de l'utilisateur
        $roles = $user->getRoles();

        // Parcourir les rôles de l'utilisateur
        foreach ($roles as $role) {
            // Si l'utilisateur est un ADMIN, le rediriger vers la page d'administration
            if ($role === 'ADMIN') {
                return new RedirectResponse($this->urlGenerator->generate('app_admin1_index'));
            }
            // Si l'utilisateur est un MEDECIN, le rediriger vers le tableau de bord des médecins
            elseif ($role === 'MEDECIN') {
                return new RedirectResponse($this->urlGenerator->generate('medecin_dashboard'));
            }
            // Si l'utilisateur est un PATIENT, le rediriger vers le tableau de bord des patients
            elseif ($role === 'PATIENT') {
                return new RedirectResponse($this->urlGenerator->generate('patient_dashboard'));
            }
        }

        // Par défaut, si aucun rôle spécifique n'est trouvé, rediriger vers une page par défaut
        return new RedirectResponse($this->urlGenerator->generate('default_route'));
    }


    protected function getLoginUrl(Request $request): string
{
return $this->urlGenerator->generate(self::LOGIN_ROUTE);
}
}
