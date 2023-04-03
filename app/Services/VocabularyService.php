<?php

namespace App\Services;

use App\Imports\VocabularyImport;
use App\Exports\VocabularyExport;
use App\Interface\VocabularyInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\Vocabulary;
use Google\Cloud\TextToSpeech\V1\AudioConfig;
use Google\Cloud\TextToSpeech\V1\AudioEncoding;
use Google\Cloud\TextToSpeech\V1\SynthesisInput;
use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\VocabularyRepository;
use Excel;

class VocabularyService implements VocabularyInterface
{

    function __construct(VocabularyRepository $repo){

    }

    public function getList(): array
    {
        try{
            return $this->repo->getAll();
        } catch (Exception $exception) {
            Log::error("VocabularyService: getList - ".$exception->getMessage());
            return false;
        }
    }

    public function importFromExcel($excel): bool
    {
        try{
            Excel::import(new VocabularyImport, $excel, 'public');
            return true;
        } catch (Exception $exception) {
            Log::error("VocabularyService: importFromExcel - ".$exception->getMessage());
            return false;
        }

    }

    public function textToSpeach(string $text): string|false
    {
        try {
            if(!Storage::disk('speech')->exists($text.'.mp3')){
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
                $result = (bool) Storage::disk('speech')->put($text.'.mp3', $resp->getAudioContent());
                if(!$result) {
                    return false;
                }
            }
            return $text.'.mp3';

        } catch (Exception $exception) {
            Log::error("VocabularyService: textToSpeach - ".$exception->getMessage());
            return false;
        }
    }

    function exportExcel(Collection $models):BinaryFileResponse|false
    {
        try{
            $data = $models->map(function (Vocabulary $vocabulary){
                $value = [];
                $value[] = $vocabulary->vocabulary." ".(empty($vocabulary->parts_of_speech) ? "" : "(".$vocabulary->parts_of_speech.")");
                $value[] = $vocabulary->translate ?? '';
                $value[] = $vocabulary->example ?? '';
                return $value;
            });

            return Excel::download(new VocabularyExport($data),'vocabulary.xlsx');;
        } catch (Exception $exception) {
            Log::error("VocabularyService: importFromExcel - ".$exception->getMessage());
            return false;
        }
    }
}
