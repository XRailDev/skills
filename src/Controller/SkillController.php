<?php
namespace App\Controller;
use App\Entity\Skill;
use App\Entity\Person;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SkillController extends Controller {
    /**
     * @Route("/", name="skill_list")
     * @Method({"GET"})
     */
    public function index() {
        $skills= $this->getDoctrine()->getRepository(Skill::class)->findAll();
        return $this->render('main/index.html.twig', array('skills' => $skills));
    }

    /**
     * @Route("/skill/new/{person_id}", name="new_skill")
     * Method({"GET", "POST"})
     * @param Request $request
     * @param Person $person_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function new(Request $request, Person $person_id) {
        $skill = new Skill();
        $form = $this->createFormBuilder($skill)
            ->add('name', TextType::class, array('attr' => array(
                'required' => true,
                'class' => 'form-control')))
            ->add('level', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ],
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Create',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $skill = $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $person = $entityManager->getRepository(Person::class)->find($person_id);
            $person->addSkill($skill);
            $entityManager->persist($skill);
            $entityManager->persist($person);
            $entityManager->flush();
            return $this->redirectToRoute('skill_list');
        }
        return $this->render('main/new.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/skill/edit/{id}", name="edit_skill")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $skill = new Skill();
        $skill = $this->getDoctrine()->getRepository(Skill::class)->find($id);
        $form = $this->createFormBuilder($skill)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('level', ChoiceType::class, [
                'choices' => [
                    '1' => 1,
                    '2' => 2,
                    '3' => 3,
                    '4' => 4,
                    '5' => 5,
                    '6' => 6,
                    '7' => 7,
                    '8' => 8,
                    '9' => 9,
                    '10' => 10,
                ],
            ])
            ->add('save', SubmitType::class, array(
                'label' => 'Update',
                'attr' => array('class' => 'btn btn-primary mt-3')
            ))
            ->getForm();
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            return $this->redirectToRoute('skill_list');
        }
        return $this->render('main/edit.html.twig', array(
            'form' => $form->createView()
        ));
    }
    /**
     * @Route("/skill/show", name="skill_show")
     * @Method({"GET"})
     */
    public function show() {
        $skills= $this->getDoctrine()->getRepository(Skill::class)->findAll();
        return $this->render('main/show.html.twig', array('skills' => $skills));
    }
    /**
     * @Route("/skill/delete/{id}")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $skill = $this->getDoctrine()->getRepository(Skill::class)->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($skill);
        $entityManager->flush();
        $response = new Response();
        $response->send();
    }
}