<?php
namespace Magecomp\Sms\Observer\Customer;

use Magento\Framework\Event\ObserverInterface;

class ShipmentSaveObserver implements ObserverInterface
{
    protected $helperapi;
    protected $helpershipment;
    protected $emailfilter;
    protected $customerFactory;

    public function __construct(
        \Magecomp\Sms\Helper\Apicall $helperapi,
        \Magecomp\Sms\Helper\Shipment $helpershipment,
        \Magento\Email\Model\Template\Filter $filter,
        \Magento\Customer\Model\CustomerFactory $customerFactory)
    {
        $this->helperapi = $helperapi;
        $this->helpershipment = $helpershipment;
        $this->emailfilter = $filter;
        $this->customerFactory = $customerFactory;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        if(!$this->helpershipment->isEnabled())
            return $this;

        $event = $observer->getEvent();
        $track = $event->getTrack();
        $trackingId = $track->getNumber();
        $title = $track->getTitle();


        $shipment   = $track->getShipment();
        $order      = $shipment->getOrder();

        
        

        if($shipment)
        {
            $billingAddress = $order->getBillingAddress();
            $mobilenumber = $billingAddress->getTelephone();

            if($order->getCustomerId() > 0)
            {
                $customer = $this->customerFactory->create()->load($order->getCustomerId());
                $mobile = $customer->getMobilenumber();
                if($mobile != '' && $mobile != null)
                {
                    $mobilenumber = $mobile;
                }

                

                //foreach ($shipment->getAllTracks() as $_item) {
                //    $title = $_item->getTitle();
                //    $number = $_item->getNumber();
                //}

                $this->emailfilter->setVariables([
                    'order' => $order,
                    'shipment' => $shipment,
                    'customer' => $customer,
                    'mobilenumber' => $mobilenumber,
                    
                ]);
            }
            else
            {
                $this->emailfilter->setVariables([
                    'order' => $order,
                    'shipment' => $shipment,
                    'mobilenumber' => $mobilenumber,
                    
                ]);
            }

            if ($this->helpershipment->isShipmentNotificationForUser())
            {
                //$message = $this->helpershipment->getShipmentNotificationUserTemplate();
                $message = "Your order has been shipped through ".$title.". Your tracking no is ".$trackingId." for your reference.";
                //$finalmessage = $this->emailfilter->filter($message);
                $this->helperapi->callApiUrl($mobilenumber,$message);
            }

            if($this->helpershipment->isShipmentNotificationForAdmin() && $this->helpershipment->getAdminNumber())
            {
                $message = $this->helpershipment->getShipmentNotificationForAdminTemplate();
                $finalmessage = $this->emailfilter->filter($message);
                $this->helperapi->callApiUrl($this->helpershipment->getAdminNumber(),$finalmessage);
            }
        }
        return $this;
    }
}
