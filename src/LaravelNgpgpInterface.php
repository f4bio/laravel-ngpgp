<?php

namespace F4bio\LaravelNgpgp;

interface LaravelNgpgpInterface
{
    public function keygen(string $userId): string;
    public function encrypt(string $publicKey, string $text): string;
}
