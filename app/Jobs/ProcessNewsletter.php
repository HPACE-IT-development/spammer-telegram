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

        $madelineSessions = collect([]);
        $madelineSessionsReports = [];
        foreach ($this->action->performers as $performer) {
            try {
                $madelineSessions->push(new API(MadelineHelper::getMadelineFullPath($performer->phone)));
            } catch (\Throwable $e) {
                $madelineSessionsReports[$performer->phone] = $e->getMessage();
                continue;
            }
        }

        $recipientsCollections = collect($this->action->recipients);
        $report->update(['total_recipients_amount' => $recipientsCollections->count()]);
        if($madelineSessions->isNotEmpty()) {
            $infoAboutRecipients = [];
            $completedRecipientsAmount = 0;
            while ($recipientsCollections->isNotEmpty()) {
                $awaitingResults = [];

                foreach ($madelineSessions as $session) {
                    $recipient = $recipientsCollections->shift();

                    if (!empty($recipient)) {
                        $awaitingResults[] = \Amp\async(function () use ($session, $recipient) {
                            try {
                                if ($this->action->first_image_full_path) {
                                    return $session->messages->sendMedia(
                                        peer: $recipient,
                                        media: [
                                            '_' => 'inputMediaUploadedPhoto',
                                            'file' => new RemoteUrl($this->action->first_image_url)
                                        ],
                                        message: $this->action->text
                                    );
                                } else {
                                    return $session->messages->sendMessage(
                                        peer: $recipient,
                                        message: $this->action->text
                                    );
                                }
                            } catch (\Throwable $e) {
                                return [
                                    'recipient' => $recipient,
                                    'message' => $e->getMessage(),
                                    'error' => true
                                ];
                            }
                        });
                    } else break;
                }

                $results = \Amp\Future\await($awaitingResults);
                foreach ($results as $result) {
                    if(isset($result['error'])) {
                        $infoAboutRecipients[$result['recipient']] = [
                            'sent' => false,
                            'message' => $result['message']
                        ];
                    } else {
                        $infoAboutRecipients[$result['request']['body']['peer']] = [
                            'sent' => true
                        ];
                    }
                    $completedRecipientsAmount = $completedRecipientsAmount++;
                }

                /* Если получателей больше нет => все сообщения отправлены */
                if ($recipientsCollections->isEmpty()) {
                    $reportDataset = [
                        'completed_recipients_amount' => $completedRecipientsAmount,
                        'info_about_recipients' => json_encode($infoAboutRecipients),
                        'report_status_id' => 1
                    ];

                    if($madelineSessionsReports) $reportDataset['sessions_errors'] = json_encode($madelineSessionsReports);

                    $report->update($reportDataset);
                    $this->action->update(['action_status_id' => 4]);
                } else {
                    $report->update(['completed_recipients_amount' => $completedRecipientsAmount]);
                    sleep($this->sleepingTime);
                }
            }
        } else {
            $report->update([
                'report_status_id' => 2,
                'sessions_errors' => json_encode($madelineSessionsReports)
            ]);
        }
    }
}
