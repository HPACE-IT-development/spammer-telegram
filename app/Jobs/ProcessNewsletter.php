<?php

namespace App\Jobs;

use App\Models\Action;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessNewsletter implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Action $action;
    public function __construct(Action $action)
    {
        $this->action = $action;
    }


    public function handle(): void
    {
//        $madelineSessions = [];
//
//        foreach ($this->action->performers as $performer)
//        {
//
//        }

        $recipients = collect([
            'получатель1',
            'получатель2',
            'получатель3',
            'получатель4',
            'получатель5',
            'получатель6',
            'получатель7',
        ]);

        $sessions = ['сессия1', 'сессия2', 'сессия3'];

        while($recipients->isNotEmpty()) {
            $awaitingResults = [];
            Log::debug("Новый цикл рассылки:".Carbon::now());
            foreach ($sessions as $session) {
                $recipient = $recipients->shift();

                if(!empty($recipient)) {
                    $awaitingResults[] = \Amp\async(function () use ($recipient, $session) {
                        try {
                            switch ($session) {
                                case 'сессия1':
                                    sleep(2);
                                    break;
                                case 'сессия2':
                                    sleep(5);
                                    break;
                                case 'сессия3':
                                    throw new \Exception('Исключение при 3');
                                    Log::debug('КОД ПОСЛЕ ВЫБРОСА ИСКЛЮЧЕНИЯ');
                            }
                        } catch (\Exception $e) {
                            Log::debug('Было выброшено исключение');
                        }

                        return "$session : $recipient";
                    });
                } else break;
            }

            $results = \Amp\Future\await($awaitingResults);
            Log::debug($results);
        }
    }
}
