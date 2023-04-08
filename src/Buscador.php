<?php

namespace Alura\BuscadorDeCursos;

use GuzzleHttp\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{
    private readonly ClientInterface $httpClient;
    private readonly Crawler $crawler;

    public function __construct(ClientInterface $httpClient, Crawler $crawler)
    {
        $this->crawler = $crawler;
        $this->httpClient = $httpClient;
    }

    public function buscar(string $url): array
    {

        $response = $this->httpClient->request(
            'GET',
            $url
        );

        $html = $response->getBody();


        $this->crawler->addHtmlContent("$html");

        $elementosCurso = $this->crawler->filter('span.card-curso__nome');

        $cursos = [];

        foreach ($elementosCurso as $elemento) {
            $cursos[] = $elemento->textContent;
        }

        return $cursos;
    }
}
