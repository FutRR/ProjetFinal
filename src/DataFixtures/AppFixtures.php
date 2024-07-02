<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Etape;
use App\Entity\Niveau;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Factory::create();

        $niveauId = 2;
        $niveau = $manager->getRepository(Niveau::class)->find($niveauId);

        // Création d'étapes pour le Niveau 1
        for ($i = 1; $i <= 4; $i++) {
            $etape = new Etape();
            $etape->setNomEtape($faker->word);
            $etape->setDescription('lorem ipsum blabla');
            $etape->setOrdre($i);
            $etape->setNiveau($niveau);
            $manager->persist($etape);
        }

        // Enregistrer les objets en base de données
        $manager->flush();
    }
}
