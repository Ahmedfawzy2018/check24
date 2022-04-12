<?php declare(strict_types=1);

namespace App\Security\Firewall;

use Symfony\Component\HttpFoundation\Request;

final class Credentials
{
    private string $email;
    private string $password;
    private string $token;

    private function __construct(string $email, string $password, string $token)
    {
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function token(): string
    {
        return $this->token;
    }

    public static function fromRequest(Request $request): Credentials
    {
        return new self(
            email: (string) $request->request->get('email'),
            password: (string) $request->request->get('password'),
            token: (string) $request->request->get('_csrf_token')
        );
    }
}
