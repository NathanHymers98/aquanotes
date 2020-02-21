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

        $funFact = 'Octopuses can change the color of their body in just *three-tenths* of a second!';

        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');

        $key = md5($funFact);
        if ($cache->contains($key)) { // If the cache contains the fun fact string
            $funFact = $cache->fetch($key); // Then the cache should go and fetch the string from the cache
        } else { // If the cache does not contain the string
            sleep(1);
            $funFact = $this->get('markdown.parser') // Get the parser object and use it to parse the string
                ->transform($funFact);
            $cache->save($key, $funFact); // Save the parsed string to the cache
        }

        $funFact = $this->get('markdown.parser') // Getting the markdown parser object by calling the container method get() and using one of its methods to parse the $funFact string
            ->transform($funFact);

        return $this->render('genus/show.html.twig', array( // Using the render() function which goes out to the templating service object and calls a method named renderResponse so we can just return the render function with the twig view we want to show
                                                                    // along with any variables we want to use on this view.
            'name' => $genusName, // Passing a name variable into twig that is set to $genusName. The 'name' part is what is used by twig, this format is the same throughout.
            'funFact' => $funFact,
        ));
    }

    // Setting the route and generating the URL to a specific route, I am doing this by giving this route a specific name
    /**
     * @Route("/genus/{genusName}/notes", name="genus_show_notes")
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