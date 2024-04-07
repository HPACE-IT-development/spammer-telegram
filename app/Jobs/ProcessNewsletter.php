<?php

namespace App\Jobs;

use App\Helpers\MadelineHelper;
use App\Models\Action;
use Carbon\Carbon;
use danog\MadelineProto\API;
use danog\MadelineProto\LocalFile;
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
    protected int $sleepingTime;

    protected int $timeout;

    public function __construct(Action $action)
    {
        $this->action = $action;
        $this->sleepingTime = 5;

        $recipients_amount = $action->recipients_collection->count();
        $this->timeout = ($recipients_amount * $this->sleepingTime) + ($recipients_amount * 3) + ($recipients_amount * 2);
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
                    if($this->action->first_image_full_path) {
                        $awaitingResults[] = \Amp\async(fn () => $session->sendPhoto(
                            peer: $recipient,
                            file: new LocalFile($this->action->first_image_full_path),
                            caption: $this->action->text
                        ));
                    } else {
                        $awaitingResults[] = \Amp\async(fn () => $session->messages->sendMessage(
                            peer: $recipient,
                            message: $this->action->text
                        ));
                    }
                } else break;
            }

            $results = \Amp\Future\await($awaitingResults);

            /* Если получателей больше нет => все сообщения отправлены */
            if($recipientsCollections->isEmpty()) {
                // отчет
            } else {
                sleep($this->sleepingTime);
            }
            Log::debug($results);
        }
    }
}
