<?php namespace Tjphippen\Docusign;

use Firebase\JWT\JWT;
use GuzzleHttp\Client;

class JwtAuth
{
    private string $clientId;
    private string $userId;
    private string $privateKey;
    private string $authServer;
    private array $scopes;
    private ?string $accessToken = null;
    private ?int $expiresAt = null;

    public function __construct(array $config)
    {
        $this->clientId = $config['client_id'];
        $this->userId = $config['user_id'];
        $this->privateKey = $config['private_key'];
        $this->authServer = $config['auth_server'] ?? 'account-d.docusign.com';
        $this->scopes = $config['jwt_scopes'] ?? ['signature', 'impersonation'];
    }

    public function getAccessToken(): string
    {
        if ($this->accessToken && $this->expiresAt && time() < $this->expiresAt - 60) {
            return $this->accessToken;
        }

        return $this->requestAccessToken();
    }

    private function requestAccessToken(): string
    {
        $now = time();
        $payload = [
            'iss' => $this->clientId,
            'sub' => $this->userId,
            'aud' => $this->authServer,
            'iat' => $now,
            'exp' => $now + 3600,
            'scope' => implode(' ', $this->scopes),
        ];

        $assertion = JWT::encode($payload, $this->privateKey, 'RS256');

        $client = new Client();
        $response = $client->post('https://' . $this->authServer . '/oauth/token', [
            'form_params' => [
                'grant_type' => 'urn:ietf:params:oauth:grant-type:jwt-bearer',
                'assertion' => $assertion,
            ],
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        $this->accessToken = $data['access_token'];
        $this->expiresAt = $now + ($data['expires_in'] ?? 3600);

        return $this->accessToken;
    }

    /**
     * Get the consent URL that the user must visit to grant consent for the app.
     */
    public function getConsentUrl(string $redirectUri = 'https://www.docusign.com'): string
    {
        $scopes = implode('+', $this->scopes);
        return 'https://' . $this->authServer . '/oauth/auth?response_type=code'
            . '&scope=' . $scopes
            . '&client_id=' . $this->clientId
            . '&redirect_uri=' . urlencode($redirectUri);
    }
}
