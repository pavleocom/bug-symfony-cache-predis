<?php

namespace App\Controller;

use Psr\Cache\CacheItemInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Cache\CacheInterface;

class TestCache extends AbstractController
{
    public function __construct(
        private CacheInterface $cache,
    )
    {
    }

    #[Route(path: '/test-cache', methods: ['GET'])]
    public function testCache(): Response
    {
        $cachedValue = $this->cache->get('test', function (CacheItemInterface $item) {
            $item->expiresAfter(20); // seconds
            $randomInt = random_int(0, 100);
            return (string) $randomInt;
        });

        return new Response($cachedValue, 200);
    }

}