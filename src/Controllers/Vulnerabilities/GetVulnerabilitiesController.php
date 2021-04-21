<?php declare(strict_types=1);

namespace Reconmap\Controllers\Vulnerabilities;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Reconmap\Controllers\Controller;
use Reconmap\Repositories\VulnerabilityRepository;
use Reconmap\Repositories\VulnerabilityStatsRepository;

class GetVulnerabilitiesController extends Controller
{
    public function __construct(
        private VulnerabilityRepository $repository,
        private VulnerabilityStatsRepository $statsRepository
    )
    {
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        $page = $this->getIntQueryParam($params, 'page');

        if (isset($params['keywords'])) {
            $keywords = $params['keywords'];
            $vulnerabilities = $this->repository->findByKeywords($keywords);
        } elseif (isset($params['targetId'])) {
            $targetId = (int)$params['targetId'];
            $vulnerabilities = $this->repository->findByTargetId($targetId);
        } else {
            $vulnerabilities = $this->repository->findAll($page);
        }
        $count = $this->statsRepository->countAll();

        $pageCount = max(ceil($count / 20), 1);

        $response = new Response;
        $response->getBody()->write(json_encode($vulnerabilities));
        return $response
            ->withHeader('Access-Control-Expose-Headers', 'X-Page-Count')
            ->withHeader('X-Page-Count', $pageCount);
    }
}
