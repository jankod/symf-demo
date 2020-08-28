<?php


namespace App\Controller;


use App\Entity\Resource;
use App\Util\Daska;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class IndexController extends AbstractController
{


    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * @Route ("/pag", name="pagination")
     * @param EntityManagerInterface $em
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    public function pagination(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request)
    {
        $query = $em->createQuery("SELECT r FROM App\Entity\Resource r");
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        $name = $this->translator->trans('hello');

        return $this->render("pagination.html.twig", ['pagination' => $pagination, 'name' => $name]);
    }


    /**
     * @Route ("/page2", name="page2")
     * @return string
     */
    public function page2()
    {
        return $this->render('page2.html.twig');
    }


    /**
     * @Route ("/", name="index")
     * @return Response
     * @throws Exception
     */
    public function index(): Response
    {

        $manager = $this->getDoctrine()->getManager();
        $res = new  Resource();
        $res->setName("resource 2 " . base64_encode(random_bytes(14)));
        $manager->persist($res);
        $manager->flush();

        //return new Response('<html> <head></head> <body>Ovo nije voov dssaddsdas sadsaddas je prva stranica</body></html>');
        $name = "jansko čćžčšpš ss ds";
        $daska = new Daska();

        $daska->setName("daska je ovo");
        return $this->render('index.html.twig', ['name' => $name, 'daska' => $daska]);
    }
}

