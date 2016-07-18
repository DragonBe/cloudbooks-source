<?php

namespace Cloudbooks\Member\Factory;

use Cloudbooks\Common\Interfaces\ServiceFactoryInterface;
use Cloudbooks\Common\Interfaces\ServiceLocatorInterface;
use Cloudbooks\Member\Service\MemberService;

class MemberServiceFactory implements ServiceFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $memberTable = $serviceLocator->get('\Cloudbooks\Member\Model\MemberTable');
        $memberHydrator = $serviceLocator->get('\Cloudbooks\Member\Model\MemberHydrator');
        $memberEntity = $serviceLocator->get('\Cloudbooks\Member\Entity\Member');
        $memberValidator = $serviceLocator->get('\Cloudbooks\Member\Model\MemberValitor');

        return new MemberService($memberTable, $memberHydrator, $memberEntity, $memberValidator);
    }
}
