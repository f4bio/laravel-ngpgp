<?php

namespace F4bio\LaravelNgpgp;

use Exception;
use OpenPGP;
use OpenPGP_Crypt_RSA;
use OpenPGP_Crypt_Symmetric;
use OpenPGP_LiteralDataPacket;
use OpenPGP_Message;
use OpenPGP_SecretKeyPacket;
use OpenPGP_UserIDPacket;
use phpseclib\Crypt\RSA;

class LaravelNgpgp implements LaravelNgpgpInterface
{
    private array $config;

    /**
     * Create a new class instance.
     *
     * @return void
     */
    public function __construct($config)
    {
        $this->config = $config;
        echo implode($this->config);
    }

    /**
     * @return string private key
     */
    public function keygen(string $userId): string
    {
        $rsa = new RSA();
        $k = $rsa->createKey(512);
        $loaded = $rsa->loadKey($k['privatekey']);

        if ($loaded) {
            $nKey = new OpenPGP_SecretKeyPacket([
                'n' => $rsa->modulus->toBytes(),
                'e' => $rsa->publicExponent->toBytes(),
                'd' => $rsa->exponent->toBytes(),
                'p' => $rsa->primes[2]->toBytes(),
                'q' => $rsa->primes[1]->toBytes(),
                'u' => $rsa->coefficients[2]->toBytes(),
            ]);
            $uid = new OpenPGP_UserIDPacket($userId);
            $wKey = new OpenPGP_Crypt_RSA($nKey);

            $m = $wKey->sign_key_userid([$nKey, $uid]);
            // Serialize private key
            return $m->to_bytes();
        }

        return '';
    }

    /**
     * en-armored encryption
     *
     * @return string On success, this function returns the encrypted text.
     *                        On failure, this function returns false.
     *
     * @throws Exception
     */
    public function encrypt(string $publicKey, string $text): string
    {
        $key = OpenPGP_Message::parse($publicKey);
        $data = new OpenPGP_LiteralDataPacket($text);
        $encrypted = OpenPGP_Crypt_Symmetric::encrypt($key, new OpenPGP_Message([$data]));

        return OpenPGP::enarmor($encrypted->to_bytes(), 'PGP MESSAGE');
    }
}
