<?php
declare(strict_types=1);

namespace Bss\InternShip\Observer;

use Bss\InternShip\Model\InternshipFactory;
use Bss\InternShip\Model\ResourceModel\Internship as InternshipResource;
use Bss\InternShip\Model\ResourceModel\Internship\CollectionFactory as InternshipCollectionFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Class UpdateInternshipOnCustomerCreate
 *
 * Update information internship database
 */
class UpdateInternshipOnCustomerCreate implements ObserverInterface
{
    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var InternshipCollectionFactory
     */
    protected $internshipCollectionFactory;

    /**
     * @var InternshipFactory
     */
    protected $internshipFactory;

    /**
     * @var InternshipResource
     */
    protected $internshipResource;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param ManagerInterface $messageManager
     * @param InternshipCollectionFactory $internshipCollectionFactory
     * @param InternshipFactory $internshipFactory
     * @param InternshipResource $internshipResource
     * @param LoggerInterface $logger
     */
    public function __construct(
        ManagerInterface $messageManager,
        InternshipCollectionFactory $internshipCollectionFactory,
        InternshipFactory $internshipFactory,
        InternshipResource $internshipResource,
        LoggerInterface $logger
    ) {
        $this->messageManager = $messageManager;
        $this->internshipCollectionFactory = $internshipCollectionFactory;
        $this->internshipFactory = $internshipFactory;
        $this->internshipResource = $internshipResource;
        $this->logger = $logger;
    }

    /**
     * Function replace name
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer)
    {
        try {
            $customer = $observer->getEvent()->getCustomer();
            $customerEmail = $customer->getEmail();
            $customerFirstname = $customer->getFirstname();
            $customerLastname = $customer->getLastname();

            $this->logger->info('Customer registered: ' . $customerEmail);

            $internshipCollection = $this->internshipCollectionFactory->create()
                ->addFieldToFilter('email', $customerEmail);

            foreach ($internshipCollection as $internshipData) {
                $internship = $this->internshipFactory->create();
                $this->internshipResource->load($internship, $internshipData->getId());

                $this->logger->info('Updating Internship: ' . $internship->getId());
                $internship->setFirstname($customerFirstname);
                $internship->setLastname($customerLastname);
                $this->internshipResource->save($internship);
                $this->logger->info('Internship updated successfully: ' . $internship->getId());
            }

        } catch (\Exception $e) {
            $this->logger->error('Error updating Internship: ' . $e->getMessage());
            $this->messageManager->addErrorMessage(__('There was an error while updating Internship data.'));
        }
    }
}
