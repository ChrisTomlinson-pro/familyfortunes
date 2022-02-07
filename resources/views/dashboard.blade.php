<x-app-layout>
    @push('scripts')
        <script>
            let selectedQuiz = '';

            function selectQuiz(quizUuid) {
                document.getElementById('begin-broadcast-button').disabled = false;
                document.getElementById('delete-quiz-button').disabled = false;
                selectedQuiz = quizUuid;
            }

            function broadcastBtnClick() {
                const broadcastUrl = '{{ url('/') . '/broadcasting/quiz/begin-broadcast/' }}' + selectedQuiz;
                axios.get(broadcastUrl).then((response) => {
                    if (response.status === 201) {
                        window.location.reload();
                    }
                });
            }
        </script>
    @endpush
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($isBroadcasting)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                Hey there
            </div>
            @else
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <label>
                        <select onchange="selectQuiz(this.value)" class="mb-2" id="quiz-select">
                            @foreach($quizzes as $quiz)
                                <option value="" disabled selected>Select a quiz</option>
                                <option value="{{ $quiz->uuid }}">{{ $quiz->name }}</option>
                            @endforeach
                        </select>
                    </label>

                    <div class="flex">
                        <button
                            disabled
                            id="begin-broadcast-button"
                            class="bg-blue-500 hover:bg-blue-400 text-white font-bold py-2 px-4 rounded mr-1"
                            onclick="broadcastBtnClick()"
                        >
                            Begin Broadcasting
                        </button>
                        <form action="{{ route('quiz-delete', ['quiz' => $quiz->uuid]) }}" content="enctype-multipart" method="delete">
                            @csrf
                            @method("DELETE")
                            <div>
                                <button disabled type="submit" id="delete-quiz-button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" >Delete</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
