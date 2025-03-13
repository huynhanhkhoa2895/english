<?php

namespace App\Services;

use App\Http\Resources\VocabularyCollection;
use App\Imports\VocabularyImport;
use App\Exports\VocabularyExport;
use App\Interface\VocabularyInterface;
use App\Interface\ZipInterface;
use App\Interface\GoogleInterface;
use App\Repositories\VocabularyRelationshipRepository;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Models\Vocabulary;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\VocabularyRepository;
use Illuminate\Support\Facades\Http;
use Excel;

class VocabularyService implements VocabularyInterface
{

    function __construct(private readonly VocabularyRepository $repo, protected GoogleInterface $googleService, protected ZipInterface $zipService, protected VocabularyRelationshipRepository $repoVocabularyRelationship){

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
                $useGoogle = !$this->callApiDictionary($text);
                if(!$useGoogle){
                    $this->callApiLaban($text);
                }
                
                // $useGoogle = false;
                // if(count(explode(" ",$text))>1){
                //     $useGoogle = true;
                // }else{
                //     $useGoogle = !$this->callApiDictionary($text);
                // }
                // if($useGoogle){
                //     $this->googleService->callApiGoogle($text,$text,"speech");
                // }
            }
            return $text.'.mp3';

        } catch (Exception $exception) {
            Log::error("VocabularyService: textToSpeach - ".$exception->getMessage());
            return false;
        }
    }


    private function callApiDictionary(string $text): bool
    {
        try {
            $url = "https://dictionary.cambridge.org";
            $response = Http::withHeaders([
                "User-Agent"=> "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/93.0.4577.82 Safari/537.36"
            ])->get($url."/dictionary/english/".$text);
            $body = $response->body();
            $pattern = '/<source [^>]*src="(.+)/';
            preg_match_all($pattern,$body,$src);
            $dataSrc = null;
            foreach ($src[1] as $match){
                $data = preg_match('/\/us_pron\//',$match);
                if($data){
                    $dataSrc = explode('"',$match)[0];
                    break;
                }
            }
            $contents = file_get_contents($url.$dataSrc);
            return Storage::disk('speech')->put($text.".mp3", $contents);
        } catch (Exception $exception){
            dd($exception);
            Log::error("VocabularyService: callApiDictionary - ".$exception->getMessage());
            return false;
        }
    }

    private function callApiLaban(string $text): bool{
        try {
            $url = "https://dict.laban.vn/ajax/getsound?accent=us&word=";
            $response = Http::get($url.''.$text);
            $body = $response->body();
            if($body) {
                $body = json_decode($body);
            }
            if($body->data) {
                $contents = file_get_contents($body->data);
                return Storage::disk('speech')->put($text.".mp3", $contents);
            }
            return false;
        } catch (Exception $exception){
            dd($exception);
            Log::error("VocabularyService: callApiDictionary - ".$exception->getMessage());
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

            if($data && $id == $data->id && $part_of_speech === $data->parts_of_speech && $vocabulary === $data->vocabulary){
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

    function syncRelationship(string $idVocabulary1,string $idVocabulary2,string $relationship): bool
    {
        try {
            $list = collect([$idVocabulary1,$idVocabulary2]);
            $dataId = $list->map(function (string $id) use ($relationship) {
                return [
                    (int)$id,
                    $this->repoVocabularyRelationship->getRelation($id,$relationship,['vocabulary_relationship'])->map(fn ($item) => $item->vocabulary_relationship)
                ];
            });

            $list = $dataId->flatten()->unique();

            foreach ($list as $index=>$vocabulary) {
                $qty = $index+1;
                while (isset($list[$qty])) {
                    $vocabulary2 = $list[$qty];
                     $this->repoVocabularyRelationship->syncVocabulary($vocabulary,$vocabulary2,$relationship);
                    $qty++;
                }
            }

            return true;
        } catch (Exception $exception) {
            Log::error("VocabularyService: syncRelationship - ".$exception->getMessage());
            return false;
        }
        return false;
    }
}
