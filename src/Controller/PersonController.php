<?php
namespace App\Controller;
use App\Entity\Person;
use App\Entity\Skill;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
class PersonController extends Controller{
    /**
     * @Route("/", name="person_list")
     * @Method({"GET"})
     */
    public function index(){
        $persons= $this->getDoctrine()->getRepository(Person::class)->findAll();
        return $this->render('main/index.html.twig', array('persons' => $persons));

    }

    /**
     * @Route("/person/new", name="new_person")
     * Method({"GET", "POST"})
     */
    public function new(Request $request){
        $person = new Person();
        $form = $this->createFormBuilder($person)
            ->add('name', TextType::class, array(
                'required' => true,
                'attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $person = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($person);
            $entityManager->flush();
            return $this->redirectToRoute('person_list');
        }

        return $this->render('main/new_person.html.twig', array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/person/{id}", name="person_show")
     */
    public function show($id) {
//        $skills= $this->getDoctrine()->getRepository(Skill::class)->find($id);
//        $personName = $skills->getPerson()->getName();
        $person = $this->getDoctrine()
            ->getRepository(Person::class)
            ->find($id);
        $skills = $person->getSkills();
        return $this->render('main/show.html.twig', array('skills' => $skills));
    }


}
