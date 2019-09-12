<?php


namespace App\Controller;


use App\Mindbox\Form\CustomerType;
use App\Mindbox\MindBoxHandler;
use App\Mindbox\Model\MindboxArea;
use App\Mindbox\Model\MindboxCustomer;
use App\Mindbox\Model\MindboxSubscription;
use App\Mindbox\Operations\CallbackOperation;
use App\Mindbox\Operations\PopupOperation;
use App\Mindbox\Operations\RegistartionOperation;
use App\Mindbox\Operations\WebSiteLoginOperation;
use JMS\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MindboxController extends AbstractController
{
    /**
     * @Route("/mindbox", name="mindbox")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, MindBoxHandler $mindboxHandler, SerializerInterface $serializer)
    {

        $model = new MindboxCustomer();

        $form = $this->createForm(CustomerType::class, $model);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($form->get('smsSubscription')->getData()) {
                $model->addSubscriptions(new MindboxSubscription());
            }

            if ($form->get('smsSubscription')->getData()) {
                $model->addSubscriptions(new MindboxSubscription('Sms'));
            }

            $model->addCustomField('b2b', true);
            $model->addCustomField('city', 'Mосква');
            $model->addCustomField('childrenNames', ['Маша', 'Петя']);
            $model->addId('bitrixId', 346257);
            $model->addId('webSiteUserId', 2189478);

            $mindboxArea = new MindboxArea();
            $mindboxArea->addId('bitrixId', 346257);
            $mindboxArea->addId('webSiteUserId', 2189478);

            $model->setArea($mindboxArea);

            $operation = new RegistartionOperation();
            $operation->setModel($model);

            $result = $mindboxHandler->run($operation);

            $operation = new WebSiteLoginOperation();
            $operation->setModel($model);

            $result = $mindboxHandler->run($operation);


            $operation = new CallbackOperation();
            $operation->setModel($model);

            $result = $mindboxHandler->run($operation);


            $operation = new PopupOperation();
            $operation->setModel($model);

            $result = $mindboxHandler->run($operation);

        }


        return $this->render("default/mindbox.html.twig", [
            'form' => $form->createView(),
            'base_dir' => realpath($this->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR,
        ]);
    }

}