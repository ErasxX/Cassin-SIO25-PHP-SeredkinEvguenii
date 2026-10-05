<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\MembreRepository;
use App\Entity\Membre;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\MembreType;
use Symfony\Component\HttpFoundation\Request;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $nom = 'Evguenii';
        $age = 20;

        return $this->render('home/index.html.twig', [
            'nom' => $nom,
            'age' => $age,
        ]);
    }


    #[Route('/number', name: 'app_number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return $this->render('lucky/number.html.twig', [
            'number' => $number,
        ]);
    }

    #[Route('/about', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }


    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        $nom = 'Seredkin';
        $prenom = 'Evguenii';
        $formation = 'BTS SIO SLAM';
        $age = 20;
        $ville = 'Strasbourg';

        $competences = [
            'PHP',
            'HTML / CSS',
            'Symfony',
            'SQL',
            'JavaScript',
            'MariaDB',
        ];

        return $this->render('home/profile.html.twig', [
            'nom' => $nom,
            'prenom' => $prenom,
            'formation' => $formation,
            'age' => $age,
            'ville' => $ville,
            'competences' => $competences,
        ]);
    }

}
