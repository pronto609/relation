<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use App\Entity\Question;
use App\Factory\AnswerFactory;
use App\Factory\QuestionFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Tag;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $questions = QuestionFactory::createMany(20);

        QuestionFactory::new()
            ->unpublished()
            ->many(5)
            ->create()
        ;

        AnswerFactory::createMany(100, function () use ($questions) {
            return [
                'question' => $questions[array_rand($questions)]
            ];
        });

        AnswerFactory::new(function () use ($questions) {
            return [
                'question' => $questions[array_rand($questions)]
            ];
        })->needsApproval()->many(20)->create();

        $question = QuestionFactory::createOne()->object();

        $tag1 = new Tag();
        $tag1->setName('dinosaurs');

        $tag2 = new Tag();
        $tag2->setName('monkey');

        $manager->persist($tag1);
        $manager->persist($tag2);

        $tag1->addQuestion($question);
        $tag2->addQuestion($question);


        $manager->flush();
    }
}
