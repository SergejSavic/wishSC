<?php

namespace App\Console\Commands;

use App\Contracts\Repositories\UserRepositoryInterface;
use App\Models\WishUser;
use Exception;
use Illuminate\Console\Command;
use SendCloud\MiddlewareComponents\Models\Repository\ConfigRepository;
use SendCloud\MiddlewareComponents\Models\Repository\QueueItemRepository;

/**
 * Class DeleteInactiveUsers
 * @package App\Console\Commands
 */
class DeleteInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendcloud:delete_inactive_users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes inactive users';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws Exception
     */
    public function handle(): void
    {
        $inactiveContexts = $this->getWishUserRepository()->getInactiveContexts();
        foreach ($inactiveContexts as $context) {
            /** @var WishUser $user */
            $user = $this->getWishUserRepository()->getUser($context);
            if ($user !== null) {
                $this->getWishUserRepository()->deleteUserByContext($context);
                QueueItemRepository::delete($context);
                ConfigRepository::delete($context);
            }
        }
    }

    /**
     * Get wish user repository
     *
     * @return UserRepositoryInterface
     */
    private function getWishUserRepository(): UserRepositoryInterface
    {
        return app(UserRepositoryInterface::class);
    }
}
