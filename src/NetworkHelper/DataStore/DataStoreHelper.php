<?php
/**
 * Curl helper to core requests.
 *
 * Helper enabling communication with the casino nucleus, it performs all operations
 * on the network after the end of the game.
 *
 * @category   Helpers
 * @package    App\NetworkHelper\Core
 * @author     Rafal Malik <kontakt@raspberryvision.pl>
 * @copyright  03.2020 Raspberry Vision
 */

namespace App\NetworkHelper\DataStore;

use App\Model\DTO\Game\Game;
use App\Model\DTO\Network\NetworkRequest;
use App\Model\DTO\Network\NetworkRequestInterface;
use App\Model\DTO\Network\NetworkResponseInterface;
use App\NetworkHelper\AbstractNetworkHelper;
use App\NetworkHelper\ModelBuilder;

/**
 * A class that provides access methods to casino action.
 * @category   NetworkHelper
 * @package    App\NetworkHelper\Core
 * @author     Rafal Malik <rafalmalik.info@gmail.com>
 * @copyright  03.2020 Raspberry Vision
 */
class DataStoreHelper extends AbstractNetworkHelper
{
    /** @var ModelBuilder $modelBuilder */
    private $modelBuilder;

    /**
     * DataStoreHelper constructor.
     */
    public function __construct()
    {
        $this->modelBuilder = new ModelBuilder();
        parent::__construct(
            'loterioma_datastore_helper',
            'http://api',
            80
        );
    }

    /**
     * The method that sends a request to save the user provided as a parameter.
     * @param NetworkRequestInterface $networkRequest
     * @return NetworkResponseInterface
     */
    public function storeUser(NetworkRequestInterface $networkRequest): NetworkResponseInterface
    {
        return $this->makeRequest($networkRequest);
    }

    /**
     * The method used to retrieve the user's object based on the criteria provided.
     * @param NetworkRequestInterface $networkRequest
     * @return NetworkResponseInterface
     */
    public function fetchUser(NetworkRequestInterface $networkRequest): NetworkResponseInterface
    {
        return $this->makeRequest($networkRequest);
    }

    /**
     * The method that sends a request to save the object of the created game.
     * !!! To play, you must still activate the game object.
     * @param Game $game
     * @return NetworkResponseInterface
     */
    public function storeGame(Game $game): NetworkResponseInterface
    {
        return $this->makeRequest(new NetworkRequest(
            '/games',
            'POST',
            'sadasdas',
            $game
        ));
    }

    /**
     * The method that sends a request to save the object of the created game.
     * !!! To play, you must still activate the game object.
     * @param int|null $id
     * @return Game|null
     */
    public function fetchGame(int $id): ?Game
    {
        $response = $this->makeRequest(new NetworkRequest(
            '/games/' . $id,
            'GET',
            'sadasdas',
            []
        ));

        if ($response->getBody()) {
            return $this->modelBuilder->convert(Game::class, $response->getBody());
        }

        return null;
    }

    /**
     * The method that sends a request to save the object of the created game.
     * !!! To play, you must still activate the game object.
     * @param Game $game
     * @return Game|null
     */
    public function updateGame(Game $game): ?Game
    {
        $response = $this->makeRequest(new NetworkRequest(
            '/games/' . $game->getId(),
            'PATCH',
            'sadasdas',
            $game
        ));

        if ($response->getBody()) {
            return $this->modelBuilder->convert(Game::class, $response->getBody());
        }

        return null;
    }

    /**
     * The method that sends a request to save the object of the created game.
     * !!! To play, you must still activate the game object.
     * @return Game[]|array
     */
    public function fetchGames(): array
    {
        $response = $this->makeRequest(new NetworkRequest(
            '/games',
            'GET',
            'sadasdas',
            []
        ));

        if ($response->getBody()) {

            $gameObjects = [];
            foreach ($response->getBody() as $game) {
                $gameObjects [] = $this->modelBuilder->convert(Game::class, $game);
            }

            return $gameObjects;
        }

        return [];
    }
}