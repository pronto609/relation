<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        QuestionFactory::createMany(20);

        QuestionFactory::new()
            ->unpublished()
            ->many(5)
            ->create()
        ;

        $answer = new Answer();
        $answer->setContent('This question answer');
        $answer->setUsername('wrgbetrbg');

        $question = new Question();
        $question->setName('Title question');
        $question->setQuestion('...wergethrhr .e.grt.tghrthrthrt ...');

        $answer->setQuestion($question);

        $manager->persist($answer);
        $manager->persist($question);


        $manager->flush();
    }
}
