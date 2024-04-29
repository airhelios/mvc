<?php

namespace App\Game;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class GameManagerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGameManagerConstructor(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertInstanceOf("\App\Game\GameManager", $gameManager);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testCreateGameManagerStatic(): void
    {
        $gameManager = GameManager::gameManagerNew();
        $this->assertInstanceOf("\App\Game\GameManager", $gameManager);
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetSetPlayerMachine(): void
    {
        $gameManager = GameManager::gameManagerNew();
        $this->assertEquals("player", $gameManager->getCurrentPlayer());
        $gameManager->setPlayerMachine();
        $this->assertEquals("machine", $gameManager->getCurrentPlayer());
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testGetGameStatus(): void
    {
        //Test initial status
        $gameManager = GameManager::gameManagerNew();
        $this->assertEquals("player_turn", $gameManager->getGameStatus());

        //Test player bust-status
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(22);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals("player_bust", $gameManager->getGameStatus());

        //Test player bust-status
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(20);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(22);
        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals("house_bust", $gameManager->getGameStatus());

        //Test house win status
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(20);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(21);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $gameManager->setPlayerMachine();

        $this->assertEquals("house_win", $gameManager->getGameStatus());

        //Test house win status
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(20);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(19);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $gameManager->setPlayerMachine();

        $this->assertEquals("player_win", $gameManager->getGameStatus());

    }

    public function testGetPlayerHand(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubCard = $this->createMock(CardG::class);
        $stubPlayerHand->method("getCards")->willReturn([$stubCard]);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals([$stubCard], $gameManager->getPlayerHand());
    }

    public function testGetMachineHand(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubCard = $this->createMock(CardG::class);
        $stubHouseHand->method("getCards")->willReturn([$stubCard]);
        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals([$stubCard], $gameManager->getMachineHand());
    }

    public function testGetPlayerCardStrings(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubCard = $this->createMock(CardG::class);
        $stubCard->method("getAsString")->willReturn("Ace of Spades");
        $stubHouseHand->add($stubCard);
        $stubPlayerHand->method("getCards")->willReturn([$stubCard]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(["Ace of Spades"], $gameManager->getPlayerCardStrings());
    }


    public function testGetPlayerCardStringsParents(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubCard = $this->createMock(CardGraphicG::class);
        $stubCard->method("getAsStringParent")->willReturn("Ace of Spades");
        $stubPlayerHand->add($stubCard);
        $stubPlayerHand->method("getCards")->willReturn([$stubCard]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(["Ace of Spades"], $gameManager->getPlayerCardStringsParent());
    }

    public function testgetPlayerCardColors(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubCard = $this->createMock(CardG::class);
        $stubCard->method("getAsColor")->willReturn("Spades");

        $stubPlayerHand->add($stubCard);
        $stubPlayerHand->method("getCards")->willReturn([$stubCard]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(["Spades"], $gameManager->getPlayerCardColors());
    }

    public function testGetMachineCardStrings(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubCard = $this->createMock(CardG::class);
        $stubCard->method("getAsString")->willReturn("Ace of Spades");
        $stubHouseHand->add($stubCard);
        $stubHouseHand->method("getCards")->willReturn([$stubCard]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(["Ace of Spades"], $gameManager->getMachineCardStrings());
    }

    public function testGetMachineCardStringsParents(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubCard = $this->createMock(CardGraphicG::class);
        $stubCard->method("getAsStringParent")->willReturn("Ace of Spades");
        $stubHouseHand->add($stubCard);
        $stubHouseHand->method("getCards")->willReturn([$stubCard]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(["Ace of Spades"], $gameManager->getMachineCardStringsParent());
    }

    public function testGetMachineCardColors(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubCard = $this->createMock(CardG::class);
        $stubCard->method("getAsColor")->willReturn("Spades");

        $stubHouseHand->add($stubCard);
        $stubHouseHand->method("getCards")->willReturn([$stubCard]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(["Spades"], $gameManager->getMachineCardColors());
    }

    public function testGetWinnerPhrase(): void
    {

        //Test player wins with score of 21 vs 20
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(21);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(20);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(
            "The Player wins with a score of 21 against 20",
            $gameManager->getWinnerPhrase()
        );

        //Test house wins with score of 20 vs 21
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(20);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(21);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(
            "The House wins with a score of 21 against 20",
            $gameManager->getWinnerPhrase()
        );

        //Test player goes bust
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(22);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(21);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(
            "House wins because the Player went bust!",
            $gameManager->getWinnerPhrase()
        );

        //Test house goes bust
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(21);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(22);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(
            "Player wins because the House went bust!",
            $gameManager->getWinnerPhrase()
        );
    }

    public function testGetBestPlayerScore(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(21);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(21, $gameManager->getBestPlayerScore());
    }

    public function testGetBestMachineScore(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('bestScore')->willReturn(21);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals(21, $gameManager->getBestMachineScore());
    }

    public function testGetScore(): void
    {
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('sumValue')->willReturn([11, 21]);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubHouseHand->method('sumValue')->willReturn([11, 21]);

        $stubDeck = $this->createMock(DeckOfCardsG::class);

        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals([11, 21], $gameManager->getScore("machine"));

        $this->assertEquals([11, 21], $gameManager->getScore("hand"));
    }

    public function testDrawPlayer(): void
    {
        $stubCard = $this->createMock(CardG::class);

        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method("getCards")->willReturn([$stubCard]);

        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubDeck = $this->createMock(DeckOfCardsG::class);

        $stubDeck->method("draw")->willReturn($stubCard);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);

        $this->assertEquals($stubCard, $gameManager->drawPlayer());
    }

    public function testCheckPlayerHand(): void
    {
        //Test bust
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(22);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals("bust", $gameManager->checkPlayerHand());

        //Test player_21
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(21);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals("player_21", $gameManager->checkPlayerHand());

        //Test playing
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubPlayerHand->method('bestScore')->willReturn(20);
        $stubHouseHand = $this->createMock(CardHandG::class);

        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $this->assertEquals("playing", $gameManager->checkPlayerHand());
    }

    public function testPopulateMachine(): void
    {
        //Test bust
        $stubPlayerHand = $this->createMock(CardHandG::class);
        $stubHouseHand = $this->createMock(CardHandG::class);
        $stubDeck = $this->createMock(DeckOfCardsG::class);
        $stubCard = $this->createMock(CardG::class);
        $stubCard->method("getValue")->willReturn(1);
        $stubDeck->method("draw")->willReturn($stubCard);

        $gameManager = new GameManager($stubPlayerHand, $stubHouseHand, $stubDeck);
        $gameManager->populateMachine();
        $this->assertEquals(17, $gameManager->populateMachine());

    }

}
