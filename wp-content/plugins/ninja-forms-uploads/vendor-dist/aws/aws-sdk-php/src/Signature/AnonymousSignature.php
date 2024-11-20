<?php

namespace NF_FU_VENDOR\Aws\Signature;

use NF_FU_VENDOR\Aws\Credentials\CredentialsInterface;
use NF_FU_VENDOR\Psr\Http\Message\RequestInterface;
/**
 * Provides anonymous client access (does not sign requests).
 */
class AnonymousSignature implements SignatureInterface
{
    public function signRequest(RequestInterface $request, CredentialsInterface $credentials)
    {
        return $request;
    }
    public function presign(RequestInterface $request, CredentialsInterface $credentials, $expires, array $options = [])
    {
        return $request;
    }
}
