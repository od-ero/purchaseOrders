<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class WhatsAppService
{
    protected $client;
    protected $apiUrl;
    protected $token;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('WHATSAPP_API_URL');
        $this->token = env('WHATSAPP_API_TOKEN');
    }
    public function sendTextMessage($to, $message)
{
    $headers = [
        'Authorization' => 'Bearer ' . $this->token,
        'Content-Type' => 'application/json',
    ];

    $data = [
        'messaging_product' => 'whatsapp',
        'to' => $to,
        'type' => 'text',
        'text' => [
            'body' => $message,
        ],
    ];

    try {
        $response = $this->client->post($this->apiUrl, [
            'headers' => $headers,
            'json' => $data,
        ]);

        return json_decode($response->getBody(), true);
    } catch (RequestException $e) {
        return [
            'error' => true,
            'message' => $e->getMessage(),
        ];
    }
}

    public function sendMessage($to, $message, $mediaUrl, $mediaType = 'image')
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ];
    
        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => $mediaType,
            $mediaType => [
                'link' => $mediaUrl,
                'caption' => $message,  // Adding a caption
            ],
        ];
    
        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => $headers,
                'json' => $data,
            ]);
    
            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    public function sendTemplateMessage($to, $templateName, $languageCode = 'en_US')
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ];

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $to,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $languageCode,
                ],
            ],
        ];

        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => $headers,
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
    
    public function sendTemplateMessageWithAttachment($recipients, $templateName, $languageCode = 'en_US', $pdfUrl, $caption, $header)
    {
        $headers = [
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json',
        ];

        $messages = [];

        foreach ($recipients as $recipient) {
            $messages[] = [
                'to' => $recipient,
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => [
                        'code' => $languageCode,
                    ],
                    'components' => [
                        [
                            'type' => 'header',
                            'parameters' => [
                                [
                                    'type' => 'text',
                                    'text' => $header,
                                ],
                            ],
                        ],
                        [
                            'type' => 'body',
                            'parameters' => [
                                [
                                    'type' => 'document',
                                    'document' => [
                                        'link' => $pdfUrl,
                                        'filename' => 'Receipt.pdf', // Change to the appropriate filename
                                    ],
                                ],
                                [
                                    'type' => 'text',
                                    'text' => $caption,
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }

        $data = [
            'messaging_product' => 'whatsapp',
            'to' => $recipients,
            'type' => 'template',
            'template' => [
                'name' => $templateName,
                'language' => [
                    'code' => $languageCode,
                ],
                'components' => [
                    [
                        'type' => 'header',
                        'parameters' => [
                            [
                                'type' => 'text',
                                'text' => $header,
                            ],
                        ],
                    ],
                    [
                        'type' => 'body',
                        'parameters' => [
                            [
                                'type' => 'document',
                                'document' => [
                                    'link' => $pdfUrl,
                                    'filename' => 'Receipt.pdf', // Change to the appropriate filename
                                ],
                            ],
                            [
                                'type' => 'text',
                                'text' => $caption,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $this->client->post($this->apiUrl, [
                'headers' => $headers,
                'json' => $data,
            ]);

            return json_decode($response->getBody(), true);
        } catch (RequestException $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }
}
