<?php

namespace TomatoPHP\FilamentTranslations\Jobs;

use Filament\Notifications\Notification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Stichoza\GoogleTranslate\GoogleTranslate;
use TomatoPHP\FilamentTranslations\Models\Translation;

class ScanWithGoogleTranslate implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

	public function __construct(
		public Authenticatable $user,
		public string $language = "en"
	) {
	}

	/**
	 * Execute the job.
	 */
	public function handle(): void
	{
		$translator = new GoogleTranslate($this->language);

		Translation::chunk(200, function (Collection $translations) use ($translator) {
			foreach ($translations as $translation) {
				$textToTranslate = $translation->text['en'] ?? $translation['key'];
				$translation->setTranslation($this->language, $translator->translate($textToTranslate));
				$translation->save();
			}
		});

		Notification::make()
			->title(trans('filament-translations::translation.google_scan_notifications_done'))
			->success()
			->sendToDatabase($this->user);
	}
}
