<?php


namespace AppBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GenusController extends Controller
{
    // Below I am setting the Route to /genus which is the URL. When a user goes to this page, the showAction function builds the page. This is the case because the annotation is directly above the function
    // By having {genusName} in the URL and $genusName being passed as an argument, it means that we could pass anything and set it to $genusName and that would become the URL or we could ass something in the URL and it would fill the $genusName variable in the function
    // This makes the URL dynamic.
    /**
     * @Route("/genus/{genusName}")
     */
    public function showAction($genusName) // The controller function. This function must return a response object
    {

        return $this->render('genus/show.html.twig', array( // Using the render() function which goes out to the templating service object and calls a method named renderResponse so we can just return the render function with the twig view we want to show
                                                                    // along with any variables we want to use on this view.
            'name' => $genusName, // Passing a name variable into twig that is set to $genusName. The 'name' part is what is used by twig, this format is the same throughout.
        ));
    }

    /**
     * @Route("/genus/{genusName}/notes")
     * @Method("GET")
     */
    public function getNotesAction($genusName)
    {
        $notes = [
                ['id' => 1, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Octopus asked me a riddle, outsmarted me', 'date' => 'Dec. 10, 2015'],
                ['id' => 2, 'username' => 'AquaWeaver', 'avatarUri' => '/images/ryan.jpeg', 'note' => 'I counted 8 legs... as they wrapped around me', 'date' => 'Dec. 1, 2015'],
                ['id' => 3, 'username' => 'AquaPelham', 'avatarUri' => '/images/leanna.jpeg', 'note' => 'Inked!', 'date' => 'Aug. 20, 2015'],
            ];
        $data = [
            'notes' => $notes
        ];

        return new JsonResponse($data);
    }
}