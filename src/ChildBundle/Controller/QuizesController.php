<?php

namespace ChildBundle\Controller;

use ChildBundle\Entity\Answer;
use ChildBundle\Entity\Attempt;
use ChildBundle\Entity\ChildAnswer;
use ChildBundle\Entity\Question;
use ChildBundle\Entity\Quiz;
use ChildBundle\Form\QuestionType;
use ChildBundle\Form\QuizType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class QuizesController extends Controller
{
    public function listQuizesByCatAction(Request $request)
    {
        $categories = $this->getDoctrine()->getRepository('ShopBundle:Category')
            ->findBy(['type' => 'Quiz']);
        $quizes = $this->getDoctrine()->getRepository("ChildBundle:Quiz")->findAll();
        return $this->render("ChildBundle:Child:quizes.html.twig", [
            'quizes' => $quizes,
            'categories' => $categories
        ]);
    }

    public function listQuizesAction(Request $request)
    {
        $quizes = $this->getDoctrine()->getRepository("ChildBundle:Quiz")->findAll();
        return $this->render("ChildBundle:Admin/quizes:list.html.twig", [
            'quizes' => $quizes
        ]);
    }

    public function addQuizAction(Request $request)
    {
        $quiz = new Quiz();
        $form = $this->createForm(QuizType::class, $quiz);
        if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute("quizes_list");
        }
        return $this->render('ChildBundle:Admin/quizes:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Ajouter un quiz',
            'btn' => 'Ajouter'
        ]);
    }

    public function addQuestionsAction(Request $request, $id)
    {
        $quiz = $this->getDoctrine()->getRepository("ChildBundle:Quiz")->find($id);
        if ($quiz != null && count($quiz->getQuestions()) < 4) {
            $question = new Question();
            $action = $request->get('action');
            $question->setQuiz($quiz);
            $form = $this->createForm(QuestionType::class, $question);
            if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($question);
                $em->flush();
                if ($action == "stay")
                    return $this->redirectToRoute('questions_add', [ 'id' => $quiz->getId() ]);
                else
                    return $this->redirectToRoute('questions_list', [ 'id' => $quiz->getId() ]);
            }
            return $this->render('ChildBundle:Admin/questions:form.html.twig', [
                'form' => $form->createView(),
                'title' => 'Ajouter une question à : ' . $quiz->getName()
            ]);
        }
    }

    public function addAnswersAction(Request $request, $id)
    {

        $question = $this->getDoctrine()->getRepository("ChildBundle:Question")->find($id);
        if ($question != null && count($question->getAnswers()) < 4) {
            $answer = new Answer();
            $action = $request->get('action');
            $form = $this->createForm(AnswerType::class, $question);
            $form->remove('subject')->remove('type')->add('name');
            if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($answer);
                $em->flush();
                if ($action == "stay")
                    return $this->redirectToRoute('quizes_add');
                else
                    return $this->redirectToRoute('quizes_list', $id);
            }
            return $this->render('ChildBundle:Admin/quizes:form.html.twig', [
                'form' => $form->createView(),
                'title' => 'Ajouter une Réponse'
            ]);
        }
    }

    public function listQuestionsAction($id, Request $request)
    {
        $quiz = $this->getDoctrine()->getRepository("ChildBundle:Quiz")->find($id);
        $questions = $this->getDoctrine()->getRepository("ChildBundle:Question")->findQuiz($id);
        if ($request->isXmlHttpRequest())
            return $this->render("ChildBundle:Child/Quiz:questions.html.twig", [
                'questions' => $questions
            ]);
        return $this->render("ChildBundle:Admin/questions:list.html.twig", [
            'questions' => $questions,
            'quiz' => $quiz
        ]);
    }

    public function answerQuizAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $answers = $request->get('answers');
        $child = $em->getRepository('ChildBundle:Child')->find($id);
        $answers = json_decode($answers);
        $attempt = new Attempt();
        $i = 0;
        foreach ($answers as $inanswer) {
            $answer = $em->getRepository('ChildBundle:Answer')->find($inanswer->answer);
            if ($answer->getCorrect())
                $i++;
            $question = $em->getRepository('ChildBundle:Question')->find($inanswer->question);
            $answer->setQuestion($question);
            $childAns = new ChildAnswer();
            $childAns->setChild($child);
            $childAns->setAnswer($answer);
            $childAns->setAttempt($attempt);
            $quiz = $question->getQuiz();
            $attempt->setChild($child);
            $attempt->setQuiz($quiz);
            $attempt->setScore($i);
            $attempt->setDate(new \DateTime());
            $em->persist($childAns);
            $em->persist($attempt);
        }
        $em->flush();
        return new Response("Vous avez obtenu " . $i . " reponse(s) correcte(s)");
    }

    public function showQuizAction(Request $request)
    {
        $id = $request->get('id');
        $quiz = $this->getDoctrine()->getRepository('ChildBundle:Quiz')->find($id);
        return $this->render('@Child/Child/Quiz/questions.html.twig', [
            'quiz' => $quiz
        ]);
    }

    public function editQuizAction(Request $request, $id)
    {
        $quiz = $this->getDoctrine()->getRepository('ChildBundle:Quiz')->find($id);
        $form = $this->createForm(QuizType::class, $quiz);
        if ($request->getMethod() == 'POST' && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($quiz);
            $em->flush();
            return $this->redirectToRoute("quizes_add", ["id" => $quiz->getId()]);
        }
        return $this->render('ChildBundle:Admin/quiz:form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier un quiz',
            'btn' => 'Sauvgarder'
        ]);
    }

    public function deleteQuizAction(Request $request, $id)
    {
        $quiz = $this->getDoctrine()->getRepository('ChildBundle:Quiz')->find($id);
        $em->remove($quiz);
        $em->flush();
        return $this->redirectToRoute("quizes_list");
    }


}
