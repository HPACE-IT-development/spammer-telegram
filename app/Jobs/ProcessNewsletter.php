<?php

namespace App\Jobs;

use App\Helpers\MadelineHelper;
use App\Models\Action;
use App\Models\Report;
use Carbon\Carbon;
use danog\MadelineProto\API;
use danog\MadelineProto\LocalFile;
use danog\MadelineProto\RemoteUrl;
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
        $this->sleepingTime = 20;

        $recipients_amount = $action->recipients_collection->count();
        $this->timeout = ($recipients_amount * $this->sleepingTime) + ($recipients_amount * 3) + ($recipients_amount * 2);
    }


    public function handle(): void
    {
        $this->action->update(['action_status_id' => 3]);

        $report = Report::create(['action_id' => $this->action->id]);

        $madelineSessions = [];

        foreach ($this->action->performers as $performer) {
            $madelineSessions[] = new API(MadelineHelper::getMadelineFullPath($performer->phone));
        }

        $recipientsCollections = collect($this->action->recipients);

        while ($recipientsCollections->isNotEmpty()) {
            $awaitingResults = [];

            foreach ($madelineSessions as $session) {
                $recipient = $recipientsCollections->shift();

                if (!empty($recipient)) {
                    $awaitingResults[] = \Amp\async(function () use ($session, $recipient) {
                        try {
                            if ($this->action->first_image_full_path) {
                                return $session->sendPhoto(
                                    peer: $recipient,
                                    file: new RemoteUrl($this->action->first_image_url),
                                    caption: $this->action->text
                                );
                            } else {
                                return $session->messages->sendMessage(
                                    peer: $recipient,
                                    message: $this->action->text
                                );
                            }
                        } catch (\Throwable $e) {
                            return $e->getMessage();
                        }
                    });
                } else break;
            }

            $results = \Amp\Future\await($awaitingResults);
            $report->update(['test' => $report->test + 20]);
            /* Если получателей больше нет => все сообщения отправлены */
            if ($recipientsCollections->isEmpty()) {
                $this->action->update(['action_status_id' => 4]);
            } else {
                sleep($this->sleepingTime);
            }
            Log::debug($results);
        }
    }
}
