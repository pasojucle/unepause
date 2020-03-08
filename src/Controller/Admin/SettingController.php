<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Entity\Action;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SettingController extends AbstractController
{
    /**
     * @Route("/admin/setting/{action}/{page}",
     *  name="admin_setting",
     *  defaults={"action"=1, "page"=null})
     */
    public function adminSetting(Action $action, ?Page $page)
    {
        return $this->render('Admin/setting/edit.html.twig', [
            'current_action' => $action,
            'current_page' => $page,
        ]);
    }
}
