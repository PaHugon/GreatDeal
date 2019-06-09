<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use App\Service\AnnouncementService;
use App\Entity\Announcement;
use App\Form\AnnouncementType;


class AnnouncementController extends AbstractController
{
    private $announcementService;

    public function __construct( AnnouncementService $announcementService ){
        $this->announcementService = $announcementService;
    }

    /**
     * @Route("/announcements", name="announcement_list")
     */
    public function list(Request $request){
        $query = $request->query->get('query');

        if(!empty($query)) {
            $announcements = $this->announcementService->search($query);
        } else {
            $announcements = $this->announcementService->getAll();
        }

        return $this->render('announcement/list.html.twig', array(
            'announcements' => $announcements,
        ));
    }

    /**
     * @Route("/announcement/add", name="announcement_add")
     */
    public function add( Request $request ){
        $announcement = new Announcement();
        $form = $this->createForm( AnnouncementType::class, $announcement);

        $form->handleRequest( $request );
        if( $form->isSubmitted() && $form->isValid() ){
            $am = $this->getDoctrine()->getManager();

            $announcement->setDate(new \DateTime());

            // Set img_1
            // if($announcement->getImg1() !== null) {
                $file1 = $announcement->getImg1();
                $fileName1 = $this->generateUniqueFileName() . '.' . $file1->guessExtension();

                try {
                    $file1->move(
                        $this->getParameter('img_directory'),
                        $fileName1
                    );
                } catch (FileException $e) {

                }
                $announcement->setImg1($fileName1);
            /* } else {
                $announcement->setImg1(null);
            }*/
            
            // Set img_2
            // if($announcement->getImg2() !== null) {
                $file2 = $announcement->getImg2();
                $fileName2 = $this->generateUniqueFileName() . '.' . $file2->guessExtension();

                try {
                    $file2->move(
                        $this->getParameter('img_directory'),
                        $fileName2
                    );
                } catch (FileException $e) {

                }
                $announcement->setImg2($fileName2);
            /* } else {
                $announcement->setImg2(null);
            } */
            
            // Set img_3
            // if($announcement->getImg3() !== null) {
                $file3 = $announcement->getImg3();
                $fileName3 = $this->generateUniqueFileName() . '.' . $file3->guessExtension();

                try {
                    $file3->move(
                        $this->getParameter('img_directory'),
                        $fileName3
                    );
                } catch (FileException $e) {

                }
                $announcement->setImg3($fileName3);
            /* } else {
                $announcement->setImg3(null);
            }*/

            $am->persist( $announcement );
            $am->flush();

            return $this->redirectToRoute('announcement_show', array(
                'id' => $announcement->getId()
            ));
            
        }

        return $this->render('announcement/add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/announcement/{id}", name="announcement_show", requirements = {"id" = "\d+"})
     */
    public function show( $id ){
        return $this->render( 'announcement/show.html.twig', array(
            'announcement' => $this->announcementService->getOne( $id )
        ));
    }
}
