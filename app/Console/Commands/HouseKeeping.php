<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;

class HouseKeeping extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'app:keep';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Get the application ready with a single command';

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->info('Starting Application House Keeping');

    $this->call('migrate:fresh');
    $this->call('db:seed');

    $this->info('Done With Application House Keeping');


    // $this->output->createProgressBar(count(User::all()));

    // $bar->start();

    // foreach ($users as $user) {
    //   $this->performTask($user);

    //   $bar->advance();
    // }

    // $bar->finish();
  }
}
