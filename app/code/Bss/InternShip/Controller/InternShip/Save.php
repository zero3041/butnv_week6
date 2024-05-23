<?php
declare(strict_types=1);

namespace Bss\InternShip\Controller\InternShip;

use Bss\InternShip\Model\InternshipFactory;
use Bss\InternShip\Model\ResourceModel\Internship as InternshipResource;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;

/**
 * Class Save
 *
 * Save data to database
 */
class Save implements HttpPostActionInterface
{
    /**
     * @var InternshipFactory
     */
    protected $internshipFactory;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var InternshipResource
     */
    protected $internshipResource;

    /**
     * @param InternshipFactory $internshipFactory
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param RedirectFactory $resultRedirectFactory
     * @param InternshipResource $internshipResource
     */
    public function __construct(
        InternshipFactory $internshipFactory,
        RequestInterface $request,
        ManagerInterface $messageManager,
        RedirectFactory $resultRedirectFactory,
        InternshipResource $internshipResource
    ) {
        $this->internshipFactory = $internshipFactory;
        $this->request = $request;
        $this->messageManager = $messageManager;
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->internshipResource = $internshipResource;
    }

    /**
     * Function save data
     *
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        $data = $this->request->getPostValue();

        try {
            $internship = $this->internshipFactory->create();
            $internship->setData($data);
            $this->internshipResource->save($internship);
            $this->messageManager->addSuccessMessage(__('Your data has been saved!'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('There was an error while saving Internship data,
             please try again!'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('bss/internship/index');
        return $resultRedirect;
    }
}
