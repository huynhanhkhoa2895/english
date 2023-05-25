<?php

namespace App\Services;

use App\Http\Resources\VocabularyCollection;
use App\Imports\VocabularyImport;
use App\Exports\VocabularyExport;
use App\Interface\VocabularyInterface;
use App\Interface\ZipInterface;
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

    function __construct(private readonly VocabularyRepository $repo, protected ZipInterface $zipService ){

    }

    public function getList(?string $relation,?string $id,?int $page,?int $limit): VocabularyCollection|false
    {
        try{
            return new VocabularyCollection($this->repo->getAll());
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

    function exportExcel(Collection $models,$cols):BinaryFileResponse|false
    {
        try{
            $data = $models->map(function (Vocabulary $vocabulary) use ($cols) {
                $value = [];
                foreach ($cols as $col) {
                    $val = $vocabulary->$col ?? '';
                    if($col === "vocabulary"){
                        $val = $vocabulary->vocabulary." ".(empty($vocabulary->parts_of_speech) ? "" : "(".$vocabulary->parts_of_speech.")");
                    }
                    $value[] = $val;
                }
                return $value;
            });
            Excel::store(new VocabularyExport($data),'vocabulary.xlsx','excel');
            $nameFile = $this->zipService->zipFile($models->pluck("sound")->all(),"sound","speech");
            $fileZipVocabularyAndSound = $this->zipService->zipFile([$nameFile,'vocabulary.xlsx'],"excel",["zip","excel"]);
            return response()->download(Storage::disk('zip')->path($fileZipVocabularyAndSound));
        } catch (Exception $exception) {
            Log::error("VocabularyService: importFromExcel - ".$exception->getMessage());
            return false;
        }
    }

    function getNextPreviousVocabulary(Vocabulary $vocabulary,string $type = "next") : Vocabulary|false
    {
        try {
            return $this->repo->getNextPrevious($vocabulary->id,$type) ?? false;
        } catch (Exception $exception) {
            Log::error("VocabularyService: getNextVocabulary - ".$exception->getMessage());
            return false;
        }
    }

    function validateVocabulary(string $vocabulary,string $part_of_speech,string|null $id) : bool
    {
        try {
            $data = $this->repo->getVocabularyByPartOfSpeech($vocabulary,$part_of_speech);
            if($id == $data->id && $part_of_speech === $data->parts_of_speech && $vocabulary === $data->vocabulary){
                return true;
            }else{
                return empty($data);
            }
        } catch (Exception $exception) {
            Log::error("VocabularyService: validateVocabulary - ".$exception->getMessage());
            return false;
        }
        return false;
    }
}
