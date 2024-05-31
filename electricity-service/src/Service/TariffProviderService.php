<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\TariffProviderException;
use Symfony\Component\DependencyInjection\Exception\ParameterNotFoundException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class TariffProviderService
{
    public function __construct(
        private HttpClientInterface $client,
        private ParameterBagInterface $parameter,
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     *
     * @throws ParameterNotFoundException
     * @throws TransportExceptionInterface
     * @throws TariffProviderException
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws ServerExceptionInterface
     */
    public function all(): array
    {
        $response = $this->client->request(
            'GET',
            $this->parameter->get('tariff.provider.url').'/api/products',
        );

        if (Response::HTTP_OK !== $response->getStatusCode()) {
            throw new TariffProviderException('Unable to fetch tariff provider data');
        }

        return $response->toArray();
    }
}
