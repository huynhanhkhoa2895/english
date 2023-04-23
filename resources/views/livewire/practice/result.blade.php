<div>
    <form wire:submit.prevent="submit">
        {{ $this->form }}
        <div class="py-4" :form="$this->form">
            <x-filament::button type="submit">
                Submit
            </x-filament::button>
        </div>
    </form>
    @if(!empty($this->data))
            @foreach($this->data as $item)
            <div class="bg-white px-4 py-4 mb-6">
                <h3 class="mb-6 font-bold text-xl">Student: {{$item['student_name']}} has {{count($item['submits'])}} submit</h3>
                @foreach($item['submits'] as $submit)
                    <div class="py-4 border-t">
                        <p class="font-bold text-xl">#{{$submit->id}} {{$submit->question_title}}</p>
                        <p class="font-medium">Date: {{$submit->created_at}}</p>
                        <p class="font-medium py-4">Point: {{$submit->point}}</p>
                        <table class='filament-tables-table w-full text-start divide-y table-auto'>
                            <thead>
                                <tr class="bg-gray-500/5">
                                    <th class="px-4 py-2 whitespace-nowrap font-medium text-start text-sm text-gray-600">Question</th>
                                    <th class="px-4 py-2 whitespace-nowrap font-medium text-start text-sm text-gray-600">Correct answer</th>
                                    <th class="px-4 py-2 whitespace-nowrap font-medium text-start text-sm text-gray-600">Answer</th>
                                    <th class="px-4 py-2 whitespace-nowrap font-medium text-start text-sm text-gray-600">Result</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y whitespace-nowrap">
                                @foreach($submit->results as $result)
                                    <tr class="divide-x rtl:divide-x-reverse">
                                        <td>{{$result->question}}</td>
                                        <td>
                                            {{
                                                $result->question_type === 'true_false' ? ($result->result ? "True" : "False") : $result->correct_answer
                                            }}
                                        </td>
                                        <td>{{$result->answer}}</td>
                                        <td>{{$result->result ? "True" : "False"}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            @endforeach
    @endif
</div>


