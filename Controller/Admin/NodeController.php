<?php

namespace HitcKit\CoreBundle\Controller\Admin;

use HitcKit\CoreBundle\Entity\Node;
use HitcKit\CoreBundle\Form\Admin\NodeType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NodeController extends AbstractController
{
    /**
     * @Route(
     *     path="/node/{nodeId}/{action}",
     *     requirements={"nodeId": "(root|\d+)", "action": "list"},
     *     defaults={"nodeId": "", "action": ""},
     *     name="hitc_kit_core.node_list"
     * )
     * @param $nodeId
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function list($nodeId, PaginatorInterface $paginator, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Node::class);
        $nodeId = $nodeId === 'root' ? null : $nodeId;
        $node = $nodeId ? $repository->find($nodeId) : null;
        $qb = $repository->getNodeListBuilder($nodeId);
        $pagination = $paginator->paginate($qb, $request->query->getInt('page', 1), 15);

        return $this->render('@HitcKitCore/admin_node_list.html.twig', ['pagination' => $pagination, 'node' => $node]);
    }

    /**
     * @Route(
     *     path="/node/{nodeId}/edit",
     *     requirements={"nodeId": "\d+"},
     *     defaults={"nodeId": "0"},
     *     name="hitc_kit_core.node_edit"
     * )
     * @param $nodeId
     * @param Request $request
     * @return Response
     */
    public function edit($nodeId, Request $request): Response
    {
        $repository = $this->getDoctrine()->getRepository(Node::class);
        $node = $repository->find($nodeId);
        $form = $this->createForm(NodeType::class, $node)->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //
        // }

        return $this->render('@HitcKitCore/admin_node_edit.html.twig', ['node' => $node, 'form' => $form->createView()]);
    }
}
