<?php
declare(strict_types=1);

namespace Bss\InternShip\Controller\InternShip;

use Bss\InternShip\Helper\Data;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Class Index
 *
 * Create page
 */
class Index implements HttpGetActionInterface, HttpPostActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var RedirectFactory
     */
    protected $redirectFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Data
     */
    protected $helper;

    /**
     * @param PageFactory $resultPageFactory
     * @param RequestInterface $request
     * @param RedirectFactory $redirectFactory
     * @param ManagerInterface $messageManager
     * @param Data $helper
     */
    public function __construct(
        PageFactory $resultPageFactory,
        RequestInterface $request,
        RedirectFactory $redirectFactory,
        ManagerInterface $messageManager,
        Data $helper
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->request = $request;
        $this->redirectFactory = $redirectFactory;
        $this->messageManager = $messageManager;
        $this->helper = $helper;
    }

    /**
     * Create page
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface|\Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        if ($this->helper->getStatus() == 0) {
            $redirect = $this->redirectFactory->create();
            $redirect->setPath('/');
            $this->messageManager->addErrorMessage(
                __("You do not have enough permissions to access this page, please contact the administrator!")
            );
            return $redirect;
        }

        return $this->resultPageFactory->create();
    }
}
