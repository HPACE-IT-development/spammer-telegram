<?php

namespace App\Jobs;

use App\Helpers\MadelineHelper;
use App\Models\Action;
use Carbon\Carbon;
use danog\MadelineProto\API;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\DataCollector\LoggerDataCollector;

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
        $madelineSessions = [];

        foreach ($this->action->performers as $performer)
        {
            $madelineSessions[] = new API(MadelineHelper::getMadelineFullPath($performer->phone));
        }


        $recipientsCollections = collect($this->action->recipients);

        while ($recipientsCollections->isNotEmpty())
        {
            $awaitingResults = [];

            foreach($madelineSessions as $session) {
                $recipient = $recipientsCollections->shift();

                if(!empty($recipient)) {
                    $awaitingResults[] = \Amp\async(fn () => $session->messages ->sendMessage(
                        peer: $recipient,
                        message: $this->action->text
                    ));
                } else break;
            }

            $results = \Amp\Future\await($awaitingResults);
            Log::debug($results);
        }
    }
}
