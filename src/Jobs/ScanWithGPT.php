<?php

namespace TomatoPHP\FilamentTranslations\Jobs;

use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use OpenAI\Laravel\Facades\OpenAI;
use TomatoPHP\FilamentTranslations\Models\Translation;

class ScanWithGPT implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public string $language = "English",
        public int $userId,
        public string $userType
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $user = $this->userType::find($this->userId);
        $getAllTranslations = Translation::all();
        $chunks = array_chunk($getAllTranslations->toArray(), 50);

        foreach ($chunks as $chunk) {
            $makeJsonArray = [];
            foreach ($chunk as $translation) {
                $makeJsonArray[$translation['key']] = $translation['text']['en'] ?? $translation['key'];
            }

            $json = json_encode($makeJsonArray);
            $result = OpenAI::chat()->create([
                "model" => "gpt-3.5-turbo",
                "messages" => [
                    [
                        "role" => "system",
                        "content" => "You are a translator. Your job is to translate the following json object to the language specified in the prompt."
                    ],
                    [
                        "role" => "user",
                        "content" =>  "Translate the following json object from English to " . $this->language . ", ensuring you return only the translated content without added quotes or any other extraneous details. Importantly, any word prefixed with the symbol ':' should remain unchanged"
                    ],
                    [
                        "role" => "user",
                        "content" => $json
                    ]
                ],
                "temperature" => 0.4,
                "n" => 1,
            ]);

            if ($result->choices && count($result->choices) > 0 && $result->choices[0]->message) {
                $translationArray = json_decode($result->choices[0]->message->content) ?? [];
            }


            $getLocal = config('filament-translations.locals');
            $local = "en";
            foreach ($getLocal as $key => $item) {
                if ($item['label'] == $this->language) {
                    $local = $key;
                }
            }

            for ($i = 0; $i < count($chunk); $i++) {
                $translationModel = Translation::where('key', $chunk[$i]['key'])->first();
                if ($translationModel) {
                    $text = $translationModel->text;
                    $text[$local] = $translationArray->{$chunk[$i]['key']} ?? $chunk[$i]['key'];

                    $translationModel->text = $text;
                    $translationModel->save();
                }
            }

            Notification::make()
                ->title(trans('filament-translations::translation.gpt_scan_notifications_done'))
                ->success()
                ->sendToDatabase($user);
        }
    }
}