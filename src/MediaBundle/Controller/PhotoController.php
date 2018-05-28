<?php

namespace MediaBundle\Controller;

use MediaBundle\Entity\Photo;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhotoController extends Controller
{
    public function savePhotoAction(Request $request){
        $photo = new Photo();
        $photo->setFile($request->files->get('file'));
        $em = $this->getDoctrine()->getManager();
        $em->persist($photo);
        $em->flush();
        return new Response($photo->getId());
    }
}
