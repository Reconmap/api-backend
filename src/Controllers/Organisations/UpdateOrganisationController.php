<?php declare(strict_types=1);

namespace Reconmap\Controllers\Organisations;

use Psr\Http\Message\ServerRequestInterface;
use Reconmap\Controllers\Controller;
use Reconmap\Models\AuditLogAction;
use Reconmap\Models\Organisation;
use Reconmap\Repositories\OrganisationRepository;
use Reconmap\Services\ActivityPublisherService;

class UpdateOrganisationController extends Controller
{
    public function __construct(private OrganisationRepository $repository, private ActivityPublisherService $activityPublisherService)
    {
    }

    public function __invoke(ServerRequestInterface $request): array
    {
        /** @var Organisation $organisation */
        $organisation = $this->getJsonBodyDecoded($request);

        $success = $this->repository->updateRootOrganisation($organisation);

        $loggedInUserId = $request->getAttribute('userId');

        $this->auditAction($loggedInUserId);

        return ['success' => $success];
    }

    private function auditAction(int $loggedInUserId): void
    {
        $this->activityPublisherService->publish($loggedInUserId, AuditLogAction::ORGANISATION_UPDATED);
    }
}
