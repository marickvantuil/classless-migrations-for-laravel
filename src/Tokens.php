<?php

declare(strict_types=1);

namespace Marick\LaravelClasslessMigrations;

class Tokens
{
    private function __construct(private readonly string $tokenString)
    {
        //
    }

    public static function from(string $code): Tokens
    {
        $tokens = token_get_all($code);

        $tokenString = '';

        foreach ($tokens as $token) {
            if (is_string($token)) {
                $tokenString .= $token;
            }

            if (is_array($token)) {
                if (token_name($token[0]) === 'T_WHITESPACE') {
                    continue;
                }

                $tokenString .= $token[0];
            }
        }

        return new Tokens($tokenString);
    }

    public function contains(string $find): bool
    {
        return str_contains($this->tokenString, $find);
    }
}
