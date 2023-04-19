<table class="table-auto border-collapse border border-slate-500 w-full">
    <thead>
        <tr>
            <th class="border border-slate-600">Question</th>
            <th class="border border-slate-600">Correct Answer</th>
            <th class="border border-slate-600">Answer</th>
            <th class="border border-slate-600">Result</th>
        </tr>
    </thead>
    <tbody>
        @foreach($record->resultQuestion()->get() as $result)
            <tr>
                <td class="border border-slate-700 p-2">{{$result->question}}</td>
                <td class="border border-slate-700 p-2">{{$result->pivot->correct_answer}}</td>
                <td class="border border-slate-700 p-2">{{$result->pivot->answer}}</td>
                <td class="border border-slate-700 p-2">{!! $result->pivot->result ? "<span class='text-green-500'>Correct</span>" : "<span class='text-red-500'>Wrong</span>" !!}</td>
            </tr>
        @endforeach
    </tbody>
</table>
