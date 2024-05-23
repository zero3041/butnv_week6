<?php
declare(strict_types=1);

namespace Bss\InternShip\Plugin;

use Bss\InternShip\Model\ResourceModel\Internship\CollectionFactory as InternshipCollectionFactory;
use Magento\Checkout\Block\Cart\Sidebar;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Framework\Message\ManagerInterface as MessageManager;
use Psr\Log\LoggerInterface;

/**
 * Class Display message
 *
 * Display message discount customer
 */
class DisplayDiscountMessage
{
    /**
     * @var InternshipCollectionFactory
     */
    protected $internshipCollectionFactory;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    /**
     * @var MessageManager
     */
    protected $messageManager;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @param InternshipCollectionFactory $internshipCollectionFactory
     * @param CustomerSession $customerSession
     * @param MessageManager $messageManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        InternshipCollectionFactory $internshipCollectionFactory,
        CustomerSession $customerSession,
        MessageManager $messageManager,
        LoggerInterface $logger
    ) {
        $this->internshipCollectionFactory = $internshipCollectionFactory;
        $this->customerSession = $customerSession;
        $this->messageManager = $messageManager;
        $this->logger = $logger;
    }

    /**
     * Plugin method to display discount message
     *
     * @param Sidebar $subject
     * @param array $result
     * @return array
     */
    public function afterGetSectionData(Sidebar $subject, $result)
    {
        if ($this->customerSession->isLoggedIn()) {
            $customerEmail = $this->customerSession->getCustomer()->getEmail();
            $this->logger->info("Customer email: " . $customerEmail);

            $internshipCollection = $this->internshipCollectionFactory->create();
            $internshipCollection->addFieldToFilter('email', $customerEmail);
            $size = $internshipCollection->getSize();
            $this->logger->info("Size of internship collection: " . $size);

            if ($size > 0) {
                $this->messageManager->addSuccessMessage(__('You got 50% off for all orders'));
                $this->logger->info("Discount message added successfully.");
            }
        }
        return $result;
    }
}
