<?php
namespace App\Controller;

use App\Card\CardGraphic;
use App\Card\Card;
use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CardGameController extends AbstractController
{
    #[Route("/game/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route("/game/card/test/roll", name: "test_roll_card")]
    public function testRollCard(): Response
    {
        $die = new CardGraphic();
        $num = 1;  

        $card_array = array();
        $card_string_array = array();
    
        for ($i = 0; $i < $num; $i++) {
            array_push($card_array, $die->roll());
            array_push($card_string_array, $die->getAsString());
        }

        $data = [
            "card" => $card_array,
            "card_string_array" => $card_string_array
        ];


        return $this->render('card/test/roll.html.twig', $data);
    }

    #[Route("/game/card/test/roll/{num<\d+>}", name: "test_roll_num_cards")]
    public function testRollCardMany(string $num): Response
    {
        $die = new CardGraphic();
        $num = intval( $num );  

        $card_array = array();
        $card_string_array = array();
    
        for ($i = 0; $i < $num; $i++) {
            array_push($card_array, $die->roll());
            array_push($card_string_array, $die->getAsString());
        }

        $data = [
            "card" => $card_array,
            "card_string_array" => $card_string_array
        ];

        return $this->render('card/test/roll.html.twig', $data);
    }

    #[Route("/game/card/test/cardhand/{num<\d+>}", name: "test_cardhand")]
    public function testCardHand(int $num): Response
    {
        if ($num > 99) {
            throw new \Exception("Can not roll more than 99 cards!");
        }

        $hand = new CardHand();
        for ($i = 1; $i <= $num; $i++) {
            if ($i % 2 === 1) {
                $hand->add(new CardGraphic());
            } else {
                $hand->add(new Card());
            }
        }

        $hand->roll();

        $data = [
            "num_cards" => $hand->getNumberCards(),
            "cardRoll" => $hand->getString(),
        ];

        return $this->render('card/test/cardhand.html.twig', $data);
    }

    #[Route("/game/card/init", name: "card_init_get", methods: ['GET'])]
    public function init(): Response
    {
        return $this->render('card/init.html.twig');
    }

    #[Route("/game/card/init", name: "card_init_post", methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $numCard = $request->request->get('num_cards');

        $hand = new CardHand();
        for ($i = 1; $i <= $numCard; $i++) {
            $hand->add(new CardGraphic());
        }
        $hand->roll();

        $session->set("card_cardhand", $hand);
        $session->set("card_cards", $numCard);
        $session->set("card_round", 0);
        $session->set("card_total", 0);

        return $this->redirectToRoute('card_play');
    }
    #[Route("/game/card/play", name: "card_play", methods: ['GET'])]
    public function play(
        SessionInterface $session
    ): Response
    {
        $cardhand = $session->get("card_cardhand");

        $data = [
            "cardCards" => $session->get("card_cards"),
            "cardRound" => $session->get("card_round"),
            "cardTotal" => $session->get("card_total"),
            "cardValues" => $cardhand->getString() 
        ];

        return $this->render('card/play.html.twig', $data);
    }

    #[Route("/game/card/roll", name: "card_roll", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response
    {
        $hand = $session->get("card_cardhand");
        $hand->roll();

        $roundTotal = $session->get("card_round");
        $round = 0;
        $values = $hand->getValues();
        foreach ($values as $value) {
            if ($value === 1) {
                $round = 0;
                $roundTotal = 0;
                $this->addFlash(
                    'warning',
                    'You got a 1 and you lost the round points!'
                );
                break;
            }
            $round += $value;
        }

        $session->set("card_round", $roundTotal + $round);
        
        return $this->redirectToRoute('card_play');
    }

    #[Route("/game/card/save", name: "card_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response
    {
        $roundTotal = $session->get("card_round");
        $gameTotal = $session->get("card_total");

        $session->set("card_round", 0);
        $session->set("card_total", $roundTotal + $gameTotal);
        $this->addFlash(
            'notice',
            'Your round was saved to the total!'
        );

        return $this->redirectToRoute('card_play');
    }
}

