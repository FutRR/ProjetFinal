<?php

namespace App\DataFixtures;

use App\Entity\Etape;
use App\Entity\Niveau;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $niveauId = 3;
        $niveau = $manager->getRepository(Niveau::class)->find($niveauId);

        $nomEtapes = ['Lecture', 'Rythme', 'Théorie', 'Morceau'];

        // Création d'étapes
        foreach ($nomEtapes as $i => $nomEtape) {
            $etape = new Etape();
            $etape->setNomEtape($nomEtape);
            $etape->setDescription('lorem ipsum blabla');
            $etape->setPdf('pdf/piano-facile.pdf');
            $etape->setOrdre($i + 1);
            $etape->setNiveau($niveau);
            $manager->persist($etape);
        }

        // Enregistrer les objets en base de données
        $manager->flush();
    }
}
