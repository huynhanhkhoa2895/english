<?php

namespace App\Services;

use App\Interface\GoogleInterface;
use Exception;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;


class GoogleService implements GoogleInterface{
    public function callApiGoogle(string $text,string $name,string $disk): bool
    {
        try {
            $textToSpeechClient = new TextToSpeechClient([
                'credentials' => storage_path("app/english-381805-2094589455c0.json"),
                'keyFilename' => storage_path("app/english-381805-2094589455c0.json"),
                'projectId' => 'english-381805'
            ]);

            $input = new SynthesisInput();
            $input->setText($text);
            $voice = new VoiceSelectionParams();
            $voice->setLanguageCode('en-US');
            $audioConfig = new AudioConfig();
            $audioConfig->setAudioEncoding(AudioEncoding::MP3);

            $resp = $textToSpeechClient->synthesizeSpeech($input, $voice, $audioConfig);
            $result = (bool) Storage::disk($disk)->put($name.'.mp3', $resp->getAudioContent());
            if(!$result) {
                return false;
            }
            return true;
        } catch (Exception $exception){
            Log::error("GoogleService: callApiGoogle - ".$exception->getMessage());
            return false;
        }
    }
}
